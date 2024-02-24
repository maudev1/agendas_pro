<div>
    <table id="myTable" class="display table table-striped" style="width:100%">
        <thead>
            <tr>
                @foreach($headers as $item)
                    <th>{{ $item }}</th>
                @endforeach
            </tr>
        </thead>

    </table>

</div>
