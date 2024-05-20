
  <audio src="./sounds/pogi gising na alarm.mp3" class="notificationSound"></audio>
  <script src="./scripts/notification.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
<script>
  $(document).ready(function() {
  $('#calendar').fullCalendar({
    events: <?php include './config/fetch_tasks.php'; ?>,
    selectable: true,
    selectHelper: true,
    select: function() {
      $('#addTaskModal').modal('toggle');
    },
    header: {
      left: 'month, agendaWeek, agendaDay, list',
      center: 'title',
    },
    buttonText: {
      today: 'Today',
      month: 'Month',
      week: 'Week',
      day: 'Day',
      list: 'List'
    },
    editable: true,
    eventDrop: function(event) {
      let start = event.start.format("YYYY-MM-DD HH:mm:ss");
      let end = event.end.format("YYYY-MM-DD HH:mm:ss");
      let title = event.title;
      $.ajax({
        url: "./config/update_task.php",
        type: "POST",
        data: { title: title, start: start, end: end },
        success: function(response) {
          alert(response);
        },
        error: function(xhr, status, error) {
          console.error(xhr.responseText);
        }
      });            
    },
    eventClick: function(event) {
      if(confirm("Are you sure want to remove it?")) {
        let title = event.title;
        $.ajax({
          url: "./config/delete_task.php",
          type: "POST",
          data: { title: title },
          success: function(response) {
            alert(response);
            window.location.reload();
          }
        });
      }
    },
    viewRender: function(view, element) {
      $('.fc-toolbar .fc-center').find('h2').addClass('my-3 my-sm-2');
      $('.fc-toolbar').addClass('my-3');
    }
  });

  });
</script>