<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function profile (User $user)
    {
                return view('profile', compact('user'));
    }
    
    public function save (Request $request)
    {
        $input = request()->all();
        $name = $input['name'];
        $email = $input['email'];
        $userId = $input['userId'];
        $picture = $input['picture'] ?? null;
        $newAddress = $input['new_address'] ?? null;
        $mainAddress = $input['main_address'] ?? null;
        $setMainAddress = $input['set_main_address'] ?? null;

        $user = User::find($userId); 
    
        request()->validate([
            'name' => 'required',
            'email' => "email|required|unique:users,email,{$user->id}",
            'picture' => 'mimetypes:image/*|nullable',
            'current_password' => 'current_password|required_with:password|nullable',
            'password' => 'confirmed|min:8|nullable'
        ]);

        if ($input['password'] && $input['current_password']) {
            $user->password = Hash::make($input['password']);
            $user->save();
        }
        
        if ($mainAddress) {
            Address::where('user_id', $user->id)->update([
                'main' => 0,
            ]);
            Address::where('id', $mainAddress)->update([
                'main' => 1,
            ]);
        }

        if ($newAddress && $setMainAddress) {
            Address::where('user_id', $user->id)->update([
                'main' => 0,
            ]);

            Address::create([
                    'user_id' => $user->id,
                    'address' => $newAddress,
                    'main' => 1,
            ]);
        } elseif ($newAddress) {
                Address::create([
                    'user_id' => $user->id,
                    'address' => $newAddress,
                    'main' => 0
            ]);
            
        }

        if ($picture) {
            $mimeType = $request->file('picture')->getMimeType();
            $type = explode('/', $mimeType);

            if ($type[0] == 'image') {
                $ext = $picture->getClientOriginalExtension();
                $fileName = time() . rand(10000, 99999). "." . $ext;
                $picture->storeAs('public/users', $fileName);
                $user->picture = "users/$fileName";
            } 
            
        }

        $user->name = $name; 
        $user->email = $email; 
        $user->save(); 
        session()->flash('saveProfileSuccess');
        return back();
    
}
public function orders () 
    {   
        $user = Auth::user()->id;
        $orders = Order::where('user_id', $user)->get();
        $data = [
            'title' => 'Список заказов',
            'orders' => $orders,
        ];
        return view('orders', $data);
    }
}
    
