document.addEventListener("DOMContentLoaded",function(){
  const url = base_url + "Perfil/verPerfil";
      const http = new XMLHttpRequest();
      http.open("GET",url,true);
      http.send();
      http.onreadystatechange = function(){
          if(this.readyState==4 && this.status==200){     
            const res = JSON.parse(this.responseText);
    
            document.getElementById("id").value=res.id;
            document.getElementById("usuario").value=res.usuario;
            document.getElementById("nombre").value=res.nombre;
            document.getElementById("carnet").value=res.carnet;
            document.getElementById("clave").value=res.clave;   
            document.getElementById("institucion").value=res.id_institucion;   
          }
      }
})



    function frmpassword(){
      $("#change_pass").modal("show");
      const id = document.getElementById('id').value;
      const clave = document.getElementById('clave').value;
      document.getElementById('modal-id').value = id;
      document.getElementById('modal-clave').value = clave;      
    }
    
    function btnEditarPerfil (e){
      e.preventDefault();

        const id = document.getElementById('modal-id').value;
        const claveVerificar = document.getElementById('modal-clave').value;
        const claveActual = document.getElementById('clave-act');
        const claveNueva = document.getElementById('clave-new');
        const claveRepetida = document.getElementById('clave-rep'); 
        console.log("ID: " + id);
        console.log("asd"+ claveVerificar);

        if(claveActual.value=="" ||claveNueva.value=="" ||claveRepetida.value==""){
          Swal.fire({
            position: "top",
            icon: "error",
            title: "Todos los campos son obligatorios",
            showConfirmButton: false,
            timer: 2000
          });
        }else{
          console.log('perrire')
          console.log(claveActual.value)
          console.log(claveNueva)
          console.log(claveRepetida)
            // const url = base_url + "Usuarios/registrar";
            // const frm=document.getElementById("frmUsuario");
            // const http = new XMLHttpRequest();
            // http.open("POST",url,true);
            // http.send(new FormData(frm));
            // http.onreadystatechange = function(){
            //     if(this.readyState==4 && this.status==200){ 
            //       const res= JSON.parse(this.responseText);
            //       if(res=="si"){
            //         Swal.fire({
            //           position: "top",
            //           icon: "success",
            //           title: "Usuario registrado con exito",
            //           showConfirmButton: false,
            //           timer: 2000
            //         });  
            //         frm.reset();
            //         $("#nuevo_usuario").modal("hide");
            //         tblUsuarios.ajax.reload();
            //       }else if(res=="modificado"){
            //         Swal.fire({
            //           position: "top",
            //           icon: "success",
            //           title: "Usuario modificado con exito",
            //           showConfirmButton: false,
            //           timer: 2000
            //         });  
            //         $("#nuevo_usuario").modal("hide");
            //         tblUsuarios.ajax.reload();
            //       }else{
            //         Swal.fire({
            //           position: "top",
            //           icon: "error",
            //           title: res,
            //           showConfirmButton: false,
            //           timer: 2000
            //         });
            //       }
            //     }
            // }
           
        }
    }

 
    // function btnEditarPerfil (e){
    //   e.preventDefault();
    //   console.log('asd')
    //   // const ids = document.getElementById('modal-id').value;
    //   // const claveActual = document.getElementById('clave-act').value;
    //   // const claveNueva = document.getElementById('clave-new').value;
    //   // const claveRepetida = document.getElementById('clave-rep').value;
    //   // console.log("ID: " + ids);
    //   // console.log("Clave Actual: " + claveActual);
    //   // console.log("Clave Nueva: " + claveNueva);
    //   // console.log("Clave Repetida: " + claveRepetida);
    // }
   
   // para contraseñas
    $(document).ready(function(){
        $('#btnMostrarAct').click(function(){
            var tipo = $('#clave-act').attr('type');
            if(tipo == 'password'){
                $('#clave-act').attr('type', 'text');
                $(this).html('<i class="fa fa-eye-slash"></i>');
            } else {
                $('#clave-act').attr('type', 'password');
                $(this).html('<i class="fa fa-eye"></i>');
            }
        });
    });
    $(document).ready(function(){
      $('#btnMostrarNew').click(function(){
          var tipo = $('#clave-new').attr('type');
          if(tipo == 'password'){
              $('#clave-new').attr('type', 'text');
              $(this).html('<i class="fa fa-eye-slash"></i>');
          } else {
              $('#clave-new').attr('type', 'password');
              $(this).html('<i class="fa fa-eye"></i>');
          }
      });
  });
  $(document).ready(function(){
    $('#btnMostrarRep').click(function(){
        var tipo = $('#clave-rep').attr('type');
        if(tipo == 'password'){
            $('#clave-rep').attr('type', 'text');
            $(this).html('<i class="fa fa-eye-slash"></i>');
        } else {
            $('#clave-rep').attr('type', 'password');
            $(this).html('<i class="fa fa-eye"></i>');
        }
    });
});



    // para controlar nombre de usuario
    var userInput = document.getElementById("nombre");
        userInput.addEventListener("input", function() {
        this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
    });



