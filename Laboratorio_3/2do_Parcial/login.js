/// <reference path="./node_modules/@types/jquery/index.d.ts" />
function Enviar() {
    var pagina = "./BACKEND/login";
    var correo = $("#txtCorreo").val();
    var clave = $("#txtClave").val();
    var json = { "correo": correo, "clave": clave };
    var cadenaJson = JSON.stringify(json);
    var form = new FormData();
    form.append("cadenaJson", cadenaJson);
    $.ajax({
        url: pagina,
        type: "post",
        dataType: "json",
        data: form,
        cache: false,
        contentType: false,
        processData: false,
        async: true
    }).done(function (respuesta) {
        if (respuesta.status == 200) {
            localStorage.setItem("jwt", respuesta.jwt);
            location.href = "./principal.html";
        }
        else {
            var html = '<div class="alert alert-danger alert-dissmisable">' + respuesta.mensaje + '</div>';
            $("#divAlert").html(html);
        }
    }).fail(function (jqXHR, textStatus, errorThrown) {
        var respuesta = JSON.parse(jqXHR.responseText);
        var html = '<div class="alert alert-danger alert-dissmisable">' + respuesta.mensaje + '</div>';
        $("#divAlert").html(html);
    });
}
function Registrar() {
    location.href = "./registro.html";
}
