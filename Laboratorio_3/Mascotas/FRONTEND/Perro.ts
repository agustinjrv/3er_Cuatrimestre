/// <reference path="Mascota.ts" />


namespace Entidades
{
    export class Perro extends Mascota
    {
        public nombre:string;
        public raza:string;
        public pathFoto:string;

        public constructor(_tamaño:string,_edad:number,_precio:number,_nombre:string,_raza:string,_pathFoto:string)
        {
            super(_tamaño,_edad,_precio);
            this.nombre=_nombre;
            this.raza=_raza;
            this.pathFoto=_pathFoto;
        }

        public ToJson()
        {
            let cadena=super.ToString();
            let perroJson=JSON.parse(cadena);
            perroJson["nombre"]=this.nombre;
            perroJson["raza"]=this.raza;
            perroJson["pathFoto"]=this.pathFoto;
            return perroJson;
        }


    }
}