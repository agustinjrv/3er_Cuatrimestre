"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var Persona = /** @class */ (function () {
    function Persona(nombre, apellido, dni, sexo) {
        this._apellido = apellido;
        this._nombre = nombre;
        this._dni = dni;
        this._sexo = sexo;
    }
    Persona.prototype.GetApellido = function () {
        return this._apellido;
    };
    Persona.prototype.GetDni = function () {
        return this._dni;
    };
    Persona.prototype.GetNombre = function () {
        return this._nombre;
    };
    Persona.prototype.GetSexo = function () {
        return this._sexo;
    };
    Persona.prototype.ToString = function () {
        return this._apellido + " - " + this._nombre + " - " + this._dni + " - " + this._sexo;
    };
    return Persona;
}());
exports.Persona = Persona;
