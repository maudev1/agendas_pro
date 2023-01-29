
document.addEventListener('DOMContentLoaded', function () {

    $("#exampleModal").on('hide.bs.modal', function(){
        formDefault()
    });

    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'pt-br',
        initialView: 'dayGridMonth',
        // initialDate: new Date(2023,1,1),
        editable: true,
        selectable: true,
        dropable: false,
        dateClick: function (info) {
            // info.dayEl.style.backgroundColor = 'red'

            $('#start').val(info.dateStr)
            $('#title').val('Agendamento Esporádico')
            $('#preview').html(``);
            $('#preview').append(`<p>${info.date}</p>`);
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
        eventMouseEnter: function (info) {

            // console.log(info)

        },
        eventMouseLeave: function (info) {

            // console.log(info)
        },
        eventReceive: function (info) {
            console.log(info)

        },
        eventDrop: function (info) {
            UpdateEventDay(info)

            // info.revert();
            // alert(info.event.title + " was dropped on " + info.event.start.toISOString());

            // if (!confirm("Are you sure about this change?")) {
            //   info.revert();
            // }
        },

        events: '/admin/schedule/all',
    });

    calendar.render();

    document.querySelector('#save').addEventListener('click', function () {

        SaveEnvent();

        calendar.refetchEvents();


    });

    document.querySelector('#delete').addEventListener('click', function(){
        DeletEvent($(this).data('id'));

        calendar.refetchEvents();

    })

    
});



async function Schedules() {

    let args = {
        method: 'GET'
    }

    let results = await fetch('/admin/schedule/all', args)
        .then((response) => {
            return response;

        })
        .catch((err) => {
            return response
        });

    return results.json();

}

async function SaveEnvent() {

    let data = [
        {
            title: $('#title').val(),
            start: $('#start').val(),
            hour: $('#hour').val(),
            notify: $('#notify').val(),
            customer_id: $('#customer').val()
        }
    ];


    let response = await fetch(`/admin/schedule/${$('#eventId').val()}`, {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    if (response.status == 200) {
        $('#exampleModal').modal('toggle');
        $('.alert').html('').hide();
    } else {

        let results = await response.json()

        if (Array.isArray(results)) {
            results.forEach((result) => {

                if (result.code != 200) {
                    $('.alert').addClass('alert-danger').text(result.message).show()

                }
            })
        }
    }

}

async function DeletEvent(id){

    await fetch(`/admin/schedule/delete/${id}`)
    .then((response)=>{
        $('#exampleModal').modal('toggle');
        $('.alert').html('').hide();
    })

    // alert(id)

}

async function UpdateEventDay(info) {

    console.log(info)

    let eventId = info.event._def.publicId;
    let newDate = info.event._instance.range.end

    let data = {
        'start': newDate
    }

    console.log(newDate)
    let response = await fetch(`/admin/schedule/${eventId}`, {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })


}

function formDefault() {
    let form = document.querySelectorAll('#modal-form input');
    form.forEach(element => {
        element.value = null
    });

    $('#delete').hide()

}

