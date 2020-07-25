/// <reference path="./node_modules/@types/jquery/index.d.ts" />
function Registrar() {
    var usuario = {};
    var pagina = "./BACKEND/usuarios";
    usuario.correo = $("#txtCorreo").val();
    usuario.clave = $("#txtClave").val();
    usuario.nombre = $("#txtNombre").val();
    usuario.apellido = $("#txtApellido").val();
    usuario.perfil = $("#txtPerfil").val();
    usuario.path = $("#foto").val();
    var archivo = $("#foto")[0];
    var cadenaJson = JSON.stringify(usuario);
    var form = new FormData();
    form.append("cadenaJson", cadenaJson);
    form.append("foto", archivo.files[0]);
    $.ajax({
        url: pagina,
        type: "post",
        dataType: "json",
        data: form,
        cache: false,
        contentType: false,
        processData: false,
        async: true
    }).done(function (resultado) {
        console.log("estoy en el done");
        console.log(resultado);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        var respuesta = JSON.parse(jqXHR.responseText);
        var html = '<div class="alert alert-danger alert-dissmisable">' + respuesta.mensaje + '</div>';
        $("#divAlert").html(html);
    });
}
