<?php include "Views/Templates/header.php";?>
   <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Usuarios</li>
   </ol>    
   <button class="btn btn-primary mb-2" type="button" onclick="frmUsuario();">Nuevo   <i class="fas fa-plus"></i> </button>  

   <table class="table  table-light custom-table " id="tblUsuarios">
         <thead class="thead-dark">
            <tr>
               <th>Usuario</th>
               <th>Nombre</th>
               <th>Carnet</th>
               <th>Institucion</th>  
               <th>Estado</th>  
               <th>Acciones</th>      
            </tr>
         </thead>
         <tbody>
         </tbody>
   </table>    

   <div id="nuevo_usuario" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header bg-primary">
               <h5 class="modal-title text-white" id="title">Nuevo Usuario</h5>
               <button class="close text-white" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
              <form method="post" id="frmUsuario" action="">
                  <div class="form-group">
                     <label for="usuario">Usuario</label>
                     <input type="hidden"id="id" name="id">                     
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
                     <select id="institucion" class="form-control" name="institucion">
                        <?php foreach ($data['instituciones']as $row) {?>
                           <option value="<?php echo $row['id']; ?>" ><?php echo $row['institucion']; ?></option>
                        <?php } ?>
                        </select>
                  </div>
                  <button id ="btn_form_usuario" class="btn btn-primary mt-3" type="button" onclick="registrarUser(event);">
                     Registrar
                  </button>
                  <button class="btn btn-danger  mt-3" type="button" data-dismiss="modal">
                     Cancelar
                  </button>
              </form>
            </div>
         </div>
      </div>
   </div>

<?php include "Views/Templates/footer.php";?>

<script src="<?php echo base_url;?>Assets/js/funciones_usuario.js"></script>
</body>
</html>
