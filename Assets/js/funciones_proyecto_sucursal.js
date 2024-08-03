function mostrarLista(id,vista) {
  console.log(id) 
  console.log(vista) 
    if(vista=="ReporteVehiculos"){
      var form = document.createElement('form');
      form.method = 'post';
      form.action =  base_url+"ReporteVehiculos";
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'id_sucursal';
      input.value = id;      
      form.appendChild(input);
      document.body.appendChild(form);
      form.submit();
    }

    else if(vista=="ReporteMateriales"){
      var form = document.createElement('form');
      form.method = 'post';
      form.action =  base_url+"ReporteMateriales";
      var input = document.createElement('input');
      input.type = 'hidden';
      input.name = 'id_sucursal';
      input.value = id;      
      form.appendChild(input);
      document.body.appendChild(form);
      form.submit();
    }

  
}
