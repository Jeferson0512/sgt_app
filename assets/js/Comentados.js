//=============================
// EDIT.PHP
//=============================

  // function cargarDocumentos() {
  //   console.log("DOCUMENTOS");
  //   fetch('<?= BASE_URL ?>correctivos/cListarCorrectivoArchivos', {
  //       method: 'POST',
  //       headers: {
  //         'Content-Type': 'application/json',
  //         'X-Requested-With': 'fetch'
  //       },
  //       body: JSON.stringify({
  //         CodCorrectivo: <?= json_encode($codigo) ?>,
  //         Tipo: 'DOC'
  //       })
  //     })
  //     .then(res => res.json())
  //     .then(res => {
  //       if (!res.success || !res.data) {
  //         alert("No se pudieron cargar archivos");
  //         return;
  //       }

  //       const archivos = res.data;

  //       // // Mostrar el primero en tu iframe mini si existe
  //       // if (archivos.length > 0) {
  //       //   const primer = archivos[0];
  //       //   const iframe = document.getElementById('pdfViewer');
  //       //   if (iframe) iframe.src = '<?= BASE_URL ?>uploads/' + primer.nombre + '#zoom=page-width';
  //       // }

  //       // Renderizador genérico para cada contenedor
  //       function renderLista(containerId) {
  //         const cont = document.getElementById(containerId);
  //         if (!cont) return;
  //         cont.innerHTML = '';

  //         archivos.forEach(file => {
  //           const url = '<?= BASE_URL ?>uploads/' + file.nombre;
  //           const title = file.nombreGuardado || file.nombre;

  //           const row = document.createElement('div');
  //           row.className = 'list-group-item d-flex justify-content-between align-items-center doc-clickable';
  //           row.setAttribute('data-url', url);
  //           row.setAttribute('data-title', title);

  //           row.innerHTML = `
  //         <span class="text-truncate" style="max-width:70%" title="${file.nombre}">${title}</span>
  //         <div class="d-flex align-items-center">
  //           <button class="btn btn-outline-primary btn-sm mr-2" data-action="view"   data-url="${url}" data-title="${title}">Ver</button>
  //           <button class="btn btn-outline-secondary btn-sm mr-2" data-action="newtab" data-url="${url}">Nueva pestaña</button>
  //           <button class="btn btn-outline-danger btn-sm" data-action="del-doc" data-index="${file.codigo}" data-ruta="${file.nombre}">Eliminar</button>
  //         </div>
  //       `;

  //           // (1) Clic en toda la fila → modal (quita estas 2 líneas si quieres solo por botón)
  //           row.addEventListener('click', (e) => {
  //             if (e.target && e.target.dataset && e.target.dataset.action) return; // evita choque con botones
  //             openPdfModal(url, title);
  //           });

  //           cont.appendChild(row);
  //         });

  //         // Delegación para botones (una sola vez por render)
  //         cont.addEventListener('click', (e) => {
  //           const btn = e.target.closest('button[data-action]');
  //           if (!btn) return;
  //           e.stopPropagation();

  //           const action = btn.dataset.action;
  //           if (action === 'view') {
  //             openPdfModal(btn.dataset.url, btn.dataset.title);
  //           } else if (action === 'newtab') {
  //             openPdfNewTab(btn.dataset.url);
  //           } else if (action === 'del-doc') {
  //             // Tu lógica existente de eliminación (baja lógica)
  //             // Puedes tener ya definida eliminarArchivo(codigo) o similar:
  //             if (typeof eliminarArchivo === 'function') {
  //               eliminarArchivo(btn.dataset.index); // usa dataset.ruta si tu endpoint lo requiere
  //             } else {
  //               console.warn('Implementa eliminarArchivo(codigo) para esta acción');
  //             }
  //           }
  //         }, {
  //           once: true
  //         });
  //       }

  //       renderLista('listDocs');
  //       renderLista('listDocsv2');
  //       renderLista('listDocsv3');
  //     });
  // }


  // function cargarDocumentos() {
  //   console.log("DOCUMENTOS");
  //   fetch('<?= BASE_URL ?>correctivos/cListarCorrectivoArchivos', {
  //       method: 'POST',
  //       headers: {
  //         'Content-Type': 'application/json',
  //         'X-Requested-With': 'fetch'
  //       },
  //       body: JSON.stringify({
  //         CodCorrectivo: <?= json_encode($codigo) ?>,
  //         Tipo: 'DOC'
  //       })
  //     })
  //     .then(res => res.json())
  //     .then(res => {
  //       if (!res.success) {
  //         alert("No se pudieron cargar archivos");
  //         return;
  //       }
  //       if (!res.data) {
  //         alert("Paso, pero no se pudieron cargar archivos");
  //         return;
  //       }
  //       console.log(<?= json_encode($codigo) ?>);
  //       console.log(res);
  //       console.log("====== FIN =========");
  //       const archivos = res.data;



  //       // Mostrar el primero en tu iframe mini si existe
  //       if (archivos.length > 0) {
  //         const primer = archivos[0];
  //         const iframe = document.getElementById('pdfViewer');
  //         if (iframe) iframe.src = '<?= BASE_URL ?>uploads/' + primer.nombre + '#zoom=page-width';
  //       }


  //       //VER ARCHIVO
  //       if (archivos.length > 0) {
  //         const primerArchivo = archivos[0]; // o filtra según algún criterio

  //         const iframe = document.getElementById('pdfViewer');
  //         iframe.src = '<?= BASE_URL ?>uploads/' + primerArchivo.nombre;
  //       }

  //       // Documentos v1
  //       const documentos = document.getElementById('listDocs');
  //       documentos.innerHTML = '';
  //       archivos.forEach(file => {
  //         const col = document.createElement('div');
  //         col.className = 'list-group-item d-flex justify-content-between align-items-center';
  //         col.innerHTML = '<span class="text-truncate" style="max-width:70%" title="' + file.nombre + '">' + file.nombreGuardado + '</span>' +
  //           '<button class="btn btn-outline-danger btn-sm" data-action="del-doc" data-index="' + file.codigo + '" data-ruta="' + file.nombre + '" >Eliminar</button>';
  //         documentos.appendChild(col);
  //       });

  //       const documentosv2 = document.getElementById('listDocsv2');
  //       documentosv2.innerHTML = '';
  //       archivos.forEach(file => {
  //         const col = document.createElement('div');
  //         col.className = 'col-6 col-md-4 mb-3';
  //         col.innerHTML = '<span class="text-truncate" style="max-width:70%" title="' + file.nombre + '">' + file.nombre + '</span>' +
  //           '<button class="btn btn-outline-danger btn-sm" data-action="del-doc" data-index="' + file.codigo + '" data-ruta="' + file.nombre + '" >Eliminar</button>';
  //         documentosv2.appendChild(col);
  //       });

  //       const documentosv3 = document.getElementById('listDocsv3');
  //       documentosv3.innerHTML = '';
  //       archivos.forEach(file => {
  //         const col = document.createElement('div');
  //         col.className = 'col-6 col-md-4 mb-3';
  //         col.innerHTML = '<span class="text-truncate" style="max-width:70%" title="' + file.nombre + '">' + file.nombre + '</span>' +
  //           '<button class="btn btn-outline-danger btn-sm" data-action="del-doc" data-index="' + file.codigo + '" data-ruta="' + file.nombre + '" >Eliminar</button>';
  //         documentosv3.appendChild(col);
  //       });
  //     });
  // }


  // function openPdfNewTab(url) {
  //   window.open(url, '_blank', 'noopener');
  // }
  // 1) Ver (modal)