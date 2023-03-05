function ActiveDatatable(columnsData, url) {
    $('#myTable').DataTable({
        ajax: url,
        columns:columnsData,
        order: [[0, "desc"], [1, "desc"]]
    });

}

function RealoadDatatable()
{
    $('#myTable').DataTable().ajax.reload();

}