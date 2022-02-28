@extends('layouts.app')

@section('title')
    Профиль
@endsection

@section('styles')
<style>
    .user-picture {
        width: 100px;
        border-radius: 100px;
        display: block;
    }
    .main-address {
        font-weight: bold;
    }
</style>
@endsection

@section('content')

    @if ($errors->isNotEmpty())
        <div class="alert alert-warning" role="alert">
            @foreach ($errors->all() as $error)
                {{$error}}
                @if (!$loop->last)<br> @endif
            @endforeach
        </div>
    @endif

    @if (session('profileSaved'))
    <div class="alert alert-success" role="alert">
        Профиль успешно сохранен!
    </div>
    @endif

    <form method="post" action="{{ route('saveProfile') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" value="{{ $user->id }}" name='userId'>
        <div class="mb-3">
            <label class="form-label">Изображение</label>
            <image class="user-picture mb-2" src="{{asset('storage')}}/{{$user->picture}}">
            <input type="file" name="picture" class="form-control">
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Почта</label>
            <input type="email" name="email" value="{{ $user->email }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label class="form-label">Имя</label>
            <input name="name" value="{{ $user->name }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Текущий пароль</label>
            <input type="password" autocomplete="off" name="current_password" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Новый пароль</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Повторите новый пароль</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Список адресов:</label>
            <ul>
                @forelse ($user->addresses as $address)
                    <input class="form-check-input" @if ($address->main) checked @endif id="{{ $address->id }}" name="main_address" type="radio" value="{{ $address->id }}">
                    <label for="{{ $address->id }}">{{$address->address}}</label>
                    <br>
                @empty 
                    <em>- Адреса не указаны -</em>
                @endforelse
            </ul>
        </div>
        <div class="mb-3">
            <label class="form-label">Новый адрес</label>
            <input name="new_address" class="form-control" placeholder="Введите новый адрес">
                <div class="form-check mt-1">
                    <input name="set_main_address" class="form-check-input" type="checkbox" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                    Сделать основным
                    </label>
                </div>
        </div>
        <button type="submit" class="btn btn-outline-dark ">Сохранить</button>
    </form>
    <div class="d-grid gap-2 col-6 mx-auto">
    <a role="button" class="btn btn-outline-dark btn-lg" aria-current="page" href="{{ route('orders', Auth::user()->id) }}">
        <strong>Мои заказы</strong>
    </a>
    </div>
@endsection