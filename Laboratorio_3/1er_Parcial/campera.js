"use strict";
/// <reference path="./ropa.ts" />
var __extends = (this && this.__extends) || (function () {
    var extendStatics = function (d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
        return extendStatics(d, b);
    };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var Entidades;
(function (Entidades) {
    var Campera = /** @class */ (function (_super) {
        __extends(Campera, _super);
        function Campera(_codigo, _nombre, _precio, _talle, _color) {
            var _this = _super.call(this, _codigo, _nombre, _precio) || this;
            _this.talle = _talle;
            _this.color = _color;
            return _this;
        }
        Campera.prototype.CamperaToJson = function () {
            var cadena;
            cadena = _super.prototype.ropaToString.call(this);
            var camperaJson = JSON.parse(cadena);
            camperaJson["talle"] = this.talle;
            camperaJson["color"] = this.color;
            return camperaJson;
        };
        return Campera;
    }(Entidades.Ropa));
    Entidades.Campera = Campera;
})(Entidades || (Entidades = {}));
