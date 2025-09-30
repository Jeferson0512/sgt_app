<?php /* prototipo_clasico.php — Prototipo clásico con Bootstrap v4.3.1 (sin dependencias locales) */
ob_start();
require_once __DIR__ . '/config/config.php';

// BLOQUEO: si no hay usuario en sesión
if (empty($_SESSION['user'])) {
  if (($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'fetch') {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
      'ok' => false,
      'msg' => 'No autenticado',
      'data' => ['redirect' => BASE_URL . 'login.php']
    ]);
    exit;
  }
  header('Location: ' . BASE_URL . 'login.php');
  exit;
}

require_once __DIR__ . '/app/core/Router.php';


if (($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'fetch') {
  ob_start();
  $url = $_GET['url'] ?? '';
  Router::dispatch($url);
  $fragment = ob_get_clean();
  header('Content-Type: text/html; charset=utf-8');
  echo $fragment;
  exit;
}
?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- <title>SGT Prototype — Clásico (Bootstrap 4.3.1)</title> -->
  <title>SGT APP</title>

  <!-- Bootstrap 4.3.1 CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <!-- Font Awesome 5 (iconos) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/global.css">

  <script>
    window.BASE_URL = '<?= BASE_URL ?>';
  </script>
  <!-- jQuery, Popper.js, Bootstrap JS (4.3.1) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="<?= BASE_URL ?>assets/js/global.js"></script>
  <script src="<?= BASE_URL ?>assets/js/templates.js"></script>

</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom fixed-top">
    <button class="btn btn-outline-secondary d-lg-none mr-2" id="btnSidebar" aria-label="Abrir menú">
      <i class="fas fa-bars"></i>
    </button>
    <a class="navbar-brand font-weight-bold" href="<?= BASE_URL ?>dashboard" data-spa>
      <i class="fas fa-magic text-primary mr-1"></i> SGT App
    </a>

    <!-- <form class="form-inline mx-auto d-none d-md-flex w-50" role="search">
      <div class="input-group w-100">
        <div class="input-group-prepend">
          <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
        </div>
        <input class="form-control" type="search" placeholder="Buscar en el sistema..." aria-label="Buscar">
      </div>
    </form> -->

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
          <!-- <a class="dropdown-item" href="#"><i class="fas fa-sliders-h mr-2"></i> Preferencias</a> -->
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-danger" href="<?= BASE_URL ?>app/actions/logout.php"><i class="fas fa-sign-out-alt mr-2"></i> Cerrar sesión</a>
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
          <a class="nav-link d-flex align-items-center" href="<?= BASE_URL ?>dashboard" data-spa>
            <i class="fas fa-home fa-fw mr-2"></i> Dashboard
            <!-- <i class="fas fa-chevron-right ml-auto small chev"></i> -->
          </a>
          <!-- <div class="collapse show" id="menuDashboard" data-parent="#navAccordion">
            <a class="nav-link pl-5" href="#">Resumen</a>
            <a class="nav-link pl-5" href="#">Indicadores</a>
            <a class="nav-link pl-5" href="#">Eventos</a>
          </div> -->

          <!-- Mantenimiento -->
          <a class="nav-link d-flex align-items-center" data-toggle="collapse" href="#menuMantenimiento" role="button" aria-expanded="false" aria-controls="menuMantenimiento">
            <i class="fas fa-wrench fa-fw mr-2"></i> Mantenimiento
            <i class="fas fa-chevron-right ml-auto small chev"></i>
          </a>
          <div class="collapse" id="menuMantenimiento" data-parent="#navAccordion">
            <a class="nav-link pl-5" href="<?= BASE_URL ?>correctivos">Correctivo</a>
            <a class="nav-link pl-5" href="#">Preventivo</a>
            <a class="nav-link pl-5" href="#">Órdenes de Trabajo</a>
            <a class="nav-link pl-5" href="#">Planificador</a>
          </div>

          <!-- Inventario -->
          <!-- <a class="nav-link d-flex align-items-center" data-toggle="collapse" href="#menuInventario" role="button" aria-expanded="false" aria-controls="menuInventario">
            <i class="fas fa-box-open fa-fw mr-2"></i> Inventario
            <i class="fas fa-chevron-right ml-auto small chev"></i>
          </a>
          <div class="collapse" id="menuInventario" data-parent="#navAccordion">
            <a class="nav-link pl-5" href="#">Equipos</a>
            <a class="nav-link pl-5" href="#">Repuestos</a>
            <a class="nav-link pl-5" href="#">Proveedores</a>
          </div> -->

          <!-- Maestros -->
          <a class="nav-link d-flex align-items-center" data-toggle="collapse" href="#menuMaestros" role="button" aria-expanded="false" aria-controls="menuMaestros">
            <i class="fas fa-user-friends fa-fw mr-2"></i> Maestros
            <i class="fas fa-chevron-right ml-auto small chev"></i>
          </a>
          <div class="collapse" id="menuMaestros" data-parent="#navAccordion">
            <a class="nav-link pl-5" href="<?= BASE_URL ?>areas" data-spa>Area</a>
            <a class="nav-link pl-5" href="<?= BASE_URL ?>cargos" data-spa>Cargo</a>
            <a class="nav-link pl-5" href="#" data-spa>Personal</a>
            <a class="nav-link pl-5" href="#" data-spa>Sentido</a>
            <a class="nav-link pl-5" href="#" data-spa>Sistemas</a>
            <a class="nav-link pl-5" href="#" data-spa>Tipo de Vehiculo</a>
            <a class="nav-link pl-5" href="#" data-spa>Turno</a>
            <a class="nav-link pl-5" href="#" data-spa>Ubicacion</a>
            <a class="nav-link pl-5" href="#" data-spa>Zona</a>
          </div>

          <!-- Personal -->
          <!-- <a class="nav-link d-flex align-items-center" data-toggle="collapse" href="#menuPersonal" role="button" aria-expanded="false" aria-controls="menuPersonal">
            <i class="fas fa-user-friends fa-fw mr-2"></i> Personal
            <i class="fas fa-chevron-right ml-auto small chev"></i>
          </a>
          <div class="collapse" id="menuPersonal" data-parent="#navAccordion">
            <a class="nav-link pl-5" href="#">Usuarios</a>
            <a class="nav-link pl-5" href="#">Roles</a>
            <a class="nav-link pl-5" href="#">Turnos</a>
          </div> -->

          <!-- Reportes -->
          <!-- <a class="nav-link d-flex align-items-center" data-toggle="collapse" href="#menuReportes" role="button" aria-expanded="false" aria-controls="menuReportes">
            <i class="fas fa-chart-bar fa-fw mr-2"></i> Reportes
            <i class="fas fa-chevron-right ml-auto small chev"></i>
          </a>
          <div class="collapse" id="menuReportes" data-parent="#navAccordion">
            <a class="nav-link pl-5" href="#">Mantenimientos</a>
            <a class="nav-link pl-5" href="#">Consumos</a>
            <a class="nav-link pl-5" href="#">Actividad</a>
          </div> -->

          <!-- Configuración -->
          <!-- <a class="nav-link d-flex align-items-center" data-toggle="collapse" href="#menuConfig" role="button" aria-expanded="false" aria-controls="menuConfig">
            <i class="fas fa-cog fa-fw mr-2"></i> Configuración
            <i class="fas fa-chevron-right ml-auto small chev"></i>
          </a>
          <div class="collapse" id="menuConfig" data-parent="#navAccordion">
            <a class="nav-link pl-5" href="#">Perfil</a>
            <a class="nav-link pl-5" href="#">Preferencias</a>
            <a class="nav-link pl-5" href="#">Seguridad</a>
          </div>
        </nav> -->

          <div class="px-3 pt-4 pb-3 text-uppercase text-muted small section-title">Sistema</div>
          <div class="px-3 pb-4">
            <div class="d-flex align-items-center text-muted small">
              <i class="far fa-hdd fa-fw mr-2"></i> v1.0 • Bootstrap 4.3.1
            </div>
          </div>
      </aside>

      <!-- Contenido -->
      <main class="col-lg-9 col-xl-10">
        <div id="spa-content">
          <?php
          // SSR inicial del módulo solicitado
          $url = $_GET['url'] ?? '';
          Router::dispatch($url);
          ?>
        </div>
      </main>
    </div>
  </div>
  <div id="spa-loader" hidden>Cargando…</div>


  <script src="<?= BASE_URL ?>assets/js/spa.js"></script>

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
      $('#navAccordion .collapse').on('show.bs.collapse', function() {
        $(this).prev('.nav-link').find('.chev').addClass('rotate');
      }).on('hide.bs.collapse', function() {
        $(this).prev('.nav-link').find('.chev').removeClass('rotate');
      });
    })();
  </script>
</body>

</html>
<?php
ob_end_flush();
?>