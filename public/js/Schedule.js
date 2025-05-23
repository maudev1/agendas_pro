
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
        events: `schedules/${$('#userId').val()}`,
        locale: 'pt-br',
        timeZone: 'America/Sao_Paulo',
        initialView: 'timeGrid',
        editable: true,
        displayEventTime: false,
        slotMinTime: '08:00:00',
        slotMaxTime: '18:00:00',
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
        },

        titleFormat: {
            month: 'long',
            year: 'numeric',
            day: 'numeric',
            weekday: 'long'
        },
        eventDidMount: function (info) {
            // if (info.event.extendedProps.image) {
            if (info.event.extendedProps) {
                var img = document.createElement('img');
                img.src = 'https://i.pravatar.cc/300';
                // img.src = info.event.extendedProps.imagem;
                info.el.querySelector('.fc-event-main-frame').prepend(img);
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

    let dayOffEvent = {
        title: 'Dia de folga',
        start: '2023-02-27',
        allDay: true
    };

    function addDayOffEvent(dayOffEvent) {

        calendar.addEvent({
            title: dayOffEvent.title,
            startRecur: dayOffEvent.start,
            endRecur: dayOffEvent.start,
            daysOfWeek: [1],
            display: 'background'
        });
    }

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

    $('select').selectize({
        sortField: 'text'
    });


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

