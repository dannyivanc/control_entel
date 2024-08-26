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
function mostrarAlerta(icon, title, timer = 2000,position="top") {
    Swal.fire({    
        icon: icon,
        title: title,
        position: position,
        showConfirmButton: false,
        timer: timer
    });
}
function frmPassword(){
    $("#change_pass").modal("show");
    const id = document.getElementById('id').value;
    // const clave = document.getElementById('clave').value;
    document.getElementById('modal-id').value = id;
    // document.getElementById('modal-clave').value = clave;      
}
    
async function btnEditarPerfil (e){
    e.preventDefault();     
    const claveActual = document.getElementById('clave-act');
    const claveNueva = document.getElementById('clave-new');
    const claveRepetida = document.getElementById('clave-rep'); 

    if(claveActual.value=="" ||claveNueva.value=="" ||claveRepetida.value==""){
        mostrarAlerta("error", "Todos los campos son obligatorios");
    }else{  
        if(claveNueva.value!=claveRepetida.value){
            mostrarAlerta("error", "Verifique la nueva contraseña");
        }
        else{
            const url = base_url + "Perfil/changePass";
            const frm=document.getElementById("frmPassword");
            const formData = new FormData(frm);
            try {
                const response = await fetch(url, {
                    method: "POST",
                    body: formData
                });
                if (response.ok) {
                    const res = await response.json();
                    mostrarAlerta(res.ico,res.msg);  
                     if(res.ico=='success') {
                        frm.reset();
                        $("#change_pass").modal("hide"); 
                     }  
                } else {
                    mostrarAlerta("error", "Se produjo un error");
                }
            } catch (error) {
                    mostrarAlerta("error","Error de servidor");
            }
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



