    // para contraseña de usuario
    $(document).ready(function(){
        $('#btnMostrarContrasena').click(function(){
            var tipo = $('#clave').attr('type');
            if(tipo == 'password'){
                $('#clave').attr('type', 'text');
                $(this).html('<i class="fa fa-eye-slash"></i>');
            } else {
                $('#clave').attr('type', 'password');
                $(this).html('<i class="fa fa-eye"></i>');
            }
        });
    });

    // para contraseña de usuario verificar contraseña




