    // // para contraseña de usuario
    // $(document).ready(function(){
    //     $('#btnMostrarContrasena').click(function(){
    //         var tipo = $('#clave').attr('type');
    //         if(tipo == 'password'){
    //             $('#clave').attr('type', 'text');
    //             $(this).html('<i class="fa fa-eye-slash"></i>');
    //         } else {
    //             $('#clave').attr('type', 'password');
    //             $(this).html('<i class="fa fa-eye"></i>');
    //         }
    //     });
    // });

   
    // //para colcoar automaticamente la fecha y hora de ingreso 

    // document.getElementById("ingreso").addEventListener("change", function() {
    //     var ingreso = new Date(this.value);
    //     var salidaInput = document.getElementById("salida");
    //     console.log('asasd')
    //     // Si se ha seleccionado una fecha de ingreso válida
    //     if (!isNaN(ingreso.getTime())) {
    //         // Habilitar el campo de salida
    //         salidaInput.disabled = false;

    //         // Configurar el mínimo valor de salida como el día siguiente al ingreso
    //         var minSalida = new Date(ingreso.getTime() + (24 * 60 * 60 * 1000));
    //         var minSalidaString = minSalida.toISOString().slice(0,16); // Formatear a formato datetime-local
    //         salidaInput.min = minSalidaString;
    //     } else {
    //         // Si no se ha seleccionado una fecha de ingreso válida, deshabilitar la salida
    //         salidaInput.disabled = true;
    //     }
    // });