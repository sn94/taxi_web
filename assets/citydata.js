//***********DEPARTAMENTOS Y CIUDADES */
var City_data= {
    alldata: [],
    datos_depart: [], 
    ciudadDepartSeleccionado:  function ( cual){
        let d= $( cual).val(); 
        $("input:hidden[name="+cual.substr(1)+"]").val( d.split(",").join(" ")  );
    },
    act_lista_dep: function ( sel){
        let depart= $( sel); 
        this.datos_depart.forEach( (ar, indice)=>{
            depart.append( "<option value="+ar.replace( /\s/g,",")+">"+ar+"</option>");
        } );  
    },
    act_lista_ciu: function ( sel, lst){
        let ciu= $( sel); ciu.empty();
        lst.forEach( (ar, indice)=>{ ciu.append( "<option value="+ ar.replace(/\s/g  , ",") +">"+ar+"</option>");	} ); 
        this.ciudadDepartSeleccionado(  sel);
    },
    actualizarListas:   function ( departamento, ciudad){
        let d= $(departamento).val();
        $("input:hidden[name="+departamento.substring(1)+"]").val( d.split(",").join(" ")  );
        let templist=  this.alldata.filter( (ar)=> ar.depart.replace( /\s/g,",") ==  d ).
        map( ar=>  ar.nombre); 
        this.act_lista_ciu( ciudad, templist);
    },
    pullData: function( res, O_DEPART, O_CIUDAD){
        //recoger datos
        this.alldata= res;
        //eliminar elementos redundantes
        this.datos_depart= res.map( (arr)=> arr.depart).filter( (valor,indice, arreglo)=>{ 	return arreglo.indexOf( valor )  == indice;  	}); 
        //cargar lista de departamento  
        this.act_lista_dep(  O_DEPART);  
        //inicializar input:hidden de departamento seleccionado por defecto
        this.ciudadDepartSeleccionado( O_DEPART); 
         //cargar lista de ciudades segun departamento
        this.actualizarListas(   O_DEPART,   O_CIUDAD );  
        //INICIALIZAR input:hidden de ciudad seleccionada por defecto
        this.ciudadDepartSeleccionado( O_CIUDAD); 
    },
    datosGeo:   function( O_DEPART, O_CIUDAD ){  
        this.O_DEPART= O_DEPART;  this.O_CIUDAD= O_CIUDAD;
        if( this.alldata.length == 0){
            let pullData=  this;
            $.get("/taxi_web/assets/ciudades.json", function( res){
                pullData.pullData( res, O_DEPART, O_CIUDAD );
            } );
        }else{
            this.pullData( this.alldata, O_DEPART, O_CIUDAD ); 
        }
        
    }

    
}; 

 