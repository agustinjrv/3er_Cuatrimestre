function CalculoFactorial(numero:number)
{
    var acumulador=1;
    for(var i=numero; i>1 ; i--)
    {
        acumulador=acumulador*i;
    }

    console.log("El factorial de " + numero + " es: " + acumulador);

}

CalculoFactorial(5);