@auth
    <div class="container">
        <div class="elem">
            <a href="/"><img src="{{ URL('imagini/nume.png')}}"></a>
            <div class="search">
                <form action="/" method="GET">
                    @csrf
                    <input type="text" name="search" placeholder="Căutare" value={{ request('search') }}>
                    <button><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
            </div>
        </div>
        <div class="butoane">
            <form action="/profil/{{Auth::id()}}" method="GET">
                @csrf
                <button>Profil</button>
            </form>
            <form action="/delogare" method="POST">
                @csrf
                <button>Delogare</button>
            </form>
        </div>
    </div>
    @else
    <div class="container">
        <div class="elem">
            <img src="{{ URL('imagini/nume.png') }}">
            <div class="search">
                <form action="/" method="GET">
                    @csrf
                    <input type="text" name="search" placeholder="Căutare" value={{ request('search') }}>
                    <button><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
            </div>
        </div>
        <div class="butoane">
            <form action="/logare" method="GET">
                @csrf
                <button>Logare</button>
            </form>
            <form action="/inregistrare" method="GET">
                @csrf
                <button>Înregistrare</button>
            </form>
        </div>
    </div>
@endauth

<style>
    .container {
        display: flex; 
        align-items: center; 
        justify-content: space-between
    }

    .elem {
        display: flex; 
        gap: 15px; 
        align-items: center
    }

    .elem img {
        width: 250px; 
        padding-top: 5px;
        padding-left: 10px
    }

    .search {
        display: inline-block
    }

    .search input {
        width: 800px; 
        height: 40px; 
        border-radius: 50px; 
        border-style: solid; 
        padding-left: 20px; 
        margin-right: 5px; 
        border-color: rgb(186, 215, 215); 
        border-width: 3px
    }

    .search input:focus {
        outline-color:rgb(119, 173, 173); 
    }

    .search input::placeholder {
        color:rgb(119, 173, 173); 
        font-size: 14px
    }

    .search button {
        border-radius: 50px; 
        width: 40px; 
        height: 40px; 
        border-color:rgb(186, 215, 215); 
        border-style: solid; 
        background-color: white; 
        border-width: 3px
    }

    i {
        color: rgb(63, 119, 115)
    }

    .butoane {
        display: flex; 
        gap: 15px; 
        padding-right: 40px
    }

    .butoane button {
        background-color: white; 
        border-color: white; 
        border-style: solid; 
        color: rgb(162, 177, 64); 
        font-weight: bold; 
        font-size: 15px
    }
</style>