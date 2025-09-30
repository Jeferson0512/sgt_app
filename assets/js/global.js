// Definir un único namespace global seguro
window.App = window.App || {};
window.Modules = window.Modules || {}; // registro de módulos

// Helpers globales: definidos solo una vez
App.helpers =
  App.helpers ||
  (() => {
    const $ = (sel, ctx = document) => ctx.querySelector(sel);
    const $$ = (sel, ctx = document) => Array.from(ctx.querySelectorAll(sel));
    const on = (el, ev, handler, opts) =>
      el.addEventListener(ev, handler, opts);
    const off = (el, ev, handler, opts) =>
      el.removeEventListener(ev, handler, opts);
    const html = (el, str) => {
      el.innerHTML = str;
      return el;
    };
    const qs = (obj = {}) =>
      Object.entries(obj)
        .map(([k, v]) => `${encodeURIComponent(k)}=${encodeURIComponent(v)}`)
        .join("&");

    // Pequeño fetch helper (JSON por defecto)
    const api = async (url, opts = {}) => {
      const res = await fetch(url, {
        headers: { "X-Requested-With": "fetch" },
        ...opts,
      });
      const ct = res.headers.get("content-type") || "";
      if (ct.includes("application/json")) return res.json();
      return res.text();
    };

    return { $, $$, on, off, html, qs, api };
  })();

(function () {
  if (!Object.prototype.hasOwnProperty.call(window, "BASE_URL")) {
    window.BASE_URL = "http://localhost/proyecto_php_spa/";
  }

  if (!Object.prototype.hasOwnProperty.call(window, "api")) {
    window.api = async function api(url, opts = {}) {
      const res = await fetch(window.BASE_URL + url, {
        headers: { "X-Requested-With": "fetch" },
        credentials: "same-origin",
        ...opts,
      });

      const ct = res.headers.get("content-type") || "";
      const text = await res.text();

      // Si dice JSON, intentamos parsear; si falla, devolvemos objeto de error
      if (ct.includes("application/json")) {
        try {
          return JSON.parse(text);
        } catch (e) {
          return {
            ok: false,
            msg: "Respuesta no es JSON válido",
            data: { body: text, status: res.status, url: res.url },
          };
        }
      }

      // Si vino HTML (p. ej., login o error), devolvemos un error uniforme
      if (
        text.trim().startsWith("<!doctype") ||
        text.trim().startsWith("<html")
      ) {
        return {
          ok: false,
          msg: "Servidor devolvió HTML (posible redirección a login o error)",
          data: { body: text, status: res.status, url: res.url },
        };
      }

      // Texto plano u otro tipo
      return {
        ok: false,
        msg: "Respuesta no JSON",
        data: { body: text, status: res.status, url: res.url },
      };
    };
  }

  if (!Object.prototype.hasOwnProperty.call(window, "__sgtBootLogged")) {
    console.log("[SGT] BASE_URL =", window.BASE_URL);
    window.__sgtBootLogged = true;
  }
})();

function detectarTipoArchivo($mimeType) {
  if (str_starts_with($mimeType, "image/")) {
    return "IMG";
    // } else if (str_starts_with($mimeType, 'video/')) {
    //     return 'VID';
    // } else if (str_starts_with($mimeType, 'audio/')) {
    //     return 'AUD';
  } else if (
    str_contains($mimeType, "pdf") ||
    str_contains($mimeType, "word")
  ) {
    return "DOC";
    // } else if (str_contains($mimeType, 'zip')) {
    //     return 'ZIP';
  } else {
    return "OTR"; // Otro
  }
}

//Uso: const resultado = validarExtensionArchivo(archivo, ['pdf', 'jpg', 'jpeg', 'png', 'docx']);
function validarExtensionArchivo(archivo, extensionesPermitidas = []) {
  if (!archivo) {
    return {
      valido: false,
      extension: null,
      mensaje: "No se seleccionó ningún archivo.",
    };
  }

  const nombre = archivo.name;
  const extension = nombre.split(".").pop().toLowerCase();

  if (!extensionesPermitidas.includes(extension)) {
    return {
      valido: false,
      extension,
      mensaje: `Extensión no permitida: .${extension}`,
    };
  }

  return {
    valido: true,
    extension,
    mensaje: `Archivo válido: ${nombre} (.${extension})`,
  };
}

// SweetAlert Toast
const Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
});
// Uso: mostrarToast(["error", "success", "warning"], "TITULO", "TEXTO")
function mostrarToast(icon, title, text) {
  Toast.fire({ icon, title, text });
}