"use strict";
function MostrarNombreApellido(nombre, apellido) {
    var letra = nombre.charAt(0);
    nombre.replace(letra, letra.toLocaleUpperCase());
    console.log(apellido.toUpperCase() + "--" + nombre);
}
MostrarNombreApellido("agustin", "Rivola");
//# sourceMappingURL=Ejercicio_05.js.map