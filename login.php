<?php require_once __DIR__ . '/config/config.php'; ?>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login – Clásico Corporativo (Bootstrap 4.3.1)</title>

  <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/global.css">
  <script>
    window.BASE_URL = '<?= BASE_URL ?>';
  </script>
  <!-- Bootstrap v4.3.1 (CDN principal) -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <!-- CDN alterno por si el anterior falla (sin SRI) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
  <!-- Fallback local opcional (coloca el archivo si lo usas en tu proyecto) -->
  <link rel="stylesheet" href="assets/libs/bootstrap-4.3.1/css/bootstrap.min.css">
</head>

<body class="bg-dark text-light">
  <div class="container min-vh-100 d-flex align-items-center py-5">
    <div class="row w-100 justify-content-center">
      <div class="col-sm-10 col-md-8 col-lg-5">
        <div class="card bg-dark text-light border-secondary shadow-sm">
          <div class="card-body">
            <div class="d-flex align-items-center mb-3">
              <div class="rounded bg-primary text-white d-inline-flex align-items-center justify-content-center mr-3" style="width:48px;height:48px;font-weight:800;">SGT</div>
              <div>
                <h5 class="mb-0">Iniciar sesión</h5>
                <small class="text-muted">Accede con tus credenciales del sistema</small>
              </div>
            </div>

            <form id="frmLogin" method="post">
              <div class="form-group">
                <label for="email">Usuario</label>
                <input type="text" class="form-control bg-dark text-light border-secondary" id="email" name="email" value="jbujaico" required>
              </div>

              <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control bg-dark text-light border-secondary" id="password" name="password" value="123456" required>
              </div>

              <div class="d-flex justify-content-between align-items-center mb-3">
                <!--
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                  <label class="custom-control-label" for="remember">Recuérdame</label>
                </div>
                -->
                <a href="#" class="small text-muted">¿Olvidaste tu contraseña?</a>
              </div>

              <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
              <p class="small text-muted mt-3 mb-0">Prototipo estático: conecta la acción del formulario a tu endpoint cuando lo integres.</p>
              <p class="msg" id="msg"></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Dependencias Bootstrap 4.3.1 (CDN principal) -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <!-- Alternos -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Fallback local opcional -->
  <script src="assets/libs/bootstrap-4.3.1/js/jquery-3.3.1.slim.min.js"></script>
  <script src="assets/libs/bootstrap-4.3.1/js/popper.min.js"></script>
  <script src="assets/libs/bootstrap-4.3.1/js/bootstrap.min.js"></script>
  <script src="<?= BASE_URL ?>assets/js/global.js"></script>


  <script>
    // // Demo: prevenir envío real para este prototipo
    // document.getElementById('loginForm').addEventListener('submit', function(e) {
    //   e.preventDefault();
    //   location.href = "http://localhost/sgt_app/index.php";
    // });

    // // Aviso si Bootstrap CSS no cargó (para explicar la vista "sin estilos")
    // (function() {
    //   var test = document.createElement('div');
    //   test.className = 'd-none'; // si Bootstrap no cargó, display será 'block'
    //   document.body.appendChild(test);
    //   var hasBs = window.getComputedStyle(test).display === 'none';
    //   document.body.removeChild(test);
    //   if (!hasBs) {
    //     console.warn('Bootstrap 4.3.1 CSS no se cargó. Verifica tu conexión o usa el archivo local en assets/libs/bootstrap-4.3.1/css/bootstrap.min.css');
    //   }
    // })();

    document.getElementById('frmLogin').addEventListener('submit', async (e) => {
      e.preventDefault();
      const fd = new FormData(e.target);
      // console.log(fd.get('email'))
      // console.log(fd.get('password'))
      try {
        const r = await api('app/actions/login_action.php', {
          method: 'POST',
          body: fd
        });
        // r debe ser JSON {ok,msg,data}
        document.getElementById('msg').textContent = r.msg || '';
        if (r.ok && r.data?.redirect) {
          location.href = r.data.redirect;
        }
      } catch (err) {
        document.getElementById('msg').textContent = 'Error de red';
        console.error(err);
      }
    });
  </script>
</body>

</html>