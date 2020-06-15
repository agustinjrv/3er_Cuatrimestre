///<reference path="../../node_modules/@types/jquery/index.d.ts" />

$(document).ready(function(){
    MostrarGrilla();    
});


function MostrarGrilla()
{
    
    let pagina : string = "../Backend/nuevaAdministracion.php";
    
	$.ajax({
        type: 'POST',
        url: pagina,
		data : { queHago : "mostrarGrilla"},
        dataType: "html",
        async: true
    })
	.done(function (retorno) {

		$("#divGrilla").html(retorno);
	})
	.fail(function (jqXHR, textStatus, errorThrown) {
       alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });   
}

function AgregarEmpleado():void {
	
    let pagina = "../Backend/nuevaAdministracion.php";

    let queHago ="agregar";
	let dni = $("#txtDni").val();
    let apellido = $("#txtApellido").val();
    let nombre =$("#txtNombre").val();
    let sexo =$("#cboSexo").val();
    let legajo =$("#txt_legajo").val();
    let sueldo =$("#txt_sueldo").val();
    let turno =$("#radTurno").val();
    let archivo : any = $("#Archivo")[0];
    //falta la foto
	let nuevoEmpleado :any = {};
    nuevoEmpleado.nombre=nombre;
    nuevoEmpleado.apellido=apellido;
    nuevoEmpleado.sexo=sexo;
    nuevoEmpleado.legajo=legajo;
    nuevoEmpleado.sueldo=sueldo;
    nuevoEmpleado.dni=dni;
    nuevoEmpleado.turno=turno;
    let formData = new FormData();
    
	formData.append("Archivo",archivo.files[0]);
	
    $.ajax({
        type: 'POST',
        url: pagina,
        dataType: "json",
        data: {
            nuevoEmpleado : nuevoEmpleado,
            formData : formData,
            queHago : queHago
		},
        async: true
    })
	.done(function (objJson) {
		
    	alert(objJson.Mensaje);
    
        if(objJson.exito)
        {
            $("#txtDni").val("");
            $("#txtApellido").val("");
            $("#txtNombre").val("");
            $("#cboSexo").val("---");
            $("#txt_legajo").val("");
            $("#txt_sueldo").val("");
            $("#radTurno").val("Mañana");	
		    MostrarGrilla();
        }
        
		
	})
	.fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });    
		
}
/*
function SubirFoto(){
	
    let pagina = "../Backend/nuevaAdministracion.php";
	let foto = $("#Archivo").val();
	
	if(foto === "")
	{
		return;
	}

	

	$.ajax({
        type: 'POST',
        url: pagina,
        dataType: "json",
		cache: false,
		contentType: false,
		processData: false,
        data: formData,
        async: true
    })
	.done(function (objJson) {

		if(!objJson.Exito){
			alert(objJson.Mensaje);
			return;
		}
		$("#divFoto").html(objJson.Html);
	})
	.fail(function (jqXHR, textStatus, errorThrown) {
        alert(jqXHR.responseText + "\n" + textStatus + "\n" + errorThrown);
    });   
}
*/
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