@extends('layouts.app')

@section('title')
    Админка
@endsection

@section('content')
 
<div class="d-grid gap-2 col-6 mx-auto">
        <a role="button" class="btn btn-outline-dark btn-lg" href="{{ route('adminCategories')}}">Список категорий</a>
        
        <a role="button" class="btn btn-outline-dark btn-lg" href="{{ route('adminProducts')}}">Список продуктов</a>
       
        <a role="button" class="btn btn-outline-dark btn-lg" href="{{ route('adminUsers')}}">Список пользователей</a>
    </div>


    <!--<a href="{{ route('adminUsers')}}">Список пользователей</a>
    <a href="{{ route('adminProducts')}}">Список продуктов</a>
    <a href="{{ route('adminCategories')}}">Список категорий</a>-->

        
    <!--    <form method="post" action="{{route('ExportCategories')}}">
        @csrf
      <button type="submit" class="btn btn-link">Выгрузить категории</button>  
    </form> 

    -->
@endsection