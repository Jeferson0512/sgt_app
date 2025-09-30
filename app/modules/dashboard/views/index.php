<?php
// Variables disponibles: $user (array con name, email)
$nombre = htmlspecialchars($user['name'] ?? 'Usuario');
// echo "<pre>";
// print_r($user);
// echo "</pre>";
?>
<div class="pt-3 pt-lg-0 px-3 px-lg-4">
    <!-- Métricas -->
    <div class="row">
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card card-metric shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">OT abiertas</div>
                        <div class="h4 mb-0 font-weight-bold">27</div>
                    </div>
                    <div class="icon bg-primary text-white"><i class="far fa-clipboard"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card card-metric shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Equipos críticos</div>
                        <div class="h4 mb-0 font-weight-bold">8</div>
                    </div>
                    <div class="icon bg-dark text-white"><i class="fas fa-shield-alt"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card card-metric shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Stock bajo</div>
                        <div class="h4 mb-0 font-weight-bold">12</div>
                    </div>
                    <div class="icon bg-info text-white"><i class="fas fa-box"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card card-metric shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Tareas hoy</div>
                        <div class="h4 mb-0 font-weight-bold">19</div>
                    </div>
                    <div class="icon bg-success text-white"><i class="fas fa-layer-group"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white font-weight-bold">Órdenes de Trabajo</div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Código</th>
                        <th>Título</th>
                        <th>Estado</th>
                        <th>Prioridad</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="font-monospace">OT-0001</td>
                        <td>Cambio de lámparas</td>
                        <td><span class="badge badge-warning">pendiente</span></td>
                        <td><span class="badge badge-primary">media</span></td>
                        <td class="text-right">
                            <button class="btn btn-sm btn-outline-secondary">Ver</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-monospace">OT-0002</td>
                        <td>Ajuste ventiladores</td>
                        <td><span class="badge badge-info">en_proceso</span></td>
                        <td><span class="badge badge-danger">alta</span></td>
                        <td class="text-right">
                            <button class="btn btn-sm btn-outline-secondary">Ver</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-monospace">OT-0003</td>
                        <td>Revisión CCTV</td>
                        <td><span class="badge badge-success">cerrado</span></td>
                        <td><span class="badge badge-secondary">baja</span></td>
                        <td class="text-right">
                            <button class="btn btn-sm btn-outline-secondary">Ver</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>