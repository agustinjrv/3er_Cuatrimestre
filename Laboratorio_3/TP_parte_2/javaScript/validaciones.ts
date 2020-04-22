


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
    return cadena==cadenaIncorrecta;
}

function ObtenerTurnoSeleccionado(): string
{  
    let turnos= <HTMLCollectionOf<HTMLInputElement>> document.getElementsByTagName("radTurno")
    let retorno="";           
    for(let i=0;i<3;i++)
    {
        if(turnos[i].checked)
        {
            retorno=turnos[i].value;
        }
    }

    return retorno;
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

function AdministrarValidaciones()
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
        cadenaDeError+="\nError el DNI no valido,debe ser un numero entre: " + dniMin + " y " + dniMax;
    }
    

    if(ValidarCamposVacios((<HTMLInputElement>document.getElementById("txtApellido")).value))
    {
    }
    else
    {
        cadenaDeError="Error,el campo Apellido no puede estar vacio";
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

    alert(cadenaDeError);
    console.log(cadenaDeError);
}