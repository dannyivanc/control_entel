let tblPatrullajes;
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
        tblPatrullajes=$('#tblPatrullajes').DataTable({
        responsive: true,
        ajax: {
            url: base_url+"Patrullajes/listar",
            dataSrc: ''
        },
        columns: [ 
        { 
          'data':'index','width': '1%','className': 'text-end',
        },
        {
          'data':'fecha','width': '6%','className': 'text-end',
        },
        {
          'data':'id_sucursal','width': '5%','className': 'text-end',
        },
        {
          'data':'id_supervisor','width': '5%','className': 'text-end',
        },
        {
          'data':'descripcion','width': '4%','className': 'text-end',
        },
        {
          'data':'acciones','width': '3%','className': 'text-center',
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
   
function frmPatrullaje(){
    document.getElementById("map").style.display = "none";
  document.getElementById("title").innerHTML="Registro Patrullaje";
  document.getElementById("btn_form_patrullaje").innerHTML="Nuevo Registro";
  document.getElementById("frmPatrullaje").reset();
  document.getElementById("descripcion").value="Sin novedad";
  document.getElementById("btn_obtener").style.display = "block";
  $("#nuevo_patrullaje").modal("show");
  document.getElementById("id").value="";
}

async function registrarPatrullaje (e){
    e.preventDefault();   
    const id_sucursal = document.getElementById("id_sucursal");
    const descripcion = document.getElementById("descripcion");
    const lat = document.getElementById("lat");
    const lng = document.getElementById("lng");
    lat.value=lati;
    lng.value=long;

    if(id_sucursal.value==""||descripcion.value==""||lat.value==""||lng.value==""){
        mostrarAlerta("error", "Complete el formulario correctamente");
    }else{
        const url = base_url + "Patrullajes/registrar";
        const frm=document.getElementById("frmPatrullaje");
        const formData = new FormData(frm);
        try {
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
                    $("#nuevo_patrullaje").modal("hide");
                    tblPatrullajes.ajax.reload();
                } else if (res === "modificado") {
                    mostrarAlerta("success", "Modificacion completada");
                    $("#nuevo_patrullaje").modal("hide");
                    tblPatrullajes.ajax.reload();
                } else {
                    mostrarAlerta("error", res);
                }
            } else {
                mostrarAlerta("error", res);
            }
        } catch (error) {
                mostrarAlerta("error","Error de servidor");
        }
    }
}


async function btnEditarSupervision(id) {
    document.getElementById("title").innerHTML = "Modificar Supervision";
    document.getElementById("btn_form_patrullaje").innerHTML = "Actualizar";
    const url = base_url + "Patrullajes/editar/" + id;
    try {
        const response = await fetch(url);
        if (response.ok) {
            const res = await response.json();      
            document.getElementById("btn_obtener").style.display = "none";
            document.getElementById("id").value = res.id;       
            document.getElementById("id_sucursal").value = res.id_sucursal;
            document.getElementById("descripcion").value = res.descripcion;
            const lat=parseFloat(res.lat);
            const lng=parseFloat(res.lng);
            initMap(lat,lng)
            $("#nuevo_patrullaje").modal("show");
        } else {
            mostrarAlerta("error", "Error en la solicitud");
        }
    } catch (error) {
        mostrarAlerta("error", "Error en el servidor");
    }
}










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


