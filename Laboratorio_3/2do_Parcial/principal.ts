/// <reference path="./node_modules/@types/jquery/index.d.ts" />

function MostrarUsuarios()
{
    let pagina="./BACKEND/";

    $.ajax({
        url:pagina,
        type:"get",
        dataType:"json",
        cache:false,
        contentType:false,
        processData:false,
        async:true
    }).done(function(resultado){
        //console.log("estoy en el done");
        //console.log(resultado);
        let listaElementos=JSON.parse(resultado.tabla);
        //console.log(listaElementos);
        let html='<table class="table table-hover table-responsive ">';
        html+= '<tr><th>Correo</th><th>Nombre</th><th>Apellido</th><th>Perfil</th><th>Foto</th></tr>';
        listaElementos.forEach(element => {
            html+='<tr>';
            html+='<td>'+element.correo +'</td>';
            html+='<td>'+element.nombre +'</td>';
            html+='<td>'+element.apellido +'</td>';
            html+='<td>'+element.perfil +'</td>';
            html+='<td>'+'<img src="BACKEND/fotos/'+element.foto+'" width="50px"></td>';
            html+='</tr>';
        });
      html+='</table>' 
      $("#tabDerecha").html(html);

    }).fail(function(jqXHR, textStatus, errorThrown){
        
        let respuesta=JSON.parse(jqXHR.responseText);
        console.log(respuesta);
        let html='<div class="alert alert-danger alert-dissmisable">'+"Error,no se a podido cargar la Tabla"+'</div>';
          $("#divAlert").html(html);
            
    });
}

function MostrarAutos()
{
    let pagina="./BACKEND/autos";

    $.ajax({
        url:pagina,
        type:"get",
        dataType:"json",
        cache:false,
        contentType:false,
        processData:false,
        async:true
    }).done(function(resultado){
        let listaElementos=JSON.parse(resultado.tabla);

        
        let html='<table class="table table-hover table-striped table-responsive">';
        html+= '<tr><th>Marca</th><th>color</th><th>Modelo</th><th>Precio</th><th>Eliminar</th><th>Modificar</th></tr>';
        listaElementos.forEach(element => {
            html+='<tr>';
            html+='<td>'+element.marca +'</td>';
            html+='<td>'+element.color +'</td>';
            html+='<td>'+element.modelo +'</td>';
            html+='<td>'+element.precio +'</td>';
            html+='<td>'+'<input type="button" value="Eliminar" onclick="EliminarAuto('+element.id+')" class="btn-danger form-control">' +'</td>';
            html+='<td>'+"<input type='button' value='Modificar' onclick='ModificarAuto("+JSON.stringify(element)+")' class='btn-info form-control'>" +'</td>';
            html+='</tr>';
        });
      html+='</table>' 
      $("#tabIzquierda").html(html);

    }).fail(function(jqXHR, textStatus, errorThrown){
        
        let respuesta=JSON.parse(jqXHR.responseText);
        console.log(respuesta);
        let html='<div class="alert alert-danger alert-dissmisable">'+"Error,no se a podido cargar la Tabla"+'</div>';
          $("#divAlert").html(html);
            
    });

}

function EliminarAuto(id)
{
    let pagina="./BACKEND/index.php";
    let jwt=localStorage.getItem("jwt");

    let json= {"id":id ,"jwt":jwt};
    $.ajax({
        url:pagina,
        type:"delete",
        headers:json,
        dataType:"json",
        cache:false,
        //contentType:false,
        //processData:false,
        async:true
    }).done(function(resultado){
        MostrarAutos();

    }).fail(function(jqXHR, textStatus, errorThrown){
        
        let respuesta=JSON.parse(jqXHR.responseText);
        if(!respuesta.exito)
        {
            location.href="login.html";
        }
       
        let html='<div class="alert alert-warning alert-dissmisable">'+"Error,no se a podido eliminar"+'</div>';
          $("#divAlert").html(html);
            
    });




}

function ModificarAuto(json)
{
    let html;
    
   
    html+='<div class="container-fluid" style="background-color: darkcyan; ">';
    html+='<form action="" >';
    html+='<div class="form-group" >';
    html+='<div class="row mt-1" >';
    html+='<div class="col-1 mt-3" ><label for="txtMarca" class="fas fa-trademark "></label></div>';
    html+='<div class="col mt-3"><input type="text" id="txtMarca" class="form-control" value="'+json.marca+'" placeholder="Marca"></div></div>';
    html+='<div class="row mt-1">';
    html+='<div class="col-1"><label for="txtColor" class="fas fa-palette "></label></div>';
    html+='<div class="col"><input type="text" id="txtColor" class="form-control" value="'+json.color+'" placeholder="Color"></div></div>';
    html+='<div class="row mt-1">';
    html+='<div class="col-1"><label for="txtModelo" class="fas fa-car"></label></div>';
    html+='<div class="col"><input type="text" id="txtModelo" class="form-control" value="'+json.modelo+'" placeholder="Modelo"></div></div>';
    html+='<div class="row mt-1">';
    html+='<div class="col-1"><label for="txtPrecio" class="fas fa-dollar-sign "></label></div>';
    html+='<div class="col"><input type="text" id="txtPrecio" class="form-control" value="'+json.precio+'" placeholder="Precio"></div>';
    html+='</div>';
    html+='<div class="row mt-3">';
    html+='<div class="col ml-5"><input type="button" value="Modificar" class="btn-success form-control" onclick="ObtenerdatosModificar('+json.id+')"></div>';
    html+='<div class="col mr-5"><input type="reset" value="Limpiar" class="btn-warning form-control" ></div>';
    html+='</div>';
    html+='</div></form></div>';
    $("#tabIzquierda").html(html);
}

function ObtenerdatosModificar(id)
{
    let marca=$("#txtMarca").val();
    let color=$("#txtColor").val();
    let modelo=$("#txtModelo").val();
    let precio=$("#txtPrecio").val();

    let pagina="./BACKEND/";
    let cadenaJson=JSON.stringify({"marca":marca,"color":color,"modelo":modelo,"precio":precio});
    let jwt=localStorage.getItem("jwt");
    let json= {"id":id ,"jwt":jwt ,"cadenaJson":cadenaJson};
    $.ajax({
        url:pagina,
        type:"put",
        headers:json,
        dataType:"json",
        cache:false,
        //contentType:false,
        //processData:false,
        async:true
    }).done(function(resultado){
        console.log(resultado);
        console.log("estoy en el done");

        MostrarAutos();

    }).fail(function(jqXHR, textStatus, errorThrown){
        console.log("estoy en el fail");
        let respuesta=JSON.parse(jqXHR.responseText);
        if(!respuesta.exito)
        {
            location.href="login.html";
        }
       
        let html='<div class="alert alert-warning alert-dissmisable">'+"Error,no se a podido Modificar"+'</div>';
          $("#divAlert").html(html);
            
    });



}

function AltaAutos()
{
    let html;
    
   
    html+='<div class="container-fluid" style="background-color: darkcyan; ">';
    html+='<form action="" >';
    html+='<div class="form-group" >';
    html+='<div class="row mt-1" >';
    html+='<div class="col-1 mt-3" ><label for="txtMarca" class="fas fa-trademark "></label></div>';
    html+='<div class="col mt-3"><input type="text" id="txtMarca" class="form-control"  placeholder="Marca"></div></div>';
    html+='<div class="row mt-1">';
    html+='<div class="col-1"><label for="txtColor" class="fas fa-palette "></label></div>';
    html+='<div class="col"><input type="text" id="txtColor" class="form-control" placeholder="Color"></div></div>';
    html+='<div class="row mt-1">';
    html+='<div class="col-1"><label for="txtModelo" class="fas fa-car"></label></div>';
    html+='<div class="col"><input type="text" id="txtModelo" class="form-control" placeholder="Modelo"></div></div>';
    html+='<div class="row mt-1">';
    html+='<div class="col-1"><label for="txtPrecio" class="fas fa-dollar-sign "></label></div>';
    html+='<div class="col"><input type="text" id="txtPrecio" class="form-control" placeholder="Precio"></div>';
    html+='</div>';
    html+='<div class="row mt-3">';
    html+='<div class="col ml-5"><input type="button" value="Agregar" class="btn-success form-control" onclick="AgregoUno()"></div>';
    html+='<div class="col mr-5"><input type="reset" value="Limpiar" class="btn-warning form-control" ></div>';
    html+='</div>';
    html+='</div></form></div>';
    $("#tabIzquierda").html(html);
}

function AgregoUno()
{
    let marca=$("#txtMarca").val();
    let color=$("#txtColor").val();
    let modelo=$("#txtModelo").val();
    let precio=$("#txtPrecio").val();

    let pagina="./BACKEND/index.php";
    let cadenaJson=JSON.stringify({"marca":marca,"color":color,"modelo":modelo,"precio":precio});
    let form=new FormData()

    form.append("cadenaJson",cadenaJson);
    $.ajax({
        url:pagina,
        type:"post",
        data:form,
        dataType:"json",
        cache:false,
        contentType:false,
        processData:false,
        async:true
    }).done(function(resultado){
        console.log(resultado);
        console.log("estoy en el done");

        MostrarAutos();

    }).fail(function(jqXHR, textStatus, errorThrown){
        console.log("estoy en el fail");
        let respuesta=JSON.parse(jqXHR.responseText);
        console.log(jqXHR);
       MiAlert(respuesta.mensaje);
       
            
    });
}

function MiAlert(mensaje)
{
    let html='<div class="alert alert-warning alert-dissmisable">'+mensaje+'</div>';
    $("#divAlert").html(html);
}

function PrimerFiltro()
{
   
    let pagina="./BACKEND/autos";

    $.ajax({
        url:pagina,
        type:"get",
        dataType:"json",
        cache:false,
        contentType:false,
        processData:false,
        async:true
    }).done(function(resultado){
        let listaElementos=JSON.parse(resultado.tabla);

        let listaNueva=listaElementos.filter(function(elemento,index,array){
            return 250888<elemento.precio;
        });
        

        let html='<table class="table table-hover table-striped table-responsive">';
        html+= '<tr><th>Marca</th><th>color</th><th>Modelo</th><th>Precio</th><th>Eliminar</th><th>Modificar</th></tr>';
        listaNueva.forEach(element => {
            html+='<tr>';
            html+='<td>'+element.marca +'</td>';
            html+='<td>'+element.color +'</td>';
            html+='<td>'+element.modelo +'</td>';
            html+='<td>'+element.precio +'</td>';
            html+='<td>'+'<input type="button" value="Eliminar" onclick="EliminarAuto('+element.id+')" class="btn-danger form-control">' +'</td>';
            html+='<td>'+"<input type='button' value='Modificar' onclick='ModificarAuto("+JSON.stringify(element)+")' class='btn-info form-control'>" +'</td>';
            html+='</tr>';
        });
      html+='</table>' 
      $("#tabDerecha").html(html);

    }).fail(function(jqXHR, textStatus, errorThrown){
        
        let respuesta=JSON.parse(jqXHR.responseText);
        console.log(respuesta);
        let html='<div class="alert alert-danger alert-dissmisable">'+"Error,no se a podido cargar la Tabla"+'</div>';
          $("#divAlert").html(html);
            
    });
}

function SegundoFiltro()
{
    let pagina="./BACKEND/autos";

    $.ajax({
        url:pagina,
        type:"get",
        dataType:"json",
        cache:false,
        contentType:false,
        processData:false,
        async:true
    }).done(function(resultado){
        let listaElementos=JSON.parse(resultado.tabla);

        let total=listaElementos.map(function(elemento,index,array){
            return parseFloat(elemento.precio);
        }).reduce(function(anterior,proximo,index,array){

            return anterior + proximo;
        },0);

        let promedio=total / listaElementos.length;

        let mensaje="El promedio del precio de autos es: " + promedio;
        MiAlertInfo(mensaje);
        


    }).fail(function(jqXHR, textStatus, errorThrown){
        
        let respuesta=JSON.parse(jqXHR.responseText);
        console.log(respuesta);
        let html='<div class="alert alert-danger alert-dissmisable">'+"Error,no se a podido cargar la Tabla"+'</div>';
          $("#divAlert").html(html);
            
    });
}

function TercerFiltro()
{
    let pagina="./BACKEND/";

    $.ajax({
        url:pagina,
        type:"get",
        dataType:"json",
        cache:false,
        contentType:false,
        processData:false,
        async:true
    }).done(function(resultado){
        //console.log("estoy en el done");
        //console.log(resultado);
        let listaElementos=JSON.parse(resultado.tabla);
        //console.log(listaElementos);

        let nuevalista=listaElementos.filter(function(element,index,array){
            return  element.perfil.toLowerCase()=="encargado";
        });

        let html='<table class="table table-hover table-responsive ">';
        html+= '<tr><th>Apellido</th><th>Foto</th></tr>';
        nuevalista.forEach(element => {
            html+='<tr>';
            html+='<td>'+element.apellido +'</td>';
            html+='<td>'+'<img src="BACKEND/fotos/'+element.foto+'" width="50px"></td>';
            html+='</tr>';
        });
      html+='</table>' 
      $("#tabIzquierda").html(html);

    }).fail(function(jqXHR, textStatus, errorThrown){
        
        let respuesta=JSON.parse(jqXHR.responseText);
        console.log(respuesta);
        let html='<div class="alert alert-danger alert-dissmisable">'+"Error,no se a podido cargar la Tabla"+'</div>';
          $("#divAlert").html(html);
            
    });
}

function MiAlertInfo(mensaje)
{
    let html='<div class="alert alert-info alert-dissmisable">'+mensaje+'</div>';
    $("#divAlert").html(html);
}