
let profile = {

    route: "admin/profiles",
    editModalId: "#exampleModal",
    deleteModalId: "#confirmModal",

    init: function () {

        profile.datatables()

        $(profile.editModalId).on('shown.bs.modal', function (e) {
            let target = $(e.relatedTarget);

            if (target.data("type") != "insert") {

                profile.edit(target.data("id"));

            }

        })

        $(profile.editModalId).on('hidden.bs.modal', function (e) {

            let elements = $(e.currentTarget).find("input")

            $('#exampleModalLabel').html("Adicionar novo Perfil")

            elements.each(function (i, e) {

                $(e).val(null).attr('checked', false);

            })

        })

        $('#modal-form').on('submit', function (e) {

            e.preventDefault();

            let profileId = $('#id').val();

            if (profileId) {
                profile.update(this);

            } else {
                profile.create(this);

            }

        });

        $(profile.deleteModalId).on('shown.bs.modal', function (e) {

            e.preventDefault();

            let profileId = $(e.relatedTarget).data("id");

            $("#profile-id").val(profileId);


        });

        $("#confirm-form").on('submit', function (e) {

            e.preventDefault();

            let profileId = $('#profile-id').val();

            if (profileId) {
                profile.delete(profileId);

            }


        })

    },
    datatables: function () {

        let columnsData = [
            { data: 'description' },
            { data: 'options' }
        ];

        ActiveDatatable(columnsData, `/${profile.route}/to_datatables`);


    },
    create: async function (element) {

        $('#exampleModalLabel').html("Adicionar novo Perfil")

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

        let response = await fetch(`/${profile.route}`, options);
        let results = await response.json();

        if (results.success) {

            $(profile.editModalId).modal("toggle");

            commons.loadFormSpinner($(".modal-body"), false);

            ReloadDatatable();

        } else if (results.errors) {

            let errors = Object.values(results.errors)
            let reverset = errors.reverse()

            reverset.forEach(function (error) {
                error.forEach(function (e) {

                    $(".alert").addClass("alert-danger").html(e).show()

                    commons.alertMessage(e, 'error', true)

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
    edit: async function (profileId) {

        $('#exampleModalLabel').html("Editar Perfil")

        let commons = new Commons();

        commons.loadFormSpinner($(".modal-body"), true)

        let response = await fetch(`/${profile.route}/${profileId}/edit`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json;charset=utf-8',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        if (response.status == 200) {
            let data = await response.json();

            setTimeout(function () {

                $('#id').val(data.role.id);
                $('#name').val(data.role.name);

                let permissions = data.permissions;

                permissions.forEach(function(p){

                    let input = $('#modal-form').find(`[name=${p}]`);
                    
                    input.attr('checked',true);

                });

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

        let response = await fetch(`/${profile.route}/${id}`, options);
        let results = await response.json();

        if (results.success) {

            $(profile.editModalId).modal("toggle");

            commons.loadFormSpinner($(".modal-body"), false);

            ReloadDatatable();

        } else if (results.errors) {

            let errors = Object.values(results.errors)
            let reverset = errors.reverse()

            reverset.forEach(function (error) {
                error.forEach(function (e) {

                    $(".alert").addClass("alert-danger").html(e).show()

                    commons.alertMessage(e, 'error', true)

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
    delete: function (profileId) {

        Swal.fire({
            title: "Você tem certeza?",
            text: "essa ação e irreversivel!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sim, excluir!",
            cancelButtonText: "cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                (async () => {

                    let options = {
                        method: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Content-Type': 'application/json;charset=utf-8'
                        }
                    };

                    try {
                        let response = await fetch(`/${profile.route}/${profileId}`, options);

                        if (!response.ok) {

                            throw new Error('Erro na requisição.');
                        }

                        let results = await response.json();

                        if (results.success) {
                            ReloadDatatable();

                            Swal.fire({
                                title: "Excluido!",
                                text: "Perfil excluído",
                                icon: "success"
                            });
                        }

                    } catch (err) {

                        console.error(`Erro ${err}`)

                    }



                })(profileId);

            }
        });






    }

};

(() => {

    "use strict";
    profile.init();

})()