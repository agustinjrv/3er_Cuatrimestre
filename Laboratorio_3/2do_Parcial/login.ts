/// <reference path="./node_modules/@types/jquery/index.d.ts" />


function Enviar()
{
    let pagina="./BACKEND/login";
    let correo=$("#txtCorreo").val();
    let clave=$("#txtClave").val();


    let json={"correo":correo,"clave":clave};
    let cadenaJson=JSON.stringify(json);
    let form = new FormData()
    form.append("cadenaJson",cadenaJson);

    $.ajax({
        url : pagina,
        type : "post",
        dataType :"json",
        data: form,
        cache: false,
        contentType: false,
        processData: false,
        async:true
    }).done(function(respuesta){

        if(respuesta.status==200)
        {
            localStorage.setItem("jwt",respuesta.jwt);
            location.href = "./principal.html";
        }
        else
        {
            let html='<div class="alert alert-danger alert-dissmisable">'+respuesta.mensaje+'</div>';
            $("#divAlert").html(html);
        }
        
        
    }).fail(function (jqXHR, textStatus, errorThrown) {     
        let respuesta=JSON.parse(jqXHR.responseText);


        let html='<div class="alert alert-danger alert-dissmisable">'+respuesta.mensaje+'</div>';
            $("#divAlert").html(html);
        
    });

}   

function Registrar()
{
    location.href="./registro.html";
}
