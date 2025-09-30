<?php
// var_dump($user);
// var_dump($lista);
?>
<!-- <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/correctivo.css"> -->


<div class="card-soft p-0 mb-3">
    <div class="px-3 py-3 d-flex align-items-center" style="border-bottom:1px solid var(--border-soft);">
        <div class="font-weight-bold mr-auto">Listado de Correctivos</div>
        <div class="input-group input-group-sm mr-2" style="width: 280px;">
            <div class="input-group-prepend"><span class="input-group-text bg-white border-0"><i class="fas fa-search text-muted"></i></span></div>
            <input id="searchInput" type="search" class="form-control border-0" placeholder="Buscar código, título o responsable">
        </div>
        <a id="btnRegistro" class="btn btn-primary btn-sm rounded-pill" href="<?= BASE_URL ?>correctivos/nuevo"><i class="fas fa-plus mr-1"></i> Registro</a>
    </div>

    <div class="table-responsive" id="tablaWrap">
        <table class="table table-soft mb-0" id="tblCorrectivos">
            <thead>
                <tr>
                    <th class="pl-3 sortable" data-sort="codigo"> Código </i></th>
                    <th class="sortable" data-sort="nombre"> Fecha </i></th>
                    <th class="sortable" data-sort="abreviatura"> Turno </i></th>
                    <th class="sortable" data-sort="estado"> Tunel </i></th>
                    <th class="sortable" data-sort="fregistro"> Sistema </i></th>
                    <th class="sortable" data-sort="fregistro"> Tipo de Equipo </i></th>
                    <th class="sortable" data-sort="fregistro"> Equipo </i></th>
                    <th class="sortable" data-sort="fregistro"> Estado </i></th>
                    <th class="sortable" data-sort="fregistro"> Personal </i></th>
                    <th class="text-center pr-3"> Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php include __DIR__ . '/../../partials/loader_spiner.php' ?>
                <!-- <tr>
                    <td colspan="10" class="text-center">
                        <div class="p-4">
                            <i class="fas fa-folder-open fa-2x text-muted mb-2"></i>
                            <div class="text-muted font-weight-bold">No hay registros disponibles</div>
                        </div>
                    </td>
                </tr> -->
            </tbody>
        </table>
    </div>
</div>


<script src="<?= BASE_URL ?>assets/js/correctivosv2.js"></script>