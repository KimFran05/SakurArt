<div class="menu">
    <a href="/">Home</a>
    <div class="dropdown">
        <div class="cat">Categorii</div>
        <div class="dropdown-content">
            @foreach ($categories as $category)
                @if ($category['id'] < 7)
                    <a href="/categorie/{{$category->id}}"> {{ $category['nume'] }} </a>
                    <hr>
                @else
                <a href="/categorie/{{$category->id}}"> {{ $category['nume'] }} </a>
                @endif
            @endforeach
        </div>
    </div>
    <a href="/coscumparaturi">Coș de cumpărături</a>
    <a href="/prodpreferate">Produse preferate</a>
</div>

<style>
    .menu {
        position: sticky;
        top: 2px;
        display: flex; 
        gap: 15px; 
        background-color: rgb(245, 226, 226); 
        outline-style: solid; 
        outline-color: rgb(233, 183, 182); 
        border-radius: 20px; 
        margin: 10px 5px;
        text-align: center; 
        padding: 10px 20px
    }

    .menu a {
        color: rgb(187, 138, 138); 
        text-decoration: none; 
        font-weight:bold;
        font-size: 17px
    }

    .cat{
        color: rgb(187, 138, 138); 
        font-weight:bold;
        font-size: 17px 
    }

    .dropdown {
        display: inline-block; 
        position: relative
    } 

    .dropdown-content {
        display: none; 
        position: absolute; 
        background-color: #ffffff;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        padding: 10px 0px
    }

    .dropdown-content a {
        color: rgb(162, 177, 64);
        text-decoration: none;
        padding: 5px 0px;
        display: block;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    hr {
        border:none;
        height:2px;
        background-color: rgb(186, 215, 215)
    }
</style>