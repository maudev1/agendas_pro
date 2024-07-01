let schedule = {

    route: "schedule",

    init: function () {

        jQuery(($) => {

            $('#date-form').on('submit', function (event) {

                event.preventDefault();

                let form = new FormData(this);

                schedule.getSchedule(form)


            });

            $('#checkout-form').on('submit', function (event) {

                event.preventDefault();

                schedule.create(this)


            });

            $('#hours-form').on('click', function (event) {

                event.preventDefault();

                schedule.toCustomerDetails();


            });


        })


    },
    create: async function (element) {

        let commons = new Commons();

        let formData = $(element).serializeArray();

        let data = {};

        $.each(formData, function () {
            data[this.name] = this.value;
        });

        data['title']       = `Corte de ${$('#customer-name').val()}`;
        data['hour']       = `${$('#date').val()}T${$('#available-hours').val()}:00`;
        data['user_id']     = `1`;
        data['notify']      = `1`;
        data['customer_id'] = '1';

        let options = {
            method: "POST",
            body: JSON.stringify(data),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json;charset=utf-8'
            }
        };

        let response = await fetch(`/${schedule.route}`, options);
        let results = await response.json();

        if (results.success) {
            $('#customer-details').hide()
            $('#confirmation').show()

            commons.loadFormSpinner($('#confirmation'), true)



        } else if (results.errors) {

            let errors = Object.values(results.errors)
            let reversed = errors.reverse()

            reversed.forEach(function (error) {
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
    getSchedule: async function (form) {

        let date = $('.date').val();

        if (date) {

            let options = {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    // 'Content-Type': 'application/json;charset=utf-8'
                },
                body: form
            }

            let response = await fetch('/schedule/date', options);
            let results = await response.json();

            if (results) {

                let availableHours = '';

                results.forEach(function (r) {

                    availableHours += `<option value="${r}">${r}</option>`

                });


                $("#available-hours").html(`<option value="">Escolha</option>${availableHours}`)
                $('#date-form').hide();
                $('#available-hours-form').show()

            }


        } else {

            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Escolha uma data!",
              });

              


        }





    },
    toCustomerDetails: function () {

        $('#available-hours-form').hide();

        $('#customer-details').show();



    }

};

(() => {

    "use strict";
    schedule.init();

})()