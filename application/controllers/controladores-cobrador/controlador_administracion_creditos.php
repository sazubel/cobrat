<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controlador_administracion_creditos extends CI_Controller {

	
	function autocompletar_contacto()
	{
		if($buscar = $this->input->get('term'))
		{
			$datos_usuario = $this->db->query('select id_cliente,CONCAT(nombre_cliente," ", apellido_cliente) as value from tabla_clientes where id_zona_de_cobros = 0 and ( select nombre_cliente like "%'.$buscar.'%" or apellido_cliente like "%'.$buscar.'%")');
			
			if($datos_usuario->num_rows() > 0)
			{
				foreach ($datos_usuario->result_array() as $row)
				{
					$result[]= $row;
				}
			}
			echo json_encode($result);
		}
	}	
	
public function agregar_credito()
{		
	//if($this->session->userdata('permiso_usuario')!=1) { redirect('controlador_administracion/cerrar_cession'); }
	
		$this->form_validation->set_rules('f_var_id_cliente', 'Cliente', 'required');
		$this->form_validation->set_rules('f_var_tipo_credito', 'Tipo de Credito', 'required');
		$this->form_validation->set_rules('f_var_cant_cuotas', 'Cantidad Cuotas', 'required');
		$this->form_validation->set_rules('f_var_monto_cuota', 'Monto', 'required');
		$this->form_validation->set_rules('f_var_monto_prestamo', 'Prestamo', 'required');
		$this->form_validation->set_message('required', 'El campo %s es obligatorio');
/*
			echo $f_var_id_cliente = $this -> input -> post('f_var_id_cliente')."<br>";
			echo $f_var_tipo_credito = $this -> input -> post('f_var_tipo_credito')."<br>";
			echo $f_var_cant_cuotas = $this -> input -> post('f_var_cant_cuotas')."<br>";
			echo $f_var_monto_cuota = $this -> input -> post('f_var_monto_cuota')."<br>";
			echo $f_var_monto_prestamo = $this -> input -> post('f_var_monto_prestamo')."<br>";
			echo $f_var_id_zona_cobros = $this -> input -> post('f_var_id_zona_cobros')."<br>";
*/		
		
		if ($this->form_validation->run() == FALSE)//validacion del formulario
			{
				//echo ('LOS DATOS INGRESADOS SON CORRECTOS');
				$this -> load -> model ('modelos-cobrador/modelo_creditos');
				$data['tipos_de_creditos'] = $this -> modelo_creditos -> tipos_de_creditos();
				$data['titulo_pagina']="Sistema de Administracion - Agregar Creditos al Sistema";
				$data['sidebar_botonera']="administracion-cobrador/admin_sidebar_menu";
				$data['admin_menu_top']="administracion-cobrador/admin_menu_top";
				$data['main_content']="administracion-cobrador/pagina_agregar_credito";
				$data['boton_destacado']=3;//destaco el primer boton en la botonera de la derecha
				
				$this->load->view('administracion-cobrador/admin_template', $data);		
			}
			
			else{				
			$f_var_id_cliente = $this -> input -> post('f_var_id_cliente');
			$f_var_tipo_credito = $this -> input -> post('f_var_tipo_credito');
			$f_var_cant_cuotas = $this -> input -> post('f_var_cant_cuotas');
			$f_var_monto_cuota = $this -> input -> post('f_var_monto_cuota');
			$f_var_monto_prestamo = $this -> input -> post('f_var_monto_prestamo');
			$f_var_detalle_credito = $this -> input -> post('f_var_detalle_credito');
			$f_var_fecha_entrega = $this -> input -> post('f_var_fecha_entrega');
			$f_var_fecha_1er_pago = $this -> input -> post('f_var_fecha_1er_pago');
			$f_var_id_zona_cobros = $this -> input -> post('f_var_id_zona_cobros');
			$f_var_id_dia_cobranza = $this -> input -> post('f_var_id_dia_cobranza');
			
			
			//CAMBIO EL FORMATO DE LA FECHA QUE ENVIA EL COMPONENTE DATEPICKER DEL TEMPLATE
			$temp1 = strtotime($f_var_fecha_entrega); 
			$temp2 = strtotime($f_var_fecha_1er_pago);      			
			$f_var_fecha_entrega = date('Y-m-d', $temp1);
			$f_var_fecha_1er_pago = date('Y-m-d', $temp2);
			///////////////////////////////////////////////////////////////////////////////
			

			//if ( empty($f_var_email)) $f_var_email = 'no especificado';
			//if (empty($f_var_direccion_gmap)) $f_var_direccion_gmap = 'no especificado';
			//if (empty($f_var_adicional)) $f_var_adicional = 'no especificado';
			
			//TODO EL ID DEL USUARIO QUE ESTA REGISTRANDO EL CREDITO
			$f_var_id_usuario = $this->session->userdata('id_usuario');
			
			//DEBO CALCULAR LA FECHA DE FIN DEL CREDITO
			$fecha_fin_credito = date("Y-m-d");
			
			//EL PRIMER ESTADO DEL CREDITO ES ACTIVO
			$estado_credito = 1;
			$pago_comision = round((($f_var_cant_cuotas * $f_var_monto_cuota-$f_var_monto_prestamo)*0.14)/$f_var_cant_cuotas,2);

			$formulario_creditos = array(
            	'id_usuario'=> $f_var_id_usuario,
				'id_cliente'=> $f_var_id_cliente,
				'id_tipo_credito'=> $f_var_tipo_credito,
				'cantidad_cuotas'=> $f_var_cant_cuotas,
				'monto_cuota'=> $f_var_monto_cuota,
				'capital_costo_invertido'=> $f_var_monto_prestamo,
				'detalle_credito'=> $f_var_detalle_credito,
				'fecha_entrega_del_bien'=> $f_var_fecha_entrega,
				'fecha_proximo_pago'=> "1970-01-01",
				'fecha_fin_credito'=> $fecha_fin_credito,
				'estado_credito'=> $estado_credito,
				'id_zona_de_cobros'=> $f_var_id_zona_cobros,
				'id_dia_cobranza'=> $f_var_id_dia_cobranza,
				'comision' => $pago_comision
            	 );		
			
			//CARGO LOS DATOS EN LA BD
			$this -> load -> model ('modelos-cobrador/modelo_creditos');	
			$this -> modelo_creditos -> alta_de_credito($formulario_creditos);
						
			    $data['titulo_pagina']="Sistema de Administracion - Agregar Creditos al Sistema";
				$data['sidebar_botonera']="administracion-cobrador/admin_sidebar_menu";
				$data['admin_menu_top']="administracion-cobrador/admin_menu_top";
				//$data['navegacion_rapida']="administrador/pagina_admin_navagacion_rapida";
				$data['main_content']="administracion-cobrador/pagina_agregar_credito";
				$data['boton_destacado']=3;//destaco el primer boton en la botonera de la derecha
				
				


				//MENSAJE DE EXITO DE ALTA DE USUARIO
				$data['mensajes']="
				<div class='notify notify-success'>

						<h3>Se ha registrado con exito el credito de $ $f_var_monto_prestamo</h3>
						
						<p>El credito se ha registrado con exito</p>
						
						<p>
						<table class='table table-striped'>
						<thead>
							<tr>
								<th></th>
								<th>Datos del Crédito</th>
							</tr>
						</thead>
						<tbody>
							<tr class='odd gradeX'>
								<td>Tipo de Credito</td>
								<td>$f_var_tipo_credito </td>
							</tr>
							<tr class='even gradeC'>
								<td>Cantidad de Cuotas:</td>
								<td>$f_var_cant_cuotas</td>
							</tr>
							<tr class='odd gradeA'>
								<td>Monto de la cuota</td>
								<td>$f_var_monto_cuota</td>
							</tr>
							
							</tbody>
						</table>
						</p>
						</div> <!-- .notify -->";
						
													
				
				$this->load->view('administracion-cobrador/admin_template', $data);
								
			}					
}






public function listar_creditos()
{	
				$this -> load -> model ('modelos-cobrador/modelo_creditos');
				/*cargo arreglo con los resultados de la funcion listar_clientes*/
				$data['lista'] = $this -> modelo_creditos -> listar_creditos();

				$data['titulo_pagina']="Sistema de administracion-cobrador - Creditos";
				$data['sidebar_botonera']="administracion-cobrador/admin_sidebar_menu";
				$data['admin_menu_top']="administracion-cobrador/admin_menu_top";
				//$data['navegacion_rapida']="administrador/pagina_admin_navagacion_rapida";
				$data['main_content']="administracion-cobrador/pagina_listar_creditos";
				$data['boton_destacado']=3;//destaco el primer boton en la botonera de la derecha
				
				$this->load->view('administracion-cobrador/admin_template', $data);
}


public function mostrar_credito($id_credito)
{	
				$this -> load -> model ('modelos-cobrador/modelo_creditos');
				$data = $this -> modelo_creditos -> mostrar_credito($id_credito);
				
				$this -> load -> model ('modelos-cobrador/modelo_pagos');
				$data['lista_pagos'] = $this -> modelo_pagos -> listar_pagos_de_un_credito($id_credito);

				$data['titulo_pagina']="Sistema de administracion-cobrador - Creditos";
				$data['sidebar_botonera']="administracion-cobrador/admin_sidebar_menu";
				$data['admin_menu_top']="administracion-cobrador/admin_menu_top";
				//$data['navegacion_rapida']="administrador/pagina_admin_navagacion_rapida";
				$data['main_content']="administracion-cobrador/pagina_mostrar_credito";
				$data['boton_destacado']=3;//destaco el primer boton en la botonera de la derecha
				
				$this->load->view('administracion-cobrador/admin_template', $data);
}









}//class Controlador_administracion extends CI_Controller {


