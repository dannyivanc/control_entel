let tblMateriales;

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
        tblMateriales=$('#tblMateriales').DataTable( {
        responsive: true,
        ajax: {
            url: base_url+"Materiales/listar",
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
          'data':'movimiento','width': '5%','className': 'text-end',
        },
        {
          'data':'descripcion','width': '4%','className': 'text-end',
        },
        {
          'data':'cantidad','width': '4%','className': 'text-end',
        },
        {
          'data':'persona','width': '10%','className': 'text-end',
        },
        {
          'data':'destino','width': '10%','className': 'text-end',
        },
        {
          'data':'observacion','width': '10%','className': 'text-end',
        },
        {
          'data':'acciones','width': '5%','className': 'text-center',
        }
      ],
      columnDefs: [
        { responsivePriority: 1, targets: 0 },
        { responsivePriority: 2, targets: 1 },
        { responsivePriority: 3, targets: 3 },
        { responsivePriority: 4, targets: 2 },
        { responsivePriority: 5, targets: 4 },
        { responsivePriority: 6, targets: 5 },
        { responsivePriority: 7, targets: 6 },
        { responsivePriority: 8, targets: 7 },
        { responsivePriority: 9, targets: 8 },
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
  $("#nuevo_material").modal("show");
  document.getElementById("id").value="";
}

async function registrarMaterial (e){
    e.preventDefault();

    const fecha = document.getElementById("fecha");
    const movimiento = document.getElementById("movimiento");
    const persona = document.getElementById("persona");      
    const destino = document.getElementById("destino");
    const cantidad = document.getElementById("cantidad");
    const descripcion = document.getElementById("descripcion");

    if(fecha.value==""||movimiento.value==""||persona.value==""||destino.value==""||descripcion.value==""||cantidad.value==""){
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
                    $("#nuevo_material").modal("hide");
                    tblMateriales.ajax.reload();
                } else if (res === "modificado") {
                    mostrarAlerta("success", "Modificacion completada");
                    $("#nuevo_material").modal("hide");
                    tblMateriales.ajax.reload();
                } else {
                    mostrarAlerta("error", res);
                }
            } else {
                mostrarAlerta("error", "Error en la solicitud");
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
            document.getElementById("cantidad").value = res.cantidad;
            document.getElementById("persona").value = res.persona;
            document.getElementById("destino").value = res.destino;
            document.getElementById("descripcion").value = res.descripcion;
            document.getElementById("observacion").value = res.observacion;
            $("#nuevo_material").modal("show");
        } else {
            mostrarAlerta("error", "Error en la solicitud");
        }
    } catch (error) {
        mostrarAlerta("error", "Error en el servidor");
    }
}

function btnDesactivarMaterial(id){
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
            const url = base_url + "Materiales/desactivar/"+id;
            const response = await fetch(url);
            if (response.ok) {
                const res = await response.json();
                if (res == "ok") {
                    mostrarAlerta("success", "Registro completado con éxito");
                    tblMateriales.ajax.reload();
                }else {
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
    //para controlar salida
    // var fechaActual = new Date();    
    // var FechaControl = new Date(fechaActual.getTime() - (14 * 60 * 60 * 1000));
    // var fechaControlString = FechaControl.toISOString().slice(0,16);
    // var salidaInput = document.getElementById("salida");
    // salidaInput.min = fechaControlString;
    // salidaInput.addEventListener("change", function() {
    //     var salidaSeleccionada = new Date(this.value);
    //     if (salidaSeleccionada < FechaControl) {
    //         salidaInput.value = fechaControlString;
    //     }
    // });
    
//para controlar retorno    
    // var salidaInput = document.getElementById("salida");
    // var retornoInput = document.getElementById("retorno");
    // salidaInput.addEventListener("change", function() {
    //     retornoInput.min = salidaInput.value;
    //     if (retornoInput.value < salidaInput.value) {
    //         retornoInput.value = "";
    //     }
    // });
    // retornoInput.addEventListener("change", function() {
    //     if (retornoInput.value < salidaInput.value) {
    //         retornoInput.value = salidaInput.value;
    //     }
    // });

//controlando solo numeros en kp salida y retorno
    // var kmSalida = document.getElementById("km_salida");
    // kmSalida.addEventListener("input", function() {
    //     this.value = this.value.replace(/\D/g, '');
    // });
    // var kmRetorno = document.getElementById("km_retorno");
    // kmRetorno.addEventListener("input", function() {
    //     this.value = this.value.replace(/\D/g, '');
    // });

//controlar nombre
    // var conductorImput = document.getElementById("conductor");
    // conductorImput.addEventListener("input", function() {
    //     this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
    // });


