@extends('elemente.layout')
@section('titlu', $product->producator)
@section('continut')
    @include('elemente.flashmes')
    @include('elemente.product')
@endsection
