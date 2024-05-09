<?php include "Views/Templates/header.php";?>
   <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Usuarios</li>
   </ol>    
   <button class="btn btn-primary mb-2" type="button" onclick="frmUsuario();">Nuevo</button>  

   <table class="table  table-light custom-table " id="tblUsuarios">
         <thead class="thead-dark">
            <tr>
               <th>Id</th>
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
            <div class="modal-header">
               <h5 class="modal-title" id="title">Nuevo Usuario</h5>
               <button class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
              <form method="post" id="frmUsuario" action="">
                  <div class="form-group">
                     <label for="usuario">Usuario</label>
                     <input type="hidden"id="id" name="id" >
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


                  <!-- <div class="form-group">
                     <label for="clave">Contraseña</label>
                     <input id="clave" class="form-control" type="password" name="clave" placeholder="Contraseña">
                  </div> -->
                  <div class="form-group">
                     <label for="clave">Contraseña</label>
                     <div class="input-group">
                        <input id="clave" class="form-control" type="password" name="clave" placeholder="Contraseña">
                        <div class="input-group-append">
                              <button class="btn btn-outline-secondary" type="button" id="btnMostrarContrasena">
                                 <i class="fa fa-eye"></i>
                              </button>
                        </div>
                     </div>
                  </div>            
                  <!-- <div class="form-group">
                     <label for="confirmar">Confirmar contraseña</label>
                     <input id="confirmar" class="form-control" type="password" name="confirmar" placeholder="Confirmar contraseña">
                  </div> -->
                  <div class="form-group">
                     <label for="confirmar">Confirmar contraseña</label>
                     <div class="input-group">
                        <input id="confirmar" class="form-control" type="password" name="confirmar" placeholder="Confirmar contraseña">
                        <div class="input-group-append">
                              <button class="btn btn-outline-secondary" type="button" id="btnMostrarConfirmarContrasena">
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
                     <button class="btn btn-primary mt-3" type="button" onclick="registrarUser(event);">
                        Registrar
                     </button>
                  </div>
              </form>
            </div>
         </div>
      </div>
   </div>
<?php include "Views/Templates/footer.php";?>