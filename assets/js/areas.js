(function(){
    if (window.__areasBooted) return;
    window.__areasBooted = true;
  
    const q  = (sel, ctx=document)=>ctx.querySelector(sel);
    const qq = (sel, ctx=document)=>Array.from(ctx.querySelectorAll(sel));
  
    // function openModal(id){ const m=q(id); m?.setAttribute('aria-hidden','false'); }
    // function closeModal(id){ const m=q(id); m?.setAttribute('aria-hidden','true'); }
    function toast(msg){ alert(msg); }
  
    async function cargarAreas(){
      const data = await window.api('areas/list');
      if (data?.data?.redirect) { location.href = data.data.redirect; return; }
      if(!data.ok) return toast(data.msg || 'Error al listar');
  
      const qtxt  = (q('#q')?.value || '').trim().toLowerCase();
      const tbody = q('#tblAreas tbody');
      if (!tbody) return;
      tbody.innerHTML = '';
      (data.data || [])
        .filter(r => r.nombre.toLowerCase().includes(qtxt))
        .forEach(r=>{
          const tr = document.createElement('tr');
          tr.innerHTML = `
            <td>${r.codigo}</td>
            <td>${r.nombre}</td>
            <td>${r.abreviatura}</td>
            <td>${r.estado==1?'<span class="badge badge-success">Activo</span>':'<span class="badge badge-danger">Inactivo</span>'}</td>
            <td>${r.fregistro}</td>
            <td>
              <button class="btn btn-outline-secondary btn-edit" data-edit="${r.codigo}">Editar</button>
              <button class="btn btn-outline-danger btn-delete" data-del="${r.codigo}">Eliminar</button>
            </td>
          `;
          tbody.appendChild(tr);
        });
    }
  
    async function guardarArea(){
      const frm = q('#crudAreaForm');
      if (!frm) return;
      const fd = new FormData(frm);
      const id = fd.get('codigo');
      // console.log(id)
      // return;
      const url = id ? 'areas/update' : 'areas/store';
      const res = await window.api(url, { method:'POST', body: fd });
      
      const msgEl = q('#msgArea');
      if (msgEl) msgEl.textContent = res.msg || '';
      if(res?.data?.redirect){ location.href = res.data.redirect; return; }
      if(res.ok){
        $('#crudAreaModal').modal('hide');
        await cargarAreas();
        toast(res.msg);
      } else {
        toast(res.msg || 'Error');
      }
    }
  
    async function editarArea(id){
      const r = await window.api('areas/show?id='+id);
      if(r?.data?.redirect){ location.href = r.data.redirect; return; }
      if(!r.ok || !r.data){ return toast(r.msg || 'No se pudo obtener'); }
      q('#area_id').value     = r.data.id;
      q('#area_nombre').value = r.data.nombre;
      q('#area_estado').value = r.data.estado;
      const t = q('#modalTitle'); if (t) t.textContent = 'Editar área';
      const m = q('#msgArea'); if (m) m.textContent = '';
      $('#crudAreaModal').modal('show');
    }
    async function eliminarArea(codigo){
      if(!confirm('¿Eliminar esta área?')) return;
      const fd = new FormData();
      fd.append('codigo', codigo);
      console.log("CODIGO: ", codigo)
      const r = await window.api('areas/AreaDelete', { method:'POST', body: fd });
      if(r?.data?.redirect){ location.href = r.data.redirect; return; }
      if(r.ok){ await cargarAreas(); }
      toast(r.msg || (r.ok?'Eliminado':'No se pudo eliminar'));
    }
    // document.addEventListener('click', (e)=>{
    //   // if(e.target.matches('#btnRegistro')){
    //   //   // const frm = q('#frmArea'); if (frm) frm.reset();
    //   //   // const idEl = q('#area_id'); if (idEl) idEl.value = '';
    //   //   // const est  = q('#area_estado'); if (est) est.value = '1';
    //   //   // const t = q('#modalTitle'); if (t) t.textContent = 'Nueva área';
    //   //   // const m = q('#msgArea'); if (m) m.textContent = '';
    //   //   openModal('#crudAreaModal');
    //   // }
    //   if(e.target.matches('#btnGuardar')){
    //     e.preventDefault();
    //     guardarArea().catch(err=>{ console.error(err); toast('Error de red'); });
    //   }
    //   const edt = e.target.closest('[data-edit]');
    //   if(edt){
    //     const id = edt.getAttribute('data-edit');
    //     editarArea(id).catch(err=>{ console.error(err); toast('Error de red'); });
    //   }
    //   const del = e.target.closest('[data-del]');
    //   if(del){
    //     const id = del.getAttribute('data-del');
    //     eliminarArea(id).catch(err=>{ console.error(err); toast('Error de red'); });
    //   }
    //   if(e.target.hasAttribute('data-close') || e.target.classList.contains('modal-backdrop')){
    //     closeModal('#crudAreaModal');
    //   }
    // });
    
    // ====== CRUD
    function openCreate(){
      $('#crudTitle').text('Registrar Area');
      $('#btnSubmit').text('Registrar');
      $('#codigoArea').val('');
    //   $('#codigo').val(nextCodigo());
      $('#nombre').val('');
      $('#abreviatura').val('');
      // $('#estado').val('pendiente');
      // $('#prioridad').val('media');
      // $('#fecha').val(new Date().toISOString().slice(0,10));
      $('#crudAreaModal').modal('show');
    }
    function openEdit(id){
      // var r = rows.find(function(x){return x.id==id}); if(!r) return;
      $('#crudTitle').text('Actualizar Area');
      $('#btnSubmit').text('Actualizar');
      $('#codigoArea').val();
      $('#nombre').val();
      $('#abreviatura').val();
      // $('#estado').val(r.estado);
      // $('#prioridad').val(r.prioridad);
      // $('#fecha').val(r.fecha||'');
      $('#crudAreaModal').modal('show');
    }
    
  $('#btnRegistro').on('click', openCreate);
  $('#crudAreaForm').on('submit', function(e){
    e.preventDefault();
    guardarArea();
  });
  // $('#tblAreas tbody').on('click', '.btn-edit', function(){ openEdit(parseInt(this.getAttribute('data-id'),10)); });
  $('#tblAreas tbody').on('click', '.btn-edit', function(){ editarArea(this.getAttribute('data-edit')); });
  $('#tblAreas tbody').on('click', '.btn-delete', function(){ eliminarArea(this.getAttribute('data-del')); });
  
    document.addEventListener('input', (e)=>{
      if(e.target && e.target.id === 'q'){
        cargarAreas().catch(err=>{ console.error(err); toast('Error al cargar'); });
      }
    });
  
    cargarAreas().catch(err=>{ console.error(err); });
  
    document.addEventListener('spa:mount', ()=>{
      // Si la tabla de Áreas está en la vista actual, repíntala
      if (document.querySelector('#tblAreas')) {
        // Reusar la función existente
        cargarAreas().catch(err=>console.error(err));
      }
    });
  })();
  