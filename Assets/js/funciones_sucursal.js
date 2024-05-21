let tblSucursales;
document.addEventListener("DOMContentLoaded",function(){
  //  if(window.location.pathname ===`/control/Usuarios`){
    tblSucursales=$('#tblSucursales').DataTable( {
      ajax: {
          url: base_url+"Sucursales/listar",
          dataSrc: ''
      },
      columns: [ 
      {
        'data':'index','width': '3%','className': 'text-end',
      },    
      {
        'data':'sucursal','className': 'text-end',
      },
      {
        'data':'institucion','className': 'text-end',
      },
      {
        'data':'id_vigilante','className': 'text-end',
      },
      {
        'data':'ciudad','className': 'text-end',
      },
      {
        'data':'direccion','className': 'text-end',
      },
      {
        'data':'estado','className': 'text-end',
      },
      {
        'data':'acciones','width': '12%','className': 'text-center',
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


function frmSucursal(){
  document.getElementById("title").innerHTML="Registro de Sucursal";
  // document.getElementById("btnAccion").innerHTML="Registrar";
  document.getElementById("frmSucursal").reset();
  // document.getElementById("cont-pass").classList.remove("d-none");
  $("#nuevo_sucursal").modal("show");
  document.getElementById("id").value="";
}

function registrarSucursal (e){
  e.preventDefault();
  const sucursal = document.getElementById("sucursal"); 
  const institucion = document.getElementById("institucion"); 
  const vigilante = document.getElementById("vigilante"); 
  const ciudad = document.getElementById("ciudad"); 
  const direccion = document.getElementById("direccion"); 
  if(sucursal.value=="" || institucion.value=="" || vigilante.value=="" || ciudad.value=="" || direccion.value=="" ){
    Swal.fire({
      position: "top",
      icon: "error",
      title: "Los campos son obligatorios ",
      showConfirmButton: false,
      timer: 2000
    }); 
  }else{
      const url = base_url + "Sucursales/registrar";
      const frm=document.getElementById("frmSucursal");
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
                title: "Sucursal registrada con exito",
                showConfirmButton: false,
                timer: 2000
              });  
              frm.reset();
              $("#nuevo_sucursal").modal("hide");
              tblSucursales.ajax.reload();
            }else if(res=="modificado"){
              Swal.fire({
                position: "top",
                icon: "success",
                title: "Sucursal modificada con exito",
                showConfirmButton: false,
                timer: 2000
              });  
              $("#nuevo_sucursal").modal("hide");
              tblSucursales.ajax.reload();
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
        document.getElementById("institucion").value=res.id_institucion;
        $("#nuevo_institucion").modal("show");
      }
  }
}
function btnDesactivarSucursal(id){
  Swal.fire({
    title: "Desactivar Sucursal",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Desactivar",
    cancelButtonText :"Cancelar"
  }).then((result) => {
    if (result.isConfirmed) {   
      const url = base_url + "Sucursales/desactivar/"+id;  
      const http = new XMLHttpRequest();
      http.open("GET",url,true);
      http.send();
      http.onreadystatechange = function(){
          if(this.readyState==4 && this.status==200){ 
            const res=JSON.parse(this.responseText); 
           if(res=="ok"){
            Swal.fire({
              title: "Desactivado",
              text: "La sucursal desactivado con exito",
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
function btnActivarSucursal(id){
  Swal.fire({
    title: "Activar Sucursal",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Activar",
    cancelButtonText :"Cancelar"
  }).then((result) => {
    if (result.isConfirmed) {   
      const url = base_url + "Sucursales/activar/"+id;  
      const http = new XMLHttpRequest();
      http.open("GET",url,true);
      http.send();
      http.onreadystatechange = function(){
          if(this.readyState==4 && this.status==200){ 
            const res=JSON.parse(this.responseText); 
           if(res=="ok"){
            Swal.fire({
              title: "Activado",
              text: "La sucursal activado con exito",
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
