function viewInstitucion(id,vista) { 
  console.log(id)
  console.log(vista)
    if(vista=="patrullaje"){
      var form = document.createElement('form');
      form.method = 'post';
      form.action =  base_url+"Patrullajes";
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'id_institucion';
      input.value = id;
      form.appendChild(input);
      document.body.appendChild(form);
      form.submit();
    }
    else if(vista=="supervision"){
      var form = document.createElement('form');
      form.method = 'post';
      form.action =  base_url+"Supervisiones";
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'id_institucion';
      input.value = id;
      form.appendChild(input);
      document.body.appendChild(form);
      form.submit();
    }
    else if(vista=="ReporteSupervision"){
      var form = document.createElement('form');
      form.method = 'post';
      form.action =  base_url+"ReporteSupervisiones";
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'id_institucion';
      input.value = id;
      form.appendChild(input);
      document.body.appendChild(form);
      form.submit();
    }



    else if(vista=="ReporteVehiculos"){
      var form = document.createElement('form');
      form.method = 'post';
      form.action =  base_url+"ProyectoSucursal?view=reporteVehiculos";
      console.log('asd')

      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'id_institucion';
      input.value = id;
      form.appendChild(input);

      // var input2 = document.createElement('input');
      // input2.type = 'hidden';
      // input2.name = 'view';
      // input2.value = vista;
      // form.appendChild(input2);

      document.body.appendChild(form);
      form.submit();
    }

  
}