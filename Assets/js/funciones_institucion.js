let tblInstituciones;
function mostrarAlerta(icon, title, timer = 2000,position="top") {
  Swal.fire({    
      icon: icon,
      title: title,
      position: position,
      showConfirmButton: false,
      timer: timer
  });
}
document.getElementById("frmInstitucion").addEventListener("keypress", function(event) {
  if (event.key === "Enter") {
      event.preventDefault();
      registrarInstitucion(event); 
  }
});
document.addEventListener("DOMContentLoaded",function(){
  //  if(window.location.pathname ===`/control/Usuarios`){
    tblInstituciones=$('#tblInstituciones').DataTable( {
      responsive: true,
      ajax: {
          url: base_url+"Instituciones/listar",
          dataSrc: ''
      },
      columns: [ 
      {
        'data':'index','width': '2%','className': 'text-end',
      },    
      {
        'data':'institucion','className': 'text-end',
      },
      {
        'data':'estado','className': 'text-end',
      },
      {
        'data':'acciones','width': '12%','className': 'text-center',
      },
      
    ],
    columnDefs: [
      { responsivePriority: 1, targets: 0 },
      { responsivePriority: 2, targets: 1 },
      { responsivePriority: 3, targets: 3 },
      { responsivePriority: 4, targets: 2 },
  ],
    language: {
      "decimal": "",
      "emptyTable": "No hay datos disponibles en la tabla",
      "info": "Mostrando _START_ - _END_ de _TOTAL_ entradas",
      "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
      "infoFiltered": "(filtrado de _MAX_ entradas totales)",
      "infoPostFix": "",
      "thousands": ",",
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
  //  }
})

function frmInstitucion(){
  document.getElementById("title").innerHTML="Registro de Instituciones";
  document.getElementById("frmInstitucion").reset();
  $("#nuevo_institucion").modal("show");
  document.getElementById("id").value="";
}
async function registrarInstitucion (e){
  e.preventDefault();
  const institucion = document.getElementById("institucion"); 
  if(institucion.value==""){
    mostrarAlerta('error','Introduzca el nombre de la institución'); 
  }else{
      const url = base_url + "Instituciones/registrar";
      const frm=document.getElementById("frmInstitucion");
      const formData = new FormData(frm);    
      const response = await fetch(url, {
          method: "POST",
          body: formData
      });
      if (response.ok) {           
          const res = await response.json();     
          mostrarAlerta(res.ico,res.msg); 
          frm.reset();
          $("#nuevo_institucion").modal("hide");
          tblInstituciones.ajax.reload();
      }
       else {
          mostrarAlerta(res.ico,res.msg);
      }
  }
}

async function btnEditarInstitucion(id){
  document.getElementById("title").innerHTML="Actualizar Institución";
  document.getElementById("btn_form_institucion").innerHTML="Actualizar";
  try {
    const url = base_url + "Instituciones/editar/"+id;  
    const response = await fetch(url);
    if (response.ok) {
        const res = await response.json();      
        document.getElementById("id").value=res.id;
        document.getElementById("institucion").value=res.institucion;
        $("#nuevo_institucion").modal("show");
    } else {
        mostrarAlerta("error", "Error en la solicitud");
    }
  } catch (error) {
      mostrarAlerta("error", "Error en el servidor");
  }
}

async function btnDesactivarInstitucion(id){
  Swal.fire({
    title: "Desactivar Usuario",
    text: "la instituciones y sus sucursaes se desactivaran",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Desactivar",
    cancelButtonText :"Cancelar"
  }).then( async(result) => {
    if (result.isConfirmed) {   
      try {
        const url = base_url + "Instituciones/desactivar/"+id; 
        const response = await fetch(url);
        if (response.ok) {
            const res =  await response.json();  
            console.log(res)    
            mostrarAlerta(res.ico,res.msg); 
            tblInstituciones.ajax.reload();
        }
      } catch (error) {
        mostrarAlerta("error", "Error en el servidor");  
      }
    }
  });
}
async function btnActivarInstitucion(id){
  Swal.fire({
    title: "Activar Usuario",
    text: "la institucion y sus sucursales se activaran",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Activar",
    cancelButtonText :"Cancelar"
  }).then( async(result) => {
    if (result.isConfirmed) {   
      if (result.isConfirmed) {   
        try {
          const url = base_url + "Instituciones/activar/"+id; 
          const response = await fetch(url);
          if (response.ok) {
              const res =  await response.json();  
              console.log(res)    
              mostrarAlerta(res.ico,res.msg); 
              tblInstituciones.ajax.reload();
          }
        } catch (error) {
          mostrarAlerta("error", "Error en el servidor");  
        }
      } 
    }
  });
}   

