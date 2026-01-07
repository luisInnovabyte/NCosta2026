<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Calendario por horas</title>
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
  <style>
    #calendar {
      max-width: 900px;
      margin: 40px auto;
    }
  </style>
</head>
<body>

  <div id="calendar"></div>

  <!-- Modal -->
  <div class="modal fade" id="eventModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Añadir clase</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="eventForm">
            <input type="hidden" id="startDate">
            <div class="mb-3">
              <label class="form-label">Profesor</label>
              <input type="text" class="form-control" id="profesor" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Aula</label>
              <input type="text" class="form-control" id="aula" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Curso</label>
              <input type="text" class="form-control" id="curso" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Descripción</label>
              <textarea class="form-control" id="descripcion"></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Hora de fin</label>
              <input type="time" class="form-control" id="horaFin" required>
            </div>
            <button type="submit" class="btn btn-primary">Añadir clase</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      let calendarEl = document.getElementById('calendar');

      let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        locale: 'es',
        slotMinTime: "08:00:00",
        slotMaxTime: "22:00:00",
        editable: false,
        selectable: true,
        select: function (info) {
          $('#startDate').val(info.startStr);
          $('#eventModal').modal('show');
        },
        events: []
      });

      calendar.render();

      $('#eventForm').on('submit', function (e) {
        e.preventDefault();
        const start = $('#startDate').val();
        const horaFin = $('#horaFin').val();

        // Creamos la fecha de fin
        const endDate = new Date(start);
        const [h, m] = horaFin.split(':');
        endDate.setHours(h);
        endDate.setMinutes(m);

        calendar.addEvent({
          title: $('#curso').val() + ' - ' + $('#profesor').val(),
          start: start,
          end: endDate.toISOString(),
          extendedProps: {
            aula: $('#aula').val(),
            descripcion: $('#descripcion').val()
          }
        });

        $('#eventModal').modal('hide');
        this.reset();
      });
    });
  </script>
</body>
</html>
