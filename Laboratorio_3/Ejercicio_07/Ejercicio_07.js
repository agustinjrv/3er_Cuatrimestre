"use strict";
BuscadorDeNumerosPrimos(20);
function BuscadorDeNumerosPrimos(limite) {
    var contador = 0;
    var contadorDePrimos = 0;
    var esPrimo = true;
    var contador = 0;
    var numero = 2;
    var j = 0;
    do {
        esPrimo = true;
        for (j = 1; j < numero; j++) {
            if (numero % j == 0) {
                contador++;
                if (contador == 3) {
                    esPrimo = false;
                    break;
                }
            }
        }
        if (esPrimo) {
            contadorDePrimos++;
            console.log(numero);
        }
        numero++;
    } while (contador < limite);
}
//# sourceMappingURL=Ejercicio_07.js.map