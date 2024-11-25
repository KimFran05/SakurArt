@if(count($products) > 0)
    <div class="prod">
        @foreach ($products as $product)
            <div class="container-prod">
                <form action="/stergereproduspref/{{$product->id}}" method="POST">
                    @csrf
                    <button class="pref"><i class="fa fa-heart" ></i></button><br>
                </form>
                <img src="{{ URL('storage/' . $product->image) }}">
                <div class="nume">
                    <a href="/produs/{{$product->id}}">
                        {{ $product['nume'] }}
                    </a>
                </div>
                <div class="pret">
                    {{ $product['pret'] }} lei
                    <form action="/adaugareproduscos/{{$product->id}}" method="POST">
                        @csrf
                        <button>+</button>  
                    </form>
                </div>
            </div>
        @endforeach
    </div>
    <div class="pagination">
        {{ $products->links() }}    
    </div>
@else
    <div class="mesaj">Nu ai adăugat niciun produs la preferate!</div>
@endif


<style>
    .prod {
        display: grid;
        grid-template-columns: repeat(4, 1fr); 
        gap: 15px;
        max-width: 900px;
        margin: 0 auto;
        padding: 10px;
        padding-right: 100px
    }

    .pref {
        border: none;
        background-color: transparent;
        margin-left: 83% 
    }

    .container-prod {
        display: flex;
        flex-direction: column;
        padding: 20px;
        outline-style: solid;
        outline-color: rgb(211, 219, 157);
        border-radius: 10px;
    }

    .container-prod img {
        width: 100%
    }

    .container-prod i {
        text-align: end;
        color: rgb(233, 183, 182);
        font-size: 25px
    }

    .nume a {
        color:rgb(106, 116, 41);
        width: 200px; 
        height: 40px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        white-space: normal;
        padding-top: 10px;
        font-size: 17px;
        text-decoration: none
    }

    .pret {
        color: rgb(63, 119, 115);
        font-size: 20px;
        padding-top: 5px;
        display: flex; 
        align-items: center;
        justify-content: space-between
    }

    .pret button {
        background-color: white;
        border: none;
        text-align: end;
        font-size: 30px;
        color: rgb(63, 119, 115)
    }

    .mesaj {
        color: rgb(63, 119, 115);
        text-align: center;
        padding-top: 20px;
        padding-bottom: 20px
    }

    .pagination {
        display: flex;
        flex-wrap: nowrap;
        justify-content: center; 
        padding: 10px; 
        margin: 0; 
        gap: 20px;
        margin-bottom: 5px
    }

    .pagination li {
        list-style: none
    }

    .pagination a {
        display: block;
        text-decoration: none;
        color: rgb(119, 173, 173);
        font-size: 20px     
    }

    .pagination .active {
        color: rgb(162, 177, 64);
        font-size: 20px;
        font-weight: bold
    }

    .pagination .disabled span, 
    .pagination .disabled a {
        color: rgb(119, 173, 173) !important; 
        pointer-events: none; 
        font-size: 20px;
        opacity: 0.5; 
    }
</style>