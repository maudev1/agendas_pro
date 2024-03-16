
let product = {

    route: "admin/products",
    editModalId: "#exampleModal",
    deleteModalId: "#confirmModal",

    init: function () {

        product.datatables()

        $(product.editModalId).on('shown.bs.modal', function (e) {
            let target = $(e.relatedTarget);

            if (target.data("type") != "insert") {

                product.edit(target.data("id"));

            }

        })

        $(product.editModalId).on('hidden.bs.modal', function (e) {

            let elements = $(e.currentTarget).find("input")

            elements.each(function (i, e) {

                $(e).val("")

            })

        })

        $('#modal-form').on('submit', function (e) {

            e.preventDefault();

            let productId = $('#id').val();

            if (productId) {
                product.update(this);

            } else {
                product.create(this);

            }

        });

        $(product.deleteModalId).on('shown.bs.modal', function(e){
            
            e.preventDefault();

            let productId = $(e.relatedTarget).data("id");

            $("#product-id").val(productId);

 
        });

        $("#confirm-form").on('submit', function(e){

            e.preventDefault();

            let productId = $('#product-id').val();
            
            if(productId){
                product.delete(productId);

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

        ActiveDatatable(columnsData, `/${product.route}/to_datatables`);


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

        let response = await fetch(`/${product.route}`, options);
        let results = await response.json();

        if (results.success) {

            $(product.editModalId).modal("toggle");

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
    edit: async function (productId) {

        let commons = new Commons();

        commons.loadFormSpinner($(".modal-body"), true)

        let response = await fetch(`/${product.route}/${productId}/edit`, {
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

        let response = await fetch(`/${product.route}/${id}`, options);
        let results = await response.json();

        if (results.success) {

            $(product.editModalId).modal("toggle");

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
    delete: async function (productId) {


        let options = {
            method: "DELETE",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json;charset=utf-8'
            }
        };


        let response = await fetch(`/${product.route}/${productId}`, options)
        let results  = await response.json();

        if(results.success){
            $(product.deleteModalId).modal("toggle");
            ReloadDatatable();
        }

    }

};

(() => {

    "use strict";
    product.init();

})()