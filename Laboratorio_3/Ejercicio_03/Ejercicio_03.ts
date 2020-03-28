Ejercicio_03(8);





function Ejercicio_03(numero:number ,cadena?:string)
{
    if(cadena)
    {
        for(var i=0 ;i<numero;i++)
        {
            console.log(cadena);
        }
    }
    else 
    {
        numero=-numero;
        console.log(numero);
    }   
}

