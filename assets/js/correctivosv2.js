(function () {
  if (window.__areasBooted) return;
  window.__areasBooted = true;

  // const q = (sel, ctx = document) => ctx.querySelector(sel);
  // const qq = (sel, ctx = document) => Array.from(ctx.querySelectorAll(sel));

  // function openModal(id){ const m=q(id); m?.setAttribute('aria-hidden','false'); }
  // function closeModal(id){ const m=q(id); m?.setAttribute('aria-hidden','true'); }
  function toast(msg) {
    alert(msg);
  }
  // Opcional: si usas Bootstrap 5, usa `badge bg-*`; si usas BS4, `badge badge-*`
  function badgeEstado(estado) {
    const e = String(estado || "").toUpperCase();
    const map = {
      AVERIADO: "warning",
      INOPERATIVO: "danger",
      OPERATIVO: "success",
    };
    const klass = map[e] || "secondary";
    const label = e.charAt(0) + e.slice(1).toLowerCase();
    return `<span class="badge badge-${klass}">${label}</span>`;
  }
  async function guardarArea() {
    const frm = $("#crudAreaForm");
    if (!frm) return;
    const fd = new FormData(frm);
    const id = fd.get("codigo");
    // console.log(id)
    // return;
    const url = id ? "areas/update" : "areas/store";
    const res = await window.api(url, { method: "POST", body: fd });

    const msgEl = $("#msgArea");
    if (msgEl) msgEl.textContent = res.msg || "";
    if (res?.data?.redirect) {
      location.href = res.data.redirect;
      return;
    }
    if (res.ok) {
      $("#crudAreaModal").modal("hide");
      await cargarCorrectivos();
      toast(res.msg);
    } else {
      toast(res.msg || "Error");
    }
  }

  async function eliminarArea(codigo) {
    if (!confirm("¿Eliminar esta área?")) return;
    const fd = new FormData();
    fd.append("codigo", codigo);
    // console.log("CODIGO: ", codigo);
    const r = await window.api("areas/AreaDelete", {
      method: "POST",
      body: fd,
    });
    if (r?.data?.redirect) {
      location.href = r.data.redirect;
      return;
    }
    if (r.ok) {
      await cargarCorrectivos();
    }
    toast(r.msg || (r.ok ? "Eliminado" : "No se pudo eliminar"));
  }
  function openCreate() {
    $("#crudTitle").text("Registrar Area");
    $("#btnSubmit").text("Registrar");
    $("#codigoArea").val("");
    //   $('#codigo').val(nextCodigo());
    $("#nombre").val("");
    $("#abreviatura").val("");
    // $('#estado').val('pendiente');
    // $('#prioridad').val('media');
    // $('#fecha').val(new Date().toISOString().slice(0,10));
    $("#crudAreaModal").modal("show");
  }
  function generarBadge(estado) {
    let color;
    // console.log("ESTADO", estado);
    switch (estado) {
      case "AVERIADO":
        color = "warning"; // amarillo
        break;
      case "INOPERATIVO":
        color = "danger"; // rojo
        break;
      default:
        color = "success"; // verde
    }

    // Capitaliza la primera letra
    const estadoCap =
      estado.charAt(0).toUpperCase() + estado.slice(1).toLowerCase();

    return `<a style="color: white" class="badge badge-${color}">${estadoCap}</a>`;
    // return "<a class='badge badge-color'>" + ucfirst(strtolower(estado)) + "</a>";
  }

  $("#btnRegistro").on("click", openCreate);
  $("#crudAreaForm").on("submit", function (e) {
    e.preventDefault();
    guardarArea();
  });
  // $('#tblCorrectivos tbody').on('click', '.btn-edit', function(){ openEdit(parseInt(this.getAttribute('data-id'),10)); });
  // $('#tblCorrectivos tbody').on('click', '.btn-edit', function(){ editarArea(this.getAttribute('data-edit')); });
  $("#tblCorrectivos tbody").on("click", ".btn-delete", function () {
    eliminarArea(this.getAttribute("data-del"));
  });

  // document.addEventListener("input", (e) => {
  //   if (e.target && e.target.id === "q") {
  //     cargarCorrectivos().catch((err) => {
  //       console.error(err);
  //       toast("Error al cargar");
  //     });
  //   }
  // });

  // cargarCorrectivos().catch((err) => {
  //   console.error(err);
  // });

  // document.addEventListener("spa:mount", () => {
  //   // Si la tabla de Áreas está en la vista actual, repíntala
  //   if (document.querySelector("#tblCorrectivos")) {
  //     // Reusar la función existente
  //     getListCorrectivo().catch((err) => console.error(err));
  //   }
  // });


  $('#searchInput').on('input', function () { cargarCorrectivos(); });
})();

$(document).ready(function () {
  // console.log("EMPEZO EL DOOM");
  //Inicialización
  getListCorrectivo();

});

async function getListCorrectivo() {
  console.log("Entro a LISTA")
  const tbody = document.querySelector('#tblCorrectivos tbody');
  // const errorDiv = document.getElementById('error');
  try {
    const response = await fetch(`${BASE_URL}correctivos/list`, {
      headers: { Accept: "application/json", "X-Requested-With": "fetch" },
    });

    const result = await response.json();
    tbody.innerHTML = '';
    // console.log("GASD", result);
    if (!result.ok || result.data.length === 0) {
      tbody.appendChild(showTablaVacia());
      return;
    }
    // console.log("HOLA", result.data)
    result.data.forEach(item => {
      const tr = document.createElement('tr');
      const codigo = item.CodigoCorrectivo ?? "";
      // const tr = filaCorrectivoHTML(item);
      tr.innerHTML = `
                <td>${codigo}</td>
                <td>${item.Fecha ?? ""}</td>
                <td>${item.Turno ?? ""}</td>
                <td>${item.Sentido ?? ""}</td>
                <td>${item.Sistema ?? ""}</td>
                <td>${item.TipoEquipo ?? ""}</td>
                <td>${item.Equipo ?? ""}</td>
                <td>${badgeEstado(item.NombreEstado ?? "", item.Clase)}</td>
                <td>${item.Personal ?? ""}</td>
                <td class="text-nowrap">
                  <a class="btn btn-outline-secondary" href="${BASE_URL}correctivos/edit?codigo=${codigo}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="black" stroke-width="2" viewBox="0 0 24 24">
                      <path d="M12 20h9"/>
                      <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                    </svg>
                  </a>
                  <button class="btn btn-outline-danger btn-delete" data-del="${codigo}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="red" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                      <polyline points="3 6 5 6 21 6" />
                      <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
                      <path d="M10 11v6" />
                      <path d="M14 11v6" />
                      <path d="M5 6l1-3h12l1 3" />
                    </svg>
                  </button>
                </td>
            `;

      tbody.appendChild(tr);
    });

  } catch (err) {
    tbody.appendChild(showTablaVacia(err.message));
    tbody.innerHTML = '';
    console.log("ERROR: ", err.message)
  }
}

// Dibuja una fila HTML a partir de un registro de correctivo
function filaCorrectivoHTML(r) {
  const codigo = r.CodigoCorrectivo ?? "";
  return `
    <tr>
      <td>${codigo}</td>
      <td>${r.Clase ?? ""}</td>
      <td>${r.Turno ?? ""}</td>
      <td>${r.Sentido ?? ""}</td>
      <td>${r.Sistema ?? ""}</td>
      <td>${r.TipoEquipo ?? ""}</td>
      <td>${r.Equipo ?? ""}</td>
      <td>${badgeEstado(r.EstadoEquipo ?? "", r.Clase)}</td>
      <td>${r.Personal ?? ""}</td>
      <td class="text-nowrap">
        <a class="btn btn-outline-secondary" href="${BASE_URL}correctivos/edit?codigo=${codigo}">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="black" stroke-width="2" viewBox="0 0 24 24">
            <path d="M12 20h9"/>
            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
          </svg>
        </a>
        <button class="btn btn-outline-danger btn-delete" data-del="${codigo}">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="red" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
            <polyline points="3 6 5 6 21 6" />
            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
            <path d="M10 11v6" />
            <path d="M14 11v6" />
            <path d="M5 6l1-3h12l1 3" />
          </svg>
        </button>
      </td>
    </tr>
  `;
}

function badgeEstado(estado, clase) {
  const e = String(estado || "").toUpperCase();
  const map = {
    AVERIADO: "warning",
    INOPERATIVO: "danger",
    OPERATIVO: "success",
  };
  const klass = map[e] || "secondary";
  // const label = e.charAt(0) + e.slice(1).toLowerCase();
  const label = e.charAt(0) + e.slice(1);
  return `<span class="badge estado-${clase}">${label}</span>`;
}