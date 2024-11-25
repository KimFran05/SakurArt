<div>
    Cumpărător: {{ $record->nume }} {{ $record->prenume }}<br>
    Număr de telefon: {{ $record->numartelefon }}<br>
    Adresă: {{ $record->adresa }}, {{ $record->judet }} {{ $record->localitate }}
</div>
<div>
    <div class="factura">
        Factură
    </div>
    <table>
        <tr>
            <th>Denumire produs</th>
            <th>Cantitate</th>
            <th>Preț</th>
        </tr>
        @foreach ($record['produse'] as $produs)
            <tr>
                <td>{{ $produs['name'] }}</td>
                <td>{{ $produs['cantitate'] }}</td>
                <td>{{ $produs['pret'] }} Lei</td>
            </tr>
        @endforeach
    </table>
    <div class="total">
        Total: {{ $record->total }} Lei
    </div>
</div>
<style>
    body {
        font-family: 'DejaVu Sans', sans-serif;
    }

    table, td, th {
        border: 1px solid;
    }

    th {
        background-color: gray;
        color: white;
        border: 1px solid black;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    .factura {
        font-size: 20px;
        padding-bottom: 10px;
        padding-top: 10px;
        text-align: center;
        font-weight: bold
    }
    
    .total {
        text-align: right
    }
</style>
