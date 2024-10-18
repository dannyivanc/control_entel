<?php include "Views/Templates/header.php";?>

   <div class="card mb-3">
      <div class="card-body text-center bg-opacity-5 bg-black">
         <span class="text-black-75 fs-5">Registro de Visitas</span> 
      </div>
      <table class="table">
         <tbody>
            <tr>
               <td class="table-secondary"  style="width: 10%">Institucion</td>
               <td> <?php echo($data['institucion']);?></td>
            </tr>
            <tr>
               <td class="table-secondary">Sucursal</td>
               <td> <?php echo($data['sucursal']);?></td>
            </tr>
         </tbody>
      </table>
   </div>


   
   <div class="d-flex justify-content-center justify-content-md-start">
      <button class="btn btn-primary mb-2" type="button" onclick="frmVisita();">
         Nuevo <i class="fas fa-plus"></i>
      </button>
   </div>

   <table class="table  table-light table-bordered  custom-table" id="tblVisitas">
         <thead class="thead-dark">
            <tr>
               <th>Nº</th>  
               <th>Intreso</th>
               <th>Nombre</th>  
               <th>Carnet</th>  
               <th>Salida</th>
               <th>Detalle</th>   
               <th>Acciones</th>   
            </tr>
         </thead>
         <tbody>
         </tbody>
   </table> 
   <div id="nuevo_visita" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header bg-primary">
               <h5 class="modal-title text-white" id="title">Nueva Visita</h5>
               <button class="btn-close btn-x" data-bs-dismiss="modal" aria-label="Close">              
               </button>
            </div>
            <div class="modal-body">
               
               <form method="post" id="frmVisita" action="">
                  <input type="hidden"id="id" name="id">   
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="ingreso">Ingreso</label>
                           <input id="ingreso" class="form-control" type="datetime-local" name="ingreso" placeholder="Hora de ingreso">
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           <label for="salida">Salida</label>
                           <input id="salida" class="form-control" type="datetime-local" name="salida" placeholder="Hora de salida">
                        </div>
                     </div>
                  </div>                     
                  <div class="row">
                     <div class="col-md-8">
                        <div class="form-group">
                           <label for="nombre">Nombre</label>
                           <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre">
                        </div>
                     </div>
                     <div class="col-md-4">                            
                        <div class="form-group">
                           <label for="carnet">Carnet</label>
                           <input id="carnet" class="form-control text-uppercase" type="text" name="carnet" placeholder="carnet">
                        </div>
                     </div>
                  </div>   
                  <div class="form-group">
                     <label for="detalle">Detalle</label>
                     <input id="detalle" class="form-control" type="text" name="detalle" placeholder="Detalle de Visita">
                  </div>               
                  <button id ="btn_form_visita" class="btn btn-primary mt-3" type="button" onclick="registrarVisita(event);">
                     Registrar
                  </button>
                  <button class="btn btn-danger  mt-3" type="button" data-bs-dismiss="modal">
                     Cancelar
                  </button>
               </form>
            </div>
         </div>
      </div>
   </div>

<?php include "Views/Templates/footer.php";?>
<script src="<?php echo base_url;?>Assets/js/funciones_visita.js"></script>

</body>
</html>
