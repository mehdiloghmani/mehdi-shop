<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\StoreRequest;
use App\Http\Requests\Admin\Users\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
     public function all()
     {
        $users= User::paginate(10);
       return view('admin.users.index' , compact('users'));
     }

     public function create()
     {
       return view('admin.users.add');
     }

     public function store(StoreRequest $request)
     {
        $validateData= $request->validated();
        $createdUser=User::create([
            'name' => $validateData['name'],
            'email' => $validateData['email'],
            'mobile' => $validateData['mobile'],
            'role' =>  $validateData['role'],
        ]);

        if(!$createdUser) {
          return back()->with('failed' , 'کاربر ایجاد نشد');
        }
        return back()->with('success' ,'کاربر ایجاد شد' );
     }

     public function edit($user_id)
     {
       $user=User::findOrFail($user_id);
       return view('admin.users.edit' , compact('user'));
     }

     public function update(UpdateRequest $request , $user_id)
     {
      $validateData= $request->validated();

      $user= User::findOrFail($user_id);
      $updatedUser=$user->update([
        'name' => $validateData['name'],
        'email' => $validateData['email'],
        'mobile' => $validateData['mobile'],
        'role' =>  $validateData['role'],
      ]);
      
      if(!$updatedUser){
        return back()->with('failed' , 'کاربر به روزرسانی نشد');
      }
      return back()->with('success' , 'کاربر به روزرسانی شد');
     }

     public function delete($user_id)
     {
       $user= User::findOrFail($user_id);
        $user->delete();
        return \back()->with('success' , 'کاربر حذف شد');
     }
}
