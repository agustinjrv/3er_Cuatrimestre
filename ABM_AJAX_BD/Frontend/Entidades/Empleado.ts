namespace Entidades
{
    export class Empleado
    {
        private nombre:string;
        private apellido:string;
        private sexo:string;
        public legajo:number;
        private sueldo:number;
        private dni:number;
        private turno:string;
        public pathFoto:string;

        public constructor(_nombre:string,_apellido:string,_sexo:string,_legajo:number,
                            _sueldo:number,_dni:number,_turno:string,_pathFoto:string){
        
        this.nombre=_nombre;
        this.apellido=_apellido;
        this.sexo=_sexo;
        this.legajo=_legajo;
        this.sueldo=_sueldo;
        this.dni=_dni;
        this.turno=_turno;
        this.pathFoto=_pathFoto
        }

        public ToString():string
        {
            return this.nombre+" - " + this.apellido+" - " + this.sexo+" - " + this.legajo+" - " + this.sueldo+" - " + this.turno+" - " + this.pathFoto;
        }
        
        public ToJson()
        {
            let Json={};
            Json["nombre"]=this.nombre;
            Json["apellido"]=this.apellido;
            Json["sexo"] = this.sexo;
            Json["legajo"] = this.legajo;
            Json["sueldo"] = this.sueldo;
            Json["dni"] = this.dni;
            Json["turno"] = this.turno;
            Json["pathFoto"] = this.pathFoto;

            return Json;
        }
        
        
    }

}
