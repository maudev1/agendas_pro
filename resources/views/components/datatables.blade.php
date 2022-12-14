<div>
    <table id="myTable">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Telefone</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <td>{{$item->name}}</td>
                <td>{{ $item->phone}}</td>
            @endforeach
        </tbody>


    </table>

</div>