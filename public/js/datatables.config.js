$(document).ready(function () {
    active_datatable();
});


function active_datatable() {
    $('#myTable').DataTable({
        ajax: '/admin/customers/to_datatables',
        columns: [
            { data: 'name' },
            { data: 'phone' }
        ],
        order: [[0, "desc"], [1, "desc"]]
    });

}