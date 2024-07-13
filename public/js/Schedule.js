let schedule = {

    route: "schedule",

    init: function () {

        
        schedule.flowControl();

        if (localStorage.getItem('flow') === '4') {

            let id = localStorage.getItem('schedule');

            if (id) {
                schedule.checkNotification(3000, id);
            }

        }

        jQuery(($) => {

            // free flow control

            $('.flow-control').on('click', function () {

                let flow = $(this).data('flow')

                localStorage.setItem('flow', flow);

                schedule.flowControl();



            });

            // flow 1

            $('#date-form').on('submit', function (event) {

                event.preventDefault();

                schedule.getScheduling(this);

                schedule.getProducts(this);



            });

            // flow 2

            $('#hours-form').on('click', function (event) {

                event.preventDefault();

                schedule.toCustomerDetails();


            });

            // flow 3

            $('#checkout-form').on('submit', function (event) {

                event.preventDefault();

                schedule.create(this)


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
    create: function (element) {

        let customerName = $('#customer-name').val();
        let customerPhone = $('#customer-phone').val();

        let commons = new Commons();


        if (!customerName) {

            commons.customAlert("error", 'Ops...', 'Informe o nome completo!')


        } else if (!customerPhone) {

            commons.customAlert("error", 'Ops...', 'Informe seu telefone!')


        } else {

            let commons = new Commons();

            let formData = $(element).serializeArray();

            let data = {};

            $.each(formData, function () {
                data[this.name] = this.value;
            });


            // data['title'] = `Corte de ${customerName}`;
            // data['customer_name']  = customerName;
            // data['customer_phone'] = customerPhone;
            data['hour'] = `${$('#date').val()}T${$('#available-hours').val()}:00`;
            data['user_id'] = `1`;
            data['notify'] = `1`;
            data['customer_id'] = '1';
            data['products'] = $('#products').val();

            Swal.fire({
                title: "Gostaria de confirmar o Agendamento?",
                // showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Sim, confirmar",
                cancelButtonText: `Cancelar`
            }).then((result) => {


                let options = {
                    method: "POST",
                    body: JSON.stringify(data),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/json;charset=utf-8'
                    }
                };

                fetch(`/${schedule.route}`, options).then(async function (response) {

                    let results = await response.json();

                    if (results.success) {

                        localStorage.setItem('flow', '4');

                        schedule.flowControl();

                        localStorage.setItem('schedule', results.schedule);

                        schedule.checkNotification(3000, results.schedule);

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


                })



            });



        }


    },
    getScheduling: async function (dataForm) {

        let form = new FormData(dataForm);

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
                    // availableHours += `<div class="col-sm-6 col-md-6"><input type="checkbox" value="${r}" class="btn-check" id="btn-check" autocomplete="off">
                    // <label class="btn btn-primary" for="btn-check">${r}</label></div>`

                });


                $("#available-hours").html(`<option value="">Escolha</option>${availableHours}`)
                // $("#available-hours-test").html(`${availableHours}`)
                // $('#date-form').hide();
                // $('#available-hours-section').show()

                localStorage.setItem('flow', '2');

                schedule.flowControl()


            }


        }

    },
    toCustomerDetails: function () {

        let availableHours = $('#available-hours').val();

        if (availableHours == '' || !availableHours) {

            let commons = new Commons();

            commons.customAlert("error", 'Ops...', 'Escolha um horário!')

        } else {

            localStorage.setItem('flow', '3');
            schedule.flowControl()

        }


    },
    getProducts: async function (dataForm) {

        let products = $('#products').val();

        let commons = new Commons();

        let form = new FormData(dataForm);

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
                let quantity = 0;

                results.forEach(function (r, index) {

                    scheduledServices += `<li class="list-group-item d-flex justify-content-between lh-sm">
                                        <div>
                                            <h6 class="my-0">${r.description}</h6>
                                            <small class="text-body-secondary">${toReal.format(r.price)}</small>
                                        </div>
                                        </li>`

                    totalPrice = totalPrice + parseFloat(r.price)
                    quantity = quantity + parseInt(index)

                });

                scheduledServices += `<li class="list-group-item d-flex justify-content-between">
                                        <span>Total</span>
                                        <strong>${toReal.format(totalPrice)}</strong>
                                      </li>`;


                $('#service-list').html(scheduledServices);
                $('#service-quantity').html(quantity)


            }
        }



    },
    flowControl: function () {

        if (!localStorage.getItem('flow')) {
            localStorage.setItem('flow', '1')
        }

        let flow = localStorage.getItem('flow');

        switch (flow) {

            case '1':
                $('#date-form').show();
                $('#available-hours-section').hide();
                $('#customer-details-section').hide();

                break;

            case '2':

                $('#date-form').hide();
                $('#available-hours-section').show();
                $('#customer-details-section').hide();

                break;

            case '3':

                $('#date-form').hide();
                $('#available-hours-section').hide();
                $('#customer-details-section').show();

                break;


            case '4':

                $('#date-form').hide();
                $('#customer-details-section').hide();
                $('#confirmation').hide();
                $('#confirmation-success').show();

                let commons = new Commons();

                commons.loadFormSpinner($('#confirmation'), true)

                break;

            case '5':

                $('#date-form').hide();
                $('#customer-details-section').hide();
                $('#confirmation').hide();
                $('#confirmation-success').show();


                break;


        }

        return flow;

    },
    checkNotification: function (interval, id) {

        setInterval(async () => {

            let options = {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    // 'Content-Type': 'application/json;charset=utf-8'
                }
            }

            let response = await fetch(`/schedule/notification/${id}`, options);
            let results = await response.json();

            if (results.success) {

                localStorage.setItem('flow', '4');

                schedule.flowControl();

                schedule.notify();

            }


        }, interval);



    },
    notify: async function () {


        await window.Notification.requestPermission()

        if (!("Notification" in window)) {
            // if (!("Notification" in navigator)) {
            console.log('Esse browser não suporta notificações desktop');
        } else {
            if (window.Notification.permission !== 'denied') {
                // Pede ao usuário para utilizar a Notificação Desktop
                await window.Notification.requestPermission();
            }
        }


        if (window.Notification.permission === 'granted') {
            const notification = new Notification('Atendimento Confirmado!', {
                body: 'O seu cabeleireiro acabou de confirmar o seu atendimento'
            });

            notification.onclick = (e) => {
                e.preventDefault();
                window.focus();
                notification.close();
            }
        }




    }

};

(() => {

    "use strict";
    schedule.init();

})()