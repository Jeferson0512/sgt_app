
  <div class="container my-4">
    <!-- Tabs -->
    <ul class="nav nav-tabs" id="tabs" role="tablist">
      <li class="nav-item"><a class="nav-link active" id="tab-mant" data-toggle="tab" href="#mant" role="tab">Mantenimiento</a></li>
      <li class="nav-item"><a class="nav-link" id="tab-act" data-toggle="tab" href="#act" role="tab">Actividades</a></li>
      <li class="nav-item"><a class="nav-link" id="tab-mat" data-toggle="tab" href="#mat" role="tab">Materiales</a></li>
      <li class="nav-item"><a class="nav-link" id="tab-arch" data-toggle="tab" href="#arch" role="tab">Archivos</a></li>
    </ul>

    <div class="tab-content border-left border-right border-bottom bg-white p-3" id="tabContent">
      <!-- =================== MANTENIMIENTO (Estilo C: Fieldsets) =================== -->
      <div class="tab-pane fade show active" id="mant" role="tabpanel" aria-labelledby="tab-mant">
        <!-- Estado -->
        <div class="form-group">
          <label class="font-weight-bold d-block mb-2">Estado</label>
          <div class="btn-group btn-group-toggle" data-toggle="buttons" id="estadoGroup">
            <label class="btn btn-outline-primary active mb-0"><input type="radio" name="estado" value="en_progreso" autocomplete="off" checked> En Progreso</label>
            <label class="btn btn-outline-secondary mb-0"><input type="radio" name="estado" value="finalizado" autocomplete="off"> Finalizado</label>
            <label class="btn btn-outline-warning mb-0"><input type="radio" name="estado" value="revisado" autocomplete="off"> Revisado</label>
            <label class="btn btn-outline-success mb-0"><input type="radio" name="estado" value="aprobado" autocomplete="off"> Aprobado</label>
          </div>
        </div>

        <!-- Fieldset: Datos principales -->
        <fieldset class="mb-3">
          <legend>Datos principales</legend>
          <div class="form-group row">
            <label class="col-sm-4 col-form-label">Fecha Mantenimiento</label>
            <div class="col-sm-8"><input type="date" class="form-control" value="2023-01-13"></div>
          </div>
          <div class="form-group row">
            <label class="col-sm-4 col-form-label">Tipo de Ficha</label>
            <div class="col-sm-8">
              <select class="form-control">
                <option selected>CORRECTIVO</option>
                <option>PREVENTIVO</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-4 col-form-label">Sistema</label>
            <div class="col-sm-8">
              <select class="form-control">
                <option>18 - SISTEMA DE SEMÁFOROS</option>
                <option>17 - ILUMINACIÓN</option>
                <option>12 - VENTILACIÓN</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-4 col-form-label">Tipo Equipo</label>
            <div class="col-sm-8">
              <select class="form-control">
                <option>ITEM 09</option>
                <option>ITEM 10</option>
                <option>ITEM 11</option>
              </select>
            </div>
          </div>
          <div class="form-group row mb-0">
            <label class="col-sm-4 col-form-label">Equipo</label>
            <div class="col-sm-8">
              <select class="form-control">
                <option>PRUEBA2</option>
                <option>PULSERA</option>
                <option>CÁMARA 03</option>
              </select>
            </div>
          </div>
        </fieldset>

        <!-- Fieldset: Responsables y descripción -->
        <fieldset class="mb-3">
          <legend>Responsables y descripción</legend>
          <div class="form-group row">
            <label class="col-sm-4 col-form-label">Técnico Responsable</label>
            <div class="col-sm-8"><input type="text" class="form-control" value="CARLOS ALARCON"></div>
          </div>
          <div class="form-group row">
            <label class="col-sm-4 col-form-label">Problema</label>
            <div class="col-sm-8"><input type="text" class="form-control" placeholder="Describe el problema" value="ASD"></div>
          </div>
          <div class="form-group row mb-0">
            <label class="col-sm-4 col-form-label">Detalle del Problema</label>
            <div class="col-sm-8"><textarea class="form-control" rows="3">ASD</textarea></div>
          </div>
        </fieldset>

        <!-- Fieldset: Condiciones y turno -->
        <fieldset>
          <legend>Condiciones y turno</legend>
          <div class="form-group row">
            <label class="col-sm-4 col-form-label">Condición</label>
            <div class="col-sm-8">
              <select class="form-control">
                <option selected>CRÍTICA</option>
                <option>ALTA</option>
                <option>MEDIA</option>
                <option>BAJA</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-4 col-form-label">Turno</label>
            <div class="col-sm-8">
              <select class="form-control">
                <option selected>MAÑANA</option>
                <option>TARDE</option>
                <option>NOCHE</option>
              </select>
            </div>
          </div>
          <div class="form-group row mb-0">
            <label class="col-sm-4 col-form-label">Observaciones</label>
            <div class="col-sm-8"><textarea class="form-control" rows="3">ASDASD</textarea></div>
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
                <th>#</th><th>Actividad</th><th>Estado</th><th>Responsable</th>
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
                <th>Código</th><th>Descripción</th><th style="width:120px">Cantidad</th><th style="width:120px">Unidad</th>
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