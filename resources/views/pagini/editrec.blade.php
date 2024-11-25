@extends('elemente.layout')
@section('titlu', 'Etitare recenzie')
@section('continut')
    <div class="edrec">
        Editare recenzie
    </div>
    <div class="editcontrec">
        <form action="/editarerec/{{$review->id}}" method="POST">
            @csrf
            @method('PUT')
            <div class="fields">
                Rating: <input type="number" name="rating" value="{{$review->rating}}" min="1" max="5"><br>
                Titlu: <input type="text" name="titlu" value="{{$review->titlu}}"><br>
                Review:<br> 
                <textarea name="continut">{{$review->continut}}</textarea><br>
            </div>
            @error('rating')
                <div class="eroare">{{ $message }}</div>
            @enderror
            @error('titlu')
                <div class="eroare">{{ $message }}</div>
            @enderror 
            @error('continut')
                <div class="eroare">{{ $message }}</div>
            @enderror
            <button>Editează</button>
        </form>
        <form action="/profil/{{Auth::id()}}" method="GET">
           <button>Anulare</button> 
        </form>
    </div>

    <style>
    
        .edrec {
            color: rgb(63, 119, 115);
            font-size: 25px;
            text-align: center;
            padding: 10px
        }

        .editcontrec {
            border: solid rgb(186, 215, 215);
            border-radius: 20px;
            padding: 20px;
            margin: 0 auto;
            margin-bottom: 15px;
            color: rgb(187, 138, 138); 
            font-size: 17px;
            width: 400px;
            text-align: center;
            margin-top: 5px
        }

        .fields {
            text-align: start
        }

        .editcontrec input {
            margin-bottom: 10px; 
            width: 200px; 
            height: 50px; 
            font-size: 15px; 
            padding-left: 10px; 
            border-color:rgb(211, 219, 157); 
            border-style: solid; 
            border-radius: 5px;
        }

        .editcontrec textarea {
            margin-top: 5px; 
            margin-bottom: 8px; 
            width: 200px;
            height: 80px; 
            font-size: 15px; 
            padding-left: 10px; 
            border-color:rgb(211, 219, 157); 
            border-style: solid; 
            border-radius: 5px;
            border-width: 2px
        }

        .editcontrec input:focus {
            outline-color:rgb(162, 177, 64); 
        }

        .editcontrec textarea:focus {
            outline-color:rgb(162, 177, 64); 
        }

        .editcontrec button {
            margin-top: 10px;
            background-color: rgb(186, 215, 215); 
            color:rgb(63, 119, 115); 
            border-radius: 5px; 
            width: 250px; 
            height: 40px; 
            font-weight:bold; 
            border-color: rgb(119, 173, 173); 
            border-style: solid; 
            font-size: 17px
        }
        .eroare {
            color: red;
            font-size: 14px;
        }
    </style>
@endsection