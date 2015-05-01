<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Controlador_administracion_clientes extends CI_Controller {

public function validar_dni2()
{
 $usr=$this->input->post('name');
 $this->load->model('modelos-cobrador/modelo_clientes');
 $result=$this->modelo_clientes->validar_dni2($usr);
 if($result)
 {
  echo 1;
  }
 else{
  echo 0;
  }
}

public function validar_dni()
{
	$validateValue=$this->input->get("fieldValue");
	$validateId=$this->input->get("fieldId");
	$this->load->model('modelos-cobrador/modelo_clientes');
	$num = $this->modelo_clientes->validar_dni($validateValue);
	/* RETURN VALUE */
	$arrayToJs = array();
	$arrayToJs[0] = $validateId;
	//$arrayToJs[0] = "var_dni";

$validateError= "This username is already taken";
$validateSuccess= "This username is available";
if($num != 1){		// validate??
	$arrayToJs[1] = true;			// RETURN TRUE

}else{
	for($x=0;$x<1000000;$x++){
		if($x == 990000){
			$arrayToJs[1] = false;

		}
	}

}
echo json_encode($arrayToJs);
}


public function agregar_cliente()
{		
	//if($this->session->userdata('permiso_usuario')!=1) { redirect('controlador_administracion/cerrar_cession'); }
	
	
		$this->form_validation->set_rules('f_var_nombres', 'Nombres', 'required');
		$this->form_validation->set_rules('f_var_apellido', 'Apellido', 'required');
		$this->form_validation->set_rules('f_var_dni', 'DNI', 'required');
		$this->form_validation->set_rules('f_var_telefono', 'Telefono', 'required');
		$this->form_validation->set_rules('f_var_celular', 'Celular', '');
		$this->form_validation->set_rules('f_var_nacimiento', 'Fecha de Nacimiento', '');
		$this->form_validation->set_rules('f_var_direccion', 'Direccion', '');
		/*mensajes de validacion*/
		$this->form_validation->set_message('required', 'El campo %s es obligatorio');
		
		
		if ($this->form_validation->run() == FALSE)//validacion del formulario
			{
				//echo ('LOS DATOS INGRESADOS SON CORRECTOS');
				$data['titulo_pagina']="Sistema de Administracion - Agregar Clientes al Sistema";
				$data['sidebar_botonera']="administracion/admin_sidebar_menu";
				$data['admin_menu_top']="administracion/admin_menu_top";
				//$data['navegacion_rapida']="administrador/pagina_admin_navagacion_rapida";
				$data['main_content']="administracion/pagina_agregar_clientes";
				$data['boton_destacado']=2;//destaco el primer boton en la botonera de la derecha
				
				$this->load->view('administracion/admin_template', $data);		
			}
			
			else{				
			$f_var_nombres = $this -> input -> post('f_var_nombres');
			$f_var_apellido = $this -> input -> post('f_var_apellido');
			$f_var_dni = $this -> input -> post('f_var_dni');
			$f_var_email = $this -> input -> post('f_var_email');
			$f_var_telefono = $this -> input -> post('f_var_telefono');
			$f_var_celular = $this -> input -> post('f_var_celular');
			$f_var_nacimiento = $this -> input -> post('f_var_nacimiento');
			$f_var_direccion = $this -> input -> post('f_var_direccion');
			$f_var_direccion_gmap = $this -> input -> post('f_var_direccion_gmap');
			$f_var_adicional = $this -> input -> post('f_var_adicional');
			
			if (empty($f_var_email)) $f_var_email = 'no especificado';
			if (empty($f_var_direccion_gmap)) $f_var_direccion_gmap = 'no especificado';
			if (empty($f_var_adicional)) $f_var_adicional = 'no especificado';
			
			$fecha_alta_cliente = date("Y-m-d");   

			$formulario_clientes = array(
            	'nombre_cliente'=> $f_var_nombres,
				'apellido_cliente'=> $f_var_apellido,
				'dni_cliente'=> $f_var_dni,
				'email_cliente'=> $f_var_email,
				'telefono_fijo_cliente'=> $f_var_telefono,
				'celular_cliente'=> $f_var_celular,
				'fecha_nac_cliente'=> $f_var_nacimiento,
				'direccion_cliente'=> $f_var_direccion,
				'direcciongmap_cliente'=> $f_var_direccion_gmap,
				'detalles_cliente'=> $f_var_adicional,
				'fecha_alta_cliente'=> $fecha_alta_cliente
            	 );		
			
			//CARGO LOS DATOS EN LA BD
			$this -> load -> model ('modelos-admin/modelo_clientes');	
			$this -> modelo_clientes -> alta_de_clientes($formulario_clientes);
						
			//echo ('LOS DATOS INGRESADOS SON CORRECTOS');
				$data['titulo_pagina']="Sistema de Administracion - Agregar Clientes al Sistema";
				$data['sidebar_botonera']="administracion/admin_sidebar_menu";
				$data['admin_menu_top']="administracion/admin_menu_top";
				//$data['navegacion_rapida']="administrador/pagina_admin_navagacion_rapida";
				$data['main_content']="administracion/pagina_agregar_clientes";
				$data['boton_destacado']=2;//destaco el primer boton en la botonera de la derecha


				//MENSAJE DE EXITO DE ALTA DE USUARIO
				$data['mensajes']="
				<div class='notify notify-success'>

						<h3>El cliente $f_var_nombres $f_var_apellido ha sido dado de alta en el sistema</h3>
						
						<p>El cliente <strong> $f_var_nombres $f_var_apellido </strong> acaba de ser dado de alta en nuestro sistema, ahora puede asignarle un crédito.</p>
						
						<p>
						<table class='table table-striped'>
						<thead>
							<tr>
								<th></th>
								<th>Datos</th>
							</tr>
						</thead>
						<tbody>
							<tr class='odd gradeX'>
								<td>Nombre y apellido</td>
								<td>$f_var_nombres $f_var_apellido </td>
							</tr>
							<tr class='even gradeC'>
								<td>DNI de $f_var_nombres $f_var_apellido</td>
								<td>$f_var_dni</td>
							</tr>
							<tr class='odd gradeA'>
								<td>Telefonos</td>
								<td>Tel: $f_var_telefono - Cel: $f_var_celular</td>
							</tr>
							<tr class='even gradeA'>
								<td>Direccion de $f_var_nombres $f_var_apellido</td>
								<td>$f_var_direccion</td>
							</tr>
							</tbody>
						</table>
						</p>
						</div> <!-- .notify -->";
								
				$this->load->view('administracion/admin_template', $data);					
			}					
}






public function listar_clientes()
{	
				$this -> load -> model ('modelos-admin/modelo_clientes');
				/*cargo arreglo con los resultados de la funcion listar_clientes*/
				$data['lista'] = $this -> modelo_clientes -> listar_clientes();

				$data['titulo_pagina']="Sistema de Administracion - Clientes";
				$data['sidebar_botonera']="administracion/admin_sidebar_menu";
				$data['admin_menu_top']="administracion/admin_menu_top";
				//$data['navegacion_rapida']="administrador/pagina_admin_navagacion_rapida";
				$data['main_content']="administracion/pagina_listar_clientes";
				$data['boton_destacado']=2;//destaco el primer boton en la botonera de la derecha
				
				$this->load->view('administracion/admin_template', $data);

}









}//class Controlador_administracion extends CI_Controller {


