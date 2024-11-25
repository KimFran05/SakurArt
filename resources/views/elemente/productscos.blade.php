@if(count($cart_products) > 0)
    <div class="prodcos">
        <div class="stanga">
            @foreach ($cart_products as $cart_product)
            <div class="prodcos2">
                <div class="container-prodcos">
                    <img src="{{ URL('storage/' . $cart_product['image']) }}">
                    <div class="infoprodcos">
                        <a href="/produs/{{$cart_product->id_produs}}">
                            {{ $cart_product['name'] }}
                        </a>
                        <div class="pretprodcos">
                            {{ $cart_product['pret'] }} lei
                        </div>
                    </div>
                    <div class="cantitate">
                        <form action="/cantitateplus/{{ $cart_product->id }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button><i class="fa fa-plus"></i></button>
                        </form>
                        {{ $cart_product['cantitate'] }}
                        <form action="/cantitateminus/{{ $cart_product->id }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button><i class="fa fa-minus"></i></button> 
                        </form>
                    </div>
                </div>
                <div class="delete">
                    <form action="/stergereproduscos/{{ $cart_product['id'] }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button><i class="fa fa-trash"></i> </button>
                    </form>
                </div>
            </div>
        @endforeach
        </div>
        <div class="sume-buton">
            <div class="container-total">
                <div class="sume">
                    @php
                        $totalproduse = 0;
                        
                        foreach ($cart_products as $produs) {
                            $totalproduse += $produs['pret'] * $produs['cantitate'];
                        }

                        $totalproduse = number_format($totalproduse, 2, '.', '');
                    @endphp
                    Cost produse: {{ $totalproduse }} lei<br>
                    Cost livrare: 10.00 lei <br>
                    @php
                        $totalproduse += 10;
                        $totalproduse = number_format($totalproduse, 2, '.', '');
                    @endphp
                    Total: {{ $totalproduse }} lei
                </div>
                <form action="/plata" method="GET">
                    <button type="submit">Pasul următor</button><br>
                </form>
            </div>
            <div class="delete-delete">
                <form action="/stergereprodusecos" method="POST">
                    @csrf
                    @method('DELETE')
                    <button><i class="fa fa-trash"></i> </button>
                </form>
            </div>
        </div>
    </div>
@else
    <div class="mesaj">Nu ai adăugat niciun produs în coș!</div>
@endif

<style>
    .prodcos {
        display: flex;
        justify-content: center;
        gap: 100px;
        margin-bottom: 30px
    }

    .prodcos2 {
        display: flex
    }

    .container-prodcos{
        outline-style: solid; 
        outline-color: rgb(211, 219, 157); 
        border-radius: 20px; 
        margin-top: 10px; 
        margin-bottom: 10px; 
        padding: 20px 30px;
        margin-left: 30px; 
        width: 500px;
        display: flex; 
        align-items: center; 
        justify-content: space-between
    }

    .container-prodcos img {
        width: 150px
    }

    .infoprodcos {
        width: 230px;
        font-size: 23px;
    }

    .infoprodcos a {
        text-decoration: none;
        color: rgb(106, 116, 41);
    }

    .infoprodcos .pretprodcos {
        padding-top: 5px;
        color: rgb(187, 138, 138)
    }

    .cantitate {
        display: flex; 
        flex-direction: column;
        align-items: center;
        font-size: 25px;
        color: rgb(119, 173, 173);
        gap: 10px;
        font-weight: bold
    }

    .cantitate button {
        border-radius: 50px; 
        width: 30px; 
        height: 30px; 
        font-size: 17px;
        border: none;
        background-color: transparent
    }

    .sume-buton {
        display: flex
    }

    .cantitate button i {
        color: rgb(119, 173, 173)
    }

    .prodcos2 .delete {
        padding: 20px 10px 
    }

    .prodcos2 .delete button{
        border: none;
        background-color: transparent;
        font-size: 17px
    }

    .sume-buton .delete-delete {
        padding-top: 20px;
        padding-right: 30px
    }

    .sume-buton .delete-delete button{
        border: none;
        background-color: transparent;
        font-size: 17px
    }

    .container-total {
        background-color: rgb(245, 226, 226); 
        outline-style: solid; 
        outline-color: rgb(233, 183, 182); 
        border-radius: 20px; 
        padding: 20px; 
        color: rgb(187, 138, 138);
        margin-top: 10px;
        margin-right: 10px;
        width: 400px;
        height: 113px;
        font-size: 17px;
        text-align: center
    }

    .container-total .sume {
        text-align: left;
        padding-left: 20px;
        padding-bottom: 10px
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
        font-size: 17px
    }

    .mesaj {
        color: rgb(63, 119, 115);
        text-align: center;
        padding-top: 20px;
        padding-bottom: 20px
    }
</style>