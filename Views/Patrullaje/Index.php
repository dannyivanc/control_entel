<?php include "Views/Templates/header.php";?>
   <div class="card mb-3">
      <div class="card-body text-center bg-opacity-5 bg-black">
         <span class="text-black-75 fs-5">Patrullajes</span> 
      </div>
      <table class="table">
         <tbody>
            <tr>
               <td class="table-secondary"  style="width: 10%">Institucion</td>
               <td> <?php echo $data['institucion']['institucion']; ?></p></td>
            </tr>

         </tbody>
      </table>
   </div>
   
   <div class="d-flex justify-content-center justify-content-md-start">
      <button class="btn btn-primary mb-2" type="button" onclick="frmSupervision();">
         Nuevo <i class="fas fa-plus"></i>
      </button>
   </div>
   
   <table class="table  table-light table-bordered  custom-table" id="tblSupervisiones">
         <thead class="thead-dark">
            <tr>
               <th>Nº</th>  
               <th>Fecha</th>
               <th>Sucursal</th>
               <th>Supervisor</th>
               <th>Descripción</th>
               <th>Acciones</th>
            </tr>
         </thead>
         <tbody>
         </tbody>
   </table> 

<?php include "Views/Supervisiones/ModalNuevo.php";?>
<?php include "Views/Templates/footer.php";?>

<script>
  (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
    key: "AIzaSyArnsC-St34MYG-ZWpAlcwl6r0k_mLZMbA",
    v: "weekly",
  });
</script>
<script src="<?php echo base_url;?>Assets/js/funciones_supervision.js"></script>

</body>
</html>
