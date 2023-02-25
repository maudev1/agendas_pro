let sendError = (error) =>{

    $('.alert').addClass('alert-danger').text(error).show();

    setTimeout(function(){

        $('.alert').fadeOut(function(){
            $('.alert').hide();
        });

    }, 5000)


}

