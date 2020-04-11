EsPar(4);
EsPar(5);
EsPar(128);
EsPar(365);

function EsPar(numero:number)
{
    if(numero%2==0)
    {
        console.log("El numero " + numero + " es par");
    }
    else
    {
        console.log("El numero " + numero + " es inpar");
    }
}