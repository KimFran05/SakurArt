@extends('elemente.layout')
@section('titlu', $category->nume)
@section('continut')
    @include('elemente.flashmes')
    <div class="nume-cat">
        {{ $category['nume'] }}
    </div>
    @include('elemente.products')
   
    <style>
        .nume-cat {
            color: rgb(63, 119, 115);
            font-size: 25px;
            text-align: center;
            padding: 10px
        }
    </style>
@endsection
