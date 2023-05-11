$.extend(
    {
        redirectPost: function(location, args)
        {
            var form = '';
            $.each( args, function( key, value ) {
                form += '<input type="hidden" name="'+key+'" value="'+value+'">';
            });
            $('<form action="'+location+'" method="POST">'+form+'</form>').appendTo('body').submit();
        }
    });


$(document).ready(function(){
    $('#tablaCalif').on('click', 'button',function(){
        var value = $(this).val();
        var idAlu = $("#idAlu").val();
        var idAsig = $("#idAsig").val();
        if($(this).hasClass("editaNota")){
            $.redirectPost("editaCalificacion.php",  { "id": value });
        }
        else if ($(this).hasClass("eliminaNota")){
            var ok = window.confirm("¿Quiere eliminar la calificación?");
            if(ok){
                $.post('eliminaCalificacion.php', 
                { "id": value, "idAlu": idAlu, "idAsig": idAsig}, function(response, status){
                            $("#tablaCalif").html(response);
                })
            }
        }
        else if ($(this).is("#crearCalificacion")){
            $.redirectPost("creaCalificacion.php",  { "id": idAsig, "id2": idAlu});
        }
    });

    $('#gestionUsuarios').on('click', 'button',function(){
        var value = $(this).val();
        if($(this).hasClass("editarU")){
            $.redirectPost("editaUsuario.php",  { "id": value });
        }
        else if ($(this).hasClass("eliminarU")){
            var ok = window.confirm("¿Quiere eliminar el usuario?");
            if(ok){
                $.post('eliminaUsuario.php', 
                { "id": value}, function(response, status){
                            if(response == 'logout')
                                window.location.replace("login.php");
                            else
                                $("#gestionUsuarios").html(response);
                })
            }
        }
        else if ($(this).is("#crearU")){
            $.redirectPost("creaUsuario.php",  {});
        }
    });

    $('#GestionAsignaturas').on('click', 'button',function(){
        var value = $(this).val();
        if($(this).hasClass("editarU")){
            $.redirectPost("editaAsignatura.php",  { "id": value });
        }
        else if($(this).hasClass("gestionar")){
            $.redirectPost("añadeAsignatura.php",  { "id": value });
        }
        else if ($(this).hasClass("eliminarU")){
            var ok = window.confirm("¿Quiere eliminar la asignatura?");
            if(ok){
                $.post('eliminaAsignatura.php', 
                { "id": value}, function(response, status){
                            $("#GestionAsignaturas").html(response);
                })
            }
        }
        else if($(this).hasClass("editarC")){ 
            $.redirectPost("editaCiclo.php",  { "id": value });
        }
        else if ($(this).hasClass("eliminarC")){
            var ok = window.confirm("¿Quiere eliminar el ciclo y sus asignaturas?");
            if(ok){
                $.post('eliminaCiclo.php', 
                { "id": value}, function(response, status){
                            $("#GestionAsignaturas").html(response);
                })
            }
        }
        else if ($(this).is("#CrearCiclo")){
            $.redirectPost("crear-ciclo.php",  {});
        }
        else if ($(this).is("#CrearAsig")){
            $.redirectPost("crear-asignatura.php",  {});
        }
    });
    $('#Entregas').on('click', 'button',function(){
        var value = $(this).val();
        if($(this).hasClass("editarE")){
            $.redirectPost("editaEntregaEvento.php",  { "id": value });
        }
        else if ($(this).hasClass("eliminarE")){
            var ok = window.confirm("¿Quiere eliminar la tarea?");
            if(ok){
                $.post('eliminaTarea.php', 
                { "id": value}, function(response, status){
                            $("#Entregas").html(response);
                })
            }
        }
    });
    $('#Eventos').on('click', 'button',function(){
        var value = $(this).val();
        if($(this).hasClass("editarE")){
            $.redirectPost("editaEntregaEvento.php",  { "id": value });
        }
        else if ($(this).hasClass("eliminarE")){
            var ok = window.confirm("¿Quiere eliminar el evento?");
            if(ok){
                $.post('eliminaEvento.php', 
                { "id": value}, function(response, status){
                            $("#Eventos").html(response);
                })
            }
        }
    });
    $('#alumnosCalificacion').on('click', 'button',function(){
        var value = $(this).val();
        if($(this).is("#cambiarPorcentajes")){
            $.redirectPost("porcentajesAsignatura.php",  { "id": value });
        }
    });
    $('#contenidoAsig').on('click', 'button',function(){
        var value = $(this).val();
        if($(this).is("#creaEventoTarea")){
            $.redirectPost("creaEventoTarea.php",  { "id": value });
        }
        if($(this).is("#subirRecursos")){
            $.redirectPost("subidaRecurso.php",  { "id": value });
        }
    });
    $('#subidaEntrega').on('click', 'button',function(){
        var value = $(this).val();
        var idEntrega = $("#id2").val();
        if($(this).is("#subirEntrega")){
            $.redirectPost("subidaEntrega.php",  { "id": value , "id2": idEntrega});
        }
    });
    $('#entregaAlu').on('click', 'button',function(){
        var value = $(this).val();
        if($(this).is("#califEntrega")){
            var id2 = $("#id2").val();
            $.redirectPost("creaCalificacionEntrega.php",  { "id": value , "id2": id2});
        }
        if($(this).is("#editCalifEntrega")){
            $.redirectPost("editaCalificacionEntrega.php",  { "id": value});
        }
    });
});