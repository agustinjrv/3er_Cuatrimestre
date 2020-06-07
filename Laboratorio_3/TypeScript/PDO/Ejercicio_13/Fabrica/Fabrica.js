"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var Fabrica = /** @class */ (function () {
    function Fabrica(razonSocial) {
        this._empleados = [];
        this._razonSocial = razonSocial;
    }
    Fabrica.prototype.AgregarEmpleado = function (persona) {
        var retorno = true;
        this._empleados.forEach(function (e) {
            if (e.GetNombre() == persona.GetNombre() && e.GetApellido() == persona.GetApellido()) {
                retorno = false;
            }
        });
        if (retorno) {
            this._empleados.push(persona);
        }
        return retorno;
    };
    Fabrica.prototype.CalcularSueldos = function () {
        var acumulador = 0;
        this._empleados.forEach(function (e) {
            acumulador += e.GetSueldo();
        });
        return acumulador;
        ;
    };
    Fabrica.prototype.EliminarEmpleado = function (persona) {
        var _this = this;
        var retorno = false;
        var contador = 0;
        this._empleados.forEach(function (e) {
            if (persona.GetApellido() == e.GetApellido() && persona.GetNombre() == e.GetNombre()) {
                _this._empleados.splice(contador, 1);
                retorno = true;
            }
            contador++;
        });
        return retorno;
    };
    Fabrica.prototype.ToString = function () {
        var cadena = "";
        cadena += "Razon Social: " + this._razonSocial + "\n" +
            "Sueldo Total: " + this.CalcularSueldos();
        this._empleados.forEach(function (e) {
            cadena += e.ToString() + "\n";
        });
        return cadena;
    };
    return Fabrica;
}());
exports.Fabrica = Fabrica;
