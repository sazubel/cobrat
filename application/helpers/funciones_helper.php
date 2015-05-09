<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//COMO USAR LOS HELPERS
//http://uno-de-piera.com/helpers-en-codeigniter/
 
function helper_traducir_fecha($fecha_ingles)
{		
	//TRADUCIR DIA PARA MOSTRAR<br>
    //http://lachabela.wordpress.com/2012/02/24/fechas-en-espanol-con-php-y-setlocale/
	$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado");
	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	
	$fecha = strtotime($fecha_ingles);
	//$fechatraducida =$dias[date('w',$fecha)]." ".date('d',$fecha)." de ".$meses[date('n')-1]. " del ".date('Y',$fecha);
	$fechatraducida =$dias[date('w',$fecha)]." ".date('d',$fecha);
	return $fechatraducida;					
}


function helper_dias_restantes($fecha_final) {  
        $fecha_actual = date("Y-m-d");  
        $s = strtotime($fecha_final)-strtotime($fecha_actual);  
        $d = intval($s/86400);  
        $diferencia = $d;  
        return $diferencia;  
    } 
	



