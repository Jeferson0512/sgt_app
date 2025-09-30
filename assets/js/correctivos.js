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

  // Dibuja una fila HTML a partir de un registro de correctivo
  function filaCorrectivoHTML(r) {
    const codigo = r.CodigoCorrectivo ?? "";
    return `
    <tr>
      <td>${codigo}</td>
      <td>${r.Fecha ?? ""}</td>
      <td>${r.Turno ?? ""}</td>
      <td>${r.Sentido ?? ""}</td>
      <td>${r.Sistema ?? ""}</td>
      <td>${r.TipoEquipo ?? ""}</td>
      <td>${r.Equipo ?? ""}</td>
      <td>${badgeEstado(r.EstadoEquipo ?? "")}</td>
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

  async function cargarCorrectivos() {
    // 1) Referencias claras
    const $tbody = $("#tblCorrectivos tbody"); // cuerpo de la tabla
    const $buscador = $("#searchInput"); // input de búsqueda (si no existe, no pasa nada)
    const columnas = 10; // cantidad de columnas de la tabla (para colspan)

    if (!$tbody.length) return;

    // 2) Mostrar estado "cargando"
    $tbody.html(`<tr><td colspan="${columnas}">Cargando...</td></tr>`);

    try {
      // 3) Llamada al endpoint (puedes cambiar a window.api si prefieres tu helper)
      const resp = await fetch(`${BASE_URL}correctivos/list`, {
        headers: { Accept: "application/json", "X-Requested-With": "fetch" },
      });
      const json = await resp.json();

      // 4) Manejo de redirección / error
      if (json?.data?.redirect) {
        location.href = json.data.redirect;
        return;
      }
      if (!json.ok) {
        $tbody.empty();
        toast(json.msg || "Error al listar");
        return;
      }

      // 5) Datos y filtro local por texto (si hay input #q)
      const lista = Array.isArray(json.data) ? json.data : [];
      const texto = ($buscador.val() || "").toString().trim().toLowerCase();
      console.log("texto: ", texto);

      const filtrada = texto
        ? lista.filter((r) => {
          // Ajusta aquí los campos a filtrar
          const hay = [
            r.CodigoCorrectivo,
            r.Equipo,
            r.Sistema,
            r.TipoEquipo,
            r.Personal,
          ].map((v) => (v || "").toString().toLowerCase());
          return hay.some((v) => v.includes(texto));
        })
        : lista;

      // 6) Render vacío si no hay resultados
      if (!filtrada.length) {
        $tbody.html(
          `<tr><td colspan="${columnas}">No hay registros.</td></tr>`
        );
        return;
      }

      // 7) Render de filas
      const html = filtrada.map(filaCorrectivoHTML).join("");
      $tbody.html(html);
    } catch (err) {
      // console.error(err);
      $tbody.empty();
      toast("Error al cargar");
    }
  }
  // async function cargarCorrectivos() {
  //   const data = await window.api("correctivos/list");
  //   if (data?.data?.redirect) {
  //     location.href = data.data.redirect;
  //     return;
  //   }
  //   if (!data.ok) return toast(data.msg || "Error al listar");

  //   const qtxt = (q("#q")?.value || "").trim().toLowerCase(); //VIENE DEL BUSCADOR
  //   const tbody = q("#tblCorrectivos tbody");
  //   if (!tbody) return;
  //   tbody.innerHTML = "";
  //   (data.data || [])
  //     // .filter(r => r.nombre.toLowerCase().includes(qtxt))
  //     .forEach((r) => {
  //       const tr = document.createElement("tr");
  //       tr.innerHTML = `
  //           <td>${r.CodigoCorrectivo}</td>
  //           <td>${r.Fecha}</td>
  //           <td>${r.Turno}</td>
  //           <td>${r.Sentido}</td>
  //           <td>${r.Sistema}</td>
  //           <td>${r.TipoEquipo}</td>
  //           <td>${r.Equipo}</td>
  //           <td> ${generarBadge(r.EstadoEquipo)}</td>
  //           <td>${r.Personal}</td>
  //           <td>
  //             <a class="btn btn-outline-secondary" href="${BASE_URL}correctivos/edit?codigo=${
  //         r.CodigoCorrectivo
  //       }">
  //               <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="black" stroke-width="2" viewBox="0 0 24 24">
  //                 <path d="M12 20h9"/>
  //                 <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
  //               </svg>

  //             </a>
  //             <button class="btn btn-outline-danger btn-delete" data-del="${
  //               r.CodigoCorrectivo
  //             }">
  //               <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke="red" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
  //                 <polyline points="3 6 5 6 21 6" />
  //                 <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6" />
  //                 <path d="M10 11v6" />
  //                 <path d="M14 11v6" />
  //                 <path d="M5 6l1-3h12l1 3" />
  //               </svg>
  //             </button>
  //           </td>
  //         `;
  //       tbody.appendChild(tr);
  //     });
  // }

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

  // async function editarArea(id){
  //   const r = await window.api('areas/show?id='+id);
  //   if(r?.data?.redirect){ location.href = r.data.redirect; return; }
  //   if(!r.ok || !r.data){ return toast(r.msg || 'No se pudo obtener'); }
  //   $('#area_id').value     = r.data.id;
  //   $('#area_nombre').value = r.data.nombre;
  //   $('#area_estado').value = r.data.estado;
  //   const t = $('#modalTitle'); if (t) t.textContent = 'Editar área';
  //   const m = $('#msgArea'); if (m) m.textContent = '';
  //   $('#crudAreaModal').modal('show');
  // }
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
  function openEdit(id) {
    // var r = rows.find(function(x){return x.id==id}); if(!r) return;
    $("#crudTitle").text("Actualizar Area");
    $("#btnSubmit").text("Actualizar");
    $("#codigoArea").val();
    $("#nombre").val();
    $("#abreviatura").val();
    // $('#estado').val(r.estado);
    // $('#prioridad').val(r.prioridad);
    // $('#fecha').val(r.fecha||'');
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

  cargarCorrectivos().catch((err) => {
    console.error(err);
  });

  document.addEventListener("spa:mount", () => {
    // Si la tabla de Áreas está en la vista actual, repíntala
    if (document.querySelector("#tblCorrectivos")) {
      // Reusar la función existente
      cargarCorrectivos().catch((err) => console.error(err));
    }
  });


  $('#searchInput').on('input', function () { cargarCorrectivos(); });
})();
