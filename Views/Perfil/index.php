<?php include "Views/Templates/header.php";?>

   <div class=" bg-opacity-5 bg-black d-flex justify-content-center align-items-center mb-3" style="height: 40px;">
      <h2 class="text-black-50 fs-4" >Mi Perfil</h4>
   </div>
   <div class="d-flex justify-content-center justify-content-md-start">

   </div>
    <div id="nuevo_usuario" >

              <form method="post" id="frmUsuario" action="">
              <input type="hidden"id="id" name="id">    
                  <div class="form-group">
                     <label for="usuario">Usuario</label>       
                     <input id="usuario" class="form-control" type="text" name="usuario" placeholder="Usuario">
                  </div>
                  <div class="form-group">
                     <label for="nombre">Nombre</label>
                     <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre">
                  </div>
                  <div class="form-group">
                     <label for="carnet">Carnet</label>
                     <input id="carnet" class="form-control" type="text" name="carnet" placeholder="Carnet">
                  </div>

                  <div class="form-group" id="cont-pass">
                     <label for="clave">Contraseña</label>
                     <div class="input-group">
                        <input id="clave" class="form-control" type="password" name="clave" placeholder="Contraseña">
                        <input type="hidden"id="clave_ant" name="clave_ant">           
                        <div class="input-group-append">
                              <button class="btn btn-outline-secondary" type="button" id="btnMostrarContrasena">
                                 <i class="fa fa-eye"></i>
                              </button>
                        </div>
                     </div>
                  </div>            
                  <div class="form-group">
                     <label for="institucion">Institucion</label>
                    
                  </div>
                  
                  <button class="btn btn-danger  mt-3" type="button" data-bs-dismiss="modal">
                     Cancelar
                  </button>
              </form>
  
   </div>

<?php include "Views/Templates/footer.php";?>

<script src="<?php echo base_url;?>Assets/js/funciones_usuario.js"></script>
</body>
</html>
