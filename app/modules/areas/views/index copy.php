<?php
var_dump($lista);

?>
<div class="card-soft p-0 mb-3">
    <div class="px-3 py-3 d-flex align-items-center" style="border-bottom:1px solid var(--border-soft);">
        <div class="font-weight-bold mr-auto">Órdenes de Trabajo</div>
        <div class="input-group input-group-sm mr-2" style="width: 280px;">
            <div class="input-group-prepend"><span class="input-group-text bg-white border-0"><i class="fas fa-search text-muted"></i></span></div>
            <input id="searchInput" type="search" class="form-control border-0" placeholder="Buscar código, título o responsable">
        </div>
        <select id="pageSize" class="custom-select custom-select-sm mr-2" style="width: auto;">
            <option value="5">5</option>
            <option value="10" selected>10</option>
            <option value="20">20</option>
        </select>
        <button id="btnRegistro" class="btn btn-primary btn-sm rounded-pill"><i class="fas fa-plus mr-1"></i> Registro</button>
    </div>

    <div class="table-responsive" id="tablaWrap">
        <table class="table table-soft mb-0" id="tblAreas">
            <thead>
                <tr>
                    <th class="pl-3 sortable" data-sort="codigo">Código <i class="fas fa-sort ml-1 sort-icon"></i></th>
                    <th class="sortable" data-sort="titulo">Título <i class="fas fa-sort ml-1 sort-icon"></i></th>
                    <th class="sortable" data-sort="estado">Estado <i class="fas fa-sort ml-1 sort-icon"></i></th>
                    <th class="sortable" data-sort="prioridad">Prioridad <i class="fas fa-sort ml-1 sort-icon"></i></th>
                    <th class="sortable" data-sort="responsable">Responsable <i class="fas fa-sort ml-1 sort-icon"></i></th>
                    <th class="sortable" data-sort="fecha">Fecha <i class="fas fa-sort ml-1 sort-icon"></i></th>
                    <th class="text-right pr-3">Acciones</th>
                </tr>
            </thead>
            <tbody><!-- rows --></tbody>
        </table>
    </div>

    <div class="px-3 py-2 d-flex align-items-center" style="border-top:1px solid var(--border-soft);">
        <small id="rangeText" class="text-muted mr-auto">Mostrando 0-0 de 0</small>
        <div class="btn-group btn-group-sm" role="group">
            <button id="btnPrev" class="btn btn-outline-secondary">Anterior</button>
            <button id="btnNext" class="btn btn-outline-secondary">Siguiente</button>
        </div>
    </div>
</div>
  <!-- ====== MODAL CRUD ====== -->
  <div class="modal" id="crudModal" tabindex="-1" role="dialog" aria-labelledby="crudTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="crudTitle">Registrar OT</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <form id="crudForm">
          <div class="modal-body">
            <input type="hidden" id="editId">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="codigo">Código</label>
                <input type="text" class="form-control" id="codigo" required>
              </div>
              <div class="form-group col-md-6">
                <label for="responsable">Responsable</label>
                <input type="text" class="form-control" id="responsable" placeholder="Nombre y apellido">
              </div>
            </div>
            <div class="form-group">
              <label for="titulo">Título</label>
              <input type="text" class="form-control" id="titulo" required>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4">
                <label for="estado">Estado</label>
                <select class="custom-select" id="estado">
                  <option value="pendiente">pendiente</option>
                  <option value="en_proceso">en_proceso</option>
                  <option value="cerrado">cerrado</option>
                </select>
              </div>
              <div class="form-group col-md-4">
                <label for="prioridad">Prioridad</label>
                <select class="custom-select" id="prioridad">
                  <option value="alta">alta</option>
                  <option value="media" selected>media</option>
                  <option value="baja">baja</option>
                </select>
              </div>
              <div class="form-group col-md-4">
                <label for="fecha">Fecha</label>
                <input type="date" class="form-control" id="fecha">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary" id="btnSubmit">Registrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

<script src="<?= BASE_URL ?>assets/js/areas.js"></script>