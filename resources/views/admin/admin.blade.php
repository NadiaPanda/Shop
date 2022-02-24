@extends('layouts.app')

@section('title')
    Админка
@endsection

@section('content')
    <div class="container">
        <table class="table table-bordered">
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <a href="{{route ('enterAsUser', $user->id}}">
                        Войти
                    </a>
                </tr>
            </tbody>

        </table>
        
        <form method="post" action="{{route('ExportCategories')}}">
        @csrf
      <button type="submit" class="btn btn-link">Выгрузить категории</button>  
    </form> 

    </div>
@endsection