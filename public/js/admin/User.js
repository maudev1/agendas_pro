
let user = {

    route: "admin/users",
    route_profile: "admin/profiles",
    editModalId: "#exampleModal",
    deleteModalId: "#confirmModal",

    init: function () {

        user.datatables();

        $(user.editModalId).on('shown.bs.modal', function (e) {
            let target = $(e.relatedTarget);

            if (target.data("type") != "insert") {

                user.edit(target.data("id"));

            }

        })

        $(user.editModalId).on('hidden.bs.modal', function (e) {

            let elements = $(e.currentTarget).find("input")

            $('#exampleModalLabel').html("Adicionar novo Usuário")

            elements.each(function (i, e) {

                $(e).val("")

            });

            user.clearFormAlerts();

        })

        $('#modal-form').on('submit', function (e) {

            e.preventDefault();

            let userId = $('#id').val();

            user.clearFormAlerts();

            if (userId) {
                user.update(this);

            } else {
                user.create(this);

            }

        });

        $(user.deleteModalId).on('shown.bs.modal', function (e) {

            e.preventDefault();

            let userId = $(e.relatedTarget).data("id");

            $("#user-id").val(userId);

            user.clearFormAlerts();


        });

        $("#confirm-form").on('submit', function (e) {

            e.preventDefault();

            let userId = $('#user-id').val();

            if (userId) {
                user.delete(userId);

            }


        });


    },
    datatables: function () {

        let columnsData = [
            { data: 'name' },
            { data: 'email' },
            { data: 'phone' },
            { data: 'options' }
        ];

        ActiveDatatable(columnsData, `/${user.route}/to_datatables`);


    },
    create: async function (element) {

        $('#exampleModalLabel').html("Adicionar novo Usuário")

        let commons = new Commons();

        commons.loadFormSpinner($(".modal-body"), true)

        let formData = $(element).serializeArray();

        let data = {};

        $.each(formData, function () {
            data[this.name] = this.value;
        });


        let options = {
            method: "POST",
            body: JSON.stringify(data),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json;charset=utf-8'
            }
        };

        let response = await fetch(`/${user.route}`, options);
        let results = await response.json();

        if (results.success) {

            $(user.editModalId).modal("toggle");

            commons.loadFormSpinner($(".modal-body"), false);

            ReloadDatatable();

        } else if (results.errors) {

            let errors = Object.keys(results.errors);

            errors.forEach(function(err){

                $(`#${err}`).addClass('is-invalid')

            });

            
            commons.loadFormSpinner($(".modal-body"), false);

            

            commons.alertMessage(results.errors[errors[0]][0], 'error', true);

            // let errors = Object.values(results.errors)
            // let reverset = errors.reverse();

          

            // reverset.forEach(function (error) {
            //     error.forEach(function (e) {

            //         $(".alert").addClass("alert-danger").html(e).show();

            //         commons.alertMessage(e, 'error', true);

            //         console.log(error)

            //     })


            // });

            // setTimeout(function () {

            //     commons.alertMessage('', 'error', false)

            // }, 3000);

            // commons.loadFormSpinner($(".modal-body"), false);

        } else {

            commons.loadFormSpinner($(".modal-body"), false);


        }


    },
    edit: async function (userId) {

        $('#exampleModalLabel').html("Editar Usuário")

        let commons = new Commons();

        commons.loadFormSpinner($(".modal-body"), true)

        let response = await fetch(`/${user.route}/${userId}/edit`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json;charset=utf-8',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        if (response.status == 200) {
            let data = await response.json();
            let {id, name, document, email, phone } = data.user;
             
            setTimeout(function () {

                $('#id').val(id)
                $('#name').val(name)
                $('#document').val(document)
                // $('#email').attr('readonly', 'readonly').val(email)
                $('#email').val(email)
                $('#phone').val(phone)
                // $('#profile').val(data.profile).trigger('change')
                $('#profile option').val(data.roles[0]).trigger('change')

                commons.loadFormSpinner($(".modal-body"), false)
            }, 500)

        }



    },
    update: async function (element) {

        let commons = new Commons();

        commons.loadFormSpinner($(".modal-body"), true)

        let formData = $(element).serializeArray();

        let data = {};

        $.each(formData, function () {
            data[this.name] = this.value;
        });


        let options = {
            method: "PUT",
            body: JSON.stringify(data),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json;charset=utf-8'
            }
        };

        let id = $('#id').val();

        let response = await fetch(`/${user.route}/${id}`, options);
        let results  = await response.json();

        if (results.success) {

            $(user.editModalId).modal("toggle");

            commons.loadFormSpinner($(".modal-body"), false);

            ReloadDatatable();

        } else if (results.errors) {
            let errors = Object.values(results.errors)
            let reversed = errors.reverse();

            
            reversed.forEach(function (error) {
                error.forEach(function (e) {
                    
                    $(".alert").addClass("alert-danger").html(e).show()

                    commons.alertMessage(e, 'error', true);

                    console.log(error)


                })


            });

           

            setTimeout(function () {

                commons.alertMessage('', 'error', false)

            }, 3000);

            commons.loadFormSpinner($(".modal-body"), false);

        } else {

            commons.loadFormSpinner($(".modal-body"), false);


        }


    },
    delete: async function (userId) {


        let options = {
            method: "DELETE",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json;charset=utf-8'
            }
        };


        let response = await fetch(`/${user.route}/${userId}`, options)
        let results = await response.json();

        if (results.success) {
            $(user.deleteModalId).modal("toggle");
            ReloadDatatable();
        }

    },

    clearFormAlerts: function (){

        let modalBody = $('#modal-form').find('.modal-body');
        
        modalBody.find('input').each(function(i, e){ 
            $(e).removeClass('is-invalid');
        });

        modalBody.find('select').removeClass('is-invalid');

        modalBody.find('.alert').html(``).hide();



    }

};

(() => {

    "use strict";
    user.init();

})()