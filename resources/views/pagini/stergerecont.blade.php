@extends('elemente.layout')
@section('titlu', $user->name. ' ' .$user->prenume)
@section('continut')
    @include('elemente.flashmes')
    <div class="profil">
        @include('elemente.butoane-profil')
        <div class="ver">
            <div class="t">
                Ștergere cont
            </div>
            <div class="container-editareprof">
                <form action="/stergerecont/{{Auth::id()}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input class="text" type="password" name="password" placeholder="Parolă"><br>
                    <input class="text" type="password" name="password_confirmation" placeholder="Confirmare parolă">
                    @error('password')
                        <div class="eroare">{{ $message }}</div>
                    @enderror
                    <button class="edit" type="submit">Șterge cont</button>
                </form>
                <form action="/profil/{{ Auth::id() }}" method="GET">
                    <button type="submit">Anulare</button>  
                </form>
            </div>
        </div>
    </div>  

    <style>
        .profil {
            display: flex;
        }

        .ver {
            display: flex;
            flex-direction: column;
            width: 100%;
            padding-top: 5px
        }

        .t {
            color: rgb(63, 119, 115);
            font-size: 25px;
            text-align: center;
            padding: 5px
        }

        .container-editareprof {
            text-align: center; 
            background-color: rgb(245, 226, 226); 
            margin-top: 15px;
            margin-bottom: 20px;
            padding: 20px 15px;
            position: relative; 
            left: 37.5%; 
            outline-style: solid; 
            outline-color: rgb(233, 183, 182); 
            border-radius: 10px; 
            width: 300px; 
            color:rgb(119, 173, 173)
        }

        .poza-profil {
            background-image: url({{ url('imagini/emojikirara.png') }}); 
            background-color: white;
            border-radius: 100px; 
            width: 150px;
            height: 150px;
            margin-right: 20px; 
            background-size: cover; 
            round-position: center;
            margin-bottom: 10px;
            margin-left: 75px
        }

        .file {
            padding-bottom: 10px
        }
        
        .container-editareprof .text {
            margin-bottom: 10px; 
            width: 90%; 
            height: 50px; 
            font-size: 15px; 
            padding-left: 10px; 
            border-color:rgb(186, 215, 215); 
            border-style: solid; 
            border-radius: 5px;
        }

        .container-editareprof .text:focus {
            outline-color:rgb(119, 173, 173); 
        }

        .container-editareprof .text::placeholder {
            color:rgb(119, 173, 173); 
        }

        .container-editareprof button {
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

        .edit {
            margin-top: 10px;
            margin-bottom: 10px
        }

        .eroare {
            color: red;
            font-size: 14px
        }
    </style>
@endsection