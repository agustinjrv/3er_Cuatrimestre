function TipoDeLetra(cadena:string)
{
    var esMayuscula=false;
    var esMinuscula=false;
    

    if(EsMayuscula(cadena))
    {
        esMayuscula=true;
    }
    if(EsMinuscula(cadena))
    {
        esMinuscula=true;
    }
    
    if(esMayuscula && esMinuscula)
    {
        console.log("La cadena: " + cadena + " esta en mayusculas y minusculas");
    }
    else if(esMayuscula)
    {
        console.log("La cadena: " + cadena + " esta en mayusculas");
    }
    else
    {
        console.log('La cadena: "' + cadena + '" esta en minusculas');
    }




}

function EsMayuscula(cadena:string):boolean
{
    return cadena==cadena.toUpperCase();
}

function EsMinuscula(cadena:string):boolean
{
    return cadena==cadena.toLocaleLowerCase();
}


TipoDeLetra("Hola Mundo");