document.addEventListener('DOMContentLoaded', function () {
    let today = moment().format('YYYY-MM-DD');

    $('#copy-shareurl').on('click', function () {
        let shareUrlField = $('#shareurl-field').val()
        navigator.clipboard.writeText(shareUrlField).then(() => {
            alert('Copiado!');
        }).catch(() => {
            alert('err');
        });

    });

    $("#exampleModal").on('hide.bs.modal', function () {
        formDefault()
    });

    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        dragScroll:false,
        events: `schedules/${$('#userId').val()}`,
        eventColor: ' #e6e6e6',
        eventTextColor: 'black',
        eventBorderColor: 'black',
        themeSystem: 'bootstrap4',
        locale: 'pt-br',
        timeZone: 'America/Sao_Paulo',
        initialView: 'timeGrid',
        editable: true,
        displayEventTime: false,
        // eventStartEditable:false,
        eventResizableFromStart:false,
        eventDurationEditable:false,
        snapDuration:'01:00:00',
        slotDuration:'01:00:00',
        slotMinTime: $('#office-hour-start').val(),
        slotMaxTime: $('#office-hour-end').val(),
        initialDate: today,
        dayCount: 4,
        visibleRange: {
            start: today
        },
        validRange: {
            start: today
        },
        businessHours: {
            daysOfWeek: [0, 2, 3, 4, 5, 6, 7],
            startTime: $('#office-hour-start').val(),
            endTime: $('#office-hour-end').val(),
        },
        titleFormat: {
            month: 'long',
            year: 'numeric',
            day: 'numeric',
            weekday: 'long'
        },
        eventDidMount: async function (info) {

            let id = info.event._def.publicId

            let response = await fetch(`/schedule/status/${id}`)
            let results = await response.json()

            if (info.event.extendedProps) {
                // var img = document.createElement('img');
                // img.src = 'https://i.pravatar.cc/300';
                // // img.src = info.event.extendedProps.imagem;
                // info.el.querySelector('.fc-event-main-frame').prepend(img);

                if (!results.confirmation) {

                    actionButtons(id, 'confirmation', info.el)

                    $('.confirmation').on('click', function (event) {
                        event.stopPropagation();

                        Swal.fire({
                            title: "Atenção",
                            text: "Você gostaria de confirmar o agendamento?",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Sim, confirmar!",
                            cancelButtonText: "Não"
                        }).then((result) => {
                            if (result.isConfirmed) {

                                let id = $(this).data('id');

                                let data = {
                                    confirmation: '1'
                                }

                                let options = {
                                    method: "POST",
                                    body: JSON.stringify(data),
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                        'Content-Type': 'application/json;charset=utf-8'
                                    }
                                }

                                fetch(`/schedule/${id}`, options).then(function (e) {

                                    calendar.refetchEvents();



                                })
                            }
                        });


                    })

                } else {
                    actionButtons(id, '', info.el)

                }


            }
        },
        dateClick: function (info) {

            let date = new Date(info.date);
            let Month = date.toLocaleDateString('pt-br', { month: 'long' });
            let WeekDay = date.toLocaleDateString('pt-br', { weekday: 'long' });
            let Hours = date.toLocaleTimeString('pt-BR');
            let MonthDay = date.getDate();

            $('#start').val(info.dateStr)
            $('#title').val('Agendamento Esporádico')
            $('#preview').html(``);
            $('#preview').append(`<p>${WeekDay} - ${MonthDay} de ${Month} às ${Hours}</p>`);
            $('#exampleModal').modal('toggle');

        },
        eventClick: function (info) {

            console.log(info)

            let eventId = info.event._def.publicId;
            let title = info.event._def.title;
            let hour = info.event._def.extendedProps.hour;
            let customer_id = info.event._def.extendedProps.customer_id;

            $('#delete').show();
            $('#eventId').val(eventId);
            $('#title').val(title);
            $('#hour').val(hour);
            $('#delete').attr('data-id', eventId);

            document.querySelectorAll('#customer option').forEach((element) => {
                if (element.value == customer_id) {
                    $(element).attr('selected', 'selected')
                }
            })

            $('#exampleModal').modal('toggle');

        },
        eventDrop: function (info) {

            let eventId = info.event._def.publicId;
            let newDate = info.event._instance.range.start

            let data = {
                start: newDate
            }

            Request.url = `schedule/${eventId}`;
            Request.method = 'POST';
            Request.data = data;
            Request.makeRequest();

        },
    });

    function addDayOffEvent(dayOffEvent) {

        calendar.addEvent({
            title: dayOffEvent.title,
            startRecur: dayOffEvent.start,
            endRecur: dayOffEvent.start,
            daysOfWeek: [1],
            display: 'background'
        });
    }

    let dayOffEvent = {
        title: 'Dia de folga',
        start: '2023-02-27',
        allDay: true
    };


    calendar.render();

    addDayOffEvent(dayOffEvent);

    $('#save').on('click', function () {

        let form = document.querySelectorAll('#modal-form input');

        let data = {
            customer_id: $('#customer').val(),
        }

        form.forEach(function (element) {
            if (element.value) {
                data[element.name] = element.value

            }

        });

        Request.data = data;
        Request.url = `schedule/${$('#eventId').val()}`;
        Request.method = 'POST'
        Request.makeRequest();

        const ResponseHandler = {
            notify: function (response) {
                $('#exampleModal').modal('toggle');


            }
        };

        Request.addObserver(ResponseHandler);

        calendar.refetchEvents();

    });

    $('#delete').on('click', function () {

        Request.url = `schedule/delete/${$('#eventId').val()}`;
        Request.method = 'GET';
        Request.makeRequest();

        const ResponseHandler = {
            notify: function (response) {
                $('#exampleModal').modal('toggle');

            }
        };

        Request.addObserver(ResponseHandler);

        calendar.refetchEvents();

    });

    $('#customer').selectize({
        sortField: 'text'
    });

    $('#products').selectize({
        sortField: 'text'
    });

    $('#new-customer-switch').on('change', function () {

        if ($(this)[0].checked) {

            $(".customer").hide()

            $(".new-customer").show()

        } else {

            $(".customer").show()
            $(".new-customer").hide()


        }


    })


});


function formDefault() {
    let form = document.querySelectorAll('#modal-form input');
    form.forEach(element => {
        element.value = null
    });

    $('#eventId').val('');

    $('#alert').fadeOut("fast", function () {
        $(this).hide();
    })


    $('#delete').fadeOut('fast', function () {
        $(this).hide()
    })

}

function actionButtons(id, type, el) {
    var button = document.createElement('button');
    button.classList.add('btn')
    button.classList.add('btn-sm')

    if (type == 'confirmation') {
        button.classList.add('btn-warning')
        button.classList.add('confirmation')
        button.setAttribute('data-id', id)
        button.innerHTML = '<i class="fas fa-clock"></i>';


    } else if (type == 'cancel') {

        button.classList.add('btn-danger')
        button.innerHTML = '<i class="fa fa-times"></i>';


    } else if (type == 'whatsapp') {

        button.classList.add('btn-success')
        button.innerHTML = '<i class="fa fa-phone"></i>';

    } else {
        button.classList.add('btn-success')
        button.innerHTML = '<i class="fas fa-check"></i>';
    }



    el.querySelector('.fc-event-main-frame').append(button)


}

