<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Http\Requests\Payment\PayRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use App\Services\Payment\PaymentService;
use App\Services\Payment\Requests\IDPayRequest;
use App\Services\Payment\Requests\IDPayVerifyRequest;
use Doctrine\DBAL\Exception\InvalidArgumentException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
    class PaymentController extends Controller
    {
        public function pay(PayRequest $request)
    {

        $validatedData = $request->validated();

        $user = User::firstOrCreate([
            'email' => $validatedData['email'],
        ],[
            'name' => $validatedData['name'],
            'mobile' => $validatedData['mobile'],
        ]);


        try{
            $orderItems = json_decode(Cookie::get('basket'), true);

            if(count($orderItems) <= 0){
                throw new \InvalidArgumentException('سبد خرید شما خالی است');
            }

            $products = Product::findMany(array_keys($orderItems));

            $productsPrice = $products->sum('price');

            $refCode = Str::random(30);

            $createdOrder = Order::create([
                'amount' => $productsPrice,
                'ref_code' => $refCode,
                'status' => 'unpaied',
                'user_id' => $user->id,
            ]);

            $orderItemsForCreatedOrder = $products->map(function($product){
                $currentProduct = $product->only(['price', 'id']);

                $currentProduct['product_id'] = $currentProduct['id'];

                unset($currentProduct['id']);

                return $currentProduct;
            });

            $createdOrder->orderItems()->createMany($orderItemsForCreatedOrder->toArray());

            $refId = rand(1111, 9999);

            $createdPayment = Payment::create([
                'gateway' => 'idpay',
                'ref_code' => $refCode,
                'res_id' => $refId,
                'status' => 'unpaied',
                'order_id' => $createdOrder->id,
            ]);

            $idPayRequest = new IDPayRequest([
                'amount' => $productsPrice,
                'user' => $user,
                'orderId' => $refCode,
                'apiKey' => config('services.gateways.id_pay.api_key'),
            ]);

            $paymentService = new PaymentService(PaymentService::IDPAY, $idPayRequest);

            return $paymentService->pay();

        }catch(\Exception $e){
           return back()->with('failed', $e->getMessage());
        }
    }

    public function callback()
    {
        return  back()->with('success' , 'پرداخت با موفقیت انجام شد');
    }
}
