@extends('elemente.layout')
@section('titlu', $user->name. ' ' .$user->prenume)
@section('continut')
    @include('elemente.flashmes')
    @if ($user->id == Auth::id())
        <div class="profil">
            @include('elemente.butoane-profil')
            <div class="ver">
                <div class="t">
                    Profil
                </div>
                <div class="informatii">
                    @if ($user->image)
                        <img class="poza-profil2" src="{{ URL('storage/' . $user->image) }}">
                    @else
                        <div class="poza-profil"></div>
                    @endif
                    Nume: {{ $user->name }}<br>
                    @if (is_null($user->prenume))
                        Prenume: -<br>
                    @else
                        Prenume: {{ $user->prenume }}<br>
                    @endif
                    Email: {{ $user->email }}<br>
                    Produse preferate: {{ count($user->favorites) }}<br>
                    Comenzi plasate: {{ count($user->orders) }}<br>
                    Recenzii postate: {{ count($user->reviews) }}
                </div>
                <div class="reccom">
                    <div class="recenzii-profil">
                        <div class="t-rec">
                            Recenzii postate
                        </div>
                        @include('elemente.recenziiprofil')
                    </div> 
                    <div class="recenzii-profil">
                        <div class="t-com">
                            Comenzi plasate
                        </div>
                        @include('elemente.comenziprofil')
                    </div>
                </div>
            </div>
        </div>  
    @else
    <div class="profil">
        <div class="ver">
            <div class="t">
                Profil
            </div>
            <div class="informatii">
                @if ($user->image)
                        <img class="poza-profil2" src="{{ URL('storage/' . $user->image) }}">
                    @else
                        <div class="poza-profil"></div>
                    @endif
                    Nume: {{ $user->name }}<br>
                    @if (is_null($user->prenume))
                        Prenume: -<br>
                    @else
                        Prenume: {{ $user->prenume }}<br>
                    @endif
                    Email: {{ $user->email }}<br>
                    Produse preferate: {{ count($user->favorites) }}<br>
                    Comenzi plasate: {{ count($user->orders) }}<br>
                    Recenzii postate: {{ count($user->reviews) }}
            </div>
            <div class="recenzii-profil">
                <div class="t-rec">
                    Recenzii postate
                </div>
                @include('elemente.recenziiprofil')
            </div> 
        </div>
    </div>  
    @endif

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
    
        .informatii {
            display: flex; 
            align-items: center;
            flex-direction: row; 
            justify-content: center;
            width: 100%;
            color: rgb(187, 138, 138); 
            background-color: rgb(245, 226, 226); 
            outline-style: solid; 
            outline-color: rgb(233, 183, 182); 
            border-radius: 20px; 
            width: 400px;
            padding: 20px 0px;
            margin-left: 34.5%;
            margin-top: 15px;
            margin-bottom: 3px
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
        }

        .poza-profil2 {
            border-radius: 100px; 
            width: 150px;
            height: 150px;
            margin-right: 20px; 
            background-size: cover; 
            round-position: center;
        }

        .recenzii-profil{
            padding-top: 15px;
            padding-left: 20px
        }

        .t {
            color: rgb(63, 119, 115);
            font-size: 25px;
            text-align: center;
            padding: 5px
        }

        .recenzii-profil .t-rec {
            color: rgb(63, 119, 115);
            font-size: 25px;
            padding-left: 25px;
            padding-bottom: 3px
        }

        .recenzii-profil .t-com {
            color: rgb(63, 119, 115);
            font-size: 25px;
            padding-right: 25px;
            padding-bottom: 3px;
            text-align: end
        }

        .reccom {
            display: flex;
            gap: 23%
        }
    </style>
@endsection