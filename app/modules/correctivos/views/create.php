<?php
// ob_start();
?>
<div class="container-fluid sticky-top">
  <div class="container py-2 d-flex align-items-center">
    <!-- <div class="mr-auto">
        <div class="small text-muted">Home / Mantenimiento / <span class="text-dark">Editar Mantenimiento Correctivo</span></div>
        <h5 class="mb-0">Editar Mantenimiento Correctivo</h5>
      </div> -->
    <div class="btn-group">
      <a href="<?= BASE_URL ?>correctivos" class="btn btn-outline-secondary btn-sm" title="Volver">&larr;</a>
      <button id="btnRegistrarCorrectivo" class="btn btn-outline-secondary btn-sm" title="Guardar cambios">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
          <polyline points="17 21 17 13 7 13 7 21" />
          <polyline points="7 3 7 8 15 8" />
        </svg>
      </button>
      <!-- <button class="btn btn-outline-secondary btn-sm" title="Abrir">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
          </svg>
        </button>
        <button class="btn btn-outline-secondary btn-sm" title="Adjuntar">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 1 1 5.66 5.66L9.88 16.88a2 2 0 1 1-2.83-2.83l8.49-8.49"/>
          </svg>
        </button> -->
      <button class="btn btn-outline-secondary btn-sm" title="Exportar a Excel">
        <!-- Ícono de Excel (hoja con X) -->
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-excel" viewBox="0 0 16 16">
          <!-- <path d="M5.884 6.68a.5.5 0 0 1 .812-.584L8 8.293l1.304-2.197a.5.5 0 1 1 .812.584L8.707 9l1.409 2.32a.5.5 0 1 1-.812.584L8 9.707l-1.304 2.197a.5.5 0 0 1-.812-.584L7.293 9 5.884 6.68z"/> -->
          <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5z" />
          <path d="M10.5 1.5V4a1 1 0 0 0 1 1h2.5L10.5 1.5z" />
        </svg>
      </button>
      <!-- <button class="btn btn-outline-secondary btn-sm" title="Eliminar">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
            <path d="M5.5 5.5a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0v-6a.5.5 0 0 1 .5-.5zm5 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0v-6z"/>
            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1 0-2h3.085a1 1 0 0 1 .707.293l.853.854h2.708l.853-.854A1 1 0 0 1 9.415 1H12.5a1 1 0 0 1 1 1v1zM4.118 4l.41 9.019A1 1 0 0 0 5.525 14h4.95a1 1 0 0 0 .997-.981L11.882 4H4.118z"/>
          </svg>
        </button> -->
      <button class="btn btn-outline-secondary btn-sm" title="Eliminar (rojo)">
        <!-- Ícono de basura con líneas rojas -->
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="red" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="bi bi-trash" viewBox="0 0 24 24">
          <polyline points="3 6 5 6 21 6" />
          <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
          <path d="M10 11v6" />
          <path d="M14 11v6" />
          <path d="M5 6l1-3h12l1 3" />
        </svg>
      </button>
      <!-- <button class="btn btn-outline-secondary btn-sm" title="Descargar">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
          </svg>
        </button> -->
      <!-- <button class="btn btn-outline-secondary btn-sm" title="Imprimir">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 6 2 18 2 18 9"/>
          <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
          <rect x="6" y="14" width="12" height="8"/>
        </svg>
        </button> -->
    </div>
    <!-- <button class="btn btn-primary btn-sm ml-2" title="Guardar cambios">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
          <polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/>
        </svg>
      </button> -->
  </div>
</div>


<div class="container my-4">
  <!-- Tabs -->
  <ul class="nav nav-tabs" id="tabs" role="tablist">
    <li class="nav-item"><a class="nav-link active" id="tab-mant" data-toggle="tab" href="#mant" role="tab">Mantenimiento</a></li>
    <!-- <li class="nav-item"><a class="nav-link" id="tab-act" data-toggle="tab" href="#act" role="tab">Actividades</a></li>
      <li class="nav-item"><a class="nav-link" id="tab-mat" data-toggle="tab" href="#mat" role="tab">Materiales</a></li>
      <li class="nav-item"><a class="nav-link" id="tab-arch" data-toggle="tab" href="#arch" role="tab">Archivos</a></li> -->
  </ul>

  <div class="tab-content border-left border-right border-bottom bg-white p-3" id="tabContent">
    <!-- =================== MANTENIMIENTO (Estilo C: Fieldsets) =================== -->

    <!-- Fieldset: Datos principales -->
    <fieldset class="mb-3">
      <legend>Datos principales</legend>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label d-block mb-2">Estado</label>
        <div class="col-sm-8 btn-group btn-group-toggle" data-toggle="buttons" id="estadoGroup">
          <label class="btn btn-outline-primary active mb-0"><input type="radio" name="estado" value="en_progreso" autocomplete="off"> En Progreso</label>
          <label class="btn btn-outline-secondary mb-0"><input type="radio" name="estado" value="finalizado" autocomplete="off"> Finalizado</label>
          <label class="btn btn-outline-warning mb-0"><input type="radio" name="estado" value="revisado" autocomplete="off"> Revisado</label>
          <label class="btn btn-outline-success mb-0"><input type="radio" name="estado" value="aprobado" autocomplete="off"> Aprobado</label>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Fecha Mantenimiento</label>
        <div class="col-sm-6 col-md-6 col-lg-6">
          <input id="dtFecha" type="date" class="form-control"
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
        <label class="col-sm-4 col-form-label">Sentido</label>
        <div class="col-sm-8">
          <select id="cmbSentido" name="sentido" class="form-control">
            <option value="" selected> -- Seleccionar Sentido -- </option>
            <?php foreach ($sSentido as $sentido): ?>
              <option value="<?= $sentido['codigo'] ?>">
                <?= htmlspecialchars($sentido['nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Sistema</label>
        <div class="col-sm-8">
          <select id="sistema" name="sistema" class="form-control">
            <option value="" selected> -- Seleccionar Sistema -- </option>
            <?php foreach ($sSistema as $sistema): ?>
              <option value="<?= $sistema['codigo'] ?>">
                <?= htmlspecialchars($sistema['nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Tipo Equipo</label>
        <div class="col-sm-8">
          <select id="tipo_equipo" name="tipo_equipo" class="form-control" disabled>
            <option value="" selected> -- Selecciona un Sistema -- </option>
            <!-- <?php foreach ($sTipoEquipo as $tipoEquipo): ?>
                <option value="<?= $tipoEquipo['codigo'] ?>"
                  <?= $tipoEquipo['codigo'] == $correctivo['codtequipo'] ? 'selected' : '' ?>>
                  <?= htmlspecialchars($tipoEquipo['nombre']) ?>
                </option>
              <?php endforeach; ?> -->
          </select>
        </div>
      </div>
      <div class="form-group row mb-0">
        <label class="col-sm-4 col-form-label">Equipo</label>
        <div class="col-sm-8">
          <select id="equipo" name="equipo" class="form-control" disabled>
            <option value=""> -- Selecciona un Tipo de Equipo -- </option>
            <!-- <?php foreach ($sEquipo as $equipo): ?>
                <option value="<?= $equipo['codigo'] ?>">
                  <?= htmlspecialchars($equipo['nombre']) ?>
                </option>
              <?php endforeach; ?> -->
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
          <select id="cmbPersonal" class="form-control">
            <option value="" disabled selected> -- Seleccionar Técnico -- </option>
            <?php foreach ($sPersonal as $personal): ?>
              <option value="<?= $personal['codigo'] ?>">
                <?= htmlspecialchars($personal['nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Problema</label>
        <div class="col-sm-8">
          <input id="txtProblema" type="text" class="form-control" placeholder="Describe el problema">
        </div>
      </div>
      <!-- <div class="form-group row mb-0">
          <label class="col-sm-4 col-form-label">Detalle del Problema</label>
          <div class="col-sm-8">
            <textarea id="txtDetalleProblema" class="form-control" rows="3">
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
          <select id="cmbCondicion" class="form-control">
            <option value="" disabled selected> -- Seleccionar Condición -- </option>
            <?php foreach ($sEstadoEquipo as $estadoEquipo): ?>
              <option value="<?= $estadoEquipo['codigo'] ?>">
                <?= htmlspecialchars($estadoEquipo['nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="form-group row">
        <label class="col-sm-4 col-form-label">Turno</label>
        <div class="col-sm-8">
          <select id="cmbTurno" class="form-control">
            <option value="" disabled selected> -- Seleccionar Turno -- </option>
            <?php foreach ($sTurno as $turno): ?>
              <option value="<?= $turno['codigo'] ?>">
                <?= htmlspecialchars($turno['nombre']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="form-group row mb-0">
        <label class="col-sm-4 col-form-label">Observaciones</label>
        <div class="col-sm-8">
          <textarea id="txtObservaciones" class="form-control" rows="3"></textarea>
        </div>
      </div>
    </fieldset>
  </div>

  <!-- =================== ACTIVIDADES =================== -->
  <div class="tab-pane fade" id="act" role="tabpanel" aria-labelledby="tab-act">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h6 class="mb-0">Actividades</h6>
      <button id="addActividad" class="btn btn-outline-secondary btn-sm"><span class="mr-1">+</span> Añadir</button>
    </div>
    <div class="table-responsive">
      <table class="table table-sm mb-0">
        <thead class="thead-light">
          <tr>
            <th>#</th>
            <th>Actividad</th>
            <th>Estado</th>
            <th>Responsable</th>
          </tr>
        </thead>
        <tbody id="tbodyActividades"></tbody>
      </table>
    </div>
  </div>

  <!-- =================== MATERIALES =================== -->
  <div class="tab-pane fade" id="mat" role="tabpanel" aria-labelledby="tab-mat">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h6 class="mb-0">Materiales</h6>
      <button id="addMaterial" class="btn btn-outline-secondary btn-sm"><span class="mr-1">+</span> Añadir</button>
    </div>
    <div class="table-responsive">
      <table class="table table-sm mb-0">
        <thead class="thead-light">
          <tr>
            <th>Código</th>
            <th>Descripción</th>
            <th style="width:120px">Cantidad</th>
            <th style="width:120px">Unidad</th>
          </tr>
        </thead>
        <tbody id="tbodyMateriales"></tbody>
      </table>
    </div>
  </div>

  <!-- =================== ARCHIVOS (nuevo diseño) =================== -->
  <div class="tab-pane fade" id="arch" role="tabpanel" aria-labelledby="tab-arch">
    <!-- Contadores -->
    <div class="border rounded mb-3">
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
    </div>

    <!-- Subir -->
    <div class="form-row">
      <div class="form-group col-md-6">
        <label class="d-block">Agregar documentos</label>
        <div class="custom-file">
          <input type="file" class="custom-file-input" id="inputDocs" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.csv,.txt">
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
    </div>
    <div>
      <h6 class="mb-2">🖼️ Imágenes (<span id="countImgs2">0</span>)</h6>
      <div id="gridImgs" class="row"></div>
    </div>
  </div>
</div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    //Declaración de variables 
    const sistemaSelect = document.getElementById('sistema');
    const tipoEquipoSelect = document.getElementById('tipo_equipo');
    const equipoSelect = document.getElementById('equipo');

    sistemaSelect.addEventListener('change', function() {
      // const BASE = '<?= rtrim(BASE_URL, '/') ?>/';
      // console.log(BASE);
      const idSistema = this.value;
      // const formData = new FormData();
      // formData.append('idSistema', idSistema);
      // console.log("VALOR SISTEMA", idSistema);
      // Limpiar los siguientes selects
      tipoEquipoSelect.innerHTML = '<option value="">-- Seleccionar Tipo de Equipo -- </option>';
      tipoEquipoSelect.disabled = false;

      equipoSelect.innerHTML = '<option value=""> -- Seleccionar un Tipo de Equipo --</option>';
      equipoSelect.disabled = true;

      if (!idSistema) {
        tipoEquipoSelect.innerHTML = '<option value="">-- Selecciona un Sistema -- </option>';
        tipoEquipoSelect.disabled = true;

        equipoSelect.innerHTML = '<option value=""> -- Selecciona un Sistema --</option>';
        equipoSelect.disabled = true;
        return;
      }

      // console.log("PASO EL IF")
      // Petición AJAX
      fetch('<?= BASE_URL ?>correctivos/getTipoEquipoPorSistema', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'fetch'
          },
          // body: formData,
          // body: JSON.stringify({ idSistema: idSistema }),
          body: new URLSearchParams({
            idSistema
          })
        })
        .then(res => {
          if (!res.ok) throw new Error('Error HTTP: ' + res.status);
          return res.json();
        })
        // .then(res => res.json())
        .then(data => {
          // console.log("PASO EL res")
          if (data && Array.isArray(data)) {
            // console.log("DATA TIPO DE EQUIPOS", data);
            data.forEach(tipo => {
              const option = document.createElement('option');
              option.value = tipo.codigo;
              option.textContent = tipo.nombre;
              tipoEquipoSelect.appendChild(option);
            });
          }
        })
        .catch(err => {
          console.error('Error al cargar tipos de equipo:', err);
        });
    });

    tipoEquipoSelect.addEventListener('change', function() {
      // changeTipoEquipo(this.value)
      const idTipoEquipo = this.value;

      equipoSelect.innerHTML = '<option value=""> -- Seleccionar Equipo --</option>';
      equipoSelect.disabled = false;
      if (!idTipoEquipo) {
        equipoSelect.innerHTML = '<option value=""> -- Selecciona un Tipo de Equipo --</option>';
        equipoSelect.disabled = true;
        return;
      }
      // if (!idTipoEquipo) return;
      // console.log("EQUIPOs")
      fetch('<?= BASE_URL ?>correctivos/getEquipoPorTipoEquipo', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'fetch'
          },
          body: new URLSearchParams({
            idTipoEquipo
          })
        })
        .then(res => res.json())
        .then(data => {
          if (data && Array.isArray(data)) {
            data.forEach(tipo => {
              const option = document.createElement('option');
              option.value = tipo.codigo;
              option.textContent = tipo.nombre;
              equipoSelect.appendChild(option);
            });
          }
        })
        .catch(err => {
          console.error('Error al cargar equipo:', err);
        });

    });

    // Aquí puedes repetir lo mismo para tipoEquipoSelect → equipoSelect
  });
  $("#btnRegistrarCorrectivo").on("click", function() {
    // console.log("HIZO CLICK");
    const data = {
      FechaMantto: $("#dtFecha").val(),
      CodSentido: $("#cmbSentido").val(),
      CodSistema: $("#sistema").val(),
      CodTipoEquipo: $("#tipo_equipo").val(),
      CodEquipo: $("#equipo").val(),
      CodPersonal: $("#cmbPersonal").val(),
      // problema: $("#txtProblema").val(),
      CodEstadoEquipo: $("#cmbCondicion").val(),
      Estado: "P",
      CodTurno: $("#cmbTurno").val(),
      Observaciones: $("#txtObservaciones").val()
    };
    console.log("Enviando Datos:", data)

    $.ajax({
      // url: "<?= BASE_URL ?>correctivos/registrarCorrectivo",
      url: "<?= BASE_URL ?>correctivos/cRegistrarCorrectivo",
      method: "POST",
      contentType: 'application/json; charset=utf-8',
      dataType: "json",
      headers: {
        'X-Requested-With': 'fetch'
      },
      data: JSON.stringify(data),
      success: function(response) {
        console.log("Servidor respondió:", response);
        console.log("TIPO DE CODIGO", response.datos);
        console.log("TIPO DE SUCCESSS", response.success);
        console.log(typeof response.success);
        if (response.success) {
          alert(response.msg);
          window.location.href = "<?= BASE_URL ?>correctivos";
        } else {
          alert("Error Success: " + response.msg);
        }
      },
      error: function(xhr, status, error) {
        console.error("Error Error:", error);
        alert("Error al guardar");
      }
    });

  });
</script>