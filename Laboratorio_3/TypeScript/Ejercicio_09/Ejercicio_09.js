"use strict";
function PedirNumero(numero) {
    if (numero > -1) {
        CalculoFactorial(numero);
    }
    else {
        console.log("El numero:" + numero + " al cubo es: " + AlCubo(numero));
    }
}
function CalculoFactorial(numero) {
    var acumulador = 1;
    for (var i = numero; i > 1; i--) {
        acumulador = acumulador * i;
    }
    console.log("El factorial de " + numero + " es: " + acumulador);
}
function AlCubo(numero) {
    var acumulador = numero * numero * numero;
    return acumulador;
}
PedirNumero(-5);
//# sourceMappingURL=Ejercicio_09.js.map