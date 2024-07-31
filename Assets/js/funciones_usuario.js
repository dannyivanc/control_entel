let tblUsuarios;
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
      tblUsuarios=$('#tblUsuarios').DataTable( {
        responsive: true,
        ajax: {
            url: base_url+"Usuarios/listar",
            dataSrc: ''
        },
        columns: [ 
        { 
          'data':'index','width': '2%','className': 'text-end',
        },
        {
          'data':'usuario','className': 'text-end',
        },
        {
          'data':'nombre','className': 'text-end',
        },
        {
          'data':'carnet','className': 'text-end',
        },
        {
          'data':'cel','className': 'text-end',
        },
        {
          'data':'institucion','className': 'text-end',
        },
        {
          'data':'rol','className': 'text-end','width': '8%',
        },
        {
          'data':'estado','className': 'text-end','width': '5%',
        },
        {
          'data': 'acciones','width': '12%','className': 'text-center',
        }
      ],
      // columnDefs: [
      //   { responsivePriority: 1, targets: 0 },
      //   { responsivePriority: 2, targets: 2 },
      //   { responsivePriority: 3, targets: 8 },
      //   { responsivePriority: 4, targets: 1 },
      //   { responsivePriority: 5, targets: 3 },
      //   { responsivePriority: 6, targets: 4 },
      //   { responsivePriority: 7, targets: 5 },
      //   { responsivePriority: 8, targets: 6 },
      //   { responsivePriority: 9, targets: 7 }
      // ],
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
        const rol = document.getElementById("rol");
        const cel = document.getElementById("cel");
        const institucion = document.getElementById("institucion");
       
        if(usuario.value=="" ||nombre.value=="" ||carnet.value==""||clave.value==""||institucion.value=="" ||rol.value=="" ||cel.value==""){
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
            document.getElementById("cel").value=res.cel;
            document.getElementById("rol").value=res.rol;
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
          const url = base_url + "Usuarios/desactivar/" + id;

          fetch(url, {
              method: 'GET'
          })
          .then(response => {
              if (response.ok) {
                  return response.json();
              } else {
                  throw new Error('Error en la solicitud');
              }
          })
          .then(res => {
              if (res === "ok") {
                  Swal.fire({
                      title: "Desactivado",
                      text: "El usuario fue desactivado con éxito",
                      icon: "success"
                  });
                  tblUsuarios.ajax.reload();
              } else {
                  Swal.fire({
                      title: "Se produjo un error",
                      text: res,
                      icon: "error"
                  });
              }
          })
          .catch(error => {
              Swal.fire({
                  title: "Error",
                  text: "Hubo un problema con la solicitud: " + error.message,
                  icon: "error"
              });
          });
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

   async function registrarPermisos(e){
      e.preventDefault();
         const url = base_url + "Usuarios/registrarPermiso";
         const frm=document.getElementById("frmPermisos");
         const formData = new FormData(frm);    
         const response = await fetch(url, {
              method: "POST",
              body: formData
          });
          if (response.ok) {           
              const res = await response.json();     
              mostrarAlerta(res.ico,res.msg);   
          } else {
              mostrarAlerta(res.ico,res.msg);
          }
    
    
    }
    

   
  //para mostrar /ocultar institucion
   function mostrarInstitucion() {
      const rol = document.getElementById('rol').value;
      const institucionContainer = document.getElementById('institucion-container');
      
      if (rol === 'cliente') {
          institucionContainer.style.display = 'block';
      } else {
          institucionContainer.style.display = 'none';
      }
    }
    document.addEventListener('DOMContentLoaded', function() {
      const indexPageElement = document.querySelector('.index-page');
      if (indexPageElement) {
          mostrarInstitucion();
      }
    });





   // para contraseña de usuario
    $(document).ready(function() {     
      if ($('.index-page').length > 0) {
          $('#btnMostrarContrasena').click(function() {
              var tipo = $('#clave').attr('type');
              if (tipo == 'password') {
                  $('#clave').attr('type', 'text');
                  $(this).html('<i class="fa fa-eye-slash"></i>');
              } else {
                  $('#clave').attr('type', 'password');
                  $(this).html('<i class="fa fa-eye"></i>');
              }
          });
          var userInput = document.getElementById("nombre");
          userInput.addEventListener("input", function() {
              this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
          });
      }
  });

