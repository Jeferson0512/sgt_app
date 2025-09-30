function showTablaVacia(message = "No hay registros disponibles") {
  // const tr = document.createElement("tr");
  // const td = document.createElement("td");

  // td.colSpan = "100";
  // td.classList.add("text-center", "text-muted");
  // td.textContent = message;

  // tr.appendChild(td);

  const tr = document.createElement('tr');
  tr.innerHTML = `
        <td colspan="10" class="text-center">
          <div class="p-4">
            <i class="fas fa-folder-open fa-2x text-muted mb-2"></i>
            <div class="text-muted font-weight-bold">No hay registros disponibles</div>
          </div>
        </td>
      `;
  return tr;
}
function showTablaVacia(message = "No hay registros disponibles") {
  const tr = document.createElement('tr');
  tr.innerHTML = `
        <td colspan="10" class="text-center">
          <div class="p-4">
            <i class="fas fa-folder-open fa-2x text-muted mb-2"></i>
            <div class="text-muted font-weight-bold">No hay registros disponibles</div>
          </div>
        </td>
      `;
  return tr;
}