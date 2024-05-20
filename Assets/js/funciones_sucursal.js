let tblSucursales;
document.addEventListener("DOMContentLoaded",function(){
  //  if(window.location.pathname ===`/control/Usuarios`){
    tblInstituciones=$('#tblSucursales').DataTable( {
      ajax: {
          url: base_url+"Sucursales/listar",
          dataSrc: ''
      },
      columns: [ 
      {
        'data':'index',
      },    
      {
        'data':'Sucursal',
      },
      {
        'data':'Institución',
      },
      {
        'data':'Vigilante',
      },
      {
        'data':'Ciudad',
      },
      {
        'data':'Direccion',
      },
      {
        'data':'Acciones',
      }
      
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
      const url = base_url + "Instituciones/registrar";
      const frm=document.getElementById("frmInstitucion");
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
              tblInstituciones.ajax.reload();
            }else if(res=="modificado"){
              Swal.fire({
                position: "top",
                icon: "success",
                title: "Institución modificada con exito",
                showConfirmButton: false,
                timer: 2000
              });  
              $("#nuevo_institucion").modal("hide");
              tblInstituciones.ajax.reload();
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




function btnEditarInstitucion(id){
  document.getElementById("title").innerHTML="Actualizar Institución";
  document.getElementById("btn_form_institucion").innerHTML="Actualizar";
  const url = base_url + "Instituciones/editar/"+id;  
  const http = new XMLHttpRequest();
  http.open("GET",url,true);
  http.send();
  http.onreadystatechange = function(){
      if(this.readyState==4 && this.status==200){     
        const res = JSON.parse(this.responseText);
        document.getElementById("id").value=res.id;
        document.getElementById("institucion").value=res.institucion;
        $("#nuevo_institucion").modal("show");
      }
  }
}

function btnDesactivarInstitucion(id){
  Swal.fire({
    title: "Desactivar Usuario",
    text: "El usuario ya no tendra acceso",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Desactivar",
    cancelButtonText :"Cancelar"
  }).then((result) => {
    if (result.isConfirmed) {   
      const url = base_url + "Instituciones/desactivar/"+id;  
      const http = new XMLHttpRequest();
      http.open("GET",url,true);
      http.send();
      http.onreadystatechange = function(){
          if(this.readyState==4 && this.status==200){ 
            const res=JSON.parse(this.responseText); 
           if(res=="ok"){
            Swal.fire({
              title: "Desactivado",
              text: "El usuario desactivado con exito",
              icon: "success"
            });
            tblInstituciones.ajax.reload();
           }
           else{
            Swal.fire({
              title: "Se produjo un error",
              text: res,
              icon: "error"
            });
           }
           
          }
      }   
    }
  });
}
function btnActivarInstitucion(id){
  Swal.fire({
    title: "Activar Usuario",
    // text: "El usuario tendra acceso nuevamente",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Activar",
    cancelButtonText :"Cancelar"
  }).then((result) => {
    if (result.isConfirmed) {   
      const url = base_url + "Instituciones/activar/"+id;  
      const http = new XMLHttpRequest();
      http.open("GET",url,true);
      http.send();
      http.onreadystatechange = function(){
          if(this.readyState==4 && this.status==200){ 
            const res=JSON.parse(this.responseText); 
           if(res=="ok"){
            Swal.fire({
              title: "Activado",
              text: "El usuario activado con exito",
              icon: "success"
            });
            tblInstituciones.ajax.reload();
           }
           else{
            Swal.fire({
              title: "Se produjo un error",
              text: res,
              icon: "error"
            });
           }
           
          }
      }    
    }
  });
}   