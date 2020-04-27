
function AdministrarValidaciones():void
{
    let cadenaDeError="";
    let dni=parseInt((<HTMLInputElement>document.getElementById("txtDni")).value);
    let dniMin =parseInt((<HTMLInputElement>document.getElementById("txtDni")).min);
    let dniMax =parseInt((<HTMLInputElement>document.getElementById("txtDni")).max);

    if(ValidarRangoNumerico(dni,dniMin,dniMax))
    {

    }
    else
    {
        cadenaDeError+="Error,el DNI no valido,debe ser un numero entre: " + dniMin + " y " + dniMax;
    }
    

    if(ValidarCamposVacios((<HTMLInputElement>document.getElementById("txtApellido")).value))
    {
    }
    else
    {
        cadenaDeError+="\nError,el campo Apellido no puede estar vacio";
    }
    
    if(ValidarCamposVacios((<HTMLInputElement>document.getElementById("txtNombre")).value))
    {
     
    }
    else
    {
        cadenaDeError+="\nError,el campo Nombre no puede estar vacio";
    }

    let valorCorrecto=(<HTMLInputElement>document.getElementById("cboSexo")).value;
    let valorIncorrecto="---";
    if(ValidarCombo(valorCorrecto,valorIncorrecto))
    {

    }
    else
    {
        cadenaDeError+="\nError,no a seleccionado el sexo del empleado";
    }
    
    
    

    let legajo=parseInt((<HTMLInputElement>document.getElementById("txt_legajo")).value);
    let legajoMin=parseInt((<HTMLInputElement>document.getElementById("txt_legajo")).min);
    let legajoMax=parseInt((<HTMLInputElement>document.getElementById("txt_legajo")).max);

    if(ValidarRangoNumerico(legajo,legajoMin,legajoMax))
    {

    }
    else
    {
        cadenaDeError+="\nError el Legajo no es valido,debe ser un numero entre: " + legajoMin + " y " + legajoMax;
    }

    let sueldo=parseInt((<HTMLInputElement>document.getElementById("txt_sueldo")).value);
    let sueldoMin=parseInt((<HTMLInputElement>document.getElementById("txt_sueldo")).min);
    let turno=ObtenerTurnoSeleccionado()
    let sueldoMax=ObtenerSueldoMaximo(turno);

    if(ValidarRangoNumerico(sueldo,sueldoMin,sueldoMax))
    {

    }
    else 
    {
        cadenaDeError+="\nError,para el turno " + turno +" el sueldo debe ser un numero entre: " + sueldoMin + " y " + sueldoMax;
    }

    if(ValidarCamposVacios(cadenaDeError))
    {
        alert(cadenaDeError);
        console.log(cadenaDeError);
    }
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
      //obtengo todos los inputs
      let radios : HTMLCollectionOf<HTMLInputElement> =  <HTMLCollectionOf<HTMLInputElement>> document.getElementsByTagName("input");
      let seleccionados : string = "";
      //recorro los inputs
      for (let index = 0; index < radios.length; index++) {
          let input = radios[index];
          
          if (input.type === "radio") { //verifico que sea un checkbox
              if (input.checked === true) { //verifico que este seleccionado
                  seleccionados += input.value + "-";
              }
          }
      }
      //quito el ultimo guion (-)
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
    if(flag)
    {
        (<HTMLInputElement>document.getElementById(id)).style.display="block";
    }
    else
    {
        (<HTMLInputElement>document.getElementById(id)).style.display="none";
    }
}

function VerificarValidacionesLogin(): boolean
{
    let retorno:boolean=false;
    if((<HTMLInputElement>document.getElementById("spanDni")).style.display=="none")
    {
        if((<HTMLInputElement>document.getElementById("spanApellido")).style.display=="none")
        {
            retorno=true;
        }
    }//no incluimos el verificar campos vacios y otros;

    return retorno;
}

