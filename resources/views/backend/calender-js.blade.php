
<script type="text/javascript" src="{{ asset('backend/vendor/calender/main.js') }}"></script>
<script>

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialDate: '{{ date("Y-m-d") }}',
      editable: true,
      selectable: true,
      businessHours: true,
      dayMaxEvents: true, // allow "more" link when too many events
      events: [
                {
                    title: 'News & Offer : {{  calendarnewsoffer(date("Y-m-d"))->title }}',
                    start: '{{ date("Y-m-d") }}'
                } 
      ]
    });

    calendar.render();
  });

</script>
