"use strict";
var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
var ListaMeses;
(function (ListaMeses) {
    ListaMeses[ListaMeses["Enero"] = 0] = "Enero";
    ListaMeses[ListaMeses["Febrero"] = 1] = "Febrero";
    ListaMeses[ListaMeses["Marzo"] = 2] = "Marzo";
    ListaMeses[ListaMeses["Abril"] = 3] = "Abril";
    ListaMeses[ListaMeses["Mayo"] = 4] = "Mayo";
    ListaMeses[ListaMeses["Junio"] = 5] = "Junio";
    ListaMeses[ListaMeses["Julio"] = 6] = "Julio";
    ListaMeses[ListaMeses["Agosto"] = 7] = "Agosto";
    ListaMeses[ListaMeses["Septiembre"] = 8] = "Septiembre";
    ListaMeses[ListaMeses["Octubre"] = 9] = "Octubre";
    ListaMeses[ListaMeses["Noviembre"] = 10] = "Noviembre";
    ListaMeses[ListaMeses["Diciembre"] = 11] = "Diciembre";
})(ListaMeses || (ListaMeses = {}));
;
var i;
for (i = 0; i < 12; i++) {
    console.log("Mes: " + meses[i] + "--- Es " + (i + 1));
}
//# sourceMappingURL=Ejercicio_02.js.map