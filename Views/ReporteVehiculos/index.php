<?php include "Views/Templates/header.php";?>
   <div class="card mb-3">
      <div class="card-body text-center bg-opacity-5 bg-black">
         <span class="text-black-75 fs-5">Reporte de entrada - salida de vehiculos</span> 
      </div>
   </div>
      <div >               
         <form class="row row-cols-lg-auto g-3 align-items-center" method="post" id="frmReporte" action="">
            <div class="col-12"> 
                  <label for="inicio"  class="fw-bold">Fecha inicial</label>
                  <input id="inicio" class="form-control" type="date" name="inicio">
            </div>
            <div class="col-12">
               <label for="fin"  class="fw-bold">Fecha final</label>
               <input id="fin" class="form-control" type="date" name="fin">
            </div>

            <div class="col-12 marTop-4-5 ">
               <button class="btn btn-primary me-3" type="button" onclick="enviarRango(event);">
                  Buscar en rango <i class="fas fa-calendar"></i>
               </button>
               <button class="btn btn-primary" type="button" onclick="descargarPdf();">
                  Descargar <i class="fas fa-file-pdf"></i>
               </button>
            </div>
         </form>
      </div>
         
   <table class="table  table-light table-bordered custom-table" id="tblReportVehiculos">
       <thead class="thead-dark">
               <tr>
               <th>Nº</th>  
               <th>Salida</th>
               <th>Retorno</th>
               <th>Tipo</th>  
               <th>Placa</th>  
               <th>Km Salida</th>
               <th>Km Retorno</th>      
               <th>Conductor</th>  
               <th>Destino</th>     
               </tr>           
         </thead>
   </table>    
<?php include "Views/Templates/footer.php";?>

<script src="<?php echo base_url;?>Assets/js/funciones_reporte_vehiculos.js"></script>

</body>
</html>
