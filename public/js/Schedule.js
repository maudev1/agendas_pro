let schedule = {

    route: "schedule",

    init: function () {

        jQuery(($) => {

            $('#date-form').on('submit', function (event) {

                event.preventDefault();

                let form = new FormData(this);

                schedule.getSchedule(form)
                schedule.getProducts(form)


            });

            $('#checkout-form').on('submit', function (event) {

                event.preventDefault();

                schedule.create(this)


            });

            $('#checkout-form-before').on('click', function () {

                $('#date-form').show();

                $('#available-hours-section').hide()


            });

            $('#hours-form').on('click', function (event) {

                event.preventDefault();

                schedule.toCustomerDetails();


            });

            $('#customer-details-before').on('click', function () {

                $('#customer-details-section').hide();
                $('#available-hours-section').show();


            });

            $('#products').selectize({
                sortField: 'text'

            });

            const fullDate = new Date();
            const dateAndTime = fullDate.toJSON();
            const date = dateAndTime.split('T');

            $('#date').attr('min', `${date[0]}`)

        })


    },
    create: async function (element) {

        let commons = new Commons();

        let formData = $(element).serializeArray();

        let data = {};

        $.each(formData, function () {
            data[this.name] = this.value;
        });

        data['title'] = `Corte de ${$('#customer-name').val()}`;
        data['hour'] = `${$('#date').val()}T${$('#available-hours').val()}:00`;
        data['user_id'] = `1`;
        data['notify'] = `1`;
        data['customer_id'] = '1';
        data['products'] = $('#products').val();

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
            $('#customer-details-section').hide()
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

        let date = $('#date').val();

        let commons = new Commons();

        if (!products || products == '') {

            commons.customAlert("error", 'Ops...', 'Escolha algum serviço!')


        } else if (!date || date == '') {

            commons.customAlert("error", 'Ops...', 'Escolha a data!')


        } else {

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
                $('#available-hours-section').show()

            }


        }

    },
    toCustomerDetails: function () {

        let availableHours = $('#available-hours').val();

        if (availableHours == '' || !availableHours) {

            let commons = new Commons();

            commons.customAlert("error", 'Ops...', 'Escolha um horário!')

        } else {
            $('#available-hours-section').hide();

            $('#customer-details-section').show();

        }





    },
    getProducts: async function (form) {

        let products = $('#products').val();

        let commons = new Commons();

        let toReal = new Intl.NumberFormat('pt-BR', {
            style: 'currency',
            currency: 'BRL',
        });

        if (!products || products == '') {

            commons.customAlert("error", 'Ops...', 'Escolha algum serviço!')


        } else {

            let options = {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    // 'Content-Type': 'application/json;charset=utf-8'
                },
                body: form
            }

            let response = await fetch('/schedule/products', options);
            let results = await response.json();

            if (results) {

                let scheduledServices = '';
                let totalPrice = 0;

                results.forEach(function (r) {

                    // availableHours += `<option value="${r}">${r}</option>`
                    scheduledServices += `<li class="list-group-item d-flex justify-content-between lh-sm">
                                        <div>
                                            <h6 class="my-0">${r.description}</h6>
                                            <small class="text-body-secondary">${toReal.format(r.price)}</small>
                                        </div>
                                        </li>`

                    totalPrice = totalPrice + parseFloat(r.price)

                });

                scheduledServices += `<li class="list-group-item d-flex justify-content-between">
                                        <span>Total</span>
                                        <strong>${toReal.format(totalPrice)}</strong>
                                      </li>`;



                $('#service-list').html(scheduledServices);


                // $("#available-hours").html(`<option value="">Escolha</option>${availableHours}`)
                // $('#date-form').hide();
                // $('#available-hours-section').show()

            }
        }



    }

};

(() => {

    "use strict";
    schedule.init();

})()