@extends ('layouts.app')

@section ('title')

Список продуктов

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
                <th>Цена</th>
            </tr>
        </thead>
   <tbody>
   @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
   @endforeach                 
   </tbody>
</table> 

<form method="post" action="{{route('ExportProducts')}}">
        @csrf
      <button class="btn btn-outline-secondary btn-lg" type="submit" class="btn btn-link">Выгрузить продукты</button>  
    </form> 

@endsection

