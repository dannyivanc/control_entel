let tblVisitas;
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
        tblVisitas=$('#tblVisitas').DataTable( {
        responsive: true,
        ajax: {
            url: base_url+"Visitas/listar",
            dataSrc: ''
        },
        columns: [ 
        { 
          'data':'index','width': '3%','className': 'text-end',
        },
        {
          'data':'ingreso','width': '11%','className': 'text-end',
        },
        {
          'data':'nombre','width': '20%','className': 'text-end',
        },
        {
          'data':'carnet','width': '6%','className': 'text-end',
        },
        {
          'data':'salida','width': '7%','className': 'text-end',
        },
        {
          'data':'detalle','width': '7%','className': 'text-end',
        },
        {
          'data': 'acciones','width': '12%','className': 'text-center',
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

function frmVisita(){
  document.getElementById("title").innerHTML="Registro de Visitas";
  document.getElementById("btn_form_visita").innerHTML="Nueva Visita";
  document.getElementById("frmVisita").reset();
  $("#nuevo_visita").modal("show");
  document.getElementById("id").value="";
}

async function registrarVisita (e){
    e.preventDefault();
    const ingreso = document.getElementById("ingreso");
    const salida = document.getElementById("salida");      
    const nombre = document.getElementById("nombre");
    const carnet = document.getElementById("carnet");
    const detalle = document.getElementById("detalle");

    if(ingreso.value==""||nombre.value==""||carnet.value==""||detalle.value==""){
        mostrarAlerta("error", "Solo la hora de salida puede estar en blanco");
    }else{
        const url = base_url + "Visitas/registrar";
        const frm=document.getElementById("frmVisita");
        const formData = new FormData(frm);      
        try {
           const response = await fetch(url, {
                method: "POST",
                body: formData
            });
            if (response.ok) {
                const res = await response.json();
                if(res.ico=='success'){
                    mostrarAlerta(res.ico,res.msg);
                    frm.reset();
                    $("#nuevo_visita").modal("hide");
                    tblVisitas.ajax.reload();
                }
                else{
                    mostrarAlerta(res.ico,res.msg);
                }
            } else {
                mostrarAlerta(res.ico, res.msg);
            }
        } catch (error) {
                mostrarAlerta("error","Error de servidor");
        }
    }
}

async function btnEditarVisita(id) {
    document.getElementById("title").innerHTML = "Actualizar Visita";
    document.getElementById("btn_form_visita").innerHTML = "Actualizar";
    const url = base_url + "Visitas/editar/" + id;
    try {
        const response = await fetch(url);
        if (response.ok) {
            const res = await response.json();
            document.getElementById("id").value = res.id;
            document.getElementById("ingreso").value = res.ingreso;
            document.getElementById("salida").value = res.salida;
            document.getElementById("nombre").value = res.nombre;
            document.getElementById("carnet").value = res.carnet;
            document.getElementById("detalle").value = res.detalle;
            $("#nuevo_visita").modal("show");
        } else {
            mostrarAlerta("error", "Error en la solicitud");
        }
    } catch (error) {
        mostrarAlerta("error", "Error en el servidor");
    }
}

function btnDesactivarVisita(id){
    Swal.fire({
      title: "Completar registro",
      icon: "warning",
      text: "El registro de la visita ya no podra ser visualizada",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Completar",
      cancelButtonText :"Cancelar"
    }).then(async(result) => {
      if (result.isConfirmed) {   
        try {
            const url = base_url + "Visitas/desactivar/"+id;
            const response = await fetch(url);
            if (response.ok) {
                const res = await response.json();
                    res.ico=='error'? mostrarAlerta(res.ico,res.msg,4000):mostrarAlerta(res.ico,res.msg),tblVisitas.ajax.reload();;
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
    var fechaActual = new Date();    
    var FechaControl = new Date(fechaActual.getTime() - (14 * 60 * 60 * 1000));
    var fechaControlString = FechaControl.toISOString().slice(0,16);
    var ingresoInput = document.getElementById("ingreso");
    ingresoInput.min = fechaControlString;
    ingresoInput.addEventListener("change", function() {
        var salidaSeleccionada = new Date(this.value);
        if (salidaSeleccionada < FechaControl) {
            ingresoInput.value = fechaControlString;
        }
    });
    
//para controlar ingreso    
    var ingresoInput = document.getElementById("ingreso");
    var salidaInput = document.getElementById("salida");
    ingresoInput.addEventListener("change", function() {
        salidaInput.min = ingresoInput.value;
        if (ingresoInput.value < ingresoInput.value) {
            ingresoInput.value = "";
        }
    });
    salidaInput.addEventListener("change", function() {
        if (salidaInput.value < ingresoInput.value) {
            salidaInput.value = ingresoInput.value;
        }
    });


//controlar nombre
    var conductorImput = document.getElementById("nombre");
    conductorImput.addEventListener("input", function() {
        this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
    });