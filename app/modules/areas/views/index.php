<?php
// var_dump($lista);

?>
<div class="card-soft p-0 mb-3">
  <div class="px-3 py-3 d-flex align-items-center" style="border-bottom:1px solid var(--border-soft);">
    <div class="font-weight-bold mr-auto">Listado de Áreas</div>
    <div class="input-group input-group-sm mr-2" style="width: 280px;">
      <div class="input-group-prepend"><span class="input-group-text bg-white border-0"><i class="fas fa-search text-muted"></i></span></div>
      <input id="searchInput" type="search" class="form-control border-0" placeholder="Buscar código, título o responsable">
    </div>
    <!-- <select id="pageSize" class="custom-select custom-select-sm mr-2" style="width: auto;">
            <option value="5">5</option>
            <option value="10" selected>10</option>
            <option value="20">20</option>
        </select> -->
    <button id="btnRegistro" class="btn btn-primary btn-sm rounded-pill"><i class="fas fa-plus mr-1"></i> Registro</button>
  </div>

  <div class="table-responsive" id="tablaWrap">
    <table class="table table-soft mb-0" id="tblAreas">
      <thead>
        <tr>
          <th class="pl-3 sortable" data-sort="codigo"> Código </i></th>
          <th class="sortable" data-sort="nombre"> Nombre </i></th>
          <th class="sortable" data-sort="abreviatura"> Abreviatura </i></th>
          <th class="sortable" data-sort="estado"> Estado </i></th>
          <th class="sortable" data-sort="fregistro"> Fec. Creación </i></th>
          <th class="text-center pr-3"> Acciones</th>
        </tr>
      </thead>
      <tbody><!-- rows --></tbody>
    </table>
  </div>

  <!-- <div class="px-3 py-2 d-flex align-items-center" style="border-top:1px solid var(--border-soft);">
        <small id="rangeText" class="text-muted mr-auto">Mostrando 0-0 de 0</small>
        <div class="btn-group btn-group-sm" role="group">
            <button id="btnPrev" class="btn btn-outline-secondary">Anterior</button>
            <button id="btnNext" class="btn btn-outline-secondary">Siguiente</button>
        </div>
    </div> -->
</div>
<!-- ====== MODAL CRUD ====== -->
<div class="modal" id="crudAreaModal" tabindex="-1" role="dialog" aria-labelledby="crudTitle" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="crudTitle">Registrar Area</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form id="crudAreaForm">
        <div class="modal-body">
          <input type="hidden" name="codigo" id="codigoArea">
          <!-- <div class="form-row">
              <div class="form-group col-md-12">
                <label for="codigo">Código</label>
                <input type="text" class="form-control" id="codigo">
              </div>
            </div> -->
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="nombre">Nombre</label>
              <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre del Área" required>
            </div>
            <div class="form-group col-md-6">
              <label for="abreviatura">Abreviatura</label>
              <input type="text" class="form-control" name="abreviatura" id="abreviatura" required>
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