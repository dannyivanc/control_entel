document.addEventListener("DOMContentLoaded",function(){
  //  if(window.location.pathname ===`/control/Usuarios`){
    tblInstituciones=$('#tblInstituciones').DataTable( {
      ajax: {
          url: base_url+"Perfil/usuario",
          dataSrc: ''
      },


  });
  //  }
})
    function frmPerfil(){
      document.getElementById("title").innerHTML="Nuevo usuario";
      document.getElementById("btn_form_usuario").innerHTML="Nuevo usuario";
      document.getElementById("frmUsuario").reset();
      // document.getElementById("cont-pass").classList.remove("d-none");
      $("#nuevo_usuario").modal("show");
      document.getElementById("id").value="";
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
   
   // para contraseña de usuario
    $(document).ready(function(){
        $('#btnMostrarContrasena').click(function(){
            var tipo = $('#clave').attr('type');
            if(tipo == 'password'){
                $('#clave').attr('type', 'text');
                $(this).html('<i class="fa fa-eye-slash"></i>');
            } else {
                $('#clave').attr('type', 'password');
                $(this).html('<i class="fa fa-eye"></i>');
            }
        });
    });
    // para controlar nombre de usuario
    var userInput = document.getElementById("nombre");
        userInput.addEventListener("input", function() {
        this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
    });



