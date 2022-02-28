<?php

namespace App\Http\Controllers;

use App\Jobs\ExportCategories;
use App\Jobs\ExportProducts;
use App\Jobs\ImportCategories;
use App\Jobs\ImportProducts;
use App\Models\Category;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    {
      $products = DB::table('products as p')
      ->select(
         'p.id','p.name', 'p.description', 'p.price', 'p.category_id', 'c.name as category' ,'p.picture'       
     )
      ->join('categories as c', 'p.category_id', '=', 'c.id')
      ->orderBy('c.id')      
      ->get();
      
      $i=1;
      foreach ($products as $product)
      {
         $product->id_into_table=$i;
         $i++;
      }
      $categories = Category::get();
      
      $data = [
         'title' => 'Продукты',
         'title1' => 'Список продуктов',
         'products' => $products,
         'categories' => $categories,         
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
    session()->flash('startExportCategories');
        return back();
}  

public function ExportProducts() 
{
    ExportProducts::dispatch();
    session()->flash('startExportProducts');
        return back();
    
}
public function ImportCategories (Request $request) 
{
    $request->validate([         
        'fileImport' => 'required|file|mimes:csv,txt', 
     ]);     

     $file=$request->file('fileImport');
     $filename = $file->getClientOriginalName();    
     $fileall=$file->storeAs('public/categories', $filename); 
     $tpm_file = $_SERVER['DOCUMENT_ROOT'] . '\\storage\categories\\'.$filename;
     $this->dispatch(new ImportCategories($tpm_file));  
     session()->flash('startImportCategories');
     return back();
}
public function addCategory ()
    {
      request()->validate([
         'name' => 'required|min:3',
         'description' => 'required|min:3',    
         'picture' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
            
     ]);
  
     $picture = request('picture') ?? null;
     if ($picture) {            
         $ext = $picture->getClientOriginalExtension();
         $filename = time() . rand(10000,99999) . '.' . $ext;
         $picture->storeAs('public/products', $filename);
         $picturebase = "products/$filename";
      }

        Category::create([
            'name' => request('name'),
            'description' => request('description'),
            'picture' => $picturebase,
        ]);
        session()->flash('categoryCreated');
        return back();
    }

    public function createProduct ()
    {
      $input = request()->all(); 
      $name = $input['name'];
      
      $description = $input['description'];
      $price = $input['price'];
      $picture = $input['picture'] ?? null;
      $category_id = $input['category_id'];
      
        request()->validate([
            'name' => 'required|min:3',
            'description' => 'required|min:3',
            'price' => 'required',
            'picture' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
            'category_id' => 'required'
        ]);
     

        if ($picture) {            
            $ext = $picture->getClientOriginalExtension();
            $filename = time() . rand(10000,99999) . '.' . $ext;
            $picture->storeAs('public/products', $filename); 
            $picturebase = "products/$filename";
         }
    
        Product::create([
            'name' => $name,
            'description' => $description,
            'picture' => $picturebase,
            'price' => $price,
            'category_id' => $category_id,
        ]);
        session()->flash('productCreate');//показывает ключ один раз и удаляется
        return back();
      }
    public function ImportProducts (Request $request)
    {
        $request->validate([         
            'fileImport' => 'required|file|mimes:csv,txt', 
         ]);
         $file=$request->file('fileImport');
         $filename = $file->getClientOriginalName();    
       $fileall=$file->storeAs('public/products', $filename); 
         $tpm_file = $_SERVER['DOCUMENT_ROOT'] . '\\storage\products\\'.$filename;
         $this->dispatch(new ImportProducts($tpm_file));  
          session()->flash('startImportProducts');
          return back();
}
}