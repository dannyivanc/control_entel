let tblSupervisiones;

function mostrarAlerta(icon, title, timer = 2000,position="top") {
    Swal.fire({    
        icon: icon,
        title: title,
        position: position,
        showConfirmButton: false,
        timer: timer
    });
}


function frmMaterial(){
  document.getElementById("title").innerHTML="Registro de Materiales";
  document.getElementById("btn_form_material").innerHTML="Nuevo Registro";
  document.getElementById("frmMaterial").reset();
  $("#nuevo_supervision").modal("show");
  document.getElementById("id").value="";
}

const viewInstitucion =(id)=>{
  const url = base_url + `Supervisiones/${id}`;

}


document.addEventListener("DOMContentLoaded", function() {
  const idElement = document.getElementById('supervisionId');
  if (idElement) {
    const id = idElement.value;
    $('#tblUsuarios').DataTable({
      ajax: {
        url: `${base_url}Supervisiones/${id}`,
        dataSrc: ''
      },
      columns: [
        { 'data': 'index', 'width': '3%', 'className': 'text-end' },
        { 'data': 'usuario', 'className': 'text-end' },
        { 'data': 'nombre', 'className': 'text-end' },
        { 'data': 'carnet', 'className': 'text-end' },
        { 'data': 'institucion', 'className': 'text-end' },
        { 'data': 'cel', 'className': 'text-end' },
        { 'data': 'rol', 'className': 'text-end', 'width': '8%' },
        { 'data': 'estado', 'className': 'text-end', 'width': '5%' },
        { 'data': 'acciones', 'width': '12%', 'className': 'text-center' }
      ],
      language: {
        "decimal": "",
        "emptyTable": "No hay datos disponibles en la tabla",
        "info": "Mostrando _START_ - _END_ de _TOTAL_ registros",
        "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
        "infoFiltered": "(filtrado de _MAX_ entradas totales)",
        "lengthMenu": "Mostrar _MENU_ ",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "No se encontraron registros",
        "paginate": {
            "first": "Primero",
            "last": "Último",
            "next": "Siguiente",
            "previous": "Anterior"
        },
        "aria": {
            "sortAscending": ": activar para ordenar la columna de manera ascendente",
            "sortDescending": ": activar para ordenar la columna de manera descendente"
        }
      }
    });
  }
});
