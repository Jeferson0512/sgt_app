<?php /* prototipo_clasico.php — Prototipo clásico con Bootstrap v4.3.1 (sin dependencias locales) */ ?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>SGT Prototype — Clásico (Bootstrap 4.3.1)</title>

  <!-- Bootstrap 4.3.1 CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <!-- Font Awesome 5 (iconos) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/J6MdU6K6oY8V+9Yx1C0N1t6nZT7L7F9nN9xYp1Yx1Q8zC4VZrj4lrF8aZp2I2QfYb7z4kwO3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
    /* ===== Estilos clásicos y layout ===== */
    body { background: #f7f9fc; }

    /* Navbar fijo */
    .navbar { height: 56px; }

    /* Sidebar sticky (desktop) y offcanvas (mobile) */
    .sidebar {
      position: sticky;
      top: 56px;
      height: calc(100vh - 56px);
      overflow-y: auto;
      border-right: 1px solid #e9ecef;
      background: #fff;
    }
    .sidebar .nav-link { color: #334155; }
    .sidebar .nav-link:hover { background: #f1f5f9; }
    .sidebar .nav-link .fa-fw { width: 1.25rem; }
    .sidebar .section-title { letter-spacing: .08em; }

    /* Chevron rotatorio para colapsables */
    .chev { transition: transform .2s ease; }
    .chev.rotate { transform: rotate(90deg); }

    /* Métricas */
    .card-metric .icon {
      width: 42px; height: 42px; border-radius: .75rem;
      display: inline-flex; align-items: center; justify-content: center;
    }

    /* Offcanvas simple para móviles */
    @media (max-width: 991.98px) {
      .sidebar {
        position: fixed; z-index: 1040; left: 0; top: 56px; width: 260px;
        height: calc(100vh - 56px); transform: translateX(-100%);
        transition: transform .2s ease-in-out;
      }
      .sidebar.show { transform: translateX(0); }
      body.offcanvas-active { overflow: hidden; }
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top">
    <button class="btn btn-outline-secondary d-lg-none mr-2" id="btnSidebar" aria-label="Abrir menú">
      <i class="fas fa-bars"></i>
    </button>
    <a class="navbar-brand font-weight-bold" href="#">
      <i class="fas fa-magic text-primary mr-1"></i> SGT Prototype
    </a>

    <form class="form-inline mx-auto d-none d-md-flex w-50" role="search">
      <div class="input-group w-100">
        <div class="input-group-prepend">
          <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
        </div>
        <input class="form-control" type="search" placeholder="Buscar en el sistema..." aria-label="Buscar">
      </div>
    </form>

    <ul class="navbar-nav ml-auto align-items-center">
      <li class="nav-item mr-3">
        <a class="nav-link position-relative" href="#" title="Notificaciones">
          <i class="far fa-bell"></i>
          <span class="badge badge-danger position-absolute" style="top: 0; right: 0; transform: translate(25%,-25%);">3</span>
        </a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="badge badge-primary rounded-circle p-2 mr-2">JF</span>
          <div class="d-none d-sm-block text-left">
            <div class="small font-weight-bold">Jeferson</div>
            <div class="small text-muted">Administrador</div>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
          <a class="dropdown-item" href="#"><i class="far fa-user mr-2"></i> Perfil</a>
          <a class="dropdown-item" href="#"><i class="fas fa-sliders-h mr-2"></i> Preferencias</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-danger" href="#"><i class="fas fa-sign-out-alt mr-2"></i> Cerrar sesión</a>
        </div>
      </li>
    </ul>
  </nav>

  <div class="container-fluid" style="padding-top: 70px;">
    <div class="row">
      <!-- Sidebar -->
      <aside class="col-lg-3 col-xl-2 sidebar" id="sidebar" aria-label="Barra lateral de navegación">
        <div class="px-3 pt-3 pb-2 text-uppercase text-muted small section-title">Navegación</div>
        <nav id="navAccordion" class="nav flex-column">
          <!-- Dashboard -->
          <a class="nav-link d-flex align-items-center" data-toggle="collapse" href="#menuDashboard" role="button" aria-expanded="true" aria-controls="menuDashboard">
            <i class="fas fa-home fa-fw mr-2"></i> Dashboard
            <i class="fas fa-chevron-right ml-auto small chev"></i>
          </a>
          <div class="collapse show" id="menuDashboard" data-parent="#navAccordion">
            <a class="nav-link pl-5" href="#">Resumen</a>
            <a class="nav-link pl-5" href="#">Indicadores</a>
            <a class="nav-link pl-5" href="#">Eventos</a>
          </div>

          <!-- Mantenimiento -->
          <a class="nav-link d-flex align-items-center" data-toggle="collapse" href="#menuMantenimiento" role="button" aria-expanded="true" aria-controls="menuMantenimiento">
            <i class="fas fa-wrench fa-fw mr-2"></i> Mantenimiento
            <i class="fas fa-chevron-right ml-auto small chev"></i>
          </a>
          <div class="collapse show" id="menuMantenimiento" data-parent="#navAccordion">
            <a class="nav-link pl-5" href="#">Preventivo</a>
            <a class="nav-link pl-5" href="#">Correctivo</a>
            <a class="nav-link pl-5" href="#">Órdenes de Trabajo</a>
            <a class="nav-link pl-5" href="#">Planificador</a>
          </div>

          <!-- Inventario -->
          <a class="nav-link d-flex align-items-center" data-toggle="collapse" href="#menuInventario" role="button" aria-expanded="false" aria-controls="menuInventario">
            <i class="fas fa-box-open fa-fw mr-2"></i> Inventario
            <i class="fas fa-chevron-right ml-auto small chev"></i>
          </a>
          <div class="collapse" id="menuInventario" data-parent="#navAccordion">
            <a class="nav-link pl-5" href="#">Equipos</a>
            <a class="nav-link pl-5" href="#">Repuestos</a>
            <a class="nav-link pl-5" href="#">Proveedores</a>
          </div>

          <!-- Personal -->
          <a class="nav-link d-flex align-items-center" data-toggle="collapse" href="#menuPersonal" role="button" aria-expanded="false" aria-controls="menuPersonal">
            <i class="fas fa-user-friends fa-fw mr-2"></i> Personal
            <i class="fas fa-chevron-right ml-auto small chev"></i>
          </a>
          <div class="collapse" id="menuPersonal" data-parent="#navAccordion">
            <a class="nav-link pl-5" href="#">Usuarios</a>
            <a class="nav-link pl-5" href="#">Roles</a>
            <a class="nav-link pl-5" href="#">Turnos</a>
          </div>

          <!-- Reportes -->
          <a class="nav-link d-flex align-items-center" data-toggle="collapse" href="#menuReportes" role="button" aria-expanded="false" aria-controls="menuReportes">
            <i class="fas fa-chart-bar fa-fw mr-2"></i> Reportes
            <i class="fas fa-chevron-right ml-auto small chev"></i>
          </a>
          <div class="collapse" id="menuReportes" data-parent="#navAccordion">
            <a class="nav-link pl-5" href="#">Mantenimientos</a>
            <a class="nav-link pl-5" href="#">Consumos</a>
            <a class="nav-link pl-5" href="#">Actividad</a>
          </div>

          <!-- Configuración -->
          <a class="nav-link d-flex align-items-center" data-toggle="collapse" href="#menuConfig" role="button" aria-expanded="false" aria-controls="menuConfig">
            <i class="fas fa-cog fa-fw mr-2"></i> Configuración
            <i class="fas fa-chevron-right ml-auto small chev"></i>
          </a>
          <div class="collapse" id="menuConfig" data-parent="#navAccordion">
            <a class="nav-link pl-5" href="#">Perfil</a>
            <a class="nav-link pl-5" href="#">Preferencias</a>
            <a class="nav-link pl-5" href="#">Seguridad</a>
          </div>
        </nav>

        <div class="px-3 pt-4 pb-3 text-uppercase text-muted small section-title">Sistema</div>
        <div class="px-3 pb-4">
          <div class="d-flex align-items-center text-muted small">
            <i class="far fa-hdd fa-fw mr-2"></i> v1.0 • Bootstrap 4.3.1
          </div>
        </div>
      </aside>

      <!-- Contenido -->
      <main class="col-lg-9 col-xl-10">
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
      </main>
    </div>
  </div>

  <!-- jQuery, Popper.js, Bootstrap JS (4.3.1) -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  <script>
    // Offcanvas simple para el sidebar en móviles
    (function() {
      var btn = document.getElementById('btnSidebar');
      var sidebar = document.getElementById('sidebar');
      if (btn && sidebar) {
        btn.addEventListener('click', function() {
          sidebar.classList.toggle('show');
          document.body.classList.toggle('offcanvas-active');
        });
      }

      // Rotar chevrons al abrir/cerrar menús
      $('#navAccordion .collapse').on('show.bs.collapse', function(){
        $(this).prev('.nav-link').find('.chev').addClass('rotate');
      }).on('hide.bs.collapse', function(){
        $(this).prev('.nav-link').find('.chev').removeClass('rotate');
      });
    })();
  </script>
</body>
</html>
