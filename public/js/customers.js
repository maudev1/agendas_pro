
jQuery(($) => {

    $('#save').on('click', function () {
        Save();
    })

});


async function Save() {

    // let user = {
    //     name: $('#name').val(),
    //     cpf: $('#cpf').val(),
    //     phone: $('#phone').val(),
    //     mail: $('#mail').val(),
    //     password: $('#password').val()
    // };

    // let response = await fetch('/admin/customers', {
    //     method: 'POST',
    //     headers: {
    //         'Content-Type': 'application/json;charset=utf-8',
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //     },
    //     body: JSON.stringify(user)
    // });

    // let result = await response.json();

    
    // alert(result.message);
    
    active_datatable();

}