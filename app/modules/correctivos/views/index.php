<?php
// var_dump($user);
// var_dump($lista);
?>
<!-- <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/correctivo.css"> -->
<style>
    /* Cards y tabla */
    .card-soft {
        background: var(--card-bg);
        border: 1px solid var(--border-soft);
        border-radius: var(--card-radius);
        box-shadow: var(--shadow-soft);
    }

    .metric-label {
        color: #6b7280;
        font-size: .85rem;
        font-weight: 600;
        margin-bottom: .35rem;
    }

    .metric-value {
        font-size: 1.75rem;
        font-weight: 800;
        color: #111827;
    }

    .metric-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #eef2ff;
        color: #4338ca;
    }

    .table-soft thead th {
        border-bottom: 1px solid var(--border-soft);
        color: #111827;
        font-weight: 700;
    }

    .table-soft tbody tr {
        border-bottom: 1px solid var(--border-soft);
    }

    .btn-ghost {
        border-radius: 999px;
        padding: .25rem .75rem;
        font-weight: 600;
        border: 1px solid var(--border-soft);
        background: #fff;
    }

    /* Chips pastel */
    .chip {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        padding: .2rem .6rem;
        font-size: .78rem;
        font-weight: 700;
    }

    .chip-amber {
        background: #fde68a;
        color: #8a6b00;
    }

    .chip-sky {
        background: #bae6fd;
        color: #065f85;
    }

    .chip-emerald {
        background: #a7f3d0;
        color: #065f46;
    }

    .chip-rose {
        background: #fecdd3;
        color: #9f1239;
    }

    .chip-indigo {
        background: #e0e7ff;
        color: #3730a3;
    }

    .chip-slate {
        background: #e5e7eb;
        color: #334155;
    }

    .text-mono {
        font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    }

    /* Encabezado sticky dentro del contenedor scroll */
    .table-responsive {
        max-height: 56vh;
    }

    .table-responsive thead th {
        position: sticky;
        top: 0;
        background: #fff;
        z-index: 1;
    }
</style>

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