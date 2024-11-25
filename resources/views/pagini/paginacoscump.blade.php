@extends('elemente.layout')
@section('titlu', 'Coș de cumpărături')
@section('continut')
    <div class="t">
        Coș de cumpărături
    </div>
    @include('elemente.productscos')

    <style>
        .t {
            color: rgb(63, 119, 115);
            font-size: 25px;
            text-align: center;
            padding: 10px
        }
    </style>
@endsection