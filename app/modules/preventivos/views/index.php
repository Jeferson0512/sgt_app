<style>
    body {
        background: #f1f5f9;
    }

    .layout {
        max-width: 1200px;
        /* margin: 40px auto; */
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    }

    /* Chips */
    .chip {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: .8rem;
        font-weight: 600;
        cursor: pointer;
        margin: 4px;
    }

    .chip.active {
        outline: 2px solid rgba(0, 0, 0, .2);
    }

    .chip-orange {
        background: #fde68a;
        color: #92400e;
    }

    .chip-blue {
        background: #bae6fd;
        color: #075985;
    }

    .chip-green {
        background: #a7f3d0;
        color: #065f46;
    }

    .chip-purple {
        background: #ddd6fe;
        color: #6b21a8;
    }

    .chip-gray {
        background: #e5e7eb;
        color: #374151;
    }

    /* Calendario */
    .calendar-container {
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 10px;
    }

    /* Tabla */
    .card-soft {
        background: #fff;
        border: 1px solid #e6e9ef;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .05);
    }

    .chips-top {
        border-top: 1px solid #e6e9ef;
        padding: 8px 12px;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .table thead th {
        background: #f9fafb;
        font-weight: 700;
    }

    .btn-icon {
        padding: .2rem .5rem;
    }
</style>
<div class="layout">
    <!-- Barra superior -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <button class="btn btn-success btn-sm rounded-pill" data-toggle="modal" data-target="#modalAccion">
                <i class="fas fa-plus mr-1"></i> Nueva Acción
            </button>
            <button class="btn btn-outline-secondary btn-sm rounded-pill" id="btnRefrescar">
                <i class="fas fa-sync-alt mr-1"></i> Refrescar
            </button>
            <button class="btn btn-outline-dark btn-sm rounded-pill" data-toggle="modal" data-target="#modalFiltros">
                <i class="fas fa-filter mr-1"></i> Filtros
            </button>
        </div>
        <div>
            <button id="btnToggleVista" class="btn btn-info btn-sm rounded-pill">
                <i class="fas fa-list mr-1"></i> Ver Lista
            </button>
        </div>
    </div>

    <!-- Vista Calendario -->
    <div id="vistaCalendario">
        <h4 class="mb-3">Mantenimientos Preventivos — Calendario</h4>
        <div class="calendar-container mb-3">
            <!-- <div class="text-left">
                <span class="chip chip-orange" data-estado="Programado">🟡 Programado</span>
                <span class="chip chip-blue" data-estado="En Progreso">🔵 En Progreso</span>
                <span class="chip chip-green" data-estado="Finalizado">🟢 Finalizado</span>
                <span class="chip chip-purple" data-estado="Revisado">🟣 Revisado</span>
                <span class="chip chip-gray" data-estado="Aprobado">⚪ Aprobado</span>
                <span class="chip chip-gray" data-estado="Todos">🔘 Ver Todos</span>
            </div> -->
            <div class="chips-bottom">
                <span class="chip chip-gray" data-estado="Todos">🔘 Ver Todos</span>
                <span class="chip chip-orange" data-estado="Programado">🟡 Programado</span>
                <span class="chip chip-blue" data-estado="En Progreso">🔵 En Progreso</span>
                <span class="chip chip-green" data-estado="Finalizado">🟢 Finalizado</span>
                <span class="chip chip-purple" data-estado="Revisado">🟣 Revisado</span>
                <span class="chip chip-gray" data-estado="Aprobado">⚪ Aprobado</span>
            </div>
            <div id="calendar"></div>
        </div>
    </div>

    <!-- Vista Lista -->
    <div id="vistaLista" style="display:none;">
        <h4 class="mb-3">Mantenimientos Preventivos — Lista</h4>
        <div class="card-soft">
            <div class="chips-top">
                <span class="chip chip-gray" data-estado="Todos">🔘 Ver Todos</span>
                <span class="chip chip-orange" data-estado="Programado">🟡 Programado</span>
                <span class="chip chip-blue" data-estado="En Progreso">🔵 En Progreso</span>
                <span class="chip chip-green" data-estado="Finalizado">🟢 Finalizado</span>
                <span class="chip chip-purple" data-estado="Revisado">🟣 Revisado</span>
                <span class="chip chip-gray" data-estado="Aprobado">⚪ Aprobado</span>
            </div>
            <div class="px-3 pt-2 pb-2">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-2">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Formato</th>
                                <th>Sistema</th>
                                <th>Trabajo</th>
                                <th>Usuario</th>
                                <th>Estado</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tbody"></tbody>
                    </table>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <small id="rangeInfo" class="text-muted">Mostrando 0-0 de 0</small>
                    <div class="d-flex align-items-center">
                        <label class="mr-2 mb-0 small text-muted">Filas:</label>
                        <select id="pageSize" class="custom-select custom-select-sm mr-2" style="width:auto;">
                            <option>5</option>
                            <option selected>10</option>
                            <option>20</option>
                            <option>50</option>
                        </select>
                        <div class="btn-group btn-group-sm" role="group">
                            <button id="prevPage" class="btn btn-outline-secondary">Anterior</button>
                            <button id="nextPage" class="btn btn-outline-secondary">Siguiente</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal Acción -->
<div class="modal fade" id="modalAccion" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content p-4">
            <h5 class="mb-3">Nueva Acción</h5>
            <form id="formAccion">
                <div class="form-group">
                    <label for="tipoAccion">Tipo</label>
                    <select class="form-control" id="tipoAccion" required>
                        <option value="programar">Programar Mantenimiento</option>
                        <option value="iniciar">Iniciar Mantenimiento</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Sistema</label>
                    <input type="text" class="form-control" id="sistema" required>
                </div>
                <div class="form-group">
                    <label>Formato</label>
                    <input type="text" class="form-control" id="formato" required>
                </div>
                <div class="group-programar">
                    <div class="form-group"><label>Fecha Inicio</label><input type="date" class="form-control" id="fechaInicio"></div>
                    <div class="form-group"><label>Fecha Fin</label><input type="date" class="form-control" id="fechaFin"></div>
                    <div class="form-group"><label>Duración (días)</label><input type="number" class="form-control" id="duracion" value="1"></div>
                </div>
                <div class="group-iniciar" style="display:none;">
                    <div class="form-group"><label>Fecha del Mantenimiento</label><input type="date" class="form-control" id="fechaUnica"></div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-6"><label>Trabajo</label><input type="text" class="form-control" id="trabajo"></div>
                    <div class="form-group col-sm-6"><label>Usuario</label><input type="text" class="form-control" id="usuario"></div>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Filtros -->
<div class="modal fade" id="modalFiltros" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content p-4">
            <h5 class="mb-3">Filtros</h5>
            <form id="formFiltros">
                <div class="form-group"><label>Desde</label><input type="date" class="form-control" id="filtroDesde"></div>
                <div class="form-group"><label>Hasta</label><input type="date" class="form-control" id="filtroHasta"></div>
                <div class="form-group">
                    <label>Estado</label>
                    <select class="form-control" id="filtroEstado">
                        <option value="">Todos</option>
                        <option>Programado</option>
                        <option>En Progreso</option>
                        <option>Finalizado</option>
                        <option>Revisado</option>
                        <option>Aprobado</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-dark btn-sm">Aplicar</button>
            </form>
        </div>
    </div>
</div>
<script>
    const LS_EVENTS = 'eventos_preventivos';
    const getEventos = () => JSON.parse(localStorage.getItem(LS_EVENTS) || '[]');
    const setEventos = (v) => localStorage.setItem(LS_EVENTS, JSON.stringify(v));

    let calendar, page = 1,
        pageSize = 10,
        query = '',
        chip = 'Todos';

    function chipClass(e) {
        return e === 'Programado' ? 'chip-orange' : e === 'En Progreso' ? 'chip-blue' : e === 'Finalizado' ? 'chip-green' : e === 'Revisado' ? 'chip-purple' : 'chip-gray';
    }

    function filtrarEventos(data) {
        return chip === 'Todos' ? data : data.filter(e => e.estado === chip);
    }

    function filtrarBusqueda(data) {
        if (!query) return data;
        q = query.toLowerCase();
        return data.filter(e => [e.formato, e.trabajo, e.usuario, (e.title || '')].join(' ').toLowerCase().includes(q));
    }

    function renderCalendar() {
        let data = getEventos();
        data = filtrarEventos(data);
        calendar.removeAllEvents();
        calendar.addEventSource(data);
    }

    function renderTabla() {
        let data = getEventos();
        data = filtrarEventos(data);
        data = filtrarBusqueda(data);
        const total = data.length;
        const totalPages = Math.max(1, Math.ceil(total / pageSize));
        page = Math.min(Math.max(1, page), totalPages);
        const start = (page - 1) * pageSize,
            end = Math.min(page * pageSize, total);
        const view = data.slice(start, end);

        const html = view.map(e => `
            <tr>
            <td>${e.start||'—'}</td><td>${e.formato||'—'}</td>
            <td>${(e.title||'').replace(/^(Prog:|Inicio:)\s*/,'')||'—'}</td>
            <td>${e.trabajo||'—'}</td><td>${e.usuario||'—'}</td>
            <td><span class="chip ${chipClass(e.estado)}">${e.estado}</span></td>
            <td class="text-right"><button class="btn btn-sm btn-outline-danger btn-icon" onclick="eliminarEvento('${e.start}','${e.title}')"><i class="fas fa-trash"></i></button></td>
            </tr>`).join('');
        $('#tbody').html(html);
        $('#rangeInfo').text(`Mostrando ${total?(start+1):0}-${end} de ${total}`);
        $('#prevPage').prop('disabled', start === 0);
        $('#nextPage').prop('disabled', end >= total);
    }

    function eliminarEvento(start, title) {
        if (!confirm(`¿Eliminar "${title}"?`)) return;
        setEventos(getEventos().filter(e => !(e.start === start && e.title === title)));
        renderTabla();
    }
    window.eliminarEvento = eliminarEvento;

    $(function() {
        // FullCalendar
        calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
            initialView: 'dayGridMonth',
            locale: 'es',
            events: getEventos(), // Usa abreviaturas de días
            datesSet: function(info) { // Cambiar la primera letra del mes a mayúscula
                let monthTitle = document.querySelector('.fc-toolbar-title');
                if (monthTitle) {
                    monthTitle.textContent = monthTitle.textContent.charAt(0).toUpperCase() + monthTitle.textContent.slice(1);
                }
            },
            dateClick: function(info) {
                // Abrir modal al hacer clic en un día
                $('#modalAccion').modal('show');

                // Rellenar la fecha automáticamente
                $('#fechaInicio').val(info.dateStr);
                $('#fechaFin').val(info.dateStr);
                $('#fechaUnica').val(info.dateStr);
            }, // clic en evento existente
            eventClick: function(info) {
                const evento = info.event.extendedProps;

                // Mostrar modal con los datos del evento
                $('#modalAccion').modal('show');
                $('#tipoAccion').val(evento.tipo || 'programar').trigger('change');
                $('#sistema').val(evento.sistema || '');
                $('#formato').val(evento.formato || '');
                $('#trabajo').val(evento.trabajo || '');
                $('#usuario').val(evento.usuario || '');
                $('#fechaInicio').val(evento.startStr);
                $('#fechaFin').val(evento.endStr);
                $('#fechaUnica').val(evento.startStr);



                // // CUANDO VENGA CON PHPMYADMIN
                // const evento = info.event;

                // // Abrir modal de edición
                // $('#modalAccion').modal('show');

                // // Si quieres consultar detalles exactos desde la DB:
                // $.get('/preventivos/detalle/' + evento.id, function(data) {
                //     $('#tipoAccion').val(data.tipo).trigger('change');
                //     $('#sistema').val(data.sistema);
                //     $('#formato').val(data.formato);
                //     $('#trabajo').val(data.trabajo);
                //     $('#usuario').val(data.usuario);
                //     $('#fechaInicio').val(data.fecha_inicio);
                //     $('#fechaFin').val(data.fecha_fin);
                //     $('#fechaUnica').val(data.fecha_inicio);
                // });
            }
        });
        calendar.render();

        // Toggle vistas
        $('#btnToggleVista').on('click', function() {
            $('#vistaCalendario,#vistaLista').toggle();
            if ($('#vistaCalendario').is(':visible')) $(this).html('<i class="fas fa-list mr-1"></i> Ver Lista');
            else $(this).html('<i class="fas fa-calendar mr-1"></i> Ver Calendario');
        });

        // Chips
        $('.chip').on('click', function() {
            $('.chip').removeClass('active');
            $(this).addClass('active');
            chip = $(this).data('estado');
            renderTabla();
            // renderCalendar();
            //Se usa en vez del renderCalendar()
            let data = getEventos();
            if (chip !== 'Todos') data = data.filter(e => e.estado === chip);
            calendar.removeAllEvents();
            calendar.addEventSource(data);
        });

        // Paginación
        $('#pageSize').on('change', function() {
            pageSize = parseInt(this.value) || 10;
            page = 1;
            renderTabla();
        });
        $('#prevPage').on('click', () => {
            page = Math.max(1, page - 1);
            renderTabla();
        });
        $('#nextPage').on('click', () => {
            page++;
            renderTabla();
        });

        // Guardar acción
        $('#formAccion').on('submit', function(e) {
            e.preventDefault();
            const tipo = $('#tipoAccion').val(),
                sistema = $('#sistema').val().trim(),
                formato = $('#formato').val().trim(),
                trabajo = $('#trabajo').val().trim(),
                usuario = $('#usuario').val().trim();
            const nuevo = {
                title: (tipo === 'programar' ? 'Prog: ' : 'Inicio: ') + sistema,
                estado: (tipo === 'programar' ? 'Programado' : 'En Progreso'),
                color: (tipo === 'programar' ? '#fbbf24' : '#38bdf8'),
                start: (tipo === 'programar' ? $('#fechaInicio').val() : $('#fechaUnica').val()),
                end: (tipo === 'programar' ? $('#fechaFin').val() : null),
                formato,
                trabajo,
                usuario
            };
            const arr = getEventos();
            arr.push(nuevo);
            setEventos(arr);
            $('#modalAccion').modal('hide');
            calendar.addEvent(nuevo);
            renderTabla();
        });

        // Refrescar
        $('#btnRefrescar').on('click', () => {
            calendar.removeAllEvents();
            calendar.addEventSource(getEventos());
            renderTabla();
        });

        // Filtros
        $('#formFiltros').on('submit', function(e) {
            e.preventDefault();
            const desde = $('#filtroDesde').val(),
                hasta = $('#filtroHasta').val(),
                estado = $('#filtroEstado').val();
            chip = estado || 'Todos';
            let data = getEventos();
            if (desde) data = data.filter(e => (e.start || '') >= desde);
            if (hasta) data = data.filter(e => (e.start || '') <= hasta);
            calendar.removeAllEvents();
            calendar.addEventSource(data);
            renderTabla();
            $('#modalFiltros').modal('hide');
        });

        // Tipo acción toggle
        $('#tipoAccion').on('change', function() {
            if (this.value === 'programar') {
                $('.group-programar').show();
                $('.group-iniciar').hide();
            } else {
                $('.group-programar').hide();
                $('.group-iniciar').show();
            }
        }).trigger('change');

        // Inicializar
        renderTabla();
    });
</script>