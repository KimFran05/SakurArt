@extends('elemente.layout')
@section('titlu', 'Home')
@section('continut')
    @include('elemente.flashmes')
    <div class="t">
        Produse
    </div>
    @include('elemente.products')

<style>
    .t {
        color: rgb(63, 119, 115);
        font-size: 25px;
        text-align: center;
        padding: 10px
    }
</style>
@endsection