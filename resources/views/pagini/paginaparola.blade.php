@extends('elemente.layout2')
@section('titlu', 'Parolă uitată')
@section('continut')
<div class="imagine">
    <img src="{{ URL('imagini/kiraracat.png') }}">
    <p>Introdu emailul contului și îți vom trimite în scurt timp linkul de resetare a parolei</p>
</div>
<div class="container">
    <div class="home">
        <a href="/logare">&lt&lt Logare</a>
    </div>
    <form>
        @csrf
        <input type="email" name="email" placeholder="Email">
        @error('email')
            <div class="eroare">{{ $message }}</div>
        @enderror
        <button type="submit">Trimite</button><br>
    </form>
</div>
@endsection

<style>
    .imagine {
        text-align: center; 
        padding-top: 95px
    }

    .imagine img {
        width: 150px
    }

    .imagine p {
        color: rgb(162, 177, 64)
    }

    .container {
        text-align:center; 
        background-color: rgb(245, 226, 226); 
        padding-bottom: 7px; 
        padding-left: 15px; 
        padding-right: 15px; 
        padding-top: 15px; 
        position: absolute; 
        top: 55%; 
        left: 50%; 
        transform: translate(-50%, -50%); 
        outline-style: solid; 
        outline-color: rgb(233, 183, 182); 
        border-radius: 10px; 
        width: 300px; 
        color:rgb(119, 173, 173)
    }

    .home {
        text-align: start; 
        padding-left: 10px; 
        padding-bottom: 15px
    }

    a {
        color: rgb(162, 177, 64); 
        text-decoration: none; 
        font-weight:bold;
        font-size: 17px
    }

    input {
        margin-bottom: 10px; 
        width: 95%; 
        height: 50px; 
        font-size: 15px; 
        padding-left: 10px; 
        border-color:rgb(186, 215, 215); 
        border-style: solid; 
        border-radius: 5px;
    }

    input:focus {
        outline-color:rgb(119, 173, 173); 
    }

    input::placeholder {
        color:rgb(119, 173, 173); 
    }

    .parola {
        text-align: end; 
        padding-right: 10px;
        padding-top: 5px;
        padding-bottom: 15px
    }

    button {
        background-color: rgb(186, 215, 215); 
        color:rgb(63, 119, 115); 
        border-radius: 5px; 
        width: 95%; 
        height: 40px; 
        font-weight:bold; 
        border-color: rgb(119, 173, 173); 
        border-style: solid; 
        font-size: 17px
    }

    .eroare {
        color: red;
        font-size: 14px
    }
</style>