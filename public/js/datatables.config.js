function ActiveDatatable(columnsData, url) {

    setTimeout(function () {

        $('#myTable').DataTable({
            ajax: url,
            columns: columnsData,
            // colReorder: true,
            dataSrc: "data",
            dataType: "json",
            order: [[0, "desc"], [1, "desc"]],
            language: {
                url: '//cdn.datatables.net/plug-ins/2.0.2/i18n/pt-BR.json',
            },
            responsive:true,
            columnDefs: [
                // { responsivePriority: 1, targets: 0 },
                { responsivePriority: columnsData.length, targets: 2 }
            ]
        });


    }, 500)

}

function ReloadDatatable() {
    $('#myTable').DataTable().ajax.reload();

}