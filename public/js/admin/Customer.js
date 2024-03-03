let customer = {

    route: "admin/customers",
    editModalId: "#exampleModal",

    init: function () {

        customer.datatables()

        $(customer.editModalId).on('shown.bs.modal', function (e) {
            let target = $(e.relatedTarget);

            if (target.data("type") != "insert") {

                customer.edit(target.data("id"));

            }

        })

        $(customer.editModalId).on('hidden.bs.modal', function (e) {

            let elements = $(e.currentTarget).find("input")

            elements.each(function (i, e) {

                $(e).val("")

            })

        })

        $('#modal-form').on('submit', function (e) {

            e.preventDefault();

            let id = $('#id').val();

            if (id) {
                customer.update(this);

            } else {
                customer.create(this);

            }




        });

    },

    datatables: function () {

        let columnsData = [
            { data: 'name' },
            { data: 'phone' },
            { data: 'options' }
        ];

        ActiveDatatable(columnsData, `/${customer.route}/to_datatables`);


    },
    create: async function (element) {

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

        let response = await fetch(`/${customer.route}`, options);
        let results = await response.json();

        if (results.success) {

            $(customer.editModalId).modal("toggle");

            commons.loadFormSpinner($(".modal-body"), false);

            ReloadDatatable();

        } else if(results.errors){

            let errors = Object.values(results.errors)
            let reverset = errors.reverse()

            reverset.forEach(function(error){
                error.forEach(function(e){

                    $(".alert").addClass("alert-danger").html(e).show()

                    commons.alertMessage(e, 'error', true)

                })


            });

            setTimeout(function(){

                commons.alertMessage('', 'error', false)

            },3000);

            commons.loadFormSpinner($(".modal-body"), false);

        }else{

            commons.loadFormSpinner($(".modal-body"), false);


        }


    },
    edit: async function (customerId) {

        let commons = new Commons();

        commons.loadFormSpinner($(".modal-body"), true)

        let response = await fetch(`/${customer.route}/${customerId}/edit`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json;charset=utf-8',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        if (response.status == 200) {
            let data = await response.json();

            setTimeout(function () {

                $('#id').val(data.id)
                $('#name').val(data.name)
                $('#cpf').val(data.cpf)
                $('#phone').val(data.phone)
                $('#mail').val(data.mail)

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

        let response = await fetch(`/${customer.route}/${id}`, options);
        let results = await response.json();

        if (results.success) {

            $(customer.editModalId).modal("toggle");

            commons.loadFormSpinner($(".modal-body"), false);

            ReloadDatatable();

        } else if(results.errors){

            let errors = Object.values(results.errors)
            let reverset = errors.reverse()

            reverset.forEach(function(error){
                error.forEach(function(e){

                    $(".alert").addClass("alert-danger").html(e).show()

                    commons.alertMessage(e, 'error', true)

                })


            });

            setTimeout(function(){

                commons.alertMessage('', 'error', false)

            },3000);

            commons.loadFormSpinner($(".modal-body"), false);

        }else{

            commons.loadFormSpinner($(".modal-body"), false);


        }


    },

    delete: function () {



    }
};

(() => {

    "use strict";
    customer.init();

})()