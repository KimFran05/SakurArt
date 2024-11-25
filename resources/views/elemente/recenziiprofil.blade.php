@if(count($reviews) > 0)
    <div class="rec">
        @foreach ($reviews as $review)
            @if ($user->id == Auth::id())
                <div class="recc">
                    <div class="container-rec">
                        <div class="numeuser">
                            <div class="rat">
                                @if ($review->user->image)
                                    <img class="pfp2" src="{{ URL('storage/' . $review->user->image) }}">
                                @else
                                    <div class="pfp"></div>
                                @endif
                                <a href="/profil/{{ $review->user->id }}"><div>{{ $review->user->name }} {{ $review->user->prenume }}</div></a>
                                <div><i class="fa fa-star" ></i> {{ $review['rating'] }} </div>
                            </div>
                            {{ $review['created_at']->diffForHumans() }}
                        </div>
                        <div class="contrec">
                            {{ $review['titlu'] }} <br>
                            {{ $review['continut'] }}  
                        </div>
                        <form action="/produs/{{ $review['id_produs'] }}" method="GET">
                            <div class="butpag">
                                <button>Pagină produs</button>
                            </div>
                        </form>
                    </div>
                    <div class="edit-delete">
                        <a href="/editarerec/{{ $review['id'] }}"><i class="fa fa-pencil"></i></a><br>
                        <form action="/stergererec/{{ $review['id'] }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button><i class="fa fa-trash"></i> </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="container-rec">
                    <div class="numeuser">
                        <div class="rat">
                            <div class="pfp"></div>
                            <a href="/profil/{{ $review->user->id }}"><div>{{ $review->user->name }}</div></a>
                            <div><i class="fa fa-star" ></i> {{ $review['rating'] }} </div>
                        </div>
                        {{ $review['created_at']->diffForHumans() }}
                    </div>
                    <div class="contrec">
                        {{ $review['titlu'] }} <br>
                        {{ $review['continut'] }}  
                    </div>
                    <form action="/produs/{{ $review['id_produs'] }}" method="GET">
                        <div class="butpag">
                            <button>Pagină produs</button>
                        </div>
                    </form>
                </div>
            @endif
        @endforeach
    </div>
@else
    <div class="mesaj">Nu a fost găsită nicio recenzie</div>
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

    .container-rec{
        outline-style: solid; 
        outline-color: rgb(211, 219, 157); 
        border-radius: 20px; 
        margin-top: 10px; 
        margin-bottom: 10px; 
        padding: 10px 20px;
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

    .edit-delete {
        padding-top: 20px    
    }

    .edit-delete button{
        border: none;
        background-color: transparent
    }

    .edit-delete a{
        padding-left: 6px
    }

    .edit-delete i {
        color: rgb(106, 116, 41);
        font-size: 17px;
        padding-bottom: 10px;
        padding-left: 5px
    }

    .mesaj {
        color: rgb(63, 119, 115);
        text-align: center;
        padding-top: 20px;
        padding-bottom: 20px
    }
</style>