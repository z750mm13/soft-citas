<div class="card">
    <div class="card-header">{{ __('Calendario') }}</div>

    <div class="card-body">
        <div id='calendar'></div>
    </div>
</div>

@push('postjs')
<script src='{{ asset('vendor/fullcalendar/main.js') }}'></script>
<script src='{{ asset('vendor/fullcalendar/locales/es.js') }}'></script>
<script defer>
    document.addEventListener('DOMContentLoaded', function() {
      events = [
        { // this object will be "parsed" into an Event Object
          title: 'C', // a property!
          start: '2018-09-01', // a property!
          end: '2018-09-02' // a property! ** see important note below about 'end' **
        }
      ];
      var calendarEl = document.getElementById('calendar');
      var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'es',
				contentHeight: 'auto',
      });
      calendar.render();
    });
</script>
@endpush

@push('css')
<link href='{{ asset('vendor/fullcalendar/main.css') }}' rel='stylesheet' />
@endpush