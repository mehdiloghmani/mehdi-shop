<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Products\StoreRequest;
use App\Http\Requests\Admin\Products\UpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Utilities\ImageUploader;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\Return_;

class ProductsController extends Controller
{
    public function all()
    {
        $products = Product::paginate(10);
        return view('admin.products.all' , compact('products'));
    }

    public function create()
    {
        $categories= Category::all();
        return view('admin.products.add', compact('categories'));
    }

    public function store(StoreRequest $request)
    {
        $validateData= $request->validated();
        $admin=User::where('email', 'admin@gmail.com')->first();

        $createdProduct=Product::create([
         'title'=>$validateData['title'],
        'description'=>$validateData['description'],
        'category_id'=>$validateData['category_id'],
        'price'=>$validateData['price'],
        'owner_id'=>$admin->id,
     ]);


     if(!$this->uploadImages($createdProduct, $validateData))
     {
         return back()->with('failed', 'محصول ایجاد نشد');
     }

     return back()->with('success', 'محصول ایجاد شد');

 }
       public function edit($product_id)
       {
         $categories= Category::all();
         $product = Product::findOrFail($product_id);
         return view('admin.products.edit' , compact('product' , 'categories'));
       }

       public function update(UpdateRequest $request , $product_id)
       {
            $validateData= $request->validated();

            $product = Product::findOrFail($product_id);

            $UpdatedProduct=$product->update([
                'title'=>$validateData['title'],
                'description'=>$validateData['description'],
                'category_id'=>$validateData['category_id'],
                'price'=>$validateData['price'],
            ]);

            if(!$this->uploadImages($product, $validateData) or !$UpdatedProduct)
            {
                return back()->with('failed', 'تصاویر بروزرسانی نشد');
            }

            return back()->with('success', 'محصول بروزرسانی شد');
        }

    public function delete($product_id)
    {
        $product = Product::findOrFail($product_id);
        $product->delete();
        return back()->with('success' , 'محصول حذف شد');
    }

    public function downloadDemo($product_id)
    {
       $product= Product::findOrFail($product_id);
       return response()->download(public_path($product->demo_url));
    }

    public function downloadSource($product_id)
    {
        $product= Product::findOrFail($product_id);
        return response()->download(storage_path('app/local_storage/'.$product->source_url));
    }

    private function uploadImages($createdProduct ,$validateData )
    {

        try {
            $basePath= 'products/' . $createdProduct->id . '/';
            $sourceImageFullPath=null;
            $data=[];
            if (isset($validateData['source_url']))
            {
                $sourceImageFullPath= $basePath .'source_url_'. $validateData['source_url']->getClientOriginalName();
                ImageUploader::upload($validateData['source_url'], $sourceImageFullPath, 'local_storage');
                $data+= ['source_url'=>$sourceImageFullPath];
            }

            if (isset($validateData['thumbnail_url']))
            {
                $fullPath= $basePath .'thumbnail_url'. '_' . $validateData['thumbnail_url']->getClientOriginalName();
                ImageUploader::upload($validateData['thumbnail_url'] , $fullPath ,'public_storage');
                $data+= ['thumbnail_url'=>$fullPath];
            }

            if (isset($validateData['demo_url'])) {
            $fullPath= $basePath .'demo_url'.'_' . $validateData['demo_url']->getClientOriginalName();
            ImageUploader::upload($validateData['demo_url'] , $fullPath ,'public_storage');
            $data+= ['demo_url'=>$fullPath];
            }

            $UpdatedProduct=$createdProduct->update($data);


     if (!$UpdatedProduct) {
        throw new \Exception('تصاویر اپلود نشدند');
     }
         return back()->with('success' , 'محصول ایجاد شد');

        } catch (\Exception $e) {
            return back()->with('failed', $e->getMessage());
        }
    }
}
