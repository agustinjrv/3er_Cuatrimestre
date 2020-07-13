///<reference path="../../node_modules/@types/jquery/index.d.ts" />
///<reference path="../Entidades/Empleado.ts" />


function AgregarEmpleado(queHago):void {
	
    let pagina = "../Backend/Fabrica/";

    let nombre =($("#txtNombre").val()).toString();
    let apellido = $("#txtApellido").val().toString();
    let sexo =$("#cboSexo").val().toString();
    let legajo =parseInt($("#txt_legajo").val().toString());
    let sueldo =parseFloat($("#txt_sueldo").val().toString());
	let dni = parseInt($("#txtDni").val().toString());
    let turno =$("#radTurno").val().toString();
    let foto : any = $("#foto")[0];
    let pathFoto= $("#foto").val().toString();
 
    let unEmpleado= new Entidades.Empleado(nombre,apellido,sexo,legajo,sueldo,dni,turno,pathFoto);
    let cadenaJson = JSON.stringify(unEmpleado.ToJson());
    let form = new FormData();
    form.append("foto",foto.files[0]);
    form.append("cadenaJson",cadenaJson);
  //  form.append("queHago",queHago);
   
    $.ajax({
        url : pagina,
        type : "POST",
        dataType :"json",
        data: form,
        cache: false,
        contentType: false,
        processData: false,
        async:true
    }).done(function(respuesta){
        console.log(respuesta);
        alert("estoy en el done");
        MostrarLista();

        $("#txtNombre").val("");
        $("#txtApellido").val("");
        $("#cboSexo").val("Masculino");
        $("#txt_legajo").val("");
        $("#txt_sueldo").val("");
        $("#txtDni").val("");
        $("#radTurno").val("Mañana");
        $("#foto").val("");
        $("#btnAgregar").val("Agregar");

    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
        console.log(jqXHR.responseText);
        console.log(textStatus);
        console.log(errorThrown);
    });
		
}



function MostrarLista()
{
    
    let pagina : string = "../Backend/Fabrica/";
    
	$.ajax({
        type: 'GET',
        url: pagina,
		data : { queHago : "Mostrar"},
        dataType: "json",
        async: true
    })
	.done(function (retorno) {
        let html='<h2>Listado de Empleados</h2>';
        html+='<table alingn="center">';
        html+='<tr><td>Info</td></tr>';
        html+='<tr><td><hr></td></tr>';
       
        retorno.forEach(element => {
            let unEmpleado=new Entidades.Empleado(element.nombre,element.apellido,element.sexo,element.legajo,element.sueldo,element.dni,element.turno,element.pathFoto);
            let json=JSON.stringify(unEmpleado.ToJson());
            html+= "<tr>"+"<td>"+ unEmpleado.ToString() +"</td>";
            html+="<td>"+'<img src=../Backend/fotos/'+unEmpleado.pathFoto + 'width="90" height="90">'+"</td>";
            html+="<td>"+"<input type='button' value='Eliminar' onclick='EliminarEmpleado("+ unEmpleado.legajo +")'>"+'</td>';
            html+="<td>"+"<input type='button' value='Modificar' onclick='ModificarEmpleado("+json+")'>"+'</td>';
            html+="</tr>";

        });
        html+="</table>";

		$("#divGrilla").html(html);
	})
	.fail(function (jqXHR, textStatus, errorThrown) {
       alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });   
}


function EliminarEmpleado(legajo:number):void {
	
    let pagina = "../Backend/Administracion.php";

    let queHago ="Eliminar";

    let form = new FormData();
    form.append("legajo",legajo.toString());
    form.append("queHago",queHago);
   
    $.ajax({
        url : pagina,
        type : "post",
        dataType :"text",
        data: form,
        cache: false,
        contentType: false,
        processData: false,
        async:true
    }).done(function(respuesta){

        alert(respuesta);
        MostrarLista();

    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });
		
}

function ModificarEmpleado(unEmpleado)
{
    $("#txtNombre").val(unEmpleado.nombre);
    $("#txtApellido").val(unEmpleado.apellido);
    $("#cboSexo").val(unEmpleado.sexo);
    $("#txt_legajo").val(unEmpleado.legajo);
    

    $("#txt_sueldo").val(unEmpleado.sueldo);
    $("#txtDni").val(unEmpleado.dni);
    $("#txtDni").attr("readonly","readonly");
    $("#radTurno").val(unEmpleado.turno);
    $("#foto").attr("disabled","disabled");
    $("#foto").attr("requiered","");
    

   $("#btnAgregar").val("Modificar");
   $("#btnAgregar").attr("onclick","AgregarEmpleado('Modificar')");
}

function AdministrarValidaciones():void
{
    let dni=parseInt((<HTMLInputElement>document.getElementById("txtDni")).value);
    let dniMin =parseInt((<HTMLInputElement>document.getElementById("txtDni")).min);
    let dniMax =parseInt((<HTMLInputElement>document.getElementById("txtDni")).max);

    AdministrarSpanError("spanDni",ValidarRangoNumerico(dni,dniMin,dniMax));    
    AdministrarSpanError("spanApellido",(ValidarCamposVacios((<HTMLInputElement>document.getElementById("txtApellido")).value)));
    AdministrarSpanError("spanNombre",ValidarCamposVacios((<HTMLInputElement>document.getElementById("txtNombre")).value));

    let valorCorrecto=(<HTMLInputElement>document.getElementById("cboSexo")).value;
    AdministrarSpanError("spanSexo",ValidarCombo(valorCorrecto,"---"));
    
    let legajo=parseInt((<HTMLInputElement>document.getElementById("txt_legajo")).value);
    let legajoMin=parseInt((<HTMLInputElement>document.getElementById("txt_legajo")).min);
    let legajoMax=parseInt((<HTMLInputElement>document.getElementById("txt_legajo")).max);
    AdministrarSpanError("spanLegajo",ValidarRangoNumerico(legajo,legajoMin,legajoMax));
    
    let sueldo=parseInt((<HTMLInputElement>document.getElementById("txt_sueldo")).value);
    let sueldoMin=parseInt((<HTMLInputElement>document.getElementById("txt_sueldo")).min);
    let turno=ObtenerTurnoSeleccionado();
    let sueldoMax=ObtenerSueldoMaximo(turno);
    AdministrarSpanError("spanSueldo",ValidarRangoNumerico(sueldo,sueldoMin,sueldoMax));

    AdministrarSpanError("spanFile",ValidarCamposVacios((<HTMLInputElement>document.getElementById("inputFile")).value));
}

function VerificarValidacionesLogin(): boolean
{
    let retorno:boolean=false;
    let cadena:string=(<HTMLInputElement>document.getElementById("txtApellido")).value;
    AdministrarSpanError("spanApellido",ValidarCamposVacios(cadena));

    let numero=parseInt((<HTMLInputElement>document.getElementById("txtDni")).value);
    let min=parseInt((<HTMLInputElement>document.getElementById("txtDni")).min);
    let max=parseInt((<HTMLInputElement>document.getElementById("txtDni")).max);

    AdministrarSpanError("spanDni",ValidarRangoNumerico(numero,min,max));


    if((<HTMLInputElement>document.getElementById("spanDni")).style.display=="none")
    {
        if((<HTMLInputElement>document.getElementById("spanApellido")).style.display=="none")
        {
            retorno=true;
        }
    }

    return retorno;
}

function ValidarCamposVacios(cadena:string):boolean
{
    let retorno=false;
    let tam=cadena.length;
    if(tam>0)
    {
        retorno=true;
    }

    return retorno;
}

function ValidarRangoNumerico(numero:number, minimo:number, maximo:number): boolean
{
    let retorno=false;

    if(numero>=minimo && numero<=maximo)
    {
        retorno=true;
    }


    return retorno;
}

function ValidarCombo(cadena:string, cadenaIncorrecta:string): boolean
{
    return cadena!=cadenaIncorrecta;
}

function ObtenerTurnoSeleccionado():string
{  
      let radios : HTMLCollectionOf<HTMLInputElement> =  <HTMLCollectionOf<HTMLInputElement>> document.getElementsByTagName("input");
      let seleccionados : string = "";
   
      for (let index = 0; index < radios.length; index++) {
          let input = radios[index];
          
          if (input.type === "radio") { 
              if (input.checked === true) { 
                  seleccionados += input.value + "-";
              }
          }
      }
      
      seleccionados = seleccionados.substr(0, seleccionados.length - 1);
      console.log(seleccionados);
      return seleccionados;
}

function ObtenerSueldoMaximo(cadena:string): number
{
    let retorno=0;
    switch (cadena) {
        case "Mañana":
        retorno=20000;
            
            break;
        case "Tarde":
            retorno=18500
            break;
        case "Noche":
            retorno=25000
            break;
    }


    return retorno;
}

function AdministrarSpanError(id:string, flag:boolean): void
{
    if(!flag)
    {
        (<HTMLInputElement>document.getElementById(id)).style.display="block";
    }
    else
    {
        (<HTMLInputElement>document.getElementById(id)).style.display="none";
    }
}

function AdministrarModificar(dni:string)
{
    (<HTMLInputElement> document.getElementById("hiddenDni")).value=dni;
    let form:HTMLFormElement = <HTMLFormElement>document.getElementById('formMostrar');
    form.submit();
}

