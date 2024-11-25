<div class="butoane-profil">
    <form action="/editareprofil/{{Auth::id()}}" method="GET">
        <button>Editează profil</button>
    </form>
    <form action="/schimbareparola/{{Auth::id()}}" method="GET">
        <button>Schimbă parola</button>
    </form>
    <form action="/stergerecont/{{Auth::id()}}" method="GET">
        <button>Șterge cont</button>
    </form>
</div>
<div class="vl"></div>

<style>
    .butoane-profil {
        width: 15%;
        padding-left: 20px;
        padding-right: 10px;
        padding-top: 15px;
    }

    .butoane-profil button {
        background-color: rgb(186, 215, 215); 
        color: rgb(63, 119, 115); 
        border-radius: 5px; 
        width: 95%; 
        height: 40px; 
        font-weight: bold; 
        border-color: rgb(119, 173, 173); 
        border-style: solid; 
        font-size: 17px;
        margin-bottom: 10px;
    }

    .vl {
        border-left: 3px solid rgb(186, 215, 215);
        margin-bottom: 10px;
    }
</style>