
jQuery(($) => {

    let route = "/admin/customers"

    let columnsData = [
        { data: 'name' },
        { data: 'phone' },
        { data: 'options' }
    ];


    ActiveDatatable(columnsData, `${route}/to_datatables`);

    $('button[data-toggle=modal]').on('click', function () {
        ClearForm();
    })

    $('#modal-form').on('submit', function (event) {

        event.preventDefault();

        let formData = $(this).serializeArray();

        let jsonFormaData = {};

        $.each(formData, function () {
            jsonFormaData[this.name] = this.value;
        });


        let customer = $('#id').val();

        Request.url = customer ? `${route}/update/${customer}` : route;
        Request.method = "POST";
        Request.data = jsonFormaData;

        Request.makeRequest();

        const ResponseHandler = {
            notify: function (response) {

                $('#exampleModal').modal('toggle');

                RealoadDatatable()


            }
        };

        Request.addObserver(ResponseHandler);


    });

    $('#delete-confirm').on('click', function () {

        let customer = $('#customer-id').val();

        Request.url = customer ? `${route}/${customer}` : route;
        Request.method = "delete";
        Request.makeRequest();

        const ResponseHandler = {
            notify: function (response) {

                $('#confirmModal').modal('toggle');

                RealoadDatatable();

            }
        };

        Request.addObserver(ResponseHandler);

    });

});

async function Fetch(customerId) {
    ClearForm();

    let response = await fetch(`/admin/customers/edit/${customerId}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json;charset=utf-8',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    if (response.status == 200) {
        let data = await response.json();

        $('#id').val(data.id)
        $('#name').val(data.name)
        $('#cpf').val(data.cpf)
        $('#phone').val(data.phone)
        $('#mail').val(data.mail)
    }

}

function Delete(customerId) {
    $('#customer-id').val(customerId);
}


function ClearForm() {
    document.querySelectorAll('input').forEach(input => {
        input.value = ''

    });
}
