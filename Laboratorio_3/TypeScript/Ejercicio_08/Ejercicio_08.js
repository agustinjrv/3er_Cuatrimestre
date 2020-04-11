"use strict";
function CalculoFactorial(numero) {
    var acumulador = 1;
    for (var i = numero; i > 1; i--) {
        acumulador = acumulador * i;
    }
    console.log("El factorial de " + numero + " es: " + acumulador);
}
CalculoFactorial(5);
//# sourceMappingURL=Ejercicio_08.js.map