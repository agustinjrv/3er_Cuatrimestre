"use strict";
function TipoDeLetra(cadena) {
    var esMayuscula = false;
    var esMinuscula = false;
    if (EsMayuscula(cadena)) {
        esMayuscula = true;
    }
    if (EsMinuscula(cadena)) {
        esMinuscula = true;
    }
    if (esMayuscula && esMinuscula) {
        console.log("La cadena: " + cadena + " esta en mayusculas y minusculas");
    }
    else if (esMayuscula) {
        console.log("La cadena: " + cadena + " esta en mayusculas");
    }
    else {
        console.log('La cadena: "' + cadena + '" esta en minusculas');
    }
}
function EsMayuscula(cadena) {
    return cadena == cadena.toUpperCase();
}
function EsMinuscula(cadena) {
    return cadena == cadena.toLocaleLowerCase();
}
TipoDeLetra("Hola Mundo");
//# sourceMappingURL=Ejercicio_10.js.map