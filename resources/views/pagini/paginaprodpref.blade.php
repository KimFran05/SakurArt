@extends('elemente.layout')
@section('titlu', 'Produse preferate')
@section('continut')
    @include('elemente.flashmes')
    <div class="t">
        Produse preferate
    </div>
    @include('elemente.productspref')

    <style>
        .t {
            color: rgb(63, 119, 115);
            font-size: 25px;
            text-align: center;
            padding: 10px
        }
    </style>
@endsection