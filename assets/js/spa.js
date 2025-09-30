// assets/js/spa.js — navegación sin recarga con History API
(function () {
    const BASE_URL  = (window.BASE_URL || location.origin + '/').replace(/\/+$/, '/') + '';
    const BASE_PATH = new URL(BASE_URL).pathname; // p.ej. /proyecto_php_spa/
    const $  = (s, c=document)=>c.querySelector(s);
  
    const contentEl = $('#spa-content');
    const loaderEl  = $('#spa-loader');
  
    const loadedScripts = new Set(
      Array.from(document.scripts).map(s => s.src).filter(Boolean)
    );
  
    function showLoader(show=true){ if(loaderEl) loaderEl.hidden = !show; }
  
    function isInternalHref(href){
      try {
        const u = new URL(href, location.href);
        // Solo enlaces internos bajo BASE_PATH
        return u.origin === location.origin && u.pathname.startsWith(BASE_PATH);
      } catch { return false; }
    }
  
    function pathFromHref(href){
      const u = new URL(href, location.href);
      // Ruta relativa respecto a BASE_PATH (lo que consume index.php?url=...)
      return u.pathname.slice(BASE_PATH.length) + (u.search || '');
    }
  
    function setActiveNav(href){
      const p = new URL(href, location.href).pathname;
      document.querySelectorAll('.sidebar nav a, .topnav a').forEach(a=>{
        const ap = new URL(a.href, location.href).pathname;
        a.classList.toggle('active', ap === p);
      });
    }
  
    async function fetchFragment(path){
      const res  = await fetch(BASE_URL + path, {
        headers: { 'X-Requested-With': 'fetch' },
        credentials: 'same-origin'
      });
      // Si nos devolvieron JSON puede ser redirección a login o error
      const ct   = res.headers.get('content-type') || '';
      const text = await res.text();
      if (ct.includes('application/json')) {
        try {
          const data = JSON.parse(text);
          if (data?.data?.redirect) { location.href = data.data.redirect; return null; }
          return `<div class="card"><h3>${data.ok?'OK':'Error'}</h3><pre>${(data.msg||'').replace(/</g,'&lt;')}</pre></div>`;
        } catch {
          return `<div class="card"><h3>Error</h3><pre>Respuesta JSON inválida</pre></div>`;
        }
      }
      return text;
    }
  
    function hydrate(html){
      if(!contentEl) return;
      // Crear contenedor temporal para analizar scripts del fragmento
      const tmp = document.createElement('div');
      tmp.innerHTML = html;
  
      // 1) Insertar markup
      contentEl.innerHTML = html;
  
      // 2) Ejecutar scripts del fragmento
      const scripts = tmp.querySelectorAll('script');
      scripts.forEach(s=>{
        const src = s.getAttribute('src');
  
        if (src) {
          // Cargar SOLO si no está cargado aún
          const abs = new URL(src, location.href).href;
          if (loadedScripts.has(abs)) return;
          const sc = document.createElement('script');
          // Copiar atributos básicos
          Array.from(s.attributes).forEach(a=> sc.setAttribute(a.name, a.value));
          sc.onload = () => { /* opcional: console.log('loaded', abs); */ };
          document.body.appendChild(sc);
          loadedScripts.add(abs);
        } else {
          // Re-ejecutar inline
          const sc = document.createElement('script');
          sc.textContent = s.textContent;
          document.body.appendChild(sc);
          sc.remove();
        }
      });
  
      // 3) Avisar a los módulos para que repinten datos si es necesario
      document.dispatchEvent(new CustomEvent('spa:mount', {
        detail: { path: location.href.slice(BASE_URL.length) }
      }));
  
      // 4) Scroll top
      window.scrollTo({ top: 0, behavior: 'instant' });
    }
  
    async function navigateTo(path, push=true){
      try {
        showLoader(true);
        const html = await fetchFragment(path);
        if (html == null) return; // ya nos redirigieron (login)
        hydrate(html);
        if (push) history.pushState({ path }, '', BASE_URL + path);
        setActiveNav(location.href);
      } catch (e) {
        console.error(e);
      } finally {
        showLoader(false);
      }
    }
  
    // Interceptar clicks en <a data-spa> (y NO en [data-no-spa])
    document.addEventListener('click', (e)=>{
      const a = e.target.closest('a[data-spa]');
      if (!a) return;           // solo manejamos enlaces marcados
      if (a.hasAttribute('data-no-spa')) return;
      const href = a.getAttribute('href');
      if (!href || !isInternalHref(href)) return;
      e.preventDefault();
      const path = pathFromHref(href);
      navigateTo(path, true);
    });
  
    // Soporte back/forward
    window.addEventListener('popstate', ()=>{
      const path = location.href.startsWith(BASE_URL)
        ? location.href.slice(BASE_URL.length)
        : '';
      navigateTo(path || 'dashboard', false);
    });
  
    // Estado inicial
    setActiveNav(location.href);
  })();

  
// // spa.js — navegación sin recarga, con History API
// (function () {
//   const BASE_URL = window.BASE_URL.replace(/\/+$/, '/') // asegurar slash final
//   const BASE_PATH = new URL(BASE_URL).pathname // p.ej. /proyecto_php_spa/
//   const q  = (sel, ctx=document)=>ctx.querySelector(sel)
//   const qq = (sel, ctx=document)=>Array.from(ctx.querySelectorAll(sel))

//   const contentEl = q('#spa-content')
//   const loaderEl  = q('#spa-loader')

//   function showLoader(show=true){
//     if(!loaderEl) return
//     loaderEl.hidden = !show
//   }

//   function isInternal(url){
//     try {
//       const u = new URL(url, location.href)
//       return u.origin === location.origin && u.pathname.startsWith(BASE_PATH)
//     } catch { return false }
//   }

//   function pathFromHref(href){
//     const u = new URL(href, location.href)
//     // devolver ruta relativa del app sin BASE_PATH, ej: 'areas' o 'dashboard'
//     return u.pathname.slice(BASE_PATH.length) + (u.search || '')
//   }

//   function setActiveNav(href){
//     const p = new URL(href, location.href).pathname
//     qq('.sidebar nav a, .topnav a').forEach(a=>{
//       const ap = new URL(a.href, location.href).pathname
//       a.classList.toggle('active', ap === p)
//     })
//   }

//   async function fetchText(path){
//     const res = await fetch(BASE_URL + path, {
//       headers: { 'X-Requested-With': 'fetch' },
//       credentials: 'same-origin'
//     })
//     const ct = res.headers.get('content-type') || ''
//     const text = await res.text()

//     // Si vino JSON, puede ser redirección a login u error
//     if (ct.includes('application/json')) {
//       try {
//         const data = JSON.parse(text)
//         if (data?.data?.redirect) { location.href = data.data.redirect; return null }
//         // Devolver mensaje como HTML simple
//         return `<div class="card"><h3>${data.ok?'OK':'Error'}</h3><pre>${data.msg||''}</pre></div>`
//       } catch {
//         return `<div class="card"><h3>Error</h3><pre>Respuesta JSON inválida</pre></div>`
//       }
//     }
//     return text
//   }
//   /** ANTIGUO */
//   // function hydrate(html){
//   //   // Pegar HTML y re-ejecutar scripts del fragmento
//   //   contentEl.innerHTML = html

//   //   const tmp = document.createElement('div')
//   //   tmp.innerHTML = html
//   //   const scripts = tmp.querySelectorAll('script')

//   //   scripts.forEach(s=>{
//   //     const sc = document.createElement('script')
//   //     for (const {name, value} of Array.from(s.attributes)) sc.setAttribute(name, value)
//   //     if (!s.src) sc.textContent = s.textContent
//   //     document.body.appendChild(sc)
//   //     if (!s.src) sc.remove()
//   //   })

//   //   window.scrollTo({ top: 0, behavior: 'instant' })
//   // }
//   // dentro de spa.js, antes de hydrate:
// const loadedScripts = new Set(
//   Array.from(document.scripts)
//        .map(s => s.src)
//        .filter(Boolean)
// );

// function hydrate(html){
//   contentEl.innerHTML = html;

//   const tmp = document.createElement('div');
//   tmp.innerHTML = html;
//   const scripts = tmp.querySelectorAll('script');

//   scripts.forEach(s=>{
//     const src = s.getAttribute('src');

//     if (src) {
//       // ya cargado → no duplicar
//       if (loadedScripts.has(src)) return;
//       const sc = document.createElement('script');
//       sc.src = src;
//       // copiar otros attrs (type, etc) si quieres
//       document.body.appendChild(sc);
//       loadedScripts.add(src);
//     } else {
//       // inline: re-ejecutar
//       const sc = document.createElement('script');
//       sc.textContent = s.textContent;
//       document.body.appendChild(sc);
//       sc.remove();
//     }
//   });

//   window.scrollTo({ top: 0, behavior: 'instant' });
// }

//   async function navigateTo(path, push=true){
//     try{
//       showLoader(true)
//       const html = await fetchText(path)
//       if (html == null) return // ya se redireccionó
//       hydrate(html)
//       if (push) history.pushState({ path }, '', BASE_URL + path)
//       setActiveNav(BASE_URL + path)
//     }catch(err){
//       console.error(err)
//       alert('Error al cargar la vista')
//     }finally{
//       showLoader(false)
//     }
//   }

//   document.addEventListener('click', (e)=>{
//     const a = e.target.closest('a')
//     if (!a) return
//     if (a.hasAttribute('data-no-spa')) return
//     if (a.target === '_blank') return
//     if (e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return
//     const href = a.getAttribute('href')
//     if (!href || !isInternal(href)) return
//     e.preventDefault()
//     const path = pathFromHref(href)
//     navigateTo(path, true)
//   })

//   window.addEventListener('popstate', (e)=>{
//     const path = location.href.startsWith(BASE_URL) ? location.href.slice(BASE_URL.length) : ''
//     navigateTo(path, false)
//   })

//   // Activar estado inicial
//   setActiveNav(location.href)
// })();
