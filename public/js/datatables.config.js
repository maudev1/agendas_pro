function ActiveDatatable(columnsData, url) {

    setTimeout(function () {

        $('#myTable').DataTable({
            ajax: url,
            columns: columnsData,
            dataSrc: "data",
            dataType: "json",
            order: [[0, "desc"], [1, "desc"]]
        });


    }, 500)

}

function ReloadDatatable() {
    $('#myTable').DataTable().ajax.reload();

}