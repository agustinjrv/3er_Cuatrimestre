namespace Entidades
{
    export class Ropa
    {
        public codigo:number;
        public nombre:string;
        public precio:number;

        public constructor(_codigo:number,_nombre:string,_precio:number)
        {
            this.codigo=_codigo;
            this.nombre=_nombre;
            this.precio=_precio;
        }

        public ropaToString()
        {
            let $unaRopa={"codigo" : this.codigo,"nombre" : this.nombre, "precio" : this.precio}

            return JSON.stringify($unaRopa);
        }

    }



}
