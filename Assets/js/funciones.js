let tblUsuarios;
// para mustrar usuarios
document.addEventListener("DOMContentLoaded",function(){
//  if(window.location.pathname ===`/control/Usuarios`){
  tblUsuarios=$('#tblUsuarios').DataTable( {
    ajax: {
        url: base_url+"Usuarios/listar",
        dataSrc: ''
    },
    columns: [ 
    {
      'data':'id',    
    },
    {
      'data':'usuario',
    },
    {
      'data':'nombre',
    },
    {
      'data':'carnet',
    },
    {
      'data':'institucion',
    },
    {
      'data':'estado',
    },
    {
      'data': 'acciones',
    }
  ]
});

//  }
})




function frmUsuario(){
  document.getElementById("title").innerHTML="Nuevo usuario";
  document.getElementById("btn_form_usuario").innerHTML="Nuevo usuario";
  document.getElementById("frmUsuario").reset();
  // document.getElementById("cont-pass").classList.remove("d-none");
  $("#nuevo_usuario").modal("show");
  document.getElementById("id").value="";
}
function registrarUser (e){
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


function btnEditarUser (id){
  document.getElementById("title").innerHTML="Actualizar usuario";
  document.getElementById("btn_form_usuario").innerHTML="Actualizar";
  const url = base_url + "Usuarios/editar/"+id;  
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

function btnDesactivarUsuario(id){
  Swal.fire({
    title: "Desactivar Usuario",
    text: "El usuario ya no tendra acceso",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Desactivar",
    cancelButtonText :"Cancelar"
  }).then((result) => {
    if (result.isConfirmed) {   
      const url = base_url + "Usuarios/desactivar/"+id;  
      const http = new XMLHttpRequest();
      http.open("GET",url,true);
      http.send();
      http.onreadystatechange = function(){
          if(this.readyState==4 && this.status==200){ 
            const res=JSON.parse(this.responseText); 
           if(res=="ok"){
            Swal.fire({
              title: "Desactivado",
              text: "El usuario desactivado con exito",
              icon: "success"
            });
            tblUsuarios.ajax.reload();
           }
           else{
            Swal.fire({
              title: "Se produjo un error",
              text: res,
              icon: "error"
            });
           }
           
          }
      }   
    }
  });
}

function btnActivarUsuario(id){
  Swal.fire({
    title: "Activar Usuario",
    // text: "El usuario tendra acceso nuevamente",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Activar",
    cancelButtonText :"Cancelar"
  }).then((result) => {
    if (result.isConfirmed) {   
      const url = base_url + "Usuarios/activar/"+id;  
      const http = new XMLHttpRequest();
      http.open("GET",url,true);
      http.send();
      http.onreadystatechange = function(){
          if(this.readyState==4 && this.status==200){ 
            const res=JSON.parse(this.responseText); 
           if(res=="ok"){
            Swal.fire({
              title: "Activado",
              text: "El usuario activado con exito",
              icon: "success"
            });
            tblUsuarios.ajax.reload();
           }
           else{
            Swal.fire({
              title: "Se produjo un error",
              text: res,
              icon: "error"
            });
           }
           
          }
      }    
    }
  });
}


