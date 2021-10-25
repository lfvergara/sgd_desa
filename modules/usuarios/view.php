<?php


class UsuariosView extends View{

	function mostrar_mantenimiento($usuarios, $grupos) {
		$gui = file_get_contents("static/modules/usuarios/mantenimiento.html");
		$gui_tbl_mantenimiento = file_get_contents("static/modules/usuarios/tbl_mantenimiento.html");
		$gui_slt_grupos = file_get_contents("static/modules/usuarios/slt_grupos.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);

		$dict = array("{titulo}"=>"Mantenimiento de usuarios");
		
		if(!is_array($usuarios)){$usuarios=array();}
		if(!is_array($grupos)){$grupos=array();}
		
		$gui_tbl_mantenimiento = $this->render_regex("repetir", $gui_tbl_mantenimiento, $usuarios);
		$gui_slt_grupos = $this->render_regex("grupos", $gui_slt_grupos, $grupos);
		$render = str_replace('{tbl_mantenimiento}', $gui_tbl_mantenimiento, $gui);
		$render = str_replace('{slt_grupos}', $gui_slt_grupos, $render);
		$render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}
	
	function mostrar_editar($usuario, $grupos) {
		$gui = file_get_contents("static/modules/usuarios/editar.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);

		$grupo_id = $usuario["grupo_id"];
		$display_matricula = ($grupo_id == 2) ? "block" : "none";
		
		$dict = array("{titulo}"=>"Mantenimiento de usuarios", "{display_matricula}"=>$display_matricula);
		
		if(!is_array($grupos)){$grupos=array();}
		
		$usuario = $this->set_dict($usuario);
		$render = $this->render_regex("grupos", $gui, $grupos);
		$render = $this->render($usuario, $render);
		$render = $this->render($dict, $render);
		$render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}
  
  	function guardar_informacion_matriculado($usuario) {
		$gui = file_get_contents("static/modules/usuarios/guardar_informacion.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
    
    	$grupo_id = $usuario["grupo_id"];
		$display_matricula = "block";
		
		$dict = array("{titulo}"=>"Actualización de Matriculados", "{display_matricula}"=>$display_matricula);
		
		if(!is_array($grupos)){$grupos=array();}
		
		$usuario = $this->set_dict($usuario);
		$render = $this->render($usuario, $gui);
		$render = $this->render($dict, $render);
		$render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}
  
  	function actualizar_informacion_matriculado($usuario, $matriculado) {
		$gui = file_get_contents("static/modules/usuarios/actualizar_informacion.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
    
    	$grupo_id = $usuario["grupo_id"];
		$display_matricula = "block";
		
		$dict = array("{titulo}"=>"Actualización de Matriculados", "{display_matricula}"=>$display_matricula);
		$matriculado['correoelectronico_check_si'] = ($matriculado['correoelectronico_visible_web'] == 1) ? 'checked' : '';
	    $matriculado['correoelectronico_check_no'] = ($matriculado['correoelectronico_visible_web'] == 1) ? '' : 'checked';
	    $matriculado['telefono_check_si'] = ($matriculado['telefono_visible_web'] == 1) ? 'checked' : '';
	    $matriculado['telefono_check_no'] = ($matriculado['telefono_visible_web'] == 1) ? '' : 'checked';
	    $matriculado['celular_check_si'] = ($matriculado['celular_visible_web'] == 1) ? 'checked' : '';
	    $matriculado['celular_check_no'] = ($matriculado['celular_visible_web'] == 1) ? '' : 'checked';
	    $matriculado['direccion_check_si'] = ($matriculado['direccion_visible_web'] == 1) ? 'checked' : '';
	    $matriculado['direccion_check_no'] = ($matriculado['direccion_visible_web'] == 1) ? '' : 'checked';
		
		$usuario = $this->set_dict($usuario);
		$matriculado = $this->set_dict($matriculado);
		$render = $this->render($usuario, $gui);
		$render = $this->render($matriculado, $render);
		$render = $this->render($dict, $render);
		$render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}

	function actualizar_terminos_condiciones($matriculado) {
		$gui = file_get_contents("static/modules/usuarios/actualizar_terminos_condiciones.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		$dict = array("{titulo}"=>"Actualización de Términos y Condiciones");
    
    	$matriculado = $this->set_dict($matriculado);
		$render = $this->render($matriculado, $gui);
		$render = $this->render($dict, $render);
		$render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}
  
  	function informacion_matriculado($usuario, $matriculado, $array_modal) {
		$gui = file_get_contents("static/modules/usuarios/informacion_matriculado.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
    
    	$grupo_id = $usuario["grupo_id"];
		$display_matricula = "block";
		
		$dict = array("{titulo}"=>"Actualización de Matriculados", "{display_matricula}"=>$display_matricula);
		$matriculado['correoelectronico_check_si'] = ($matriculado['correoelectronico_visible_web'] == 1) ? 'checked' : '';
	    $matriculado['correoelectronico_check_no'] = ($matriculado['correoelectronico_visible_web'] == 1) ? '' : 'checked';
	    $matriculado['telefono_check_si'] = ($matriculado['telefono_visible_web'] == 1) ? 'checked' : '';
	    $matriculado['telefono_check_no'] = ($matriculado['telefono_visible_web'] == 1) ? '' : 'checked';
	    $matriculado['celular_check_si'] = ($matriculado['celular_visible_web'] == 1) ? 'checked' : '';
	    $matriculado['celular_check_no'] = ($matriculado['celular_visible_web'] == 1) ? '' : 'checked';
	    $matriculado['direccion_check_si'] = ($matriculado['direccion_visible_web'] == 1) ? 'checked' : '';
	    $matriculado['direccion_check_no'] = ($matriculado['direccion_visible_web'] == 1) ? '' : 'checked';
		
		$usuario = $this->set_dict($usuario);
		$matriculado = $this->set_dict($matriculado);
		$render = $this->render($usuario, $gui);
		$render = $this->render($matriculado, $render);
		$render = $this->render($dict, $render);
		$render = $this->render($array_modal, $render);
		print $this->render_template($menu, $render);
	}

	function mostrar_formulario() {
		print file_get_contents("static/modules/usuarios/login.html");
	}
  
  	function recupera_pass() {
		print file_get_contents("static/modules/usuarios/recupera_contrasena.html");
	}

	function ver($array_modal) {
		$gui = file_get_contents("static/modules/usuarios/ver.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		$dict = array("{titulo}"=>"Sistema de Gestión de Documentación");
		$dict = array_merge($dict, $this->set_dict($_SESSION));
		$dict = array_merge($dict, $array_modal);
		$render = $this->render($dict, $gui);
		print $this->render_template($menu, $render);
	}
  
  	function mostrar_panel($datos) {
		$gui = file_get_contents("static/modules/usuarios/mostrar_panel.html");
		$tbl_documentos_pendientes = file_get_contents("static/modules/usuarios/tbl_documentos_pendientes.html");
		$menu = file_get_contents("static/menu.html");
    
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
    	if (!empty($datos)) {
      		$cantidad = count($datos);
      		$plural = ($cantidad > 1) ? "s" : "";
      		$plural_final = ($cantidad > 1) ? "de los mismos" : "del mismo";
      		$mensaje = "Ud posee {$cantidad} trabajo{$plural} pendiente{$plural} de su intervención. Por favor regularice la situación {$plural_final}.";
      		$msj_class = "danger";
     	 	$display_tbl = "block";
	    } else {
	      	$mensaje = "Ud no posee trabajos pendientes de su intervención.";
	      	$msj_class = "info";
	      	$display_tbl = "none";
	    }
    
   	 	$array_mensaje = array("{mensaje}"=>$mensaje, "{msj_class}"=>$msj_class, "{display_tbl}"=>$display_tbl);
		$dict = array("{titulo}"=>"Sistema de Gestión de Documentación");
		$dict = array_merge($dict, $this->set_dict($_SESSION), $array_mensaje);
    	$datos = (!is_array($datos)) ? array() : $datos;
    	$tbl_documentos_pendientes = $this->render_regex('repetir', $tbl_documentos_pendientes, $datos);
    
		$render = $this->render($dict, $gui);
		$render = str_replace("{tbl_documentos_pendientes}", $tbl_documentos_pendientes, $render);
    	print $this->render_template($menu, $render);
	}
  
 	function mostrar_panel_novedades($datos, $novedades, $eventos) {
    	$gui = file_get_contents("static/modules/usuarios/mostrar_panel_novedades.html");
		$tbl_documentos_pendientes = file_get_contents("static/modules/usuarios/tbl_documentos_pendientes_small.html");
		$lst_novedades = file_get_contents("static/modules/usuarios/lst_novedades.html");
    	if (is_array($eventos) AND !empty($eventos)) {
		  	$lst_eventos = file_get_contents("static/modules/usuarios/lst_eventos.html");
      		$lst_eventos = $this->render_regex('repetir', $lst_eventos, $eventos);
    	} else {
		  	$lst_eventos = "Sin eventos definidos en agenda";
    	}
      
		$menu = file_get_contents("static/menu.html");
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
    	if (!empty($datos)) {
      		$cantidad = count($datos);
      		$plural = ($cantidad > 1) ? "s" : "";
      		$plural_final = ($cantidad > 1) ? "de los mismos" : "del mismo";
      		$mensaje = "Ud posee {$cantidad} trabajo{$plural} pendiente{$plural} de su intervención. Por favor regularice la situación {$plural_final}.";
      		$msj_class = "danger";
      		$display_tbl = "block";
      		$col_archivo = 7;
      		$col_novedades = 5;
      		$div_archivo_display = "block";
    	} else {
      		$mensaje = "Ud no posee trabajos pendientes de su intervención.";
      		$msj_class = "info";
      		$display_tbl = "none";
      		$col_archivo = 5;
      		$col_novedades = 12;
      		$div_archivo_display = "none";
    	}
    
    	$array_mensaje = array("{mensaje}"=>$mensaje, "{msj_class}"=>$msj_class, "{display_tbl}"=>$display_tbl, "{col_archivo}"=>$col_archivo, "{col_novedades}"=>$col_novedades, "{div_archivos_display}"=>$div_archivo_display);
		$dict = array("{titulo}"=>"Sistema de Gestión de Documentación");
		$dict = array_merge($dict, $this->set_dict($_SESSION), $array_mensaje);
    	$datos = (!is_array($datos)) ? array() : $datos;
    	$tbl_documentos_pendientes = $this->render_regex('repetir', $tbl_documentos_pendientes, $datos);
    
    	$destacado = array();
    	foreach ($novedades as $clave=>$valor) {
      		if ($valor['destacado'] == 1) {
        		if (!empty($datos)) {
          			$contenido = substr($novedades[$clave]['contenido'], 0, 140) . "...";
        		} else {
          			$contenido = substr($novedades[$clave]['contenido'], 0, 400) . "...";
        		}
        		$destacado = $valor;
        		$destacado['contenido'] = $contenido;
        		unset($novedades[$clave]);
      		} else {
        		if (!empty($datos)) {
          			$novedades[$clave]['contenido'] = substr($novedades[$clave]['contenido'], 0, 180) . "...";
        		} else {
          			$novedades[$clave]['contenido'] = substr($novedades[$clave]['contenido'], 0, 450) . "...";
        		}
      		}
    	}
   
    	$destacado = $this->set_dict($destacado);
    	$lst_novedades = $this->render_regex('repetir', $lst_novedades, $novedades);
    
	    $render = $this->render($dict, $gui);
	    $render = $this->render($destacado, $render);
		$render = str_replace("{tbl_documentos_pendientes}", $tbl_documentos_pendientes, $render);
		$render = str_replace("{lst_novedades}", $lst_novedades, $render);
		$render = str_replace("{lst_eventos}", $lst_eventos, $render);
    	print $this->render_template($menu, $render);
	}
  
  	function mostrar_panel_encuesta($encuesta, $preguntas) {
		$gui = file_get_contents("static/modules/usuarios/mostrar_panel_encuesta.html");
		$menu = file_get_contents("static/menu.html");
    
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
    
	    if(!is_array($preguntas)){$preguntas=array();}
	    foreach ($preguntas as $clave=>$valor) {
	      	$respuestas = $valor['respuestas'];
	      	$pregunta_txt = $valor['pregunta'];
	      	$respuestas_txt = '';
	      	if(!empty($respuestas)) {
	        	$array_respuestas = array();
	        	$pregunta_id = $valor['pregunta_id'];
	        	foreach ($respuestas as $respuesta) {
	          		$respuesta_id = $respuesta['respuesta_id'];
	          		$respuesta_txt = $respuesta['respuesta'];
	          		$array_respuestas[] = "<input type='radio' name='pregunta[{$pregunta_txt}]' value='{$respuesta_txt}' required> " . $respuesta['respuesta'];
	        	} 
	        	$respuestas_txt = implode('<br>', $array_respuestas);
	      	} else {
	        	$respuestas_txt = 'Sin respuestas definidas.';
	      	}
	      
	      	$preguntas[$clave]['respuestas_txt'] = $respuestas_txt;
	    }
    
    	$encuesta = $this->set_dict($encuesta);
		$dict = array("{titulo}"=>"Sistema de Gestión de Documentación");
		$dict = array_merge($dict, $this->set_dict($_SESSION));
		$render = $this->render_regex("repetir", $gui, $preguntas);    
	    $render = $this->render($dict, $render);
	    $render = $this->render($encuesta, $render);
		print $this->render_template($menu, $render);
	}

	function mostrar_error($mensaje) {
		$gui = file_get_contents("static/modules/usuarios/login.html");

		$dict = array("{titulo}"=>"Error", "{mostrar}"=>"show", "{mensaje}"=>$mensaje);
	    $plantilla = $this->render($dict, $gui);
	    $plantilla = $this->render_login($plantilla);
		print $plantilla;
	}

	function mostrar_form_nuevo($datos) {
		$gui = file_get_contents("static/modules/usuarios/nueva_clave.html");
		$dict = array("{titulo}"=>"Generar clave");
		$dict = array_merge($dict, $datos);
    	$gui = str_replace('{app_name}', APP_NAME, $gui);
    	$gui = str_replace('{theme_path}', THEME_PATH, $gui);
		print $this->render($dict, $gui);
	}
}
?>