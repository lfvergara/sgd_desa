<?php
require_once "modules/usuarios/view.php";
require_once "modules/usuarios/model.php";
require_once "modules/grupos/controller.php";
require_once "modules/archivos/model.php";
require_once "modules/novedades/model.php";
require_once "tools/mailhandling.php";
//require_once "tools/firmaPDF.php";


class UsuariosController {

	function __construct() {
		$this->model = new Usuarios();
		$this->view = new UsuariosView();
	}
    
    function login() {
        $this->view->mostrar_error("Nombre de usuario o clave incorrectos.");
    }
    
	function gestionar() {
    	SessionHandling::check();
		$usuarios = $this->model->listar();
		$grupos = new GruposController();
		$this->view->mostrar_mantenimiento($usuarios, $grupos->model->listar());
	}

	function guardar() {
    	SessionHandling::check();
		$grupo = filter_input(INPUT_POST, "grupo_id");
		foreach ($_POST as $propiedad => $valor) $this->model->$propiedad = $valor;
		$this->model->save();
		
		if ($grupo == 2) {
			$this->model->matricula = filter_input(INPUT_POST, "matricula");
			$this->model->guardar_matricula();
		}
		
		header("Location: /" . APP_NAME . "/usuarios/gestionar");
	}
	
	function actualizar() {
    	SessionHandling::check();
		$usuario_id = filter_input(INPUT_POST, "usuario_id");
		$grupo = filter_input(INPUT_POST, "grupo_id");
		
		$this->model->usuario_id = $usuario_id;
		$rst = $this->model->get_usuario();
		$viejo_grupo = $rst["grupo_id"];
		
		foreach ($_POST as $propiedad => $valor) $this->model->$propiedad = $valor;
		$this->model->save();
		$this->model->usuario_id = $usuario_id;
		
		if ($grupo == 2) {
			$this->model->matricula = filter_input(INPUT_POST, "matricula");
			if ($viejo_grupo == 2) {
				$this->model->actualizar_matricula();
			} else {
				$this->model->guardar_matricula();
			}
		} else {
			$this->model->eliminar_matricula();
		}
		
		header("Location: /" . APP_NAME . "/usuarios/gestionar");
	}
  
  	function salir() {
		SessionHandling::destroy();
	}

	function ingresar() {
		$this->view->mostrar_formulario();
	}
  
  	function recupera_pass() {
		$this->view->recupera_pass();
	}

  	function recuperar_contrasena() {
		$this->model->denominacion = filter_input(INPUT_POST, "denominacion");
		$usuario = $this->model->get_by_denominacion();
    	if($usuario == 0) {
		  	$this->view->mostrar_error("Nuestro sistema no tiene un correo designado a su cuenta. Por favor comuníquese con nuestro consejo para regularizar la situación. Muchas gracias!");
    	} else {
      
      		$correoelectronico = $usuario["correoelectronico"];
      		if(empty($correoelectronico) OR $correoelectronico == '' OR is_null($correoelectronico) ) {
		    	$this->view->mostrar_error("Nuestro sistema no tiene un correo designado a su cuenta. Por favor comuníquese con nuestro consejo para regularizar la situación. Muchas gracias!");        
      		} else {
        		$random = substr(md5(mt_rand()), 0, 8);
        		$usuario["ini_token"] = $random;
        
		        $this->model->usuario_id = $usuario["usuario_id"];
		        $this->model->denominacion = $usuario["denominacion"];
		        $this->model->clave = $random;
		        $this->model->actualizar_token();
		        
		        $emailHelper = new EmailHelper();
		        $emailHelper->envia_email($usuario);
		        $this->view->mostrar_error("Hemos enviado a su correo la nueva contraseña. Muchas gracias!");        
		    }
    	}
  	}
  
	function verificar() {
		$this->model->denominacion = filter_input(INPUT_POST, "denominacion");
		$this->model->clave = filter_input(INPUT_POST, "clave");
       
    	$evaluacion = $this->model->evaluar();
    	if($evaluacion == 0) $this->view->mostrar_error("Nombre de usuario o clave incorrectos.");
    	if($evaluacion == 1) {
      		$datos = array("{usuario_id}"=>$this->model->usuario_id, "{denominacion}"=>$this->model->denominacion);
      		$this->view->mostrar_form_nuevo($datos);
    	}
    	
    	if($evaluacion == 2) {
      		$datos = $this->model->get();
      		SessionHandling::create($datos);
      		if($_SESSION["sesion.navegador_flag"] == 1) {
        		$this->view->mostrar_error("Disculpe, pero nuestro sistema no es compatible con su navegador, recomendamos usar Google Chrome.");
        		SessionHandling::destroy_sin_redirect();
      		} else {
        		$grupo_id = $_SESSION['sesion.grupo_id'];
        		if ($grupo_id == 99 || $grupo_id == 1) {
          			header("Location: /" . APP_NAME . "/usuarios/panel");
        		} else {
          			header("Location: /" . APP_NAME . "/usuarios/panel");
        		}
      		}
    	}    
	}  
  
  	/*
  	function firmar() {      
    	$jar = "/home/cpcelr/public_html/sgd_desa/tools/FirmaPDF/FirmarPDF.jar"; 
    	$archivo = "/home/cpcelr/public_html/sgd_desa/static/doc.pdf"; 
    	$firmante = "ARIEL GIMENEZ";
    	firmar($jar, $archivo, $firmante);    
  	}
  	*/
  
  	function actualizar_informacion() {
		SessionHandling::check();
    
	    $usuario_id = $_SESSION["sesion.usuario_id"];
	    $matricula = $_SESSION["sesion.matricula"];
	    
		$this->model->usuario_id = $usuario_id;
		$this->model->matricula = $matricula;
		$usuario = $this->model->get_usuario();
		
	    $flag = $this->model->verificar_matricula_matriculado();
	    $this->model->matriculado_id = $flag;
	    $matriculado = $this->model->get_matriculado();
	    $this->view->actualizar_informacion_matriculado($usuario, $matriculado);
  	}

  	function actualizar_terminos_condiciones() {
		SessionHandling::check();
    
	    $usuario_id = $_SESSION["sesion.usuario_id"];
	    $matricula = $_SESSION["sesion.matricula"];

	    $this->model->usuario_id = $usuario_id;
		$this->model->matricula = $matricula;
		$terminos_condiciones = $this->model->verificar_termino_condiciones();
		
	    if ($terminos_condiciones == 0) {
		    $flag = $this->model->verificar_matricula_matriculado();
		    $this->model->matriculado_id = $flag;
		    $matriculado = $this->model->get_matriculado();
  			$this->view->actualizar_terminos_condiciones($matriculado);
	    } else {
	    	$this->view->mostrar_panel_espera_confirmacion();    		
		}
  	}
  
  	function mis_datos($argumentos) {
		SessionHandling::check();
    	SessionHandling::actualizar();
    
    	switch($argumentos[0]) {
			case 1:
				$array_msj = array("{mensaje}"=>"Su información ha sido actualizada.", "{display}"=>"show");
				break;
			default:
				$array_msj = array("{mensaje}"=>"", "{display}"=>"none");
				break;
		}
    
	    $usuario_id = $_SESSION["sesion.usuario_id"];
	    $matricula = $_SESSION["sesion.matricula"];
    
		$this->model->usuario_id = $usuario_id;
		$this->model->matricula = $matricula;
		$usuario = $this->model->get_usuario();
		
	    $flag = $this->model->verificar_matricula_matriculado();
	    $this->model->matriculado_id = $flag;
	    $matriculado = $this->model->get_matriculado();
	    $this->view->informacion_matriculado($usuario, $matriculado, $array_msj);
  	}
  
  	function actualizar_informacion_matriculado() {
		SessionHandling::check();
	    $usuario_id = $_SESSION["sesion.usuario_id"];
	    $matricula = $_SESSION["sesion.matricula"];
	    
	    $matriculado = array('apellido'=>filter_input(INPUT_POST, 'apellido'),
                         	 'nombre'=>filter_input(INPUT_POST, 'nombre'),
                         	 'matricula'=>filter_input(INPUT_POST, 'matricula'));
    	$this->model->telefono = filter_input(INPUT_POST, 'telefono');
		$this->model->telefono_visible_web = filter_input(INPUT_POST, 'telefono_visible_web');
		$this->model->celular = filter_input(INPUT_POST, 'celular');
		$this->model->celular_visible_web = filter_input(INPUT_POST, 'celular_visible_web');
		$this->model->correoelectronico = filter_input(INPUT_POST, 'correoelectronico');
		$this->model->correoelectronico_visible_web = filter_input(INPUT_POST, 'correoelectronico_visible_web');
		$this->model->direccion = filter_input(INPUT_POST, 'direccion');
		$this->model->direccion_visible_web = filter_input(INPUT_POST, 'direccion_visible_web');
		$this->model->matriculado_id = filter_input(INPUT_POST, 'matriculado_id');
		$this->model->actualizar_matriculado();    
    
	    $emailHelper = new EmailHelper();
	    $emailHelper->envia_email_actualizacion_matriculado($matriculado);
    
    	header("Location: /" . APP_NAME . "/usuarios/mis_datos/1");
  	}
  
  	function actualizar_matriculado() {
		SessionHandling::check();
	    $usuario_id = $_SESSION["sesion.usuario_id"];
	    $matricula = $_SESSION["sesion.matricula"];
    
    	$matriculado = array('apellido'=>filter_input(INPUT_POST, 'apellido'),
    						 'nombre'=>filter_input(INPUT_POST, 'nombre'),
    						 'matricula'=>filter_input(INPUT_POST, 'matricula'));
    
		$this->model->telefono = filter_input(INPUT_POST, 'telefono');
		$this->model->telefono_visible_web = filter_input(INPUT_POST, 'telefono_visible_web');
		$this->model->celular = filter_input(INPUT_POST, 'celular');
		$this->model->celular_visible_web = filter_input(INPUT_POST, 'celular_visible_web');
		$this->model->correoelectronico = filter_input(INPUT_POST, 'correoelectronico');
		$this->model->correoelectronico_visible_web = filter_input(INPUT_POST, 'correoelectronico_visible_web');
		$this->model->direccion = filter_input(INPUT_POST, 'direccion');
		$this->model->direccion_visible_web = filter_input(INPUT_POST, 'direccion_visible_web');
		$this->model->matriculado_id = filter_input(INPUT_POST, 'matriculado_id');
		$this->model->actualizar_matriculado();
		
	    $this->model->usuario_id = $usuario_id;
	    $this->model->actualizacion = 2;
		$usuario = $this->model->desactivar_actualizacion();
    	$_SESSION["sesion.actualizacion"] = 2;
    
    	$emailHelper = new EmailHelper();
    	$emailHelper->envia_email_actualizacion_matriculado($matriculado);
    
    	header("Location: /" . APP_NAME . "/usuarios/panel");
  	}

	function ver($argumentos) {
		SessionHandling::check();
    	SessionHandling::actualizar();
		switch($argumentos[0]) {
			case 1:
				$array_msj = array("{mensaje}"=>"Su contraseña ha sido modificada.", "{display}"=>"show");
				break;
			default:
				$array_msj = array("{mensaje}"=>"", "{display}"=>"none");
				break;
		}
		
		$this->view->ver($array_msj);
	}
  
  	function bk_panel() {
		SessionHandling::check();
		SessionHandling::actualizar();
		$this->view->mostrar_panel();
	}
  
  	function panel() {
		SessionHandling::check();
		SessionHandling::actualizar();
	    $nm = new Novedades();
	    $novedades = $nm->listar_novedades_activas();
    
	    $am = new Archivos();
	    $am->estado_id = 4;
		$datos1 = $am->listar_estado_usuario();
    	if(!is_array($datos1)) $datos1 = array();
    	$am->estado_id = 7;
		$datos2 = $am->listar_estado_usuario();
    	if(!is_array($datos2)) $datos2 = array();
    	$am->estado_id = 12;
		$datos3 = $am->listar_estado_usuario();
	    if(!is_array($datos3)) $datos3 = array();
	    $datos = array_merge($datos1, $datos2, $datos3);
	    
	    $encuesta_id = $this->model->verificar_encuesta_activa();
	    $eventos = $this->model->traer_eventos();
	    
	    if (is_array($encuesta_id)) {
      		$encuesta_id = $encuesta_id[0]['encuesta_id'];
      		$matricula_id = $_SESSION["sesion.matricula_id"];
      		$this->model->encuesta_id = $encuesta_id;
      		$this->model->matricula_id = $matricula_id;
      		$encuestaresultado_id = $this->model->verificar_encuestaresultado();
      
      		if (!is_array($encuestaresultado_id)) {
        		$this->model->encuesta_id = $encuesta_id;
        		$encuesta = $this->model->traer_encuesta();
		        $preguntas = $this->model->traer_preguntas_encuesta();
		        $respuestas = array();
		        foreach ($preguntas as $clave=>$valor) {
		          	$pregunta_id = $valor['pregunta_id'];
		          	$this->model->pregunta_id = $pregunta_id;
		          	$respuestas = $this->model->traer_respuestas_pregunta();
		          	$respuestas = (!is_array($respuestas)) ? array() : $respuestas;
		          	$preguntas[$clave]['respuestas'] = $respuestas;
		        }

        		$this->view->mostrar_panel_encuesta($encuesta, $preguntas);
      		} else {
        
        		if (is_array($novedades) AND !empty($novedades)) {
          			$this->view->mostrar_panel_novedades($datos, $novedades,$eventos);
        		} else {
          			$this->view->mostrar_panel($datos);            
        		}
      		}
    	} else { 
      		if (is_array($novedades) AND !empty($novedades)) {
        		$this->view->mostrar_panel_novedades($datos, $novedades,$eventos);
      		} else {
        		$this->view->mostrar_panel($datos);            
      		}
    	}	
	}
  
  	function editar($argumentos) {
		SessionHandling::check();
		$usuario_id = $argumentos[0];
		
		$this->model->usuario_id = $usuario_id;
		$usuario = $this->model->get_usuario();
		
		$grupos = new GruposController();
		$this->view->mostrar_editar($usuario, $grupos->model->listar());
	}

	function generar() {
    	SessionHandling::check();
		$clave = filter_input(INPUT_POST, "clave");
		$reclave = filter_input(INPUT_POST, "reclave");
		if($clave !== $reclave) $this->view->mostrar_error("Las claves no coinciden.");
		if($clave === $reclave) {
			$this->model->usuario_id = filter_input(INPUT_POST, "usuario_id");
			$this->model->denominacion = filter_input(INPUT_POST, "denominacion");
			$this->model->clave = $clave;
			$this->model->get_token();
			$this->model->update_token();
			$this->view->mostrar_error("La clave ha sido generada correctamente.");
		}
	}
	
	function verificar_matricula($argumentos) {
		SessionHandling::check();
		$this->model->matricula = $argumentos[0];
		$rst = $this->model->verificar_matricula();		
		print $rst;
	}
	
	function verificar_usuario($argumentos) {
		$this->model->denominacion = $argumentos[0];
		$rst = $this->model->verificar_denominacion();		
		print $rst;
	}
	
	function blanquear($id) {
    	$this->model->usuario_id = $id[0];
		$this->model->reset();
		header("Location: /" . APP_NAME . "/usuarios/gestionar");
	}
	
	function cambiar_token() {
    	$this->model->usuario_id = filter_input(INPUT_POST, "usuario_id");
		$this->model->denominacion = filter_input(INPUT_POST, "denominacion");
		$this->model->clave = filter_input(INPUT_POST, "nclave");
		$this->model->actualizar_token();
		header("Location: /" . APP_NAME . "/usuarios/ver/1");
	}

	function guardar_terminos_condiciones() {
		$mimes_permitidos = "application/pdf";
    	$limite_filesize = 20 * 1048576;

    	$matriculado_id = filter_input(INPUT_POST, 'matriculado_id');
    	$terminos_condiciones = $_FILES['terminos_condiciones'];
    	$this->model->matriculado_id = $matriculado_id;
      	$formato = $terminos_condiciones['type'];
        $tamanio = $terminos_condiciones['size'];

    	if ($formato == $mimes_permitidos) {
            if ($tamanio < $limite_filesize) {
              	$this->model->guardar_terminos_condiciones();
				FileHandler::save_file($terminos_condiciones, "matriculados/{$matriculado_id}", 'terminos_condiciones');
              	header("Location: /" . APP_NAME . "/usuarios/actualizar_terminos_condiciones");
            } else {
              	header("Location: /" . APP_NAME . "/usuarios/actualizar_terminos_condiciones/1");
            }
      	} else {
            header("Location: /" . APP_NAME . "/usuarios/actualizar_terminos_condiciones/2");
        }
	}

	function ver_terminos_condiciones() {
     	FileHandler::get_file("documentos/terminos_condiciones");
  	}
}
?>