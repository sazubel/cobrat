<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Controlador_administracion_pagos extends CI_Controller {


	
public function agregar_cierre()
{
	$this->form_validation->set_rules('f_var_monto_de_pago', 'Monto de Pago', 'required');
	if ($this->form_validation->run() == FALSE)//validacion del formulario
			{
				$this -> load -> model ('modelos-cobrador/modelo_pagos');
				$data['listar_cierre_caja'] = $this -> modelo_pagos -> listar_cierre_caja();
				$data['titulo_pagina']="Sistema de Administracion - Creditos";
				$data['sidebar_botonera']="administracion-cobrador/admin_sidebar_menu";
				$data['admin_menu_top']="administracion-cobrador/admin_menu_top";
				$data['main_content']="administracion-cobrador/pagina_listar_cierre_caja";
				$data['boton_destacado']=4;//destaco el primer boton en la botonera de la derecha
				
				$this->load->view('administracion-cobrador/admin_template', $data);				
			}
	else{

		$monto_caja = $this -> input -> post('f_var_monto_de_pago');
		$fecha_de_pago_credito = date('Y-m-j H:i:s');
		$formulario_cierre = array(
				'monto_caja'=> $monto_caja			
            	 );		
			
		$this -> load -> model ('modelos-cobrador/modelo_pagos');	
		$this -> modelo_pagos -> calcular_cierre_caja($formulario_cierre);
		$data['listar_cierre_caja'] = $this -> modelo_pagos -> listar_cierre_caja();
		$data['titulo_pagina']="Sistema de Administracion - Creditos";
		$data['sidebar_botonera']="administracion-cobrador/admin_sidebar_menu";
		$data['admin_menu_top']="administracion-cobrador/admin_menu_top";
		$data['main_content']="administracion-cobrador/pagina_listar_cierre_caja";
		$data['boton_destacado']=4;//destaco el primer boton en la botonera de la derecha
				
	}
}
public function agregar_pago()
{		
	//if($this->session->userdata('permiso_usuario')!=1) { redirect('controlador_administracion/cerrar_cession'); }
	
	
		$this->form_validation->set_rules('f_var_monto_de_pago', 'Monto de Pago', 'required');		
		$this->form_validation->set_message('required', 'El campo %s es obligatorio');
		
		
		if ($this->form_validation->run() == FALSE)//validacion del formulario
			{
				
				$id_credito = $this -> input -> post('f_var_id_credito');
				
				//echo ('LOS DATOS INGRESADOS SON CORRECTOS');
				$this -> load -> model ('modelos-cobrador/modelo_creditos');
				$data = $this -> modelo_creditos -> mostrar_credito($id_credito);
				
				$this -> load -> model ('modelos-cobrador/modelo_pagos');
				$data['lista_pagos'] = $this -> modelo_pagos -> listar_pagos_de_un_credito($id_credito);

				$data['titulo_pagina']="Sistema de Administracion - Creditos";
				$data['sidebar_botonera']="administracion-cobrador/admin_sidebar_menu";
				$data['admin_menu_top']="administracion-cobrador/admin_menu_top";
				//$data['navegacion_rapida']="administrador/pagina_admin_navagacion_rapida";
				$data['main_content']="administracion-cobrador/pagina_listar_creditos_semanales";
				$data['boton_destacado']=4;//destaco el primer boton en la botonera de la derecha
				
				$this->load->view('administracion-cobrador/admin_template', $data);		
			}
			
			else{	
						
			$comision = $this -> input -> post('f_var_comision');
			$cuota = $this -> input -> post('f_var_cuota');
			$monto_pago = $this -> input -> post('f_var_monto_de_pago');
			$pago_comision = round(($monto_pago*$comision/$cuota),2);
			$detalle_pago = $this -> input -> post('f_var_detalle_pago');
			$fecha_pago = $this -> input -> post('f_var_fecha_pago');
			$id_credito = $this -> input -> post('f_var_id_credito');
			$id_usuario = $this -> input -> post('f_var_id_usuario');

			
			
			//CAMBIO EL FORMATO DE LA FECHA QUE ENVIA EL COMPONENTE DATEPICKER DEL TEMPLATE
			///////////////////////////////////////////////////////////////////////////////
			
			if ( empty($fecha_pago)) 
				{
				$fecha_pago = date("Y-m-d");
				}else 
					{
					$temp1 = strtotime($fecha_pago);
					$fecha_pago = date('Y-m-d', $temp1);
					}
			///////////////////////////////////////////////////////////////////////////////
			
			
			//OBTENGO LA FECHA DE PAGO DE LA TABLA DE CREDITOS
			///////////////////////////////////////////////////////////////////////////////
			$this -> load -> model ('modelos-cobrador/modelo_pagos');
		    $fecha_ideal_de_pago = $this -> modelo_pagos -> obtener_fecha_proximo_pago($id_credito);
			//$fecha_ideal_de_pago =date("Y-m-d",$fecha_ideal_de_pago);
			///////////////////////////////////////////////////////////////////////////////
			
			//ACTUALIZO LA TABLA DE CREDITOS CON LA PROXIMA FECHA DE PAGO
			///////////////////////////////////////////////////////////////////////////////
			$fecha = $fecha_ideal_de_pago;
			$fechadeproximopago = strtotime ( '+7 day' , strtotime ( $fecha ) ) ;
			$fechadeproximopago = date ( 'Y-m-j' , $fechadeproximopago );
			$fecha_ultimo_pago = $fecha_pago;
			$fecha_de_pago_credito = date('Y-m-j H:i:s');
			$this -> modelo_pagos -> actualizar_fecha_proximo_pago($id_credito);
			///////////////////////////////////////////////////////////////////////////////
			
			

			if ( empty($detalle_pago)) $detalle_pago = 'no especificado';


			$formulario_pago = array(
            	'id_credito'=> $id_credito,
				'id_usuario_que_cobro'=> $id_usuario,
				'monto_de_pago_credito'=> $monto_pago,
				'fecha_ideal_de_pago'=> $fecha_ideal_de_pago,
				'fecha_de_pago_credito'=> $fecha_de_pago_credito,
				'pago_comision' => $pago_comision,
				'detalle_de_pago'=> $detalle_pago			
            	 );		
			
			//CARGO LOS DATOS EN LA BD
			$this -> load -> model ('modelos-cobrador/modelo_pagos');	
			$this -> modelo_pagos -> alta_de_pago($formulario_pago);
						
			    //echo ('LOS DATOS INGRESADOS SON CORRECTOS');
				$this -> load -> model ('modelos-cobrador/modelo_creditos');
				$data = $this -> modelo_creditos -> mostrar_credito($id_credito);
				
				$this -> load -> model ('modelos-cobrador/modelo_pagos');
				$data['lista_pagos'] = $this -> modelo_pagos -> listar_pagos_de_un_credito($id_credito);

				$data['titulo_pagina']="Sistema de Administracion - Creditos";
				$data['sidebar_botonera']="administracion-cobrador/admin_sidebar_menu";
				$data['admin_menu_top']="administracion-cobrador/admin_menu_top";
				//$data['navegacion_rapida']="administrador/pagina_admin_navagacion_rapida";
				redirect('controladores-cobrador/controlador_administracion_pagos/listar_creditos_semanales');
				//$data['main_content']="administracion/pagina_listar_creditos_semanales";
				$data['boton_destacado']=3;//destaco el primer boton en la botonera de la derecha
				
				
				


				//MENSAJE DE EXITO DE ALTA DE USUARIO
				$data['mensajes_pago_listo']="
				<div class='notify notify-success'>

						<h3>Se ha registrado con exito el pago de $ $monto_pago</h3>
						
						<p>Gracias</p>
						
						
						</div> <!-- .notify -->";
						
													
				
				$this->load->view('administracion-cobrador/admin_template', $data);
								
			}					
}


public function listar_creditos_semanales()
{	
				$this -> load -> model ('modelos-cobrador/modelo_pagos');
				/*cargo arreglo con los resultados de la funcion listar_clientes*/
				$data['lista'] = $this -> modelo_pagos -> listar_creditos_semanales();

				$data['titulo_pagina']="Sistema de Administracion - Creditos";
				$data['sidebar_botonera']="administracion-cobrador/admin_sidebar_menu";
				$data['admin_menu_top']="administracion-cobrador/admin_menu_top";
				//$data['navegacion_rapida']="administrador/pagina_admin_navagacion_rapida";
				$data['main_content']="administracion-cobrador/pagina_listar_creditos_semanales";
				$data['boton_destacado']=4;//destaco el primer boton en la botonera de la derecha
				
				$this->load->view('administracion-cobrador/admin_template', $data);
}

public function listar_cierre_caja()
{	
				$this -> load -> model ('modelos-cobrador/modelo_pagos');
				/*cargo arreglo con los resultados de la funcion listar_clientes*/
				$data = $this -> modelo_pagos -> calcular_cierre_caja();
				$data['listar_cierre_caja'] = $this -> modelo_pagos -> listar_cierre_caja();

				$data['titulo_pagina']="Sistema de Administracion - Creditos";
				$data['sidebar_botonera']="administracion-cobrador/admin_sidebar_menu";
				$data['admin_menu_top']="administracion-cobrador/admin_menu_top";
				//$data['navegacion_rapida']="administrador/pagina_admin_navagacion_rapida";
				$data['main_content']="administracion-cobrador/pagina_listar_cierre_caja";
				$data['boton_destacado']=4;//destaco el primer boton en la botonera de la derecha
				
				$this->load->view('administracion-cobrador/admin_template', $data);
}

public function ingresar_cierre_caja()
{	
				$var_monto_de_cierre = $this -> input -> post('f_var_monto_de_cierre');
				$var_monto_comision = $this -> input -> post('f_var_monto_comision');

				$formulario_cierre = array(
            	'monto_caja'=> $var_monto_de_cierre,
				'comision_cierre'=> $var_monto_comision			
            	 );	
				$this -> load -> model ('modelos-cobrador/modelo_pagos');
				$this -> modelo_pagos -> ingresar_cierre_caja($formulario_cierre);
				$data['listar_cierre_caja'] = $this -> modelo_pagos -> listar_cierre_caja();
				redirect('controladores-cobrador/controlador_administracion_pagos/listar_cierre_caja');
/*
				$data['titulo_pagina']="Sistema de Administracion - Creditos";
				$data['sidebar_botonera']="administracion-cobrador/admin_sidebar_menu";
				$data['admin_menu_top']="administracion-cobrador/admin_menu_top";
				//$data['navegacion_rapida']="administrador/pagina_admin_navagacion_rapida";
				$data['main_content']="administracion-cobrador/pagina_listar_cierre_caja";
				$data['boton_destacado']=4;//destaco el primer boton en la botonera de la derecha
				
				$this->load->view('administracion-cobrador/admin_template', $data);*/
} 


public function mostrar_credito($id_credito)
{	
				$this -> load -> model ('modelos-cobrador/modelo_pagos');
				$data = $this -> modelo_pagos -> mostrar_credito($id_credito);
				$this -> load -> model ('modelos-cobrador/modelo_pagos');
				$data['lista_pagos'] = $this -> modelo_pagos -> listar_pagos_de_un_credito($id_credito);

				$data['titulo_pagina']="Sistema de Administracion - Creditos";
				$data['sidebar_botonera']="administracion-cobrador/admin_sidebar_menu";
				$data['admin_menu_top']="administracion-cobrador/admin_menu_top";
				//$data['navegacion_rapida']="administrador/pagina_admin_navagacion_rapida";
				$data['main_content']="administracion-cobrador/pagina_mostrar_credito";
				$data['boton_destacado']=4;//destaco el primer boton en la botonera de la derecha
				
				$this->load->view('administracion-cobrador/admin_template', $data);
}

}//class Controlador_administracion extends CI_Controller {


