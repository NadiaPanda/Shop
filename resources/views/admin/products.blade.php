@extends ('layouts.app')

@section ('title')

Список продуктов

@endsection

@section ('content')

<h1>
   {{$title}}
</h1>
<br>

@if(session('startExportProducts'))
<div class="alert alert-success">
    Выгрузка запущена
</div>
@endif
<form method="post" action="{{route('ExportProducts')}}">
        @csrf
      <button class="btn btn-outline-secondary btn-lg" type="submit" class="btn btn-link">Выгрузить продукты</button>  
    </form> 
    <br>

<table class="table table-bordered">
<thead>
            <tr>
                <th>#</th>
                <th>Категория</th>   
                <th>Изображение</th>
                <th>Наименование</th>
                <th>Описание</th>
                <th>Цена</th>
            </tr>
        </thead>
   <tbody>
   @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{$product->category}} </td>
                    <td class="pict"><image src="{{asset('storage')}}/{{$product->picture}}"width="100px"></td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
   @endforeach  </tr>               
   </tbody>
</table> 
<form method="post" action="{{ route('createProduct') }}" class="mb-3" enctype="multipart/form-data">
        @csrf
        <div class="mb-2">
            <label class="form-label"><h4>Новый продукт</h4></label>
            <input type="text" name="name" placeholder="Наименование" class="form-control">
        </div>
        <div class="mb-2">
            <textarea type="text" name="description" placeholder="Описание" class="form-control"></textarea>
        </div>
        <div class="mb-2">
            <label class="form-label">Изображение</label>
            <input type="file" name="picture" class="form-control">
        </div>
        <div class="mb-2">
            <input type="text" name="price" placeholder="Цена" class="form-control">
        </div>
        <div class="mb-2">
            <select class="form-control" name="category_id">
                <option disabled selected>--Выберите категорию--</option> 
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-outline-dark ">Создать продукт</button>
    </form>

    <form method="post" action="{{ route('ImportProducts')}}" class="mb-4" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3 "> 
        <label class="form-label"><h4>Загрузить список продуктов</h4></label>               
                <input type="file"  name="fileImport" class="form-control">
            </div>
            <button type="submit" class="btn btn-outline-dark">Загрузка продуктов</button>
        </form> 
    </div> 
    </div>
@endsection

