<div class="contprod"> 
    <div class="prodinfo">
        <img src="{{ URL('storage/' . $product->image) }}">
        <div class="prodinfocont">
            <div class="numeprod">{{ $product['nume'] }}</div>
            <div class="producator">
                Producător: {{ $product['producator'] }}
                <div class="recenzie">
                    <i class="fa fa-star" ></i> {{ $product->reviews->avg('rating') ? $product->reviews->avg('rating') : 0 }}
                </div>
            </div>
            <div class="pagpret">
                {{ $product['pret'] }} lei
            </div>
            <div class="butoane-prod">
                <form action="/adaugareproduspref/{{$product->id}}" method="POST">
                    @csrf
                    <button class="pref"><i class="fa fa-heart-o" ></i></button>
                </form>
                @if ($product['stoc'] > 0)
                    <form action="/adaugareproduscos/{{$product->id}}" method="POST">
                        @csrf
                        <button class="cos">Adaugă în coș</button>
                    </form>
                @else
                    <button class="cos">Stoc epuizat</button>
                @endif
            </div>
            <div class="des">
                Descriere
            </div> 
            <div class="descriere">
                {{ $product['descriere'] }}
            </div>
        </div>
    </div>
    <hr>
    <div class="recenzii">
        Spune-ne părerea ta<br> 
    </div>
    @if ($recenzieutil)
        <div class="mesaj">Deja ai adăugat o recenzie pentru acest produs!</div>
    @else
        @include('elemente.recenzieform')
    @endif
    <hr>
    <div class="recenzii">
        Recenzii<br> 
    </div>
    @include('elemente.recenziiprod')
</div>

<style>
    .contprod {
        padding-top: 20px;
        padding-left: 30px;
        padding-right: 30px;
    }

    .numeprod {
        color: rgb(63, 119, 115); 
        font-size: 25px;
        padding-bottom: 10px;
    }

    .prodinfo {
        display: flex;
    }

    .prodinfo img{
        border: solid rgb(211, 219, 157);
        border-radius: 20px;
        height: 450px;
        margin-bottom: 20px
    }

    .prodinfocont{
        padding: 15px;
        padding-left: 20px;
        margin-left: 20px;
        width: 100%
    }

    .recenzie {
        font-size: 18px;
        display: flex; 
        align-items: center;
        color: rgb(119, 173, 173)
    }

    .recenzie i {
        color: rgb(255, 204, 0);
        padding-right: 5px;
        padding-left: 10px;
        font-size: 18px
    }

    .pagpret {
        font-size: 40px;
        color: rgb(162, 177, 64);
        padding-bottom: 5px;
        display: flex; 
        align-items: center;
    }

    .butoane-prod {
        padding-bottom: 5px;
        display: flex; 
        align-items: center;
        left: auto;
        justify-content: center;
        gap: 5px
    }

    .pref {
        border: none;
        background-color: transparent;
        text-align: end;
        font-size: 25px;
    }

    .producator {
        color: rgb(187, 138, 138);
        padding-bottom: 5px;
        display: flex;
        font-size: 18px
    }
    
    .pref i {
        color: rgb(233, 183, 182);
        padding-right: 20px
    }

    .cos {
        background-color: rgb(186, 215, 215); 
        color:rgb(63, 119, 115); 
        border-radius: 5px; 
        width: 300px; 
        height: 40px; 
        font-weight:bold; 
        border-color: rgb(119, 173, 173); 
        border-style: solid; 
        font-size: 17px
    }

    .des {
        color:rgb(63, 119, 115);
        padding-left: 15px;
        padding-bottom: 10px;
        font-size: 20px
    }

    .descriere {
        background-color: rgb(245, 226, 226); 
        outline-style: solid; 
        outline-color: rgb(233, 183, 182); 
        border-radius: 20px;
        padding: 20px;
        color: rgb(187, 138, 138); 
        text-align: justify
    }

    .recenzii {
        color:rgb(63, 119, 115);
        padding-left: 25px;
        padding-bottom: 10px;
        padding-top: 2px;
        font-size: 20px
    }

    .mesaj {
        color: rgb(63, 119, 115);
        text-align: center;
        padding-top: 20px;
        padding-bottom: 20px
    }
</style>