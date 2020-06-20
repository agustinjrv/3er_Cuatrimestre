"use strict";
var Entidades;
(function (Entidades) {
    var Ropa = /** @class */ (function () {
        function Ropa(_codigo, _nombre, _precio) {
            this.codigo = _codigo;
            this.nombre = _nombre;
            this.precio = _precio;
        }
        Ropa.prototype.ropaToString = function () {
            var $unaRopa = { "codigo": this.codigo, "nombre": this.nombre, "precio": this.precio };
            return JSON.stringify($unaRopa);
        };
        return Ropa;
    }());
    Entidades.Ropa = Ropa;
})(Entidades || (Entidades = {}));
