@if(count($reviews) > 0)
    <div class="rec">
        @foreach ($reviews as $review)
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
            </div>
        @endforeach
    </div>
@else
    <div class="mesaj">Nu a fost găsită nicio recenzie</div>
@endif

<style>
    .rec {
        padding-bottom: 5px
    }

    .container-rec{
        outline-style: solid; 
        outline-color: rgb(211, 219, 157); 
        border-radius: 20px; 
        margin-top: 10px; 
        margin-bottom: 15px; 
        padding: 10px 20px;
        margin-left: 5px; 
        margin-right: 5px;
        width: 30%;
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
        opacity: 0.5;  */
    }
</style>