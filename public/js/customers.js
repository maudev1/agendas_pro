
jQuery(($) => {

    $('#save').on('click', function () {
        Save();
    })


    let columnsData = [
        { data: 'name' },
        { data: 'phone' }]

    active_datatable(columnsData, '/admin/customers/to_datatables');

});


async function Save() {

    let user = {
        name: $('#name').val(),
        cpf: $('#cpf').val(),
        phone: $('#phone').val(),
        mail: $('#mail').val(),
        password: $('#password').val()
    };

    let response = await fetch('/admin/customers', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json;charset=utf-8',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        body: JSON.stringify(user)
    });

    if (response.status == 200) {

        reaload_datatable();

        $('#modal-form :input').each(function () {
            $(this).val('')
        });

        $('#exampleModal').modal('toggle');

    } else {

        let data = await response.json();

        $('.alert').addClass('alert-danger').text(data.message).show()

    }


}