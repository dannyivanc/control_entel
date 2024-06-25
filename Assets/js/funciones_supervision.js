let tblSupervisiones;
let lati="",long="";

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
        tblSupervisiones=$('#tblSupervisiones').DataTable({
        // ajax: {
        //     url: base_url+"Supervisiones/listar",
        //     dataSrc: ''
        // },
        columns: [ 
        { 
          'data':'index','width': '1%','className': 'text-end',
        },
        {
          'data':'fecha','width': '6%','className': 'text-end',
        },
        {
          'data':'id_vigilante','width': '5%','className': 'text-end',
        },
        {
          'data':'puntualidad','width': '4%','className': 'text-end',
        },
        {
          'data':'pres_per','width': '10%','className': 'text-end',
        },
        {
          'data':'patrulla','width': '10%','className': 'text-end',
        },
        {
          'data':'epp','width': '10%','className': 'text-end',
        },
        {
          'data': 'libro','width': '5%','className': 'text-center',
        },
        {
          'data': 'verif_vehi','width': '5%','className': 'text-center',
        },
        {
            'data':'acciones','width': '12%','className': 'text-center',
          }
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
   
function frmSupervision(){
    document.getElementById("map").style.display = "none";
  document.getElementById("title").innerHTML="Registro de Materiales";
  document.getElementById("btn_form_material").innerHTML="Nuevo Registro";
  document.getElementById("frmSupervision").reset();
  $("#nuevo_supervision").modal("show");
  document.getElementById("id").value="";
}

async function registrarSupevision (e){
    e.preventDefault();

    const id_sucursal = document.getElementById("id_sucursal");
    const id_vigilante = document.getElementById("id_vigilante");
    const puntualidad = document.getElementById("puntualidad");      
    const pres_per = document.getElementById("pres_per");
    const patrulla = document.getElementById("patrulla");
    const epp = document.getElementById("epp");
    const libro = document.getElementById("libro");      
    const verif_vehi = document.getElementById("verif_vehi");
    const lat = document.getElementById("lat");
    const lng = document.getElementById("lng");
    lat.value=lati;
    lng.value=long;

    // console.log(document.getElementById("libro").value)

    if(id_sucursal.value==""||id_vigilante.value==""||lat.value==""||lng.value==""){
        mostrarAlerta("error", "Complete el formulario correctamente");
    }else{
        const url = base_url + "Supervisiones/registrar";
        const frm=document.getElementById("frmSupervision");
        // console.log(frm)

        const formData = new FormData(frm);
        // try {
           const response = await fetch(url, {
                method: "POST",
                body: formData
            });
        //    console.log(response)
            if (response.ok) {
                const res = await response.json();
                console.log(res)
                if (res === "si") {
                    mostrarAlerta("error", res);
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
                mostrarAlerta("error", res);
            }
        // } catch (error) {
        //         mostrarAlerta("error","Error de servidor");
        // }
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
                    tblSupervisiones .ajax.reload();
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
  








//para los switch
const updateSwitchLabel = (switchElement, labelElement) => {
    if (switchElement.checked) {
        labelElement.textContent = 'Si';
        switchElement.value = 'Si';
    } else {
        labelElement.textContent = 'No';
        switchElement.value = 'No';
    }
};
// Función para inicializar un interruptor y su etiqueta
const switchLabel = (switchId, labelId) => {
    const switchElement = document.getElementById(switchId);
    const labelElement = document.getElementById(labelId);
    updateSwitchLabel(switchElement, labelElement);
    switchElement.addEventListener('change', () => updateSwitchLabel(switchElement, labelElement));
};

// Inicializar todos los interruptores y etiquetas
switchLabel('puntualidad', 'labelPuntualidad');
switchLabel('pres_per', 'labelPres_per');
switchLabel('patrulla', 'labelPatrulla');
switchLabel('epp', 'labelEpp');
switchLabel('libro', 'labelLibro');
switchLabel('verif_vehi', 'labelVerif_vehi');



// para el mapa
function obtenerUbicacion (){
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                initMap(lat, lng);
            },
            function(error) {
                console.log('Error obteniendo la ubicación: ', error);
                initMap();
            }
        );
    } else {
        console.log('El navegador no soporta geolocalización.');
        initMap();
    }

}

async function initMap(lat=-19.583309,lng=-65.759771)  {
    lati=lat;
    long=lng;
    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
    document.getElementById("map").style.display = "block";
    const latLng = { lat:lat, lng:lng }; 

    const { Map } = await google.maps.importLibrary("maps");
    // Short namespaces can be used.
    map = new Map(document.getElementById("map"), {
        center: latLng,
        zoom: 15,
        mapId: "map"
    });
        const marker = new google.maps.marker.AdvancedMarkerElement({
        position: latLng,
        map:map,
        title: 'Uluru',
    });}


