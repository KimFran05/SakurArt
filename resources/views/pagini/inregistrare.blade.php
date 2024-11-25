@extends('elemente.layout2')
@section('titlu', 'Înregistrare')
@section('continut')
<div class="imagine">
    <img src="{{ URL('imagini/logo.png') }}">
</div>
<div class="container">
    <div class="home">
        <a href="/">&lt&lt Home</a>
    </div>
    <form action="/inregistrare" method="POST">
        @csrf
        <div class="numeprenume">
            <input class="nume" type="text" name="name" placeholder="Nume">
            <input type="text" name="prenume" placeholder="Prenume">
        </div>
        <input type="email" name="email" placeholder="Email"><br>
        <input type="password" name="password" placeholder="Parolă"><br>
        <input class="pass" type="password" name="password_confirmation" placeholder="Confirmare parolă"><br>
        @error('name')
            <div class="eroare">{{ $message }}</div>
        @enderror
        @error('prenume')
            <div class="eroare">{{ $message }}</div>
        @enderror
        @error('email')
            <div class="eroare">{{ $message }}</div>
        @enderror
        @error('password')
            <div class="eroare">{{ $message }}</div>
        @enderror
        <button type="submit">Înregistrare</button><br>
    </form>
    <div class="schimb">
        Ai deja cont? <a href="/logare">Loghează-te acum<a>
    </div>
</div>
@endsection

<style>
    .imagine {
        text-align: center; 
        padding-top: 70px
    }

    .imagine img {
        width: 300px
    }

    .container {
        text-align:center; 
        background-color: rgb(245, 226, 226); 
        padding-bottom: 15px; 
        padding-left: 15px; 
        padding-right: 15px; 
        padding-top: 15px; 
        position: absolute; 
        top: 60%; 
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

    .numeprenume {
        display: flex;
        margin: 0px 7.5px
    }

    .nume {
        margin-right: 10px
    }

    input:focus {
        outline-color:rgb(119, 173, 173); 
    }

    input::placeholder {
        color:rgb(119, 173, 173); 
    }

    .pass{
        margin-bottom: 10px;
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
        font-size: 17px;
        margin-top: 10px
    }

    .eroare {
        color: red;
        font-size: 14px
    }

    .schimb{
        font-size: 17px
    }
</style>