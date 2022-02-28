@extends('layouts.app')

@section('styles')
<style>
    .vertical_align_text {
        vertical-align: middle;
    }
</style>
@endsection

@section('content')
<table class="table table-bordered">
    <thead class="text-center">
        <tr class="vertical_align_text">
            <th>#</th>
            <th>Номер заказа</th>
            <th>Товары</th>
            <th>Адрес</th>
            <th>Дата оформления</th>
            <th>Повторить заказ</th>
        </tr>
    </thead>
    <tbody>
        
        @forelse ($orders as $idx => $order)
                <tr class="text-center vertical_align_text">
                    <td>{{ $idx + 1 }}</td>
                    <td>{{ $order->id }}</td>
                    <td>
                @php
                    $products = $order->products;
                    $summ = 0;
                @endphp    
                @foreach ($products as $product)
                    @php 
                        
                    @endphp 
                    {{ $product->name }} ({{ $product->pivot->quantity }} шт.) <b>{{ $product->pivot->price }} р.</b> <br>
                    @php
                        $productSum = $product->pivot->price * $product->pivot->quantity;
                        $summ = $summ + $productSum;                   
                    @endphp
                    @endforeach</td>
                    <td>{{ $order->getAddress($order->address_id) }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>
                        <form method="post" action="{{ route('repeatOrder') }}">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}"/>
                            <button class="btn btn-outline-dark" type="submit">Повторить</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="5">Здесь пока ничего нет, но можно это <a href="{{ route('home') }}">исправить</a></td>
                </tr>
        @endforelse
    </tbody>
</table>
@endsection