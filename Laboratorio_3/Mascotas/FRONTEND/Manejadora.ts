/// <reference path="./Perro.ts" />
/// <reference path="../node_modules/@types/jquery/index.d.ts" />

namespace PrimerParcial
{
    export class Manejadora
    {
        public static AgregarPerroJSON()
        {
            let tamaño=$("#tamaño").val().toString();
            let edad=parseInt($("#edad").val().toString());
            let precio=parseFloat($("#precio").val().toString());
            let nombre=$("#nombre").val().toString();
            let raza=$("#raza").val().toString();
            let pagina="./BACKEND/agregar_json.php";
            let path = $("#foto").val().toString();
            let foto : any = $("#foto")[0];
            
            let form = new FormData();
            let unPerro = new Entidades.Perro(tamaño,edad,precio,nombre,raza,path);
            let cadenaJson =JSON.stringify(unPerro.ToJson());
            form.append("caso","agregar");
            form.append("cadenaJson",cadenaJson);
            form.append("foto",foto.files[0]);

            $.ajax({
                url : pagina,
                type : "post",
                dataType : "json",
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                async:true
            }).done(function(respuesta){
                alert(respuesta.ok);
                unPerro.pathFoto=respuesta.pathFoto;

            }).fail(function(){
                console.log("error,ajax");
            });
        }

        public static MostrarPerrosJSON()
        {
            let pagina="./BACKEND/traer_json.php";

            $.ajax({
                url : pagina,
                type : "post",
                dataType : "json",
                cache: false,
                contentType: false,
                processData: false,
                async:true
            }).done(function(respuesta){
               // tamaño,edad,precio,nombre,raza,path
                let cadena:string="<table>";
                respuesta.forEach(element => {
                    cadena+="<tr>";
                    cadena+="<td>" + element.tamaño + "<td/>";
                    cadena+="<td>" + element.edad + "<td/>";
                    cadena+="<td>" + element.precio + "<td/>";
                    cadena+="<td>" + element.nombre + "<td/>";
                    cadena+="<td>" + element.raza + "<td/>";
                    cadena+="<td>" +' <img src="./BACKEND/fotos/'+element.pathFoto + '" height="50px" width="50px" /> ' + "<td/>";
                    cadena+="<tr/>";
                });

                $("#divTabla").html(cadena);
            }).fail(function(){
                console.log("error,ajax");
            });
        }

        public static AgregarPerroEnBaseDatos()
        {
            let tamaño=$("#tamaño").val().toString();
            let edad=parseInt($("#edad").val().toString());
            let precio=parseFloat($("#precio").val().toString());
            let nombre=$("#nombre").val().toString();
            let raza=$("#raza").val().toString();
            let pagina="./BACKEND/agregar_bd.php";
            let path = $("#foto").val().toString();
            let foto : any = $("#foto")[0];
            
            let form = new FormData();
            let unPerro = new Entidades.Perro(tamaño,edad,precio,nombre,raza,path);
            let cadenaJson =JSON.stringify(unPerro.ToJson());
            form.append("cadenaJson",cadenaJson);
            form.append("foto",foto.files[0]);

            $.ajax({
                url : pagina,
                type : "post",
                dataType : "json",
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                async:true
            }).done(function(respuesta){
                alert("ok: "+respuesta.ok+ "\nbd: " + respuesta.bd);
                unPerro.pathFoto=respuesta.pathFoto;

            }).fail(function(){
                console.log("error,ajax");
            });
        }

        public static VerificarExistencia()
        {
            let tamaño=$("#tamaño").val().toString();
            let edad=parseInt($("#edad").val().toString());
            let precio=parseFloat($("#precio").val().toString());
            let nombre=$("#nombre").val().toString();
            let raza=$("#raza").val().toString();            
            let path = $("#foto").val().toString();
            let foto : any = $("#foto")[0];
            
            let unPerro = new Entidades.Perro(tamaño,edad,precio,nombre,raza,path);
            let pagina="./BACKEND/traer_bd.php";
            $.ajax({
                url : pagina,
                type : "post",
                dataType : "json",
                cache: false,
                contentType: false,
                processData: false,
                async:true
            }).done(function(respuesta){

                let encontro=false;
                for (let i = 0; i < respuesta.length; i++) 
                {
                    if(respuesta[i].edad==unPerro.edad && respuesta[i].raza == unPerro.raza)
                    {            
                        encontro=true;
                        break;
                    }
                }
                if(encontro)
                {
                    alert("El perro ya existe");
                    console.log("El perro ya existe");
                }
                else
                {
                    PrimerParcial.Manejadora.AgregarPerroEnBaseDatos();
                }


            }).fail(function(){
                console.log("error,ajax");
            });


        }

        public static MostrarPerrosBaseDatos()
        {
            let pagina="./BACKEND/traer_bd.php";
            $.ajax({
                url : pagina,
                type : "post",
                dataType : "json",
                cache: false,
                contentType: false,
                processData: false,
                async:true
            }).done(function(respuesta){                
                 let cadena:string="<table>";
                 respuesta.forEach(element => {
                     cadena+="<tr>";
                     cadena+="<td>" + element.tamaño + "<td/>";
                     cadena+="<td>" + element.edad + "<td/>";
                     cadena+="<td>" + element.precio + "<td/>";
                     cadena+="<td>" + element.nombre + "<td/>";
                     cadena+="<td>" + element.raza + "<td/>";
                     cadena+="<td>" +' <img src="./BACKEND/fotos/'+element.pathFoto + '" height="50px" width="50px" /> ' + "<td/>";
                     cadena+="<tr/>";
                 });
 
                 $("#divTabla").html(cadena);
             }).fail(function(){
                 console.log("error,ajax");
             });
        }
    }




}
