@extends ('layouts.app')

@section ('title')

Список категорий

@endsection

@section ('content')


<h1>
   {{$title}}
</h1>
<br>
@if(session('startExportCategories'))
<div class="alert alert-success">
    Выгрузка запущена
</div>
@endif
<form method="post" action="{{route('ExportCategories')}}">
        @csrf
      <button class="btn btn-outline-secondary btn-lg" type="submit" class="btn btn-link">Выгрузить категории</button>  
    </form> 
<br>
<table class="table table-bordered">
<thead>
            <tr>
                <th>#</th>
                <th>Изображение</th>
                <th>Наименование</th>
                <th>Описание</th>
                <th>К списку продуктов</th>
            </tr>
        </thead>
   <tbody>
    
   @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td class="pict"><image src="{{asset('storage')}}/{{$category->picture}}"width="100px"></td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    <td class="text-center">
                        <a role="button" class="btn btn-outline-dark" href="{{ route('category', $category->id) }}">Перейти</a>
                    </td>
   @endforeach                 
   </tbody>
</table>
<div class="row">
  <div class="col-sm-8">
    
        <h3 class="card-title">Добавить новую категорию</h3>
        <form method="post" action="{{route('addCategory')}}" class="mb-4" enctype="multipart/form-data">       
            @csrf        
            <div class="mb-3">
                <label class="form-label">Изображение</label>
                <image class="user-picture mb-2" src="">
                <input type="file" name="picture" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Наименование</label>
                <input class="form-control mb-2" name='name'>
            </div>
            <div class="mb-3">
                <label class="form-label">Описание</label>
                <input class="form-control mb-2" name='description'>
            </div>
                            
            <button class="btn btn-outline-dark" type="submit">Сохранить</button>
        </form>
      </div>
  </div>
  <br>
  
  <div class="col-6 ">
  <h3 class="card-title">Загрузить новую категорию</h3>
       <form method="post" action="{{ route('ImportCategories')}}" class="mb-4" enctype="multipart/form-data">
        @csrf 
        <div class="mb-3 ">                
                <input type="file"  name="importFile" class="form-control">
            </div>
            <button type="submit" class="btn btn-outline-dark">Загрузка категории</button>  
        </form> 
    </div> 
    
</div>
@endsection