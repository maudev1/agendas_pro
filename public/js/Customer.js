
jQuery(($) => {

    let columnsData = [
        { data: 'name' },
        { data: 'phone' },
        { data: 'options' }
    ];


    ActiveDatatable(columnsData, '/admin/customers/to_datatables');


    // $('#save').on('click', function () {
    //     Save();
    // });

    $('button[data-toggle=modal]').on('click', function(){
        ClearForm();
    })


});

$('#modal-form').on('submit', function(event){

    event.preventDefault();

    let formData = $(this).serializeArray();

    let jsonFormaData = {};

    $.each(formData,function(){
        jsonFormaData[this.name] = this.value; 
    });

 
    let customer = $('#id').val();

    Request.url = customer ? `/admin/customers/update/${customer}` : "/admin/customers";
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



async function Fetch(customerId)
{
    ClearForm();

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

function ClearForm()
{
    document.querySelectorAll('input').forEach(input => {
        input.value = ''
        
    });
}
