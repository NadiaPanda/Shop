@extends('layouts.app')


@section('styles')
<style>
    .product-buttons {
        display: flex;
        justify-content: space-evenly;
        line-height: 37px;
    }
</style>
@endsection

@section('content')
    <cart-component 
    :prods="{{$products}}"
    :user="{{$user}}"
    address="{{$address}}"
    >

    </cart-component>
    
@endsection