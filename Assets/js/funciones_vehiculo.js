let tblVehiculos;


function frmVehiculo(){
  document.getElementById("title").innerHTML="Registro de Vehiculos";
  // document.getElementById("btnAccion").innerHTML="Registrar";
  document.getElementById("frmVehiculo").reset();
  // document.getElementById("cont-pass").classList.remove("d-none");
  $("#nuevo_vehiculo").modal("show");
  document.getElementById("id").value="";
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