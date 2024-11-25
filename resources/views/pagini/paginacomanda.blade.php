@extends('elemente.layout')
@section('titlu', 'Plată')
@section('continut')
<div class="t">
    Plată comandă
</div>
@include('elemente.detaliicomanda')
<style>
.t {
    color: rgb(63, 119, 115);
    font-size: 25px;
    text-align: center;
    padding: 10px
}
</style>
@endsection