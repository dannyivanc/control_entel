let tblInstituciones;
document.addEventListener("DOMContentLoaded",function(){
  //  if(window.location.pathname ===`/control/Usuarios`){
    tblInstituciones=$('#tblInstituciones').DataTable( {
      ajax: {
          url: base_url+"Instituciones/listar",
          dataSrc: ''
      },
      columns: [ 
      {
        'data':'institucion',
      },
      {
        'data':'estado',
      },
      
    ],
    language: {
      "decimal": "",
      "emptyTable": "No hay datos disponibles en la tabla",
      "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
      "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
      "infoFiltered": "(filtrado de _MAX_ entradas totales)",
      "infoPostFix": "",
      "thousands": ",",
      "lengthMenu": "Mostrar entradas _MENU_ ",
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
  //  }
})


function frmInstitucion(){
  document.getElementById("title").innerHTML="Registro de Instituciones";
  // document.getElementById("btnAccion").innerHTML="Registrar";
  document.getElementById("frmInstitucion").reset();
  // document.getElementById("cont-pass").classList.remove("d-none");
  $("#nuevo_institucion").modal("show");
  document.getElementById("id").value="";
}


function registrarInstitucion (e){
  e.preventDefault();
  const institucion = document.getElementById("institucion"); 
  if(institucion.value==""){
    Swal.fire({
      position: "top",
      icon: "error",
      title: "Introduzca el nombre de la institución ",
      showConfirmButton: false,
      timer: 2000
    }); 
  }else{
      const url = base_url + "Usuarios/registrar";
      const frm=document.getElementById("frmUsuario");
      const http = new XMLHttpRequest();
      http.open("POST",url,true);
      http.send(new FormData(frm));
      http.onreadystatechange = function(){
          if(this.readyState==4 && this.status==200){ 
            const res= JSON.parse(this.responseText);
            if(res=="si"){
              Swal.fire({
                position: "top",
                icon: "success",
                title: "Institución registrada con exito",
                showConfirmButton: false,
                timer: 2000
              });  
              frm.reset();
              $("#nuevo_institucion").modal("hide");
              tblUsuarios.ajax.reload();
            }else if(res=="modificado"){
              Swal.fire({
                position: "top",
                icon: "success",
                title: "Institución modificada con exito",
                showConfirmButton: false,
                timer: 2000
              });  
              $("#nuevo_institucion").modal("hide");
              tblUsuarios.ajax.reload();
            }else{
              Swal.fire({
                position: "top",
                icon: "error",
                title: res,
                showConfirmButton: false,
                timer: 2000
              });
            }
          }
      }
     
  }
}
