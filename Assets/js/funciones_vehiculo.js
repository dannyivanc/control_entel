let tblVehiculos;

function mostrarAlerta(icon, title,position="top", timer = 2000) {
    Swal.fire({    
        icon: icon,
        title: title,
        position: position,
        showConfirmButton: false,
        timer: timer
    });
}

function frmVehiculo(){
  document.getElementById("title").innerHTML="Registro de Vehiculos";
  // document.getElementById("btnAccion").innerHTML="Registrar";
  document.getElementById("frmVehiculo").reset();
  // document.getElementById("cont-pass").classList.remove("d-none");
  $("#nuevo_vehiculo").modal("show");
  document.getElementById("id").value="";
}


async function registrarVehiculo (e){
    e.preventDefault();
    const salida = document.getElementById("salida");
    const retorno = document.getElementById("retorno");
    const tipo = document.getElementById("tipo");      
    const placa = document.getElementById("placa");
    const km_salida = document.getElementById("km_salida");
    const km_retorno = document.getElementById("km_retorno");
    const conductor = document.getElementById("conductor");
    const destino = document.getElementById("destino");
    const estado =   document.getElementById("estado") ;
    // .checked ? "1" : "0"

   
    if(tipo.value==""||placa.value==""||km_salida.value==""||conductor.value=="" ||destino.value==""){
        mostrarAlerta("error", "Todos los campos son obligatorios");
    }else{
        const url = base_url + "Vehiculos/registrar";
        const frm=document.getElementById("frmVehiculo");

        // const formData = new FormData(frm);      
        // try {
        //     const response = await fetch(url, {
        //         method: "POST",
        //         body: formData
        //     });
        //     if (response.ok) {
        //         const res = await response.json();
        //         mostrarAlerta("success", res);
        //         // if (res == "si") {
        //         //     mostrarAlerta("success", "Entrada registrada con éxito");
        //         //     frm.reset();
        //         //     $("#nuevo_usuario").modal("hide");
        //         //     tblUsuarios.ajax.reload();
        //         // } else if (res == "modificado") {
        //         //     mostrarAlerta("success", "Registro completado");
        //         //     $("#nuevo_usuario").modal("hide");
        //         //     tblUsuarios.ajax.reload();
        //         // } else {
        //         //     mostrarAlerta("error", res);
        //         // }
        //     } else {
        //         mostrarAlerta("error", "Error en la solicitud");
        //     }
        // } catch (error) {
        //     mostrarAlerta("error", 'Error en el servidor' );
        // }

        const http = new XMLHttpRequest();
        http.open("POST",url,true);
        http.send(new FormData(frm));      
        http.onreadystatechange = function(){
            if(this.readyState==4 && this.status==200){ 
              const res= JSON.parse(this.responseText);
              if(res=="si"){
                mostrarAlerta("success", "Entrada registrada con exito");
                frm.reset();
                $("#nuevo_usuario").modal("hide");
                tblUsuarios.ajax.reload();
              }else if(res=="modificado"){
                mostrarAlerta("success", "Registor completado");
                $("#nuevo_usuario").modal("hide");
                tblUsuarios.ajax.reload();
              }else{
                mostrarAlerta("error",res);
              }
            }
        }
    }
}



























    //para controlar salida
    var fechaActual = new Date();    
    var FechaControl = new Date(fechaActual.getTime() - (14 * 60 * 60 * 1000));
    var fechaControlString = FechaControl.toISOString().slice(0,16);
    var salidaInput = document.getElementById("salida");
    salidaInput.min = fechaControlString;
    salidaInput.addEventListener("change", function() {
        var salidaSeleccionada = new Date(this.value);
        if (salidaSeleccionada < FechaControl) {
            salidaInput.value = fechaControlString;
        }
    });
    
//para controlar retorno    
    var salidaInput = document.getElementById("salida");
    var retornoInput = document.getElementById("retorno");
    salidaInput.addEventListener("change", function() {
        retornoInput.min = salidaInput.value;
        if (retornoInput.value < salidaInput.value) {
            retornoInput.value = "";
        }
    });
    retornoInput.addEventListener("change", function() {
        if (retornoInput.value < salidaInput.value) {
            retornoInput.value = salidaInput.value;
        }
    });

//controlando solo numeros en kp salida y retorno
    var kmSalida = document.getElementById("km_salida");
    kmSalida.addEventListener("input", function() {
        this.value = this.value.replace(/\D/g, '');
    });
    var kmRetorno = document.getElementById("km_retorno");
    kmRetorno.addEventListener("input", function() {
        this.value = this.value.replace(/\D/g, '');
    });

//controlar nombre
    var conductorImput = document.getElementById("conductor");
    conductorImput.addEventListener("input", function() {
        this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
    });