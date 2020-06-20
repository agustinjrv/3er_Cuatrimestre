///<reference path="./node_modules/@types/jquery/index.d.ts"/>
///<reference path="./campera.ts"/>

namespace Test
{
    export class Manejadora
    {
        public static AgregarCampera(caso:string)
        {
            let codigo=parseInt($("#txtCodigo").val().toString());
            let nombre=($("#txtNombre").val()).toString();
            let talle=$("#txtTalle").val().toString();
            let precio=parseFloat($("#txtPrecio").val().toString());
            let color=$("#cboColores").val().toString();
            let pagina="./BACKEND/administrar.php";

            let unaCampera= new Entidades.Campera(codigo,nombre,precio,talle,color);
            let cadenaJson=JSON.stringify(unaCampera.CamperaToJson());
            let form =new FormData();
   
            if(Test.Manejadora.AdministrarValidaciones(unaCampera.CamperaToJson()))
            {
                if(caso=="agregar")
                {
                    form.append("caso",caso);
                    form.append("cadenaJson",cadenaJson);
                    

                    $.ajax({
                        type : "post",
                        url : pagina,
                        dataType : "json",
                        data: form,
                        cache: false,
                        contentType: false,
                        processData: false,
                        async:true
                    })
                    .done(function(resultado){

                        alert(resultado["TodoOK"]);
                        Test.Manejadora.MostrarCampera();
                    })
                    .fail(function(){
                        alert("Error ajax");
                    });
                    
                }
                else if(caso=="modificar")
                {
                    form.append("caso",caso);
                    form.append("cadenaJson",cadenaJson);

                    $.ajax({
                        type : "post",
                        url : pagina,
                        dataType : "json",
                        data: form,
                        cache: false,
                        contentType: false,
                        processData: false,
                        async:true
                    })
                    .done(function(resultado){

                        alert(resultado["TodoOK"]);
                        Test.Manejadora.MostrarCampera();
                    })
                    .fail(function(){
                        alert("Error ajax");
                    })
                    .always(function(){
                        $("#btnAgregar").val("Agregar");
                        $("#btnAgregar").attr("onclick",'Test.Manejadora.AgregarCampera("agregar")');
                    });    
                }
                Test.Manejadora.LimpiarForm();
            }
        }

        public static MostrarCampera()
        {
            let form =new FormData();
            form.append("caso","mostrar");
            let pagina="./BACKEND/administrar.php";

            $.ajax({
                type : "post",
                url : pagina,
                dataType : "json",
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                async:true
            })
            .done(function(resultado){
                let cadena="<table>";
                let jsonString:string="";
                resultado.forEach(element => {
                    jsonString=JSON.stringify(element);
                    cadena+="<tr>";
                    cadena+="<td> "+ element.codigo +" </td>";
                    cadena+="<td> "+ element.nombre +" </td>";
                    cadena+="<td> "+ element.precio +" </td>";
                    cadena+="<td> "+ element.talle +" </td>";
                    cadena+="<td> "+ element.color +" </td>";
                    cadena+="<td><input type='button' value='Modificar' onclick='Test.Manejadora.ModificarCampera("+jsonString+")'><td/>"
                    cadena+="<td><input type='button' value='Eliminar' onclick='Test.Manejadora.EiminarCampera("+jsonString+")'><td/>";               
                    cadena+="<tr/>";                    
                })
                cadena+="<table/>";

                $("#divTabla").html(cadena);
            })
            .fail(function()
            {
                alert("error ajax");
            });
            
        }
            
        
        public static EiminarCampera(json)
        {
            
            let pagina="./BACKEND/administrar.php";
            let form =new FormData();
            form.append("caso","eliminar");
            form.append("cadenaJson",JSON.stringify(json));
            let borrar=prompt("¿Desea eliminar la campera con codigo: "+ json.codigo + " y Talle: " + json.talle + 
            "?\n(ingrese 's' para continuar)").toLowerCase();

            if(borrar=="s")
            {
                $.ajax({
                    type : "post",
                    url : pagina,
                    dataType : "json",
                    data: form,
                    cache: false,
                    contentType: false,
                    processData: false,
                    async:true
                })
                .done(function(resultado){
    
                    alert(resultado["TodoOK"]);
                    Test.Manejadora.MostrarCampera();
                })
                .fail(function(){
                    alert("Error ajax");
                });
                Test.Manejadora.LimpiarForm();
            }
        }

        public static ModificarCampera(json)
        {
            $("#txtCodigo").val(json.codigo);
            $("#txtCodigo").attr("readonly","readonly");
            $("#txtNombre").val(json.nombre);
            $("#txtTalle").val(json.talle);
            $("#txtPrecio").val(json.precio);
            $("#cboColores").val(json.color);
            $("#btnAgregar").val("Modificar");
            $("#btnAgregar").attr("onclick",'Test.Manejadora.AgregarCampera("modificar")');
            
        }
                    
        public static FiltrarCamperasPorColor()
        {
            let form =new FormData();
            form.append("caso","mostrar");
            let pagina="./BACKEND/administrar.php";
            let color= $("#cboColores").val();

            $.ajax({
                type : "post",
                url : pagina,
                dataType : "json",
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                async:true
            })
            .done(function(resultado){
                let cadena="<table>";
                let jsonString:string="";
                resultado.forEach(element => {

                    if(color==element.color)
                    {
                        jsonString=JSON.stringify(element);
                        cadena+="<tr>";
                        cadena+="<td> "+ element.codigo +" </td>";
                        cadena+="<td> "+ element.nombre +" </td>";
                        cadena+="<td> "+ element.precio +" </td>";
                        cadena+="<td> "+ element.talle +" </td>";
                        cadena+="<td> "+ element.color +" </td>";
                        cadena+="<td><input type='button' value='Modificar' onclick='Test.Manejadora.ModificarCampera("+jsonString+")'><td/>"
                        cadena+="<td><input type='button' value='Eliminar' onclick='Test.Manejadora.EiminarCampera("+jsonString+")'><td/>";               
                        cadena+="<tr/>";                    
                    }
                    
                })
                cadena+="<table/>";

                $("#divTabla").html(cadena);
            })
            .fail(function()
            {
                alert("error ajax");
            });
        }


        public static CarjarColoresJSON()
        {
            let form =new FormData();
            form.append("caso","colores");
            let pagina="./BACKEND/administrar.php";
            let listaColores=new Array();
            let cadena="";


            $.ajax({
                type : "post",
                url : pagina,
                dataType : "json",
                data: form,
                cache: false,
                contentType: false,
                processData: false,
                async:true
            })
            .done(function(resultado){
               
                for (var i = 0; i < resultado.length; i++) {
                    let repetido = false;
                    for (var z = 0; z < listaColores.length; z++) {
                        if (listaColores[z].descripcion == resultado[i].descripcion) {
                            repetido = true;
                            break;

                        }
                    }
                    if (repetido == false) {
                        listaColores.push(resultado[i]);
                        cadena += '<option>' + resultado[i].descripcion + '</opcion>';
                    }
                }
                $('#cboColores').html(cadena);
            })
            .fail(function()
            {
                alert("error ajax");
            });

        }

        public static AdministrarValidaciones(campera):boolean
        {
            let arrayString:string[]=["S", "M","L", "X", "XL", "XX"];
            let retorno=true;
            
            if(!Test.Manejadora.ValidarCodigo(campera.codigo))
            {
                $("#spanCodigo").attr("style","display : block;");
                retorno=false;
            }
            else
            {
                $("#spanCodigo").attr("style","display : none;");
            }
            
            if(!Test.Manejadora.ValidarCamposVacios(campera.nombre))
            {
                $("#spanNombre").attr("style","display : block;");
                retorno=false;
            }
            else
            {
                $("#spanNombre").attr("style","display : none;");
            }
            
            if(!Test.Manejadora.ValidarTalles(campera.talle??"",arrayString))
            {
                $("#spanTalle").attr("style","display : block;");
                retorno=false;
            }
            else
            {
                $("#spanTalle").attr("style","display : none;");
            }

            if(!Test.Manejadora.ValidarCamposVacios((campera.precio ?? "").toString()))
            {
                $("#spanPrecio").attr("style","display : block;");
                retorno=false;
            }
            else
            {
                $("#spanPrecio").attr("style","display : none;");
            }
            
            return retorno;
  
        }

        public static ValidarCamposVacios(cadena:string):boolean
        {
            let retorno=false;
            let tam=cadena.length;
            if(tam>0)
            {
                retorno=true;
            }

            return retorno;
        }

        public static ValidarTalles(cadena:string,arrayString:string[]):boolean
        {
            let retorno=false;

            for (let i = 0; i < arrayString.length; i++) {

                if(cadena.toUpperCase()==arrayString[i].toUpperCase())
                {
                    retorno=true;
                    break;
                }
                
            }            

            return retorno;
        }


        public static ValidarCodigo(codigo:number):boolean
        {
            let retorno=false;


            if(codigo>=523 && codigo<1000)
            {
                retorno=true;
            }
        
        
            return retorno;
        }

        public static LimpiarForm()
        {
            $("#txtCodigo").val("");
            $("#txtCodigo").val("");
            $("#txtNombre").val("");
            $("#txtTalle").val("");
            $("#txtPrecio").val("");
            $("#cboColores").val("Azul");
        }

        
    }
}

