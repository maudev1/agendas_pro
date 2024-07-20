let schedule = {

    route: "schedule",

    init: function () {

        schedule.requestNotificationPermission();

        schedule.flowControl();

        schedule.schedulingStatus();
        // schedule.notifyHandler();

        // if (localStorage.getItem('flow') != '5') {
        //     if (localStorage.getItem('schedule')) {

        //         setInterval(function () {

        //             schedule.schedulingStatus(localStorage.getItem('schedule'));

        //         }, 5000)

        //     }

        // } else {

        //     schedule.schedulingStatus(localStorage.getItem('schedule'));

        // }

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

                        console.log(results)

                        localStorage.setItem('flow', '4');

                        schedule.flowControl();

                        localStorage.setItem('schedule', results.schedule);

                        let push = new Push();
                        push.subscribeCustomer({ schedule: results.schedule, customer: results.customerId });

                        // schedule.checkNotification(3000, results.schedule);

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

                results.data.availableTime.forEach(function (r) {

                    availableHours += `<option value="${r}">${r}</option>`
                    // availableHours += `<div class="col-sm-6 col-md-6"><input type="checkbox" value="${r}" class="btn-check" id="btn-check" autocomplete="off">
                    // <label class="btn btn-primary" for="btn-check">${r}</label></div>`

                });

                console.log(results)


                $("#available-hours").html(`<option value="">Escolha</option>${availableHours}`);

                moment.locale('pt-BR')

                // var dateFormat = moment(results.data.date, 'DD/MM/YYYY');
                var formattedDate = moment(results.data.date).format('dddd, DD [de] MMMM [de] YYYY');          

                $("#time-reference").html(formattedDate)
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
                $('#service-quantity').html(quantity+1)


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
                $('#confirmation-success').hide();
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
                $('#confirmation-success').hide();
                $('#confirmation').show();

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
    toHome: function () {
        localStorage.setItem('flow', '1');
        localStorage.removeItem('schedule');
        schedule.flowControl();
    },
    schedulingStatus: function () {

        let commons = new Commons();

        commons.loadFormSpinner($('#confirmation-success'), true)

        if (localStorage.getItem('schedule')) {
            // if (localStorage.getItem('flow') == '4' || localStorage.getItem('flow') == '5') {

                let interval = setInterval(async () => {

                    let scheduleId = localStorage.getItem('schedule');

                    let options = {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            // 'Content-Type': 'application/json;charset=utf-8'
                        }
                    }


                    let response = await fetch(`/schedule/notification/${scheduleId}`, options);
                    let results = await response.json();

                    if (results.success) {

                        moment.locale('pt-BR')

                        let date = moment(results.data[0].start).format('llll');


                        localStorage.setItem('flow', '5');

                        schedule.flowControl();

                        $('#confirmation-success').html(`
                         <div class="p-3 bg-body-tertiary rounded-3">
                            <div class="check-icon-container"><span class="check-icon"><i class="fas fa-check"></i></span></div>
                         </div>
                         <div class="p-3 mb-4 bg-body-tertiary rounded-3">
                            <div class="mt-3 mb-3 text-center">                    
                             <h4 class="col-md-8 fs-4 text-center">
                               Agendamento confirmado
                             </h4>
                             
                             <h5 class="col-md-8 fs-4">${date}</h5>
                        
                            
                            </div>
                            <hr>
                            <div class="mt-3 text-center">
                                <a id="new-scheduling" onclick="schedule.toHome()" class="btn btn-lg btn-outline-dark">Novo Agendamento</a>
                            </div>

                        </div>
                        <style>
                            .check-icon-container{
                                display: flex;
                                flex-flow: column;
                                align-items: center;
                            }
                            .check-icon{
                                display:flex;
                                background-color: #47bd47;
                                padding: 20px;
                                border-radius: 30px;
                                color: white;
                                }
                        </style>
                        
                        
                        `);


                    }

                    if (localStorage.getItem('flow') == '5') {

                        clearInterval(interval)

                    }



                }, 5000);

            // }
        }


    },
    // notifyHandler() {
    //     navigator.serviceWorker.addEventListener('message', function (event) {
    //         console.log('Mensagem recebida do Service Worker:', event.data);
    //         // Aqui você pode manipular a DOM com base na mensagem recebida
    //         const message = event.data.msg;

    //         // Atualizar a DOM conforme necessário
    //         // const element = document.getElementById('your-element-id');
    //         // if (element) {
    //         //   element.textContent = `Mensagem: ${message}, URL: ${url}`;
    //         // }

    //         localStorage.setItem('flow', '5');
    //         schedule.flowControl();

    //         if(localStorage.getItem('schedule')){
    //             schedule.schedulingStatus(localStorage.getItem('schedule'));

    //         }
    //     });


    // },
    requestNotificationPermission() {
        Notification.requestPermission().then(function (permission) {
            if (permission === 'granted') {
                console.log('Permissão para notificações concedida.');
                // Aqui você pode continuar com a lógica para exibir notificações
            } else if (permission === 'denied') {
                Swal.fire({
                    title: "Habilitar notificações?",
                    text: "As notificações são importantes para lembrar os horários marcado!",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Habilitar",
                    cancelButtonText: "Não habilitar"
                }).then((result) => {
                    if (result.isConfirmed) {

                        Notification.requestPermission().then(function (permission) {

                            console.log(permission = 'granted')

                            debugger


                            // if (permission === 'granted') {
                            //     new Notification('Obrigado por permitir as notificações!');
                            // } else {
                            //     console.log('Permissão de notificações negada.');
                            // }
                        });
                        // F

                    }
                });
            } else {
                console.log('Permissão para notificações fechada pelo usuário.');
            }
        }).catch(function (error) {
            console.error('Erro ao solicitar permissão para notificações:', error);
        });
    }



};

(() => {

    "use strict";
    schedule.init();

})()