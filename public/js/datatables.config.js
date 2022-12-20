function active_datatable(columnsData, url) {
    $('#myTable').DataTable({
        ajax: url,
        columns:columnsData,
        order: [[0, "desc"], [1, "desc"]]
    });

}

function reaload_datatable()
{
    $('#myTable').DataTable().ajax.reload();

}