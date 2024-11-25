<form action="/adaugarerecenzie/{{ $product->id }}" method="POST">
    @csrf
    <div class="recform">
        <input type="number" name="rating" placeholder="Rating" min="1" max="5"><br>
        <input class="titlu" type="text" name="titlu" placeholder="Titlu"><br>
        <textarea name="continut" cols="30" rows="10" placeholder="Review"></textarea><br>
        @error('rating')
            <div class="eroare">{{ $message }}</div>
        @enderror
        @error('titlu')
            <div class="eroare">{{ $message }}</div>
        @enderror 
        @error('continut')
            <div class="eroare">{{ $message }}</div>
        @enderror
        <button class="adrev">Adaugă recenzie</button>
    </div>
</form>

<style>
    .recform {
        width: 50%;
        padding-left: 15px
    }

    .recform input {
        margin-bottom: 10px; 
        width: 30%; 
        height: 50px; 
        font-size: 15px; 
        padding-left: 10px; 
        border-color:rgb(211, 219, 157); 
        border-style: solid; 
        border-radius: 5px;
    }

    .recform input:focus {
        outline-color:rgb(162, 177, 64); 
    }

    .recform input::placeholder {
        color:rgb(162, 177, 64); 
    }

    .recform textarea {
        margin-bottom: 5px;
        width: 95%; 
        height: 80px; 
        font-size: 15px; 
        padding-left: 10px; 
        border-color:rgb(211, 219, 157); 
        border-style: solid; 
        border-width: 2px;
        border-radius: 5px;
    }

    .recform textarea:focus {
        outline-color:rgb(162, 177, 64); 
    }

    .recform textarea::placeholder {
        color:rgb(162, 177, 64); 
    }

    .adrev {
        margin-top: 7px;
        background-color: rgb(186, 215, 215); 
        color:rgb(63, 119, 115); 
        border-radius: 5px; 
        width: 40%; 
        height: 40px; 
        font-weight:bold; 
        border-color: rgb(119, 173, 173); 
        border-style: solid; 
        font-size: 17px;
        margin-bottom: 5px
    }

    .eroare {
        color: red;
        font-size: 14px;
        padding-left: 5px
    }
</style>