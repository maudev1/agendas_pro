
document.addEventListener('DOMContentLoaded', function () {

    $("#exampleModal").on('hide.bs.modal', function(){
        formDefault()
    });

    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'pt-br',
        initialView: 'timeGridWeek',
        editable: true,
        selectable: true,
        eventColor:'#6B76F5',
        businessHours:{
            daysOfWeek: [0,2,3,4,5,6,7],
            startTime: '09:00',
            endTime: '19:00'
        },

        titleFormat:{
            month:'long',
            year:'numeric',
            day:'numeric',
            weekday:'long'
        },

        dateClick: function (info) {

            let date = new Date(info.date);
    
            let Month = date.toLocaleDateString('pt-br', { month: 'long' });
            let WeekDay = date.toLocaleDateString('pt-br', { weekday: 'long' });
            let Hours = `${date.getHours()}:${date.getMinutes()}`;
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
        eventMouseEnter: function (info) {

        },
        eventMouseLeave: function (info) {
        },
        // eventReceive: function (info) {
        //     console.log(info)
        // },
        // eventDrop: function (info) {
        //     // UpdateEventDay(info)

        //     console.log(info.event.start.toISOString())
        // },

        events: '/admin/schedule/all',
    });

    calendar.render();

    document.querySelector('#save').addEventListener('click', function () {

        SaveEnvent();

        calendar.refetchEvents();


    });

    document.querySelector('#delete').addEventListener('click', function(){
        DeleteEvent($(this).data('id'));

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

    let form = document.querySelectorAll('#modal-form input');

        let data = {
            customer_id:$('#customer').val(),
        }
    

    form.forEach(function(element){
        if(element.value){
                data[element.name] = element.value
            
        }

    });


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

async function DeleteEvent(id){

    await fetch(`/admin/schedule/delete/${id}`)
    .then((response)=>{
        $('#exampleModal').modal('toggle');
        $('.alert').html('').hide();
    })
}

async function UpdateEventDay(info) {
    
    let eventId = info.event._def.publicId;
    let newDate = info.event._instance.range.start
    
    let data = {
        start: newDate
    }

    console.log(info);
    // console.log(info.event.start.toISOString());
    
    debugger;

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

    $('#eventId').val('');

    $('#alert').fadeOut("fast", function(){
        $(this).hide();
    })


    $('#delete').fadeOut('fast', function(){
        $(this).hide()
    })

}

