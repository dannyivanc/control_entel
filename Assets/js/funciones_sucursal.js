let tblSucursales;
function mostrarAlerta(icon, title,timer = 2000,position="top") {
  Swal.fire({    
      icon: icon,
      title: title,
      position: position,
      showConfirmButton: false,
      timer: timer
  });
}
document.addEventListener("DOMContentLoaded",function(){
     tblSucursales=$('#tblSucursales').DataTable( {
      responsive: true,
      ajax: {
          url: base_url+"Sucursales/listar",
          dataSrc: ''
      },
      columns: [ 
      {
        'data':'index','width': '2%','className': 'text-end',
      },    
      {
        'data':'sucursal','className': 'text-end',
      },
      {
        'data':'institucion','className': 'text-end',
      },
      {
        'data':'vigilante','className': 'text-end',
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
    // columnDefs: [
    //   { responsivePriority: 1, targets: 0 },
    //   { responsivePriority: 2, targets: 1 },
    //   { responsivePriority: 3, targets: 7 },
    //   { responsivePriority: 4, targets: 2 },
    //   { responsivePriority: 5, targets: 3 },
    //   { responsivePriority: 6, targets: 4 },
    //   { responsivePriority: 7, targets: 5 },
    //   { responsivePriority: 8, targets: 6 },
    // ],
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

function frmSucursal(){
  document.getElementById("title").innerHTML="Registro de Sucursal";
  document.getElementById("frmSucursal").reset();
  $('#vigilante').val([{}]).trigger('change');; 
  $("#nuevo_sucursal").modal("show");
  document.getElementById("id").value="";
}

async function registrarSucursal (e){
  e.preventDefault();
  const sucursal = document.getElementById("sucursal"); 
  const institucion = document.getElementById("institucion"); 
  const vigilante = document.getElementById("vigilante"); 
  const ciudad = document.getElementById("ciudad"); 
  const direccion = document.getElementById("direccion");   
  if(sucursal.value=="" || institucion.value=="" || vigilante.value=="" || ciudad.value=="" || direccion.value=="" ){
    mostrarAlerta("error","Los campos son obligatorios ");
  }else{
      const url = base_url + "Sucursales/registrar";
      const frm=document.getElementById("frmSucursal");
      const formData = new FormData(frm);      
        try {
            const response = await fetch(url, {
                method: "POST",
                body: formData
            });
            if (response.ok) {              
                const res = await response.json();
                console.log(res)
                if(res.ico =='success'){  
                  mostrarAlerta(res.ico,res.msg);  
                  $("#nuevo_sucursal").modal("hide");
                  tblSucursales.ajax.reload();               
                }
                else {
                  mostrarAlerta(res.ico,res.msg);  
                }
          }else {
            mostrarAlerta("error", "Error en la solicitud");
          }
      }catch (error) {
        mostrarAlerta("error",  error);
    }
  }
}

async function btnEditarSucursal(id){
  document.getElementById("title").innerHTML="Actualizar Sucursal";
  document.getElementById("btn_form_sucursal").innerHTML="Actualizar";
  const url = base_url + "Sucursales/editar/"+id;  
  try{
    const response= await fetch(url);
    if(response.ok){
        const res = await response.json(); 
        document.getElementById("id").value=res.sucursal.id;
        document.getElementById("sucursal").value=res.sucursal.sucursal;
        document.getElementById("institucion").value=res.sucursal.id_institucion;          
        document.getElementById("ciudad").value=res.sucursal.ciudad;
        document.getElementById("direccion").value=res.sucursal.direccion;    
        let vigilanteValues = res.vigilantes.map(v => v.id); 
        $('#vigilante').val(vigilanteValues).trigger('change');
        $("#nuevo_sucursal").modal("show");

    }else{
      mostrarAlerta("error", "Error en la solicitud");
    }
  }catch(err){
    mostrarAlerta("error", "Error en el servidor");
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
  }).then(async (result) => {
    if (result.isConfirmed) {  
      try {
        const url = base_url + "Sucursales/desactivar/"+id;  
        const response = await fetch(url);
        if (response.ok) {
          const res = await response.json();                
          mostrarAlerta(res.ico,res.msg); 
          res.ico=='success'?tblSucursales.ajax.reload():'';
        } else {
            mostrarAlerta("error ","Error en la solicitud");
        }
      } catch (error) {
          mostrarAlerta("error ","Error en el servidor");
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
  }).then(async(result) => {
    if (result.isConfirmed) {   
      try {
        const url = base_url + "Sucursales/activar/"+id;  
        const response = await fetch(url);
        if (response.ok) {
          const res = await response.json();                
          mostrarAlerta(res.ico,res.msg); 
          res.ico=='success'?tblSucursales.ajax.reload():'';
        } else {
            mostrarAlerta("error ","Error en la solicitud");
        }
      } catch (error) {
          mostrarAlerta("error ","Error en el servidor");
      }    
    }
  });
}



//para el select 2
$(document).ready(function() {
    $('#vigilante').select2({
        placeholder: "Seleccione los vigilantes",
        allowClear: true,
        width: '470px',
    });
});
