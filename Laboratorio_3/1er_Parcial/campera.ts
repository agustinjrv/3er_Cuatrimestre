/// <reference path="./ropa.ts" />

namespace Entidades
{
    export class Campera extends Ropa
    {
        public talle : string;
        public color : string;

        public constructor(_codigo:number,_nombre:string,_precio:number,_talle:string,_color:string)
        {
            super(_codigo,_nombre,_precio);
            this.talle=_talle;
            this.color=_color;
        }

        public CamperaToJson()
        {
            let cadena:string;
            cadena=super.ropaToString();
            let camperaJson=JSON.parse(cadena);
            camperaJson["talle"]=this.talle;
            camperaJson["color"]=this.color;

            return camperaJson;
        }

    }
}