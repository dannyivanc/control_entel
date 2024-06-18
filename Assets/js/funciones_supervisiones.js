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


document.addEventListener("DOMContentLoaded",function(){
    tblSupervisiones=$('#tblSupervisiones').DataTable( {
        ajax: {
            url: base_url+"Supervisiones/listar",
            dataSrc: ''
        },
        columns: [ 
        // { 
        //   'data':'index','width': '1%','className': 'text-end',
        // },
        // {
        //   'data':'fecha','width': '6%','className': 'text-end',
        // },
        // {
        //   'data':'movimiento','width': '5%','className': 'text-end',
        // },
        // {
        //   'data':'descripcion','width': '4%','className': 'text-end',
        // },
        // {
        //   'data':'persona','width': '10%','className': 'text-end',
        // },
        // {
        //   'data':'destino','width': '10%','className': 'text-end',
        // },
        // {
        //   'data':'observacion','width': '10%','className': 'text-end',
        // },
        // {
        //   'data': 'acciones','width': '5%','className': 'text-center',
        // }
      ],
      language: {
        "decimal": "",
        "emptyTable": "No hay datos disponibles en la tabla",
        "info": "Mostrando _START_ - _END_ de _TOTAL_ registros",
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
   
function frmMaterial(){
  document.getElementById("title").innerHTML="Registro de Materiales";
  document.getElementById("btn_form_material").innerHTML="Nuevo Registro";
  document.getElementById("frmMaterial").reset();
  $("#nuevo_supervision").modal("show");
  document.getElementById("id").value="";
}

async function registrarMaterial (e){
    e.preventDefault();

    const fecha = document.getElementById("fecha");
    const movimiento = document.getElementById("movimiento");
    const persona = document.getElementById("persona");      
    const destino = document.getElementById("destino");
    const descripcion = document.getElementById("descripcion");
    if(fecha.value==""||movimiento.value==""||persona.value==""||destino.value==""||descripcion.value==""){
        mostrarAlerta("error", "Solo las observaciones pueden esta vacias");
    }else{
        const url = base_url + "Materiales/registrar";
        const frm=document.getElementById("frmMaterial");

        const formData = new FormData(frm);
        try {
           const response = await fetch(url, {
                method: "POST",
                body: formData
            });
            if (response.ok) {
                const res = await response.json();
                if (res === "si") {
                    mostrarAlerta("success", "Entrada registrada con éxito");
                    frm.reset();
                    $("#nuevo_supervision").modal("hide");
                    tblSupervisiones.ajax.reload();
                } else if (res === "modificado") {
                    mostrarAlerta("success", "Modificacion completada");
                    $("#nuevo_supervision").modal("hide");
                    tblSupervisiones.ajax.reload();
                } else {
                    mostrarAlerta("error", res);
                }
            } else {
              
            }
        } catch (error) {
                mostrarAlerta("error","Error de servidor");
        }
    }
}

// function btnEditarVehiculo  (id){
//     document.getElementById("title").innerHTML="Actualizar Registro";
//     document.getElementById("btn_form_material").innerHTML="Actualizar";
//     const url = base_url + "Materiales/editar/"+id;  
//     const http = new XMLHttpRequest();
//     http.open("GET",url,true);
//     http.send();
//     http.onreadystatechange = function(){
//         if(this.readyState==4 && this.status==200){     
//           const res = JSON.parse(this.responseText);
//           document.getElementById("id").value=res.id;
//           document.getElementById("institucion").value=res.institucion;
//           $("#nuevo_vehiculo").modal("show");
//         }
//     }
//   }
async function btnEditarMaterial(id) {
    document.getElementById("title").innerHTML = "Actualizar Registro";
    document.getElementById("btn_form_material").innerHTML = "Actualizar";
    const url = base_url + "Materiales/editar/" + id;
    try {
        const response = await fetch(url);
        if (response.ok) {
             const res = await response.json();
            document.getElementById("id").value = res.id;
            document.getElementById("fecha").value = res.fecha;
            document.getElementById("movimiento").value = res.movimiento;
            document.getElementById("persona").value = res.persona;
            document.getElementById("destino").value = res.destino;
            document.getElementById("descripcion").value = res.descripcion;
            document.getElementById("observacion").value = res.observacion;
            $("#nuevo_supervision").modal("show");
        } else {
            mostrarAlerta("error", "Error en la solicitud");
        }
    } catch (error) {
        mostrarAlerta("error", "Error en el servidor");
    }
}

function btnDesactivarVehiculo(id){
    Swal.fire({
      title: "Completar registro",
      icon: "warning",
      text: "El registro del vehiculo ya no podra ser visualizado",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Desactivar",
      cancelButtonText :"Cancelar"
    }).then(async(result) => {
      if (result.isConfirmed) {   
        try {
            const url = base_url + "Vehiculos/desactivar/"+id;
            const response = await fetch(url);
            if (response.ok) {
                const res = await response.json();
                if (res == "ok") {
                    mostrarAlerta("success", "Registro completado con éxito");
                    tblSupervisiones.ajax.reload();
                } else if(res == "void"){
                    mostrarAlerta("error", "Completar los campos de RETORNO y KILOMETRAJE DE RETORNO",4000);
                }
                else {
                    mostrarAlerta("error ",res);
                }
            } else {
                mostrarAlerta("error ","Error en la solicitud");
            }
        } catch (error) {
            mostrarAlerta("error ","Error en el servidor");
        }  
      }
    });
  }

const obtenerUbicacion = ()=>{
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;
            console.log(lat)
            console.log(lng)
            initMap(lat,lng);
        });
    } else {
       console.log('la putie')
    }

}
function initMap(lat=0,lng = 0) {
    console.log('la putie')
    if(lat!=0 && lng !=0){
        document.getElementById("map").style.display = "block"; // Muestra el mapa
        const latLng = { lat:lat, lng:lng }; 
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 15,
            center: latLng
        });
            marker = new google.maps.Marker({
            position: latLng,
            map: map
        });
    }
    else{
        mostrarAlerta("error", "No se pudo obtener localización");
    }
    
   
}
// window.onload = initMap;