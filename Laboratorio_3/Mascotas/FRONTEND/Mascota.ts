namespace Entidades
{
    export class Mascota
    {
        public tamaño:string;
        public edad:number;
        public precio:number;
        
        public constructor(_tamaño:string,_edad:number,_precio:number)
        {
            this.tamaño=_tamaño;
            this.edad=_edad;
            this.precio=_precio;
        }

        public ToString():string
        {
            
            let cadena={ tamaño : this.tamaño , edad : this.edad , precio : this.precio };
            return JSON.stringify(cadena);
        }

    }
}