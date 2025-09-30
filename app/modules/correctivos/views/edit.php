<?php
// var_dump($correctivo);
// var_dump($sSistema);
// var_dump($sSistema);
// var_dump($sUnidadMedida);
?>
<style>
  /* Ajustes mínimos (manteniendo Bootstrap): */
  fieldset {
    border: 1px solid rgba(0, 0, 0, .125);
    border-radius: .5rem;
    padding: 1rem;
  }

  fieldset legend {
    font-size: .95rem;
    font-weight: 600;
    width: auto;
    padding: 0 .25rem;
  }

  .thumb {
    height: 140px;
    object-fit: cover;
  }

  .cursor-pointer {
    cursor: pointer
  }
</style>
<div class="container-fluid border-bottom bg-white sticky-top">
  <div class="container py-2 d-flex align-items-center">
    <!-- <div class="mr-auto">
        <div class="small text-muted">Home / Mantenimiento / <span class="text-dark">Editar Mantenimiento Correctivo</span></div>
        <h5 class="mb-0">Editar Mantenimiento Correctivo</h5>
      </div> -->
    <div class="btn-group">
      <a href="<?= BASE_URL ?>correctivos" class="btn btn-outline-secondary btn-sm" title="Volver">&larr;</a>
      <button id="btnRegistrarCorrectivo" class="btn btn-outline-secondary btn-sm" title="Guardar cambios">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round">
          <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
          <polyline points="17 21 17 13 7 13 7 21" />
          <polyline points="7 3 7 8 15 8" />
        </svg>
      </button>
      <button class="btn btn-outline-secondary btn-sm" title="Exportar a Excel">
        <!-- Ícono de Excel (hoja con X) -->
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
          class="bi bi-file-earmark-excel" viewBox="0 0 16 16">
          <!-- <path d="M5.884 6.68a.5.5 0 0 1 .812-.584L8 8.293l1.304-2.197a.5.5 0 1 1 .812.584L8.707 9l1.409 2.32a.5.5 0 1 1-.812.584L8 9.707l-1.304 2.197a.5.5 0 0 1-.812-.584L7.293 9 5.884 6.68z"/> -->
          <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5z" />
          <path d="M10.5 1.5V4a1 1 0 0 0 1 1h2.5L10.5 1.5z" />
        </svg>
      </button>
      <!-- <button class="btn btn-outline-secondary btn-sm" title="Adjuntar">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 1 1 5.66 5.66L9.88 16.88a2 2 0 1 1-2.83-2.83l8.49-8.49" />
        </svg>
      </button> -->
      <button class="btn btn-outline-secondary btn-sm" title="Descargar">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
          <polyline points="7 10 12 15 17 10" />
          <line x1="12" y1="15" x2="12" y2="3" />
        </svg>
      </button>
      <button class="btn btn-outline-secondary btn-sm" title="Eliminar (rojo)">
        <!-- Ícono de basura con líneas rojas -->
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="red"
          stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="bi bi-trash"
          viewBox="0 0 24 24">
          <polyline points="3 6 5 6 21 6" />
          <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
          <path d="M10 11v6" />
          <path d="M14 11v6" />
          <path d="M5 6l1-3h12l1 3" />
        </svg>
      </button>
    </div>
    <!-- <button class="btn btn-primary btn-sm ml-2" title="Guardar cambios">
        <svg class="mr-1" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
        Guardar
      </button> -->
  </div>
</div>


<div class="container my-4">
  <!-- Tabs -->
  <ul class="nav nav-tabs" id="tabs" role="tablist">
    <li class="nav-item"><a class="nav-link" id="tab-mant" data-toggle="tab" href="#mant"
        role="tab">Mantenimiento</a></li>
    <li class="nav-item">
      <a class="nav-link" id="tab-act" data-toggle="tab" href="#act" role="tab">
        Actividades
        <span id="badgeAct" class="badge badge-pill badge-light border ml-1">0</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="tab-mat" data-toggle="tab" href="#mat" role="tab">
        Repuestos
        <span id="badgeMat" class="badge badge-pill badge-light border ml-1">0</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" id="tab-arch" data-toggle="tab" href="#arch" role="tab">
        Archivos
        <span id="badgeArch" class="badge badge-pill badge-light border ml-1">0</span>
      </a>
    </li>
  </ul>

  <div class="tab-content border-left border-right border-bottom bg-white p-3" id="tabContent">
    <!-- =================== MANTENIMIENTO (Estilo C: Fieldsets) =================== -->
    <div class="tab-pane fade" id="mant" role="tabpanel" aria-labelledby="tab-mant">

      <!-- Fieldset: Datos principales -->
      <fieldset class="mb-3">
        <legend>Datos principales</legend>
        <div class="form-group row">
          <label class="col-sm-4 col-form-label d-block mb-2">Estado</label>
          <div class="col-sm-8 btn-group btn-group-toggle" data-toggle="buttons" id="estadoGroup">
            <label class="btn btn-outline-primary active mb-0"><input type="radio" name="estado"
                value="en_progreso" autocomplete="off"> En Progreso</label>
            <label class="btn btn-outline-secondary active mb-0"><input type="radio" name="estado"
                value="finalizado" autocomplete="off"> Finalizado</label>
            <label class="btn btn-outline-warning mb-0"><input type="radio" name="estado" value="revisado"
                autocomplete="off"> Revisado</label>
            <label class="btn btn-outline-success mb-0"><input type="radio" name="estado" value="aprobado"
                autocomplete="off"> Aprobado</label>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Fecha Mantenimiento</label>
          <div class="col-sm-6 col-md-6 col-lg-6">
            <input type="date" class="form-control"
              value="<?= isset($correctivo['fecha']) ? htmlspecialchars(date('Y-m-d', strtotime($correctivo['fecha']))) : '' ?>">
          </div>
        </div>
        <!-- <div class="form-group row">
          <label class="col-sm-4 col-form-label">Tipo de Ficha</label>
          <div class="col-sm-8">
            <select class="form-control">
              <option value="CODSIS002">CORRECTIVO</option>
              <option value="CODSIS003">PREVENTIVO</option>
            </select>
          </div>
        </div> -->
      </fieldset>

      <!-- Fieldset: Informacion del Equipo -->
      <fieldset class="mb-3">
        <legend>Información del Equipo</legend>
        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Sistema</label>
          <div class="col-sm-8">
            <select class="form-control">
              <?php foreach ($sSistema as $sistema): ?>
                <option value="<?= $sistema['codigo'] ?>"
                  <?= $sistema['codigo'] == $correctivo['codsistema'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($sistema['nombre']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Tipo Equipo</label>
          <div class="col-sm-8">
            <select class="form-control">
              <?php foreach ($sTipoEquipo as $tipoEquipo): ?>
                <option value="<?= $tipoEquipo['codigo'] ?>"
                  <?= $tipoEquipo['codigo'] == $correctivo['codtequipo'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($tipoEquipo['nombre']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="form-group row mb-0">
          <label class="col-sm-4 col-form-label">Equipo</label>
          <div class="col-sm-8">
            <select class="form-control">
              <?php foreach ($sEquipo as $equipo): ?>
                <option value="<?= $equipo['codigo'] ?>"
                  <?= $equipo['codigo'] == $correctivo['codequipo'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($equipo['nombre']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
      </fieldset>

      <!-- Fieldset: Detalles Técnicos -->
      <fieldset class="mb-3">
        <legend>Detalles Técnicos</legend>
        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Técnico Responsable</label>
          <div class="col-sm-8">
            <select class="form-control">
              <?php foreach ($sPersonal as $personal): ?>
                <option value="<?= $personal['codigo'] ?>"
                  <?= $personal['codigo'] == $correctivo['codpersonal'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($personal['nombre']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Problema</label>
          <div class="col-sm-8"><input type="text" class="form-control" placeholder="Describe el problema"
              value="<?= htmlspecialchars($correctivo['observaciones']) ?>"></div>
        </div>
        <!-- <div class="form-group row mb-0">
          <label class="col-sm-4 col-form-label">Detalle del Problema</label>
          <div class="col-sm-8">
            <textarea class="form-control" rows="3">
              <?= htmlspecialchars($correctivo['observaciones']) ?>
            </textarea>
          </div>
        </div> -->
      </fieldset>

      <!-- Fieldset: Condiciones Operativas -->
      <fieldset>
        <legend>Condiciones Operativas</legend>
        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Condición</label>
          <div class="col-sm-8">
            <select class="form-control">
              <?php foreach ($sEstadoEquipo as $estadoEquipo): ?>
                <option value="<?= $estadoEquipo['codigo'] ?>"
                  <?= $estadoEquipo['codigo'] == $correctivo['codturno'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($estadoEquipo['nombre']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-sm-4 col-form-label">Turno</label>
          <div class="col-sm-8">
            <select class="form-control">
              <?php foreach ($sTurno as $turno): ?>
                <option value="<?= $turno['codigo'] ?>"
                  <?= $turno['codigo'] == $correctivo['codturno'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($turno['nombre']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="form-group row mb-0">
          <label class="col-sm-4 col-form-label">Observaciones</label>
          <div class="col-sm-8"><textarea class="form-control" rows="3">
            <?= htmlspecialchars($correctivo['observaciones']) ?>
          </textarea></div>
        </div>
      </fieldset>
    </div>

    <!-- =================== ACTIVIDADES =================== -->
    <div class="tab-pane fade" id="act" role="tabpanel" aria-labelledby="tab-act">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="mb-0">Actividades</h6>
        <button id="addActividad" class="btn btn-outline-secondary btn-sm" data-toggle="modal"
          data-target="#modalActividad"><span class="mr-1">+</span> Añadir</button>
      </div>
      <div class="table-responsive">
        <table class="table table-sm mb-0" id="tblCorrectivoActividades">
          <thead class="thead-light">
            <tr>
              <th>Téçnico</th>
              <th>Fecha Revisión</th>
              <th>Hora Inicio</th>
              <th>Hora Fin</th>
              <th>Descripción</th>
              <th>Registrado por</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody id="tbodyActividades"></tbody>
        </table>
      </div>
    </div>

    <!-- =================== MATERIALES =================== -->
    <div class="tab-pane fade" id="mat" role="tabpanel" aria-labelledby="tab-mat">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="mb-0">Lista de Repuestos</h6>
        <button id="btnAddRepuesto" class="btn btn-outline-secondary btn-sm">
          <span class="mr-1">+</span> Añadir
        </button>
      </div>
      <div class="table-responsive">
        <table class="table table-sm mb-0" id="tblCorrectivoRepuestos">
          <thead class="thead-light">
            <tr>
              <th>Cod. Repuesto</th>
              <th>Repuesto</th>
              <th>Cod. Unidad</th>
              <th>unidad</th>
              <th style="width:120px">Cantidad</th>
              <th style="width:120px">Observaciones</th>
              <th style="width:120px">Acciones</th>
            </tr>
          </thead>
          <tbody id="tbodyMateriales"></tbody>
        </table>
      </div>
    </div>

    <!-- =================== ARCHIVOS (nuevo diseño) =================== -->
    <div class="tab-pane fade show active" id="arch" role="tabpanel" aria-labelledby="tab-arch">
      <!-- Contadores -->
      <!-- <div class="border rounded mb-3">
        <div class="d-flex justify-content-between align-items-center bg-light p-2 text-primary">
          <strong>Todos los archivos</strong>
          <span id="countTotal" class="badge badge-primary">0</span>
        </div>
        <div class="row no-gutters text-center">
          <div class="col-6 p-2 border-right">
            <span class="mr-1">📄</span>Documentos <span id="countDocs" class="badge badge-secondary ml-1">0</span>
          </div>
          <div class="col-6 p-2">
            <span class="mr-1">🖼️</span>Imágenes <span id="countImgs" class="badge badge-secondary ml-1">0</span>
          </div>
        </div>
      </div> -->

      <!-- Subir -->
      <div class="form-row">
        <div class="form-group col-md-6">
          <label class="d-block">Agregar documentos</label>
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="inputDocs" multiple
              accept=".pdf,.doc,.docx,.xls,.xlsx,.csv,.txt">
            <label class="custom-file-label" for="inputDocs">Seleccionar archivos</label>
          </div>
        </div>
        <div class="form-group col-md-6">
          <label class="d-block">Agregar imágenes</label>
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="inputImgs" multiple accept="image/*">
            <label class="custom-file-label" for="inputImgs">Seleccionar imágenes</label>
          </div>
        </div>
      </div>

      <!-- Listas inferiores -->
      <div class="mb-3">
        <h6 class="mb-2">📄 Documentos (<span id="countDocs2">0</span>)</h6>
        <ul id="listDocs" class="list-group"></ul>
        <ul id="listDocsv2" class="row"></ul>
        <ul id="listDocsv3" class="rowImg"></ul>
      </div>
      <!-- <div id="viewerContainer" class="mt-3">
        <iframe id="pdfViewer" width="100%" height="500px" style="border:1px solid #ccc;"></iframe>
      </div> -->
      <div>
        <h6 class="mb-2">🖼️ Imágenes (<span id="countImgs2">0</span>)</h6>
        <div id="gridImgs" class="row"></div>
      </div>
    </div>

  </div>

  <!-- MODAL ACTIVIDAD -->
  <div class="modal fade" id="modalActividad" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Descripción de Actividad</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form class="popup-form" method="POST" data-popup="actividad" id="formActividad">
            <div class="form-group">
              <label>Fecha Revisión</label>
              <input type="date" class="form-control" name="FechaInicio" required>
            </div>
            <div class="form-row">
              <div class="form-group col">
                <label>Hora Inicio</label>
                <input type="time" class="form-control" name="HoraInicio" required>
              </div>
              <div class="form-group col">
                <label>Hora Fin</label>
                <input type="time" class="form-control" name="HoraFin" required>
              </div>
            </div>
            <div class="form-group">
              <label>Técnico Responsable</label>
              <select class="form-control" name="CodPersonal" required>
                <option value="">-- SELECCIONE --</option>
                <option value="CODPER001">Técnico 1</option>
                <option value="CODPER002">Técnico 2</option>
              </select>
            </div>
            <div class="form-group">
              <label>Descripción</label>
              <input type="text" class="form-control" name="Descripcion" required>
            </div>
            <button type="submit" class="btn btn-success">Agregar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL MATERIAL -->
  <div class="modal fade" id="modalRepuesto" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Repuesto Usado</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form id="formRepuesto" class="popup-form" method="POST" data-popup="repuesto">
            <div class="form-group">
              <label>Repuesto</label>
              <select class="form-control" id="CodRepuesto" name="CodRepuesto" required>
              </select>
            </div>
            <div class="form-group">
              <label>Unidad Medida</label>
              <select class="form-control" id="CodUnidad" name="CodUnidad" disabled>
                <option value=""> -- Selecciona un Repuesto -- </option>
                <?php foreach ($sUnidadMedida as $unidadMedida): ?>
                  <option value="<?= $unidadMedida['codigo'] ?>">
                    <?= htmlspecialchars($unidadMedida['nombre']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group">
              <label>Cantidad</label>
              <input type="number" class="form-control" step="0.01" name="Cantidad" required>
            </div>
            <div class="form-group">
              <label>Observación</label>
              <input type="text" class="form-control" name="Observacion">
            </div>
            <button type="submit" class="btn btn-success">Agregar</button>
          </form>
          <div class="mensaje-formulario"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL VISTA DOCUMENTO -->
  <div class="modal fade" id="pdfPreviewModal" tabindex="-1" role="dialog" aria-labelledby="pdfPreviewLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document" style="max-width:96%;">
      <div class="modal-content">
        <div class="modal-header py-2">
          <h6 class="modal-title" id="pdfPreviewLabel">Vista previa</h6>
          <div class="ml-auto">
            <a id="pdfOpenNewTab" href="#" target="_blank" rel="noopener"
              class="btn btn-outline-primary btn-sm">Nueva pestaña</a>
            <button type="button" class="close ml-2" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
          </div>
        </div>
        <div class="modal-body p-0" style="height:80vh;">
          <iframe id="pdfPreviewFrame" src="about:blank" style="border:0;width:100%;height:100%;"></iframe>
        </div>
      </div>
    </div>
  </div>



</div>

<script>
  // $(document).ready(function() {
  //   fnCreateActividadOrRepuesto();
  // });
  document.addEventListener('DOMContentLoaded', () => {
    const repuestoSelect = document.getElementById('CodRepuesto');
    // const unidadSelect = document.getElementById('CodUnidad');
    //INICIALIZAMOS Selects
    fnGetSelectRepuestos();
    //Listas 
    fnLoadListActividad();
    fnLoadListRepuesto();
    fnLoadListViewImg();
    fnLoadListDoc();
    //Total de registros
    fnLoadCountAllCorrectivoActividades();
    fnLoadCountAllCorrectivoRepuestos();
    fnLoadCountAllCorrectivoArchivos();
    //Opciones
    fnCreateActividadOrRepuesto();

    repuestoSelect.addEventListener('change', function(e) {
      e.preventDefault()
      const codRepuesto = repuestoSelect.value;
      if (!codRepuesto) {
        alert('debe seleccioanr un Repuesto');
        unidadSelect.value = ''; // Limpia selección si no hay repuesto
        return;
      }
      fnGetSelectUnidadMedidaByCodRepuesto(codRepuesto);
    });


  });

  function openPdfModal(url, titulo) {
    const frame = document.getElementById('pdfPreviewFrame');
    const aNew = document.getElementById('pdfOpenNewTab');
    // Que entre encajado al ancho
    frame.src = url + '#zoom=page-width';
    aNew.href = url;
    document.getElementById('pdfPreviewLabel').textContent = titulo || 'Vista previa';
    $('#pdfPreviewModal').modal('show');

    // liberar memoria
    $('#pdfPreviewModal').on('hidden.bs.modal', function() {
      frame.src = 'about:blank';
      $(this).off('hidden.bs.modal');
    });
  }

  function fnLoadListActividad() {
    fetch('<?= BASE_URL ?>correctivos/cListCorrectivoActividad', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'fetch'
        },
        body: JSON.stringify({
          CodCorrectivo: <?= json_encode($codigo) ?>
        })
      })
      .then(res => res.json())
      .then(res => {
        const actividades = res.data;
        const cont = document.getElementById('tbodyActividades');
        cont.innerHTML = '';
        if (!res.success || !res.data) {
          alert("No se pudieron cargar actividades");
          return;
        }
        console.log("DATOS ACTIVIDAD", res);

        if (!res.success || res.data.length === 0) {
          cont.appendChild(showTablaVacia());
          return;
        }

        actividades.forEach(item => {
          const row = document.createElement('tr');
          row.innerHTML = `
                <!--td>${item.codpersonal ?? ""}</td-->
                <td>${item.nombre_completo ?? ""}</td>
                <td>${item.fecha_inicio ?? ""}</td>
                <td>${item.hora_inicio ?? ""}</td>
                <td>${item.hora_fin ?? ""}</td>
                <td>${item.descripcion ?? ""}</td>
                <td>${item.usercreate ?? ""}</td>
                <td class="text-nowrap">
                
                  <button class="btn btn-outline-secondary btn-editar" data-idcorrectivo="${item.codcorrectivo}" data-id="${item.codigo}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="black" stroke-width="2" viewBox="0 0 24 24">
                      <path d="M12 20h9"/>
                      <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                    </svg>
                  </button>
                  <button class="btn btn-outline-danger btn-eliminar" data-idcorrectivo="${item.codcorrectivo}" data-id="${item.codigo}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="red" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="bi bi-trash" viewBox="0 0 24 24">
                      <polyline points="3 6 5 6 21 6" />
                      <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                      <path d="M10 11v6" />
                      <path d="M14 11v6" />
                      <path d="M5 6l1-3h12l1 3" />
                    </svg>
                  </button>

                </td>
              `;

          cont.appendChild(row);
        });
      })
      .catch(err => {
        console.log(err);
        alert(err);
      });
  }

  function fnLoadListRepuesto() {
    fetch('<?= BASE_URL ?>correctivos/cListCorrectivoRepuestos', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'fetch'
        },
        body: JSON.stringify({
          CodCorrectivo: <?= json_encode($codigo) ?>
        })
      })
      .then(res => res.json())
      .then(res => {
        if (!res.success || !res.data) {
          alert("No se pudieron cargar repuestos");
          return;
        }
        console.log("DATOS REPUESTOS", res);
        const repuestos = res.data;
        console.log("repuestos.success:", res.success);
        console.log("res.data:", res.data);
        console.log("data.length:", res.data.length);

        // Render ÚNICO
        // const cont = document.getElementById('tblCorrectivoRepuestos');
        const cont = document.getElementById('tbodyMateriales');
        cont.innerHTML = '';

        if (!res.success || res.data.length === 0) {
          console.log("ENTRA")
          cont.appendChild(showTablaVacia());
          return;
        }

        repuestos.forEach(item => {
          const row = document.createElement('tr');
          row.innerHTML = `
                <td>${item.codrepuestos ?? ""}</td>
                <td>${item.r_nombre ?? ""}</td>
                <td>${item.codunidad ?? ""}</td>
                <td>${item.um_nombre ?? ""}</td>
                <td>${item.cantidad ?? ""}</td>
                <td>${item.observacion ?? ""}</td>
                <td class="text-nowrap">
                
                  <button class="btn btn-outline-secondary btn-editar" data-idcorrectivo="${item.codcorrectivo}" data-idrepuesto="${item.codrepuestos}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="black" stroke-width="2" viewBox="0 0 24 24">
                      <path d="M12 20h9"/>
                      <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                    </svg>
                  </button>
                  <button class="btn btn-outline-danger btn-eliminar" data-idcorrectivo="${item.codcorrectivo}" data-idrepuesto="${item.codrepuestos}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="red" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="bi bi-trash" viewBox="0 0 24 24">
                      <polyline points="3 6 5 6 21 6" />
                      <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                      <path d="M10 11v6" />
                      <path d="M14 11v6" />
                      <path d="M5 6l1-3h12l1 3" />
                    </svg>
                  </button>

                </td>
              `;

          cont.appendChild(row);
        });
      })
      .catch(err => {
        console.log(err);
        alert(err);
      });
  }

  function fnLoadListDoc() {
    fetch('<?= BASE_URL ?>correctivos/cListarCorrectivoArchivos', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'fetch'
        },
        body: JSON.stringify({
          CodCorrectivo: <?= json_encode($codigo) ?>,
          Tipo: 'DOC'
        })
      })
      .then(res => res.json())
      .then(res => {
        if (!res.success || !res.data) {
          alert("No se pudieron cargar archivos");
          return;
        }

        const archivos = res.data;

        // Render ÚNICO
        const cont = document.getElementById('listDocs');
        cont.innerHTML = '';

        archivos.forEach(file => {
          const url = '<?= BASE_URL ?>uploads/' + file.nombre;
          const title = file.nombreGuardado || file.nombre;

          const row = document.createElement('div');
          row.className = 'list-group-item d-flex justify-content-between align-items-center';
          row.style.cursor = 'pointer';
          row.setAttribute('data-url', url);
          row.setAttribute('data-title', title);

          row.innerHTML = `
                <span class="text-truncate" style="max-width:70%" title="${file.nombre}">
                  ${title}
                </span>
                <div class="d-flex align-items-center">
                  <!--button class="btn btn-outline-primary btn-sm mr-2" data-action="view" data-url="${url}" data-title="${title}">Ver</button-->

                  <button class="btn btn-outline-primary btn-sm" title="Ver documento"
                    data-action="view" data-url="${url}" data-title="${title}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                      class="feather feather-eye" viewBox="0 0 24 24">
                      <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                      <circle cx="12" cy="12" r="3" />
                    </svg>
                  </button> 

                  <!--button class="btn btn-outline-secondary btn-sm mr-2" data-action="newtab" data-url="${url}">Nueva pestaña</button-->

                  <button class="btn btn-outline-secondary btn-sm" title="Abrir en nueva pestaña"
                    data-action="newtab" data-url="${url}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                      stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                      class="feather feather-external-link" viewBox="0 0 24 24">
                      <path d="M18 3h3v3" />
                      <path d="M21 3l-9 9" />
                      <path d="M21 21H3V3h9" />
                    </svg>
                  </button>
                  
                  <button class="btn btn-outline-danger btn-sm" title="Eliminar (rojo)" data-action="del-doc" data-index="${file.codigo}" data-ruta="${file.nombre}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="red" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="bi bi-trash" viewBox="0 0 24 24">
                      <polyline points="3 6 5 6 21 6" />
                      <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                      <path d="M10 11v6" />
                      <path d="M14 11v6" />
                      <path d="M5 6l1-3h12l1 3" />
                    </svg>
                  </button>
                  <!--button class="btn btn-outline-danger btn-sm" data-action="del-doc" data-index="${file.codigo}" data-ruta="${file.nombre}">Eliminar</button-->
                </div>
              `;

          cont.appendChild(row);
        });
      });
  }

  function fnLoadListViewImg() {
    console.log("ARCHIVOS");
    fetch('<?= BASE_URL ?>correctivos/cListarCorrectivoArchivos', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'fetch'
        },
        body: JSON.stringify({
          CodCorrectivo: <?= json_encode($codigo) ?>,
          Tipo: 'IMG'
        })
      })
      .then(res => res.json())
      .then(res => {
        // // if (!res.success) {
        // //   alert("No se pudieron cargar archivos");
        // //   return;
        // // }
        console.log(res.data);
        console.log("====== FIN =========");
        const archivos = res.data;

        // Galería
        // const galeria = document.getElementById('galeriaArchivos');
        const galeria = document.getElementById('gridImgs');
        galeria.innerHTML = '';
        archivos.forEach(file => {
          const col = document.createElement('div');
          col.className = 'col-6 col-md-4 mb-3';
          col.innerHTML = '<div class="card">' +
            '<img class="card-img-top thumb" src="' + file.ruta + '" alt="' + file.nombre + '">' +
            '<div class="card-body p-2 d-flex justify-content-between align-files-center">' +
            '<small class="text-truncate" style="max-width:70%" title="' + file.nombreGuardado +
            '">' + file.nombreGuardado + '</small>' +
            '<button class="btn btn-outline-danger btn-sm" title="Eliminar (rojo)" data-action="del-doc" data-index="' +
            file.codigo + '" data-ruta="' + file.nombre + '">' +
            '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="red" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="bi bi-trash" viewBox="0 0 24 24">' +
            '<polyline points="3 6 5 6 21 6" />' +
            '<path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />' +
            '<path d="M10 11v6" />' +
            '<path d="M14 11v6" />' +
            '<path d="M5 6l1-3h12l1 3" />' +
            '</svg>' +
            '</button>' +
            '<!--button class="btn btn-outline-danger btn-sm" data-action="del-img" data-index="' +
            file.codigo + '">Eliminar</!--button-->' +
            '</div></div>';
          galeria.appendChild(col);
        });
      });
  }

  function fnLoadCountAllCorrectivoActividades() {
    fetch('<?= BASE_URL ?>correctivos/cCountAllCorrectivoActividades', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'fetch'
        },
        body: JSON.stringify({
          CodCorrectivo: <?= json_encode($codigo) ?>
        })
      })
      .then(r => r.json())
      .then(res => {
        if (!res.success) return;
        const total = res.data;
        console.log("datos Actividades: ", res.data);
        // principales
        document.getElementById('badgeAct').textContent = total;
      });
  }

  function fnLoadCountAllCorrectivoRepuestos() {
    fetch('<?= BASE_URL ?>correctivos/cCountAllCorrectivoRepuestos', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'fetch'
        },
        body: JSON.stringify({
          CodCorrectivo: <?= json_encode($codigo) ?>
        })
      })
      .then(r => r.json())
      .then(res => {
        if (!res.success) return;
        const total = res.data;
        console.log("datos: ", res.data);
        // principales
        document.getElementById('badgeMat').textContent = total;
      });
  }

  function fnLoadCountAllCorrectivoArchivos() {
    fetch('<?= BASE_URL ?>correctivos/cCountAllCorrectivoArchivos', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'fetch'
        },
        body: JSON.stringify({
          CodCorrectivo: <?= json_encode($codigo) ?>
        })
      })
      .then(r => r.json())
      .then(res => {
        if (!res.success) return;
        const {
          docs,
          imgs,
          total
        } = res.data;
        console.log("datos: ", res.data);
        // principales
        // document.getElementById('countDocs').textContent = docs;
        // document.getElementById('countImgs').textContent = imgs;
        document.getElementById('badgeArch').textContent = total;
        // // si usas duplicados visuales
        const d2 = document.getElementById('countDocs2');
        if (d2) d2.textContent = docs;
        const i2 = document.getElementById('countImgs2');
        if (i2) i2.textContent = imgs;
      });
  }

  function fnCreateActividadOrRepuesto() {

    $('.popup-form').on('submit', function(e) {
      e.preventDefault();

      const form = this;
      const $form = $(form);
      const popupId = $(form).data('popup'); // Identificador del popup
      const actionUrl = popupId == "actividad" ? '<?= BASE_URL ?>correctivos/cRegistrarCorrectivoActividad' : '<?= BASE_URL ?>correctivos/cRegistrarCorrectivoRepuesto';

      // Convertimos el form a objeto plano
      const formObject = {};
      $form.serializeArray().forEach(({
        name,
        value
      }) => {
        formObject[name] = value;
      });
      if (popupId == "repuesto") {
        formObject["CodUnidad"] = document.getElementById("CodUnidad").value;
      }

      formObject["CodCorrectivo"] = <?= json_encode($codigo) ?>;
      console.log(formObject);

      const fetchOptions = {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'fetch'
        },
        body: JSON.stringify(formObject)
      };

      fetch(actionUrl, fetchOptions)
        .then(response => response.json())
        .then(data => {
          const $mensaje = $form.siblings('.mensaje-formulario');
          console.log("DATOS: ", data);
          if (data.success) {
            alert("✅ " + data.message);
            const namePopup = popupId == "repuesto" ? "Repuesto registrado " : "Actividad registrada ";
            mostrarToast("success", namePopup + "satisfactoriamente");
            $form[0].reset();

            $mensaje.html(`<div class="alert alert-success">${data.message}</div>`);

            // const tipo = formObject?.Tipo || '';

            if (popupId === "actividad") {
              $('#modalActividad').modal('hide');
              fnLoadCountAllCorrectivoActividades();
              fnLoadListActividad?.();
            } else {
              $('#modalRepuesto').modal('hide');
              // fnLoadListRepuesto();
              fnLoadCountAllCorrectivoRepuestos();
              fnGetSelectRepuestos();
              // actualizarSelectRepuestos(formObject["CodCorrectivo"]);
              fnLoadListRepuesto?.();
            }

          } else {

            mostrarToast("error", "Error de registro", data.message);
            $mensaje.html(`<div class="alert alert-warning">⚠️ ${data.message}</div>`);
          }
        })
        .catch(err => {

          mostrarToast("error", "Error de registro", err.message);
          console.error("❌ Error en fetch:", err);
          const $mensaje = $form.siblings('.mensaje-formulario');
          $mensaje.html(`<div class="alert alert-danger">❌ Error: ${err.message}</div>`);
        });
    });
  }

  function fnGetSelectRepuestos() {
    const idCorrectivo = <?= json_encode($codigo) ?>;
    fetch(`<?= BASE_URL ?>correctivos/getRepuestosDisponibles?codigoCorrectivo=${idCorrectivo}`, {
        method: 'GET',
        headers: {
          'X-Requested-With': 'fetch' // Si tu backend lo requiere
        }
      })
      .then(response => response.json())
      .then(repuestos => {
        console.log('Repuestos disponibles:', repuestos);

        const select = document.getElementById('CodRepuesto');
        const selectUnidad = document.getElementById('CodUnidad');
        selectUnidad.value = '';

        // Vaciar las opciones actuales
        select.innerHTML = '';

        // Agregar opción inicial
        const defaultOption = document.createElement('option');
        defaultOption.value = '';
        defaultOption.textContent = ' -- Seleccionar Repuesto -- ';
        select.appendChild(defaultOption);

        // Agregar las opciones de repuestos
        repuestos.forEach(rep => {
          const option = document.createElement('option');
          option.value = rep.codigo;
          option.textContent = rep.nombre;
          select.appendChild(option);
        });
      })
      .catch(error => {
        console.error('Error al obtener los repuestos:', error);
      });
  }

  function fnGetRepuestoAndUnidad(codCorrectivo, codRepuesto) {
    fetch(`<?= BASE_URL ?>correctivos/getRepuestoAndUnidad?CodCorrectivo=${codCorrectivo}&CodRepuesto=${codRepuesto}`, {
        method: 'GET',
        headers: {
          'X-Requested-With': 'fetch' // Si tu backend lo requiere
        }
      })
      .then(res => res.json())
      .then(data => {
        const repuestoSelect = document.getElementById('CodRepuesto');
        const unidadSelect = document.getElementById('CodUnidad');
        const defaultOption = document.createElement('option');
        repuestoSelect.innerHTML = '';
        repuestoSelect.disabled = true;
        console.log('Repuesto y Unidad seleccionada:', data[0]);

        if (data && data[0].CodRepuesto && data[0].CodUnidad) {
          defaultOption.value = data[0]?.CodRepuesto;
          defaultOption.textContent = data[0]?.r_Nombre
          repuestoSelect.appendChild(defaultOption);
          unidadSelect.value = data[0]?.CodUnidad || ''; // ← Establece la selección
          // repuestoSelect.value = data[0]?.CodRepuesto || ''; // ← Establece la selección
        }
      })
      .catch(error => {
        console.error('Error al obtener los data:', error);
      });
  }

  function fnGetSelectUnidadMedidaByCodRepuesto(codRepuesto) {
    fetch(`<?= BASE_URL ?>correctivos/getUnidadMedidaByCodRepuesto?codRepuesto=${codRepuesto}`, {
        method: 'GET',
        headers: {
          'X-Requested-With': 'fetch' // Si tu backend lo requiere
        }
      })
      .then(res => res.json())
      .then(data => {
        console.log('Unidad Medida seleccionada:', data[0]);

        const unidadSelect = document.getElementById('CodUnidad');
        // const select = document.querySelector('select[name="CodRepuesto"]');

        // Vaciar las opciones actuales
        // unidadSelect.innerHTML = '';
        if (data && data[0].codigo) {
          unidadSelect.value = data[0]?.codigo || ''; // ← Establece la selección
        }
      })
      .catch(error => {
        console.error('Error al obtener los data:', error);
      });
  }

  function fnUpdateSelectRepuestos(codigoCorrectivo) {
    fetch(`<?= BASE_URL ?>correctivos/getRepuestosDisponibles?codigoCorrectivo=${codigoCorrectivo}`, {
        method: 'GET',
        headers: {
          'X-Requested-With': 'fetch' // Si tu backend lo requiere
        }
      })
      .then(response => response.json())
      .then(repuestos => {
        console.log('Repuestos disponibles:', repuestos);

        const $select = $('select[name="CodRepuesto"]');
        $select.empty().append('<option value=""> -- Seleccionar Repuesto -- </option>');

        repuestos.forEach(function(rep) {
          $select.append(`<option value="${rep.codigo}">${rep.nombre}</option>`);
        });
      })
      .catch(error => {
        console.error('Error al obtener los repuestos:', error);
      });
  }

  document.getElementById('btnAddRepuesto').addEventListener('click', () => {
    //Id del Formulario y los inputs a deshabilitar el disabled
    resetModal("formRepuesto", ['CodRepuesto']);
    fnGetSelectRepuestos();
    $('#modalRepuesto').modal('show');
  });
  $('#tblCorrectivoActividades').on('click', '.btn-editar', function(e) {
    e.preventDefault();

    const $boton = $(this);

    const idCorrectivo = $boton.data('idcorrectivo');
    const id = $boton.data('id');
    console.log(idCorrectivo, id);
    // fnGetRepuestoAndUnidad(idCorrectivo, idRepuesto);

    $('#modalRepuesto').modal('show');
  });
  $('#tblCorrectivoActividades').on('click', '.btn-eliminar', function(e) {
    e.preventDefault();
    e.stopPropagation();
    const $boton = $(this);
    const id = $boton.data('id');

    fetch('<?= BASE_URL ?>correctivos/cDeleteCorrectivoActividad', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'fetch'
        },
        body: JSON.stringify({
          Codigo: id
        })
      })
      .then(res => res.json())
      .then(data => {
        console.log("DATOS D ELIMINAR", data);
        // updateCounters();            // Actualiza contador
        fnLoadListActividad(); // Redibuja la lista
        fnLoadCountAllCorrectivoActividades();

        mostrarToast("success", "Repuesto eliminado satisfactoriamente");
      });
  });
  $('#tblCorrectivoRepuestos').on('click', '.btn-editar', function(e) {
    e.preventDefault();
    // alert();
    const $boton = $(this);
    // const accion = $boton.data('action');
    const idCorrectivo = $boton.data('idcorrectivo');
    const idRepuesto = $boton.data('idrepuesto');
    console.log('Editar repuesto con ID:', idRepuesto);
    fnGetRepuestoAndUnidad(idCorrectivo, idRepuesto);

    $('#modalRepuesto').modal('show');
  });
  $('#tblCorrectivoRepuestos').on('click', '.btn-eliminar', function(e) {
    e.preventDefault();
    e.stopPropagation();
    const $boton = $(this);
    // const accion = $boton.data('action');
    const idCorrectivo = $boton.data('idcorrectivo');
    const idRepuesto = $boton.data('idrepuesto');

    fetch('<?= BASE_URL ?>correctivos/cDeleteCorrectivoRepuesto', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'fetch'
        },
        body: JSON.stringify({
          CodCorrectivo: <?= json_encode($codigo) ?>,
          CodRepuesto: idRepuesto
        })
      })
      .then(res => res.json())
      .then(data => {
        console.log("DATOS D ELIMINAR", data);
        // updateCounters();            // Actualiza contador
        fnLoadListRepuesto(); // Redibuja la lista
        fnLoadCountAllCorrectivoRepuestos();
        fnGetSelectRepuestos();

        mostrarToast("success", "Repuesto eliminado satisfactoriamente");
      });
  });
  $('#listDocs').on('click', '[data-action="view"]', function(e) {
    e.preventDefault();
    e.stopPropagation();
    openPdfModal($(this).data('url'), $(this).data('title'));
  });

  $('#listDocs').on('click', '[data-action="newtab"]', function(e) {
    e.preventDefault();
    e.stopPropagation();
    window.open($(this).data('url'), '_blank', 'noopener');
  });
  $("#inputDocs").on("change", function(e) {
    // console.log("HIZO CLICK");
    var files = (e.target).files;
    console.log("===============");
    console.log("file Doc: ", files);
    const nombreArchivo = files[0].name;
    // Obtener la extensión
    const extension = nombreArchivo.split('.').pop();
    // OTRA FORMA
    if (files.length === 0) return;

    var formData = new FormData();
    formData.append("file", files[0]); // solo el primer archivo
    // // Agregamos datos adicionales, por ejemplo el código del correctivo
    formData.append("CodCorrectivo", <?= json_encode($codigo) ?>);
    formData.append("Tipo", "DOC");
    formData.append("Extension", extension);
    formData.append("Size", files[0].size);
    formData.append("RutaBase", "<?= BASE_URL ?>uploads");

    // console.log("DOCUMENTOS");
    fetch('<?= BASE_URL ?>correctivos/cRegistrarCorrectivoArchivo', {
        method: 'POST',
        headers: {
          'X-Requested-With': 'fetch'
        },
        body: formData
      }).then(response => response.json())
      .then(data => {

        console.log("INGRESO A REGISTRO")
        console.log("Servidor respondió:", data);
        console.log("TIPO DE CODIGO", data.data);
        console.log("TIPO DE SUCCESSS", data.success);
        console.log(typeof data.success);

        alert(data.nombre);
        alert(data.message);

        fnLoadListDoc();
        fnLoadCountAllCorrectivoArchivos();
        console.log("====== FIN =========");
        mostrarToast("success", "Documento registrado satisfactoriamente");

      }).catch(err => {
        mostrarToast("error", "Error al registrar el archivo", err.message);
        document.getElementById("mensajeArchivo").innerHTML = `
        <div class="alert alert-danger">❌ Error en la solicitud: ${err.message}</div>
      `;
      });

  });

  $("#inputImgs").on("change", function(e) {
    // console.log("HIZO CLICK");
    var files = (e.target).files;
    console.log("===============");
    console.log("file Img: ", files);
    const nombreArchivo = files[0].name;
    // Obtener la extensión
    const extension = nombreArchivo.split('.').pop();
    // OTRA FORMA
    if (files.length === 0) return;

    var formData = new FormData();
    formData.append("file", files[0]); // solo el primer archivo
    // // Agregamos datos adicionales, por ejemplo el código del correctivo
    formData.append("CodCorrectivo", <?= json_encode($codigo) ?>);
    formData.append("Tipo", "IMG");
    formData.append("Extension", extension);
    formData.append("Size", files[0].size);
    formData.append("RutaBase", "<?= BASE_URL ?>uploads");

    // console.log("DOCUMENTOS");
    fetch('<?= BASE_URL ?>correctivos/cRegistrarCorrectivoArchivo', {
        method: 'POST',
        headers: {
          'X-Requested-With': 'fetch'
        },
        body: formData
      }).then(response => response.json())
      .then(data => {

        alert(data.nombre);
        alert(data.message);

        fnLoadListViewImg();
        fnLoadCountAllCorrectivoArchivos();
        // console.log("====== FIN =========");
        mostrarToast("success", "Foto registrado satisfactoriamente");

      }).catch(err => {
        mostrarToast("error", "Error de registro", e.message);
        console.error(err.message)
        console.log("❌ Error en la solicitud: ", err.message)
        document.getElementById("mensajeArchivo").innerHTML = `
        <div class="alert alert-danger">❌ Error en la solicitud: ${err.message}</div>
      `;
      });
  });
  $('#listDocs').on('click', '[data-action="del-doc"]', function(e) {
    e.preventDefault();
    e.stopPropagation();
    var codDocumento = $(this).data('index'); // equivale a getAttribute('data-index')
    var rutaNombre = $(this).data('ruta'); // equivale a getAttribute('data-index')
    console.log("DOC CORREC", <?= json_encode($codigo) ?>)
    console.log("DOCUMENTO SELECCIONADO", codDocumento);
    console.log(rutaNombre)
    fetch('<?= BASE_URL ?>correctivos/eliminarArchivo', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'fetch'
        },
        body: JSON.stringify({
          CodCorrectivo: <?= json_encode($codigo) ?>,
          CodArchivo: codDocumento,
          Ruta: rutaNombre
        })
      })
      .then(res => res.json())
      .then(data => {
        console.log("DATOS D ELIMINAR", data)
        // updateCounters();            // Actualiza contador
        fnLoadListDoc(); // Redibuja la lista
        fnLoadCountAllCorrectivoArchivos();
        mostrarToast("success", "Documento eliminado satisfactoriamente");
      });

    // mostrarToast("error", "ENTROOO", "TEXTO");
  });

  $('#gridImgs').on('click', '[data-action="del-doc"]', function(e) {
    e.preventDefault();
    e.stopPropagation();
    var codImagen = $(this).data('index'); // equivale a getAttribute('data-index')
    var rutaNombre = $(this).data('ruta'); // equivale a getAttribute('data-index')
    console.log("IMG CORREC", <?= json_encode($codigo) ?>)
    console.log("IMAGENES SELECCIONADO", codImagen);
    console.log(rutaNombre)
    fetch('<?= BASE_URL ?>correctivos/eliminarArchivo', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'fetch'
        },
        body: JSON.stringify({
          CodCorrectivo: <?= json_encode($codigo) ?>,
          CodArchivo: codImagen,
          Ruta: rutaNombre
        })
      })
      .then(res => res.json())
      .then(data => {
        console.log("DATOS D ELIMINAR", data)
        // updateCounters();            // Actualiza contador
        fnLoadListViewImg(); // Redibuja la lista
        fnLoadCountAllCorrectivoArchivos();
        mostrarToast("success", "Foto eliminado satisfactoriamente");
      });
  });

  function resetModal(nameModal, Ids = []) {
    const form = document.getElementById(nameModal); // o tu formulario
    if (!form) return;

    form.reset(); // Limpia los inputs/selects

    Ids.forEach(items => {
      const inputs = document.getElementById(items);
      if (inputs) inputs.disabled = false
    });
    // Habilitar select que se pudo haber desactivado
    // document.getElementById('CodRepuesto').disabled = false;
    // document.getElementById('CodUnidad').disabled = false;

    // Quitar errores, clases, etc. (si las usas)
    // document.querySelectorAll('.is-invalid').forEach(e => e.classList.remove('is-invalid'));
  }
</script>