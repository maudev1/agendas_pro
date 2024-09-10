
let service = {

    route: "admin/services",
    editModalId: "#exampleModal",
    deleteModalId: "#confirmModal",

    init: function () {

        service.datatables()

        $(service.editModalId).on('shown.bs.modal', function (e) {
            let target = $(e.relatedTarget);

            if (target.data("type") != "insert") {

                service.edit(target.data("id"));

            }

        })

        $(service.editModalId).on('hidden.bs.modal', function (e) {

            let elements = $(e.currentTarget).find("input")

            elements.each(function (i, e) {

                $(e).val("")

            })

        })

        $('#modal-form').on('submit', function (e) {

            e.preventDefault();

            let serviceId = $('#id').val();

            if (serviceId) {
                service.update(this);

            } else {
                service.create(this);

            }

        });

        $(service.deleteModalId).on('shown.bs.modal', function(e){
            
            e.preventDefault();

            let serviceId = $(e.relatedTarget).data("id");

            $("#service-id").val(serviceId);

 
        });

        $("#confirm-form").on('submit', function(e){

            e.preventDefault();

            let serviceId = $('#service-id').val();
            
            if(serviceId){
                service.delete(serviceId);

            }


        })

    },
    datatables: function () {

        let columnsData = [
            { data: 'description' },
            { data: 'price' },
            { data: 'discount' },
            { data: 'options' }
        ];

        ActiveDatatable(columnsData, `/${service.route}/to_datatables`);


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

        let response = await fetch(`/${service.route}`, options);
        let results = await response.json();

        if (results.success) {

            $(service.editModalId).modal("toggle");

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
    edit: async function (serviceId) {

        let commons = new Commons();

        commons.loadFormSpinner($(".modal-body"), true)

        let response = await fetch(`/${service.route}/${serviceId}/edit`, {
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
                $('#description').val(data.description)
                $('#price').val(data.price)
                $('#discount').val(data.discount)

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

        let response = await fetch(`/${service.route}/${id}`, options);
        let results = await response.json();

        if (results.success) {

            $(service.editModalId).modal("toggle");

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
    delete: async function (serviceId) {

        console.log(serviceId)


        let options = {
            method: "DELETE",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json;charset=utf-8'
            }
        };


        let response = await fetch(`/${service.route}/${serviceId}`, options)
        let results  = await response.json();

        if(results.success){
            $(service.deleteModalId).modal("toggle");
            ReloadDatatable();
        }

    }

};

(() => {

    "use strict";
    service.init();

})()