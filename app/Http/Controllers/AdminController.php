<?php

namespace App\Http\Controllers;

use App\Jobs\ExportCategories;
use App\Jobs\ExportProducts;
use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Monolog\Handler\RollbarHandler;

class AdminController extends Controller
{

    public function admin ()
    {
        return view('admin.admin');
    }

    public function users ()
    {

        $users = User::paginate(4);
        $roles = Role::get();

        $data = [
            'title' => 'Список пользователей',
            'users' => $users,
            'roles' => $roles,
        ];
        return view('admin.users', $data);
    }

    public function products ()
    { $products= Product::get();
        $data = [
        'title' => 'Список продуктов',
        'products' => $products,
    ];
        return view('admin.products', $data);
    }

    public function categories ()
    { $categories = Category::get();
        $data = [
            'title' => 'Список категорий',
            'categories' => $categories,

        ];
        return view('admin.categories', $data);
    }

    public function enterAsUser ($id)
    {
        Auth::loginUsingId($id);
        return redirect()->route('adminUsers');
    }

    public function addRole ()
    {
        request()->validate([
            'name' => 'required|min:3',
        ]);

        Role::create([
            'name' => request('name')
        ]);
        return back();
    }

    public function addRoleToUser ()
    {
        request()->validate([
            'user_id' => 'required',
            'role_id' => 'required',
        ]);

        $user = User::find(request('user_id'));
        $user->roles()->attach(Role::find(request('role_id')));
        return back();
    }
public function ExportCategories()
{
    ExportCategories::dispatch();
}  

public function ExportProducts() 
{
    ExportProducts::dispatch();
    
}

}
