<?php include "Views/Templates/header.php";?>

   <div class=" bg-opacity-5 bg-black d-flex justify-content-center align-items-center mb-3" style="height: 40px;">
      <h2 class="text-black-50 fs-4" >Mi Perfil</h4>
   </div>
   <div class="d-flex justify-content-center justify-content-md-start">

   </div>
      <div>
            <form method="post" id="frmPerfil" action="">
              <input type="hidden"id="id" name="id">    
              <input type="hidden"id="clave" name="clave">    
                  <div class="form-group">
                     <label for="usuario">Nombre de usuario</label>       
                     <input id="usuario" class="form-control" type="text" name="usuario" placeholder="Usuario" disabled>
                  </div>
                  <div class="form-group">
                     <label for="nombre">Nombre</label>
                     <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre" disabled>
                  </div>
                  <div class="form-group">
                     <label for="carnet">Carnet</label>
                     <input id="carnet" class="form-control" type="text" name="carnet" placeholder="Carnet" disabled>
                  </div>
                  <div class="form-group">
                     <label for="institucion">Institucion</label>
                     <input id="institucion" class="form-control" type="text" name="institucion" placeholder="Institucion"  disabled>
                  </div>
                  
                  <div class="d-flex justify-content-center justify-content-md-start mt-4">
                     <button class="btn btn-primary mb-2" type="button" onclick="frmpassword();">
                        Modificar contraseña
                     </button>
                  </div>
            </form>

            <div id="change_pass" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
               <div class="modal-dialog" role="document">
                  <div class="modal-content">
                     <div class="modal-header bg-primary">
                        <h5 class="modal-title text-white">Modificar contraseña</h5>
                        <button class="btn-close btn-x" data-bs-dismiss="modal" aria-label="Close">              
                        </button>
                     </div>
                     <div class="modal-body">
                     <form method="post" id="frmpassword" action="">
                           <input type="hidden" id="modal-id" name="modal-i">
                           <input type="hidden" id="modal-clave" name="modal-clave">
         
                           <div class="form-group" id="cont-old">
                              <label for="clave-act">Contraseña actual</label>
                              <div class="input-group">
                                 <input id="clave-act" class="form-control" type="password" name="clave-act" placeholder="Contraseña actual">         
                                 <div class="input-group-append">
                                       <button class="btn btn-outline-secondary" type="button" id="btnMostrarAct">
                                          <i class="fa fa-eye"></i>
                                       </button>
                                 </div>
                              </div>
                           </div>      
                           
                           <div class="form-group" id="cont-new">
                              <label for="clave-new">Contrasea Nueva</label>
                              <div class="input-group">
                                 <input id="clave-new" class="form-control" type="password" name="clave-new" placeholder="Nueva Contraseña">   
                                 <div class="input-group-append">
                                       <button class="btn btn-outline-secondary" type="button" id="btnMostrarNew">
                                          <i class="fa fa-eye"></i>
                                       </button>
                                 </div>
                              </div>
                           </div>  

                           <div class="form-group" id="cont-rep">
                              <label for="clave-rep">Repetir Contraseña</label>
                              <div class="input-group">
                                 <input id="clave-rep" class="form-control" type="password" name="clave-rep" placeholder="Repetir contraseña">   
                                 <div class="input-group-append">
                                       <button class="btn btn-outline-secondary" type="button" id="btnMostrarRep">
                                          <i class="fa fa-eye"></i>
                                       </button>
                                 </div>
                              </div>
                           </div>  
                           <button id ="btn_form_usuario" class="btn btn-primary mt-3" type="button" onclick="btnEditarPerfil(event);">
                              Modificar
                           </button>
                           <button class="btn btn-danger  mt-3" type="button" data-bs-dismiss="modal">
                              Cancelar
                           </button>
                     </form>
                     </div>
                  </div>
               </div>
            </div>
  
      </div>

<?php include "Views/Templates/footer.php";?>
<script src="<?php echo base_url;?>Assets/js/funciones_perfil.js"></script>

</body>
</html>
