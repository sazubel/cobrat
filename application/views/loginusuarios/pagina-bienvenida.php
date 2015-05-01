<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
<?php ini_set ('display_errors', '1'); ?>
	<title>Canvas Admin - Login</title>

	<meta charset="utf-8" />
	<meta name="description" content="" />
	<meta name="author" content="" />		
	<meta name="viewport" content="width=device-width,initial-scale=1" />
	
	<link rel="stylesheet" href="<?php  echo  base_url();?>stylesheets/reset.css" type="text/css" media="screen" title="no title" />
	<link rel="stylesheet" href="<?php  echo  base_url();?>stylesheets/text.css" type="text/css" media="screen" title="no title" />
	<link rel="stylesheet" href="<?php  echo  base_url();?>stylesheets/buttons.css" type="text/css" media="screen" title="no title" />
	<link rel="stylesheet" href="<?php  echo  base_url();?>stylesheets/theme-default.css" type="text/css" media="screen" title="no title" />
	<link rel="stylesheet" href="<?php  echo  base_url();?>stylesheets/login.css" type="text/css" media="screen" title="no title" />
</head>

<body>

<div id="login">
	<h1>Dashboard</h1>
	<div id="login_panel">
		<!--<form id="login_form" action="<?php //echo base_url();?>index.php/controladores-login/controlador_login">-->
        <?php echo form_open('controladores-login/controlador_login'); ?>
        	
			<div class="login_fields">
				<div class="field">
					<label for="email">Usuario del sistema</label>
					<input type="text" name="var_usuario" value="" id="var_usuario" tabindex="1" placeholder="usuario" />		
				</div>
				
				<div class="field">
					<label for="password">Passuword <small><a href="javascript:;">Forgot Password?</a></small></label>
					<input type="password" name="var_pass" value="" id="var_pass" tabindex="2" placeholder="Contraseña" />			
				</div>
			</div> <!-- .login_fields -->
			
			<div class="login_actions">
				<button type="submit" class="btn btn-primary" tabindex="3">Ingresar al Sistema</button>
			</div>
		</form>
	</div> <!-- #login_panel -->		
</div> <!-- #login -->

<script src="<?php  echo  base_url();?>javascripts/all.js"></script>


</body>
</html>