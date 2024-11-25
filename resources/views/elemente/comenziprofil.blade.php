@if(count($orders) > 0)
    <div class="rec">
        @foreach ($orders as $order)
            @if ($user->id == Auth::id())
                <div class="recc">
                    <div class="container-com">
                        <div class="numeuser">
                            <div class="rat">
                                @if ($order->user->image)
                                    <img class="pfp2" src="{{ URL('storage/' . $order->user->image) }}">
                                @else
                                    <div class="pfp"></div>
                                @endif
                                <a href="/profil/{{ $order->user->id }}"><div>{{ $order->user->name }} {{ $order->user->prenume }}</div></a>
                            </div>
                            {{ $order['created_at']->diffForHumans() }}
                        </div>
                        <div class="contrec">
                            <div>{{ $order->nume }} {{ $order->prenume }}</div>
                            Adresă: {{ $order->adresa }}, {{ $order->judet }} {{ $order->localitate }}<br>
                            Total: {{ $order->total }} lei<br>
                            Produse:<br>
                            @foreach ($order['produse'] as $produs)
                                <div class="produse">
                                    <div class="poznume">
                                        <img style="width: 50px" src="{{ URL('storage/' . $produs['image'])}}">
                                        <a href="/produs/{{$produs['id_produs']}}">{{ $produs['name'] }}</a><br>
                                    </div>
                                    Cantitate: {{ $produs['cantitate'] }}<br>
                                    Pret: {{ $produs['pret'] }}<br>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endif

<style>
    .rec {
        display: flex;
        flex-direction: column;
        margin-bottom: 30px
    }

    .recc {
        display: flex;
    }

    .container-com{
        outline-style: solid; 
        outline-color: rgb(211, 219, 157); 
        border-radius: 20px; 
        margin-top: 10px; 
        margin-bottom: 10px; 
        padding: 10px 20px 0px 20px;
        margin-left: 5px; 
        margin-right: 5px;
        width: 400px;
    }

    .pfp {
        background-image: url({{ url('imagini/emojikirara.png') }}); 
        border-radius: 100px; 
        outline-style: solid; 
        outline-color: rgb(233, 183, 182); 
        outline-width: 1px;
        width: 30px;
        height: 30px;
        margin-right: 10px; 
        margin-bottom: 7px;
        background-size: cover; 
        round-position: center
    }

    .pfp2 {
        border-radius: 100px; 
        outline-style: solid; 
        outline-color: rgb(233, 183, 182); 
        outline-width: 1px;
        width: 30px;
        height: 30px;
        margin-right: 10px; 
        margin-bottom: 7px;
        background-size: cover; 
        round-position: center
    }

    .numeuser {
        display: flex; 
        justify-content: space-between;
        color: rgb(106, 116, 41);
    }
    
    .numeuser i {
        color: rgb(255, 204, 0);
        padding-left: 5px; 
    }

    .poznume {
        display: flex; 
        align-items: center;
        gap: 15px
    }

    .poznume a{
        text-decoration: none;
        color: rgb(63, 119, 115);
    }

    .produse {
        padding-bottom: 10px
    }

    .rat {
        display: flex; 
        align-items: center;
        font-size: 20px;
        color: rgb(187, 138, 138)
    }

    .rat a {
        text-decoration: none;
        color: rgb(187, 138, 138);
    }

    .contrec{
        color: rgb(63, 119, 115);
    }

    .butpag {
        text-align: center
    }

    .butpag button {
        background-color: rgb(186, 215, 215); 
        color:rgb(63, 119, 115); 
        border-radius: 5px; 
        width: 250px; 
        height: 40px; 
        font-weight:bold; 
        border-color: rgb(119, 173, 173); 
        border-style: solid; 
        font-size: 17px;
        margin-top: 10px
    }

    .mesaj {
        color: rgb(63, 119, 115);
        text-align: center;
        padding-top: 20px;
        padding-bottom: 20px
    }
</style>