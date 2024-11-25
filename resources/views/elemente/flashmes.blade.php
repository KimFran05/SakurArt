@if (session()->has('success'))
<div class="success">
    {{ session('success') }}
    <form action="/" method="POST">
        @csrf
        <button class="inchidere">X</button>
    </form>
</div>
@endif

<style>
.success {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px; 
    color: rgb(63, 119, 115);
    font-size: 20px
}

.inchidere {
    background-color: transparent;
    border: none;
    cursor: pointer;
    margin-left: 15px;
    color: rgb(63, 119, 115);
    border: solid rgb(186, 215, 215);
    border-radius: 20px;
    width: 30px; 
    height: 30px; 
}
</style>