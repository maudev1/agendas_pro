
jQuery(($) => {

    let columnsData = [
        { data: 'name' },
        { data: 'phone' },
        { data: 'options' }
    ];


    active_datatable(columnsData, '/admin/customers/to_datatables');


    $('#save').on('click', function () {
        Save();
    });

});


async function Save() {

    let user = {
        id: $('#id').val(),
        name: $('#name').val(),
        cpf: $('#cpf').val(),
        phone: $('#phone').val(),
        mail: $('#mail').val(),
        password: $('#password').val()
    };

    let url = user.id ? `/admin/customers/update/${user.id}` : "/admin/customers";

    let response = await fetch(url, {
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

async function Fetch(customerId)
{
    let response = await fetch(`/admin/customers/edit/${customerId}`,{
        method:'GET',
        headers: {
            'Content-Type': 'application/json;charset=utf-8',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    if(response.status == 200){
        let data = await response.json();
        $('#id').val(data.id)
        $('#name').val(data.name)
        $('#cpf').val(data.cpf)
        $('#phone').val(data.phone)
        $('#mail').val(data.mail)
    }



}

