document.addEventListener("DOMContentLoaded",function(){
  const url = base_url + "Perfil/verPerfil";
      const http = new XMLHttpRequest();
      http.open("GET",url,true);
      http.send();
      http.onreadystatechange = function(){
          if(this.readyState==4 && this.status==200){     
            const res = JSON.parse(this.responseText);
            // console.log(res);
    
            //provando para la contraseña
            // var clave_ant = document.getElementById("clave_ant");  
            // clave_ant.value = res.clave;
            //provando para la contraseña
    
            document.getElementById("id").value=res.id;
            document.getElementById("usuario").value=res.usuario;
            document.getElementById("nombre").value=res.nombre;
            document.getElementById("carnet").value=res.carnet;
            document.getElementById("clave").value=res.clave;   
            document.getElementById("institucion").value=res.id_institucion;   

            // document.getElementById("institucion").value=res.id_institucion;
    
            // document.getElementById("cont-pass").classList.add("d-none");
    
            //conrovando si la contraseña esta
            // document.getElementById("clave_ant").value= clave_ant.value; 
            
          }
      }
})



    function frmpassword(){
      $("#change_pass").modal("show");
      const id = document.getElementById('id').value;
      const clave= document.getElementById('clave').value;
      console.log(id)
      console.log(clave)
    }
    function editPass (e){
      e.preventDefault();
      const usuario = document.getElementById("usuario");
      const nombre = document.getElementById("nombre");
      const carnet = document.getElementById("carnet");
      const clave = document.getElementById("clave");
      const institucion = document.getElementById("institucion");
    
      if(usuario.value=="" ||nombre.value=="" ||carnet.value==""||clave.value==""||institucion.value==""){
        Swal.fire({
          position: "top",
          icon: "error",
          title: "Todos los campos son obligatorios",
          showConfirmButton: false,
          timer: 2000
        });
      }else{
          const url = base_url + "Usuarios/registrar";
          const frm=document.getElementById("frmUsuario");
          const http = new XMLHttpRequest();
          http.open("POST",url,true);
          http.send(new FormData(frm));
          http.onreadystatechange = function(){
              if(this.readyState==4 && this.status==200){ 
                const res= JSON.parse(this.responseText);
                if(res=="si"){
                  Swal.fire({
                    position: "top",
                    icon: "success",
                    title: "Usuario registrado con exito",
                    showConfirmButton: false,
                    timer: 2000
                  });  
                  frm.reset();
                  $("#nuevo_usuario").modal("hide");
                  tblUsuarios.ajax.reload();
                }else if(res=="modificado"){
                  Swal.fire({
                    position: "top",
                    icon: "success",
                    title: "Usuario modificado con exito",
                    showConfirmButton: false,
                    timer: 2000
                  });  
                  $("#nuevo_usuario").modal("hide");
                  tblUsuarios.ajax.reload();
                }else{
                  Swal.fire({
                    position: "top",
                    icon: "error",
                    title: res,
                    showConfirmButton: false,
                    timer: 2000
                  });
                }
              }
          }
        
      }
    }

 
    function btnEditarPerfil (id){
      document.getElementById("title").innerHTML="Actualizar usuario";
      document.getElementById("btn_form_usuario").innerHTML="Actualizar";
      const url = base_url + "Perfil/editar/"+id;  
      const http = new XMLHttpRequest();
      http.open("GET",url,true);
      http.send();
      http.onreadystatechange = function(){
          if(this.readyState==4 && this.status==200){     
            const res = JSON.parse(this.responseText);
    
            //provando para la contraseña
            var clave_ant = document.getElementById("clave_ant");  
            clave_ant.value = res.clave;
            //provando para la contraseña
    
            document.getElementById("id").value=res.id;
            document.getElementById("usuario").value=res.usuario;
            document.getElementById("nombre").value=res.nombre;
            document.getElementById("carnet").value=res.carnet;
            document.getElementById("clave").value=res.clave;      
            document.getElementById("institucion").value=res.id_institucion;
    
            // document.getElementById("cont-pass").classList.add("d-none");
    
            //conrovando si la contraseña esta
            document.getElementById("clave_ant").value= clave_ant.value; 
            
            $("#nuevo_usuario").modal("show");
          }
      }
    }
   
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



