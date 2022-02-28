@extends ('layouts.app')

@section ('title')

Список категорий

@endsection

@section ('content')


<h1>
   {{$title}}
</h1>

<table class="table table-bordered">
<thead>
            <tr>
                <th>#</th>
                <th>Наименование</th>
                <th>Описание</th>
                <th>К списку продуктов</th>
            </tr>
        </thead>
   <tbody>
   @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    <td class="text-center">
                        <a role="button" class="btn btn-outline-dark" href="{{ route('category', $category->id) }}">Перейти</a>
                    </td>
   @endforeach                 
   </tbody>
</table>
<form method="post" action="{{route('ExportCategories')}}">
        @csrf
      <button class="btn btn-outline-secondary btn-lg" type="submit" class="btn btn-link">Выгрузить категории</button>  
    </form> 

  
@endsection