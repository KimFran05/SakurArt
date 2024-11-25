<div class="comanda">
    <div class="tt">
        <div class="livrare">Detalii livrare:</div>
        <div class="card">Detalii card:</div>
    </div>
    <div class="container-detalii">
        <form action="/plata" method="POST">
            @csrf
            <div class="numeprenume">
                <input class="nume" type="text" name="nume" placeholder="Nume">
                <input type="text" name="prenume" placeholder="Prenume">
            </div>
            <input type="text" maxlength="10" name="numartelefon" placeholder="Număr telefon"><br>
            <div class="numeprenume">
                <input class="nume" type="text" name="judet" placeholder="Județ"><br>
                <input type="text" name="localitate" placeholder="Localitate"><br>
            </div>
            <input class="pass" type="text" name="adresa" placeholder="Adresă"><br>
            <input type="text" maxlength="16" name="numarcard" placeholder="Număr card"><br>
            <div class="numeprenume">
                <input class="nume" maxlength="5" type="text" name="dataexpirarii" placeholder="Data expirării"><br>
                <input type="text" maxlength="4" name="cvv" placeholder="CVV"><br>
            </div>
            <input class="pass" type="text" name="numedetinator" placeholder="Nume deținător"><br>
            @error('nume')
                <div class="eroare">{{ $message }}</div>
            @enderror
            @error('prenume')
                <div class="eroare">{{ $message }}</div>
            @enderror
            @error('numartelefon')
                <div class="eroare">{{ $message }}</div>
            @enderror
            @error('judet')
                <div class="eroare">{{ $message }}</div>
            @enderror
            @error('localitate')
                <div class="eroare">{{ $message }}</div>
            @enderror
            @error('adresa')
                <div class="eroare">{{ $message }}</div>
            @enderror
            @error('numarcard')
                <div class="eroare">{{ $message }}</div>
            @enderror
            @error('dataexpirarii')
                <div class="eroare">{{ $message }}</div>
            @enderror
            @error('cvv')
                <div class="eroare">{{ $message }}</div>
            @enderror
            @error('numedetinator')
                <div class="eroare">{{ $message }}</div>
            @enderror
            <button type="submit">Plată</button>
        </form>
    </div>
</div>

<style>
    .comanda {
        display: flex;
        padding-left: 31.3%;
        gap: 20px;
        margin-top: 10px
    }
    .container-detalii {
        text-align: center; 
        background-color: rgb(245, 226, 226); 
        padding: 20px 15px;
        outline-style: solid; 
        outline-color: rgb(233, 183, 182); 
        border-radius: 10px; 
        width: 300px; 
        color:rgb(119, 173, 173);
        margin-bottom: 30px
    }

    .tt {
        color:rgb(106, 116, 41);
        font-size: 17px;
        text-align: end
    }

    .livrare {
        padding-top: 35px;
        padding-bottom: 243px
    }

    .numeprenume {
        display: flex;
        margin: 0px 7.5px
    }

    .nume {
        margin-right: 10px
    }

    input {
        margin-bottom: 10px; 
        width: 90%; 
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
</style>