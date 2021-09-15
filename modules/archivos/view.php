<?php


class ArchivosView extends View{

	function mostrar_formulario_ingresar($tipos_trabajo, $entidades, $cuentas, $array_msj) {
		$gui = file_get_contents("static/modules/archivos/ingresar.html");
		$menu = file_get_contents("static/menu.html");
		
		$gui_slt_tipos_trabajo = file_get_contents("static/common/slt_tipos_trabajo.html");
		$gui_slt_tipos_trabajo = $this->render_regex('repetir', $gui_slt_tipos_trabajo, $tipos_trabajo);
		
		$gui_slt_entidades = file_get_contents("static/common/slt_entidades.html");
		$gui_slt_entidades = $this->render_regex('repetir', $gui_slt_entidades, $entidades);
		
		$gui_slt_cuentas = file_get_contents("static/common/slt_cuentas.html");
		$gui_slt_cuentas = $this->render_regex('repetir', $gui_slt_cuentas, $cuentas);
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		$dict = array("{titulo}"=>"Encargo Profesional");
		$render = $this->render($dict, $gui);
		$render = str_replace('{slt_tipos_trabajo}', $gui_slt_tipos_trabajo, $render);
		$render = str_replace('{slt_entidades}', $gui_slt_entidades, $render);
		$render = str_replace('{slt_cuentas}', $gui_slt_cuentas, $render);
		$render = $this->render($array_msj, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
  
  function mostrar_formulario_ingresar_con_ajuste($tipos_trabajo, $entidades, $cuentas, $array_msj, $cantidad_pendientes) {
		$gui = file_get_contents("static/modules/archivos/ingresar_con_ajuste.html");
		$menu = file_get_contents("static/menu.html");
      
		$gui_slt_tipos_trabajo = file_get_contents("static/common/slt_tipos_trabajo.html");
		$gui_slt_tipos_trabajo = $this->render_regex('repetir', $gui_slt_tipos_trabajo, $tipos_trabajo);
		
		$gui_slt_entidades = file_get_contents("static/common/slt_entidades.html");
		$gui_slt_entidades = $this->render_regex('repetir', $gui_slt_entidades, $entidades);
		
		$gui_slt_cuentas = file_get_contents("static/common/slt_cuentas.html");
		$gui_slt_cuentas = $this->render_regex('repetir', $gui_slt_cuentas, $cuentas);
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		    
    $cantidad_pendientes = $cantidad_pendientes[0]['CANTIDAD'];
    if ($cantidad_pendientes > 0) {
      $plural = ($cantidad_pendientes > 1) ? "s" : "";
      $plural_final = ($cantidad_pendientes > 1) ? "de los mismos" : "del mismo";
      $mensaje = "Ud posee {$cantidad_pendientes} trabajo{$plural} pendiente{$plural} de su intervención. Por favor regularice la situación {$plural_final}.";
      $msj_class = "danger";
      $display_alert = "block";
    } else {
      $mensaje = "";
      $msj_class = "";
      $display_alert = "none";
    }
		
    $array_mensaje = array("{mensaje}"=>$mensaje, "{msj_class}"=>$msj_class, "{display_alert}"=>$display_alert);
		$dict = array("{titulo}"=>"Encargo Profesional");
    $array_final = array_merge($dict, $array_mensaje);
		$render = $this->render($array_final, $gui);
		$render = str_replace('{slt_tipos_trabajo}', $gui_slt_tipos_trabajo, $render);
		$render = str_replace('{slt_entidades}', $gui_slt_entidades, $render);
		$render = str_replace('{slt_cuentas}', $gui_slt_cuentas, $render);
		$render = $this->render($array_msj, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
	
	function mostrar_formulario_ingresar_certificacion($tipos_trabajo, $entidades, $cuentas, $array_msj, $cantidad_pendientes) {
		$gui = file_get_contents("static/modules/archivos/ingresar_certificacion.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		$gui_slt_tipos_trabajo = file_get_contents("static/common/slt_tipos_trabajo.html");
		$gui_slt_tipos_trabajo = $this->render_regex('repetir', $gui_slt_tipos_trabajo, $tipos_trabajo);
		
		$gui_slt_entidades = file_get_contents("static/common/slt_entidades.html");
		$gui_slt_entidades = $this->render_regex('repetir', $gui_slt_entidades, $entidades);
		
		$gui_slt_cuentas = file_get_contents("static/common/slt_cuentas.html");
		$gui_slt_cuentas = $this->render_regex('repetir', $gui_slt_cuentas, $cuentas);
    
    $cantidad_pendientes = $cantidad_pendientes[0]['CANTIDAD'];
    if ($cantidad_pendientes > 0) {
      $plural = ($cantidad_pendientes > 1) ? "s" : "";
      $plural_final = ($cantidad_pendientes > 1) ? "de los mismos" : "del mismo";
      $mensaje = "Ud posee {$cantidad_pendientes} trabajo{$plural} pendiente{$plural} de su intervención. Por favor regularice la situación {$plural_final}.";
      $msj_class = "danger";
      $display_alert = "block";
    } else {
      $mensaje = "";
      $msj_class = "";
      $display_alert = "none";
    }
		
    $array_mensaje = array("{mensaje}"=>$mensaje, "{msj_class}"=>$msj_class, "{display_alert}"=>$display_alert);
		$dict = array("{titulo}"=>"Encargo Profesional");
    $array_final = array_merge($dict, $array_mensaje);
		$render = $this->render($array_final, $gui);
		$render = str_replace('{slt_tipos_trabajo}', $gui_slt_tipos_trabajo, $render);
		$render = str_replace('{slt_entidades}', $gui_slt_entidades, $render);
		$render = str_replace('{slt_cuentas}', $gui_slt_cuentas, $render);
		$render = $this->render($array_msj, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
	
	function mostrar_formulario_editar($archivo, $tipos_trabajo, $entidades, $cuentas) {
		$tipo = $archivo["tipo"];
		$gui_html = ($tipo == 1) ? "editar" : "editar_certificacion";
		$gui = file_get_contents("static/modules/archivos/{$gui_html}.html");
		$menu = file_get_contents("static/menu.html");
		
		$gui_slt_tipos_trabajo = file_get_contents("static/common/slt_tipos_trabajo.html");
		$gui_slt_tipos_trabajo = $this->render_regex('repetir', $gui_slt_tipos_trabajo, $tipos_trabajo);
		
		$gui_slt_entidades = file_get_contents("static/common/slt_entidades.html");
		$gui_slt_entidades = $this->render_regex('repetir', $gui_slt_entidades, $entidades);
		
		$gui_slt_cuentas = file_get_contents("static/common/slt_cuentas.html");
		$gui_slt_cuentas = $this->render_regex('repetir', $gui_slt_cuentas, $cuentas);	
		
		if($archivo["metodo_pago"] == "Depósito") {
		  $datos['opt_checked_deposito'] = 'checked';
      $datos['opt_checked_transferencia'] = '';
      $datos['opt_checked_cheque'] = '';
      $opt_deposito = "checked";
			$opt_transferencia = "";
			$opt_cheque = "";
		} else if($archivo["metodo_pago"] == "Transferencia") {
			$datos['opt_checked_deposito'] = '';
      $datos['opt_checked_transferencia'] = 'checked';
      $datos['opt_checked_cheque'] = '';
      $opt_deposito = "";
			$opt_transferencia = "checked";
			$opt_cheque = "";
		} else {
      $datos['opt_checked_deposito'] = '';
      $datos['opt_checked_transferencia'] = '';
      $datos['opt_checked_cheque'] = 'checked';
			$opt_deposito = "";
			$opt_transferencia = "";
			$opt_cheque = "checked";
		}
			
		$archivo = $this->set_dict($archivo);
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		$dict = array("{titulo}"=>"Editar documentación", "{opt_checked_deposito}"=>$opt_deposito, "{opt_checked_transferencia}"=>$opt_transferencia, "{opt_checked_cheque}"=>$opt_cheque);
		$render = $this->render($archivo, $gui);
		$render = str_replace('{slt_tipos_trabajo}', $gui_slt_tipos_trabajo, $render);
		$render = str_replace('{slt_entidades}', $gui_slt_entidades, $render);
		$render = str_replace('{slt_cuentas}', $gui_slt_cuentas, $render);
		$render = $this->render($dict, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
	
	function mostrar_detalle($datos, $seguimiento, $html, $estado_id, $matriculado, $entidades, $cuentas) {
    $gui = file_get_contents("static/modules/archivos/{$html}.html");
    $gui_seguimiento = file_get_contents("static/modules/archivos/gui_seguimiento.html");
    $gui_slt_entidades = file_get_contents("static/common/slt_entidades.html");
		$gui_slt_entidades = $this->render_regex('repetir', $gui_slt_entidades, $entidades);		
		$gui_slt_cuentas = file_get_contents("static/common/slt_cuentas.html");
		$gui_slt_cuentas = $this->render_regex('repetir', $gui_slt_cuentas, $cuentas);
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
    if($datos["metodo_pago"] == "Depósito") {
		  $datos['opt_checked_deposito'] = 'checked';
      $datos['opt_checked_transferencia'] = '';
      $datos['opt_checked_cheque'] = '';
		} else if($datos["metodo_pago"] == "Transferencia") {
			$datos['opt_checked_deposito'] = '';
      $datos['opt_checked_transferencia'] = 'checked';
      $datos['opt_checked_cheque'] = '';
		} else {
      $datos['opt_checked_deposito'] = '';
      $datos['opt_checked_transferencia'] = '';
      $datos['opt_checked_cheque'] = 'checked';
		}
    
    if($datos["excedente"] == 1) {
		  $datos['opt_checked_pago_matricula'] = 'checked';
      $datos['opt_checked_reintegro_aranceles'] = '';
		} else if($datos["excedente"] == 2) {
			$datos['opt_checked_pago_matricula'] = '';
      $datos['opt_checked_reintegro_aranceles'] = 'checked';
		} else {
      $datos['opt_checked_pago_matricula'] = '';
      $datos['opt_checked_reintegro_aranceles'] = '';
		}
    
		$carpeta = $datos['archivo_id'];
		for ($i=0; $i < count($seguimiento); $i++) {
			$archivo = $seguimiento[$i]['seguimiento_id'];
			if ($seguimiento[$i]['estado'] == 'Observado' OR $seguimiento[$i]['estado'] == 'Pendiente revisión') {
        if(FileHandler::check_file($carpeta, $archivo)==true) {
          $seguimiento[$i]['icono'] = "fa fa-file";
          $seguimiento[$i]['display_archivos'] = "none";
          $seguimiento[$i]['display_archivos_observado'] = "inline-block";
        } else {
          $seguimiento[$i]['icono'] = ""; 
          $seguimiento[$i]['display_archivos'] = "none";
          $seguimiento[$i]['display_archivos_observado'] = "none";
        }
      } else {
        if(FileHandler::check_file($carpeta, $archivo)==true) {
          $seguimiento[$i]['icono'] = "fa fa-file";
          $seguimiento[$i]['display_archivos'] = "inline-block";
        } else {
          $seguimiento[$i]['icono'] = ""; 
          $seguimiento[$i]['display_archivos'] = "none";
        }

        if(FileHandler::check_file($carpeta, 'informe')==true) {
          $seguimiento[$i]['display_archivos'] = "inline-block";
          $seguimiento[$i]['icono_informe'] = "fa fa-file";
          $seguimiento[$i]['url_informe'] = "informe";
          $seguimiento[$i]['display_informe'] = "inline-block";
        } else {
          $seguimiento[$i]['none'] = "inline-block";
          $seguimiento[$i]['icono_informe'] = "";
          $seguimiento[$i]['url_informe'] = "#";
          $seguimiento[$i]['display_informe'] = "none";
        }
        
        $seguimiento[$i]['display_archivos_observado'] = "none";
      }
		}		
    
    if(FileHandler::check_file($carpeta, 'comprobante_pago')==true) {
			$icono_comprobante = "fa fa-file";
			$comprobante_url = "comprobante_pago";
		} else {
			$icono_comprobante = ""; 
			$comprobante_url = "#";
		}
    
    if(FileHandler::check_file($carpeta, 'nota')==true) {
			$icono_nota = "fa fa-file";
			$nota_url = "nota";
		} else {
			$icono_nota = ""; 
			$nota_url = "#";
		}
  
    if ($html == 'ver') {
      $msj = 'SU DOCUMENTO NO FUE ACEPTADO TODAVIA';
      $gui = str_replace('{barcode}', $msj, $gui); 
    }
    
    if($html == 'legalizar' AND $datos['firma_digital'] == 0) {
      $gui = str_replace('{display_alert_intervenido}', 'block', $gui);
    } else {
      $gui = str_replace('{display_alert_intervenido}', 'none', $gui);
    }
    
    if ($estado_id == 8) $gui = str_replace('{gui_btn_print}', 'none', $gui);
		$dict = array("{titulo}"=>"Detalle del documento", "{disabled}"=>$disabled);
		$dict = array_merge($dict, $this->set_dict($datos));
    
    	$matriculado = $this->set_dict($matriculado[0]);
		$gui_seguimiento = $this->render_regex('repetir', $gui_seguimiento, $seguimiento);
		$render = str_replace("{seguimiento}", $gui_seguimiento, $gui);
		$render = str_replace("{icono_comprobante}", $icono_comprobante, $render);
		$render = str_replace("{comprobante_url}", $comprobante_url, $render);
		$render = str_replace("{icono_nota}", $icono_nota, $render);
		$render = str_replace("{nota_url}", $nota_url, $render);
		$render = str_replace("{slt_entidades}", $gui_slt_entidades, $render);
		$render = str_replace("{slt_cuentas}", $gui_slt_cuentas, $render);
    	$render = $this->render($matriculado, $render);
		$render = $this->render($dict, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
  
  	function mostrar_detalle_autorizar($datos, $seguimiento, $matriculado, $intentos) {
	    if($intentos > 1) {
			  $gui = file_get_contents("static/modules/archivos/mostrar_detalle_autorizar_observado.html");
	    } else {
			  $gui = file_get_contents("static/modules/archivos/mostrar_detalle_autorizar.html");
	    }
      
      
    	$gui_seguimiento = file_get_contents("static/modules/archivos/gui_seguimiento.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		$carpeta = $datos['archivo_id'];
		for ($i=0; $i < count($seguimiento); $i++) {
			$archivo = $seguimiento[$i]['seguimiento_id'];
			if ($seguimiento[$i]['estado'] == 'Observado' OR $seguimiento[$i]['estado'] == 'Pendiente revisión') {
		        if(FileHandler::check_file($carpeta, $archivo)==true) {
		          	$seguimiento[$i]['icono'] = "fa fa-file";
		          	$seguimiento[$i]['display_archivos'] = "none";
		          	$seguimiento[$i]['display_archivos_observado'] = "inline-block";
		    	} else {
		          	$seguimiento[$i]['icono'] = ""; 
		        	$seguimiento[$i]['display_archivos'] = "none";
		          	$seguimiento[$i]['display_archivos_observado'] = "none";
		        }
      		} else {
		        if(FileHandler::check_file($carpeta, $archivo)==true) {
		          $seguimiento[$i]['icono'] = "fa fa-file";
		          $seguimiento[$i]['display_archivos'] = "inline-block";
		        } else {
		          $seguimiento[$i]['icono'] = ""; 
		          $seguimiento[$i]['display_archivos'] = "none";
		        }

		        if(FileHandler::check_file($carpeta, 'informe')==true) {
		          $seguimiento[$i]['icono_informe'] = "fa fa-file";
		          $seguimiento[$i]['url_informe'] = "informe";
		          $seguimiento[$i]['display_informe'] = "inline-block";
		        } else {
		          $seguimiento[$i]['icono_informe'] = "";
		          $seguimiento[$i]['url_informe'] = "#";
		          $seguimiento[$i]['display_informe'] = "none";
		        }
        
        		$seguimiento[$i]['display_archivos_observado'] = "none";
      		}
		}	
		
		if(FileHandler::check_file($carpeta, 'comprobante_pago')==true) {
			$icono_comprobante = "fa fa-file";
			$comprobante_url = "comprobante_pago";
		} else {
			$icono_comprobante = ""; 
			$comprobante_url = "#";
		}
  
    	if ($html == 'ver') {
      		$msj = 'SU DOCUMENTO NO FUE ACEPTADO TODAVIA';
      		$gui = str_replace('{barcode}', $msj, $gui); 
    	}
    
		$dict = array("{titulo}"=>"Detalle del documento", "{disabled}"=>$disabled);
		$dict = array_merge($dict, $this->set_dict($datos));
    	if (empty($matriculado[0])) {
      		$matriculado[0] = array('correoelectronico'=>'','telefono'=>'','celular'=>'');
    	}
    
    	$matriculado = $this->set_dict($matriculado[0]);
    	print_r($seguimiento);
		$gui_seguimiento = $this->render_regex('repetir', $gui_seguimiento, $seguimiento);
		$render = str_replace("{seguimiento}", $gui_seguimiento, $gui);
		$render = str_replace("{icono_comprobante}", $icono_comprobante, $render);
		$render = str_replace("{comprobante_url}", $comprobante_url, $render);
		$render = $this->render($dict, $render);
		$render = $this->render($matriculado, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
  
  function mostrar_detalle_intervenido($datos, $seguimiento, $matriculado, $intentos, $ultima_presentacion) {
    $gui = file_get_contents("static/modules/archivos/ver_intervenido.html");
    $gui_seguimiento = file_get_contents("static/modules/archivos/gui_seguimiento.html");
		$menu = file_get_contents("static/menu.html");
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
      
		$carpeta = $datos['archivo_id'];
		for ($i=0; $i < count($seguimiento); $i++) {
			$archivo = $seguimiento[$i]['seguimiento_id'];
			if ($seguimiento[$i]['estado'] == 'Observado' OR $seguimiento[$i]['estado'] == 'Pendiente revisión') {
        if(FileHandler::check_file($carpeta, $archivo)==true) {
          $seguimiento[$i]['icono'] = "fa fa-file";
          $seguimiento[$i]['display_archivos'] = "none";
          $seguimiento[$i]['display_archivos_observado'] = "inline-block";
        } else {
          $seguimiento[$i]['icono'] = ""; 
          $seguimiento[$i]['display_archivos'] = "none";
          $seguimiento[$i]['display_archivos_observado'] = "none";
        }
      } else {
        if(FileHandler::check_file($carpeta, $archivo)==true) {
          $seguimiento[$i]['icono'] = "fa fa-file";
          $seguimiento[$i]['display_archivos'] = "inline-block";
        } else {
          $seguimiento[$i]['icono'] = ""; 
          $seguimiento[$i]['display_archivos'] = "none";
        }

        if(FileHandler::check_file($carpeta, 'informe')==true) {
          $seguimiento[$i]['icono_informe'] = "fa fa-file";
          $seguimiento[$i]['url_informe'] = "informe";
          $seguimiento[$i]['display_informe'] = "inline-block";
        } else {
          $seguimiento[$i]['icono_informe'] = "";
          $seguimiento[$i]['url_informe'] = "#";
          $seguimiento[$i]['display_informe'] = "none";
        }
        
        $seguimiento[$i]['display_archivos_observado'] = "none";
      }
		}	
    
    $tipo_id = $datos['tipo_id'];
    switch($tipo_id) {
      case 3:
        if(is_null($ultima_presentacion) OR empty($ultima_presentacion) OR $ultima_presentacion == '' OR $ultima_presentacion == 0) {
          $flag_ultimapresentacion = 0;  
        } else {
          if(FileHandler::check_file($archivo_id, $ultima_presentacion)==true) $flag_ultimapresentacion = 1;
        }
        
        if ($flag_ultimapresentacion == 1) {
          $gui = str_replace('{display_formulario_subir_informe}', 'block', $gui);
        } else {
          $gui = str_replace('{display_formulario_subir_informe}', 'none', $gui);
        }
        break;
      default:
        $gui = str_replace('{display_formulario_subir_informe}', 'block', $gui);
        break;
    }

		$dict = array("{titulo}"=>"Detalle del documento intervenido", "{disabled}"=>$disabled);
		$dict = array_merge($dict, $this->set_dict($datos));
    if (empty($matriculado[0])) {
      $matriculado[0] = array('correoelectronico'=>'','telefono'=>'','celular'=>'');
    }
    
    $matriculado = $this->set_dict($matriculado[0]);
		$gui_seguimiento = $this->render_regex('repetir', $gui_seguimiento, $seguimiento);
		$render = str_replace("{seguimiento}", $gui_seguimiento, $gui);
		$render = str_replace("{icono_comprobante}", $icono_comprobante, $render);
		$render = str_replace("{comprobante_url}", $comprobante_url, $render);
		$render = str_replace("{ultima_presentacion}", $ultima_presentacion, $render);
		$render = $this->render($dict, $render);
		$render = $this->render($matriculado, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
	
	function mostrar_listado($datos, $estado) {
		$gui = file_get_contents("static/modules/archivos/listar.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		$datos = (!is_array($datos)) ? array() : $datos;
		$dict = array("{titulo}"=>"Listado de documentos", "{estado}"=>$estado);
		$render = $this->render_regex('repetir', $gui, $datos);
		$render = $this->render($dict, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
  
  function mostrar_listado_evaluar($datos, $estado) {
		$gui = file_get_contents("static/modules/archivos/listar_evaluar.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		$datos = (!is_array($datos)) ? array() : $datos;
		$dict = array("{titulo}"=>"Listado de documentos", "{estado}"=>$estado);
		$render = $this->render_regex('repetir', $gui, $datos);
		$render = $this->render($dict, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
	
	function mostrar_listado_autorizacion($datos, $estado, $array_msj) {
		$gui = file_get_contents("static/modules/archivos/listar_autorizaciones.html");
		$gui_tbl_autorizaciones = file_get_contents("static/modules/archivos/tbl_autorizaciones.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		$datos = (!is_array($datos)) ? array() : $datos;
		$dict = array("{titulo}"=>"Listado de documentos", "{estado}"=>$estado);
		$gui_tbl_autorizaciones = $this->render_regex('repetir', $gui_tbl_autorizaciones, $datos);
		$render = str_replace("{tbl_autorizaciones}", $gui_tbl_autorizaciones, $gui);
		$render = $this->render($dict, $render);
		$render = $this->render($array_msj, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
  
  function mostrar_listado_autorizacion_usuario($datos, $estado) {
		$gui = file_get_contents("static/modules/archivos/listar_autorizaciones_usuario.html");
		$gui_tbl_autorizaciones = file_get_contents("static/modules/archivos/tbl_autorizaciones_usuario.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		$datos = (!is_array($datos)) ? array() : $datos;
		$dict = array("{titulo}"=>"Listado de documentos", "{estado}"=>$estado);
		$gui_tbl_autorizaciones = $this->render_regex('repetir', $gui_tbl_autorizaciones, $datos);
		$render = str_replace("{tbl_autorizaciones}", $gui_tbl_autorizaciones, $gui);
		$render = $this->render($dict, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
  
  function mostrar_listado_validacion($datos, $estado, $array_msj) {
		$gui = file_get_contents("static/modules/archivos/listar_validaciones.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		$datos = (!is_array($datos)) ? array() : $datos;
		$dict = array("{titulo}"=>"Listado de documentos", "{estado}"=>$estado);
		$render = $this->render_regex('repetir', $gui, $datos);
    $render = $this->render($array_msj, $render);
		$render = $this->render($dict, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
  
  function mostrar_listado_legalizar($datos, $estado) {
		$gui = file_get_contents("static/modules/archivos/listar_legalizar.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		$datos = (!is_array($datos)) ? array() : $datos;
		$dict = array("{titulo}"=>"Listado de documentos", "{estado}"=>$estado);
		$render = $this->render_regex('repetir', $gui, $datos);
		$render = $this->render($dict, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
  
  function mostrar_listado_pendientes_firma($datos, $estado) {
		$gui = file_get_contents("static/modules/archivos/listar_pendientes_firma.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		$datos = (!is_array($datos)) ? array() : $datos;
		$dict = array("{titulo}"=>"Listado de documentos", "{estado}"=>$estado);
		$render = $this->render_regex('repetir', $gui, $datos);
		$render = $this->render($dict, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
  
  function mostrar_listado_legalizar_usuario($datos, $estado) {
		$gui = file_get_contents("static/modules/archivos/listar_legalizar_usuario.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		$datos = (!is_array($datos)) ? array() : $datos;
		$dict = array("{titulo}"=>"Listado de documentos", "{estado}"=>$estado);
		$render = $this->render_regex('repetir', $gui, $datos);
		$render = $this->render($dict, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
  
  function mostrar_listado_reingresar($datos, $estado, $array_msj) {
		$gui = file_get_contents("static/modules/archivos/listar_reingresar.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		$datos = (!is_array($datos)) ? array() : $datos;
		$dict = array("{titulo}"=>"Listado de documentos", "{estado}"=>$estado);
		$render = $this->render_regex('repetir', $gui, $datos);
		$render = $this->render($dict, $render);
    $render = $this->render($array_msj, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
  
  function mostrar_listado_corregir($datos, $estado, $array_msj) {
		$gui = file_get_contents("static/modules/archivos/listar_corregir.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		$datos = (!is_array($datos)) ? array() : $datos;
		$dict = array("{titulo}"=>"Listado de documentos", "{estado}"=>$estado);
		$render = $this->render_regex('repetir', $gui, $datos);
		$render = $this->render($dict, $render);
    $render = $this->render($array_msj, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
  
  function mostrar_listado_documentos_pendientes($datos, $estado, $array_msj) {
		$gui = file_get_contents("static/modules/archivos/listar_documentos_pendientes.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		$datos = (!is_array($datos)) ? array() : $datos;
		$dict = array("{titulo}"=>"Listado de documentos", "{estado}"=>$estado);
		$render = $this->render_regex('repetir', $gui, $datos);
		$render = $this->render($dict, $render);
    $render = $this->render($array_msj, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
	
	function mostrar_pendientes($datos, $estado) {
		$gui = file_get_contents("static/modules/archivos/listar_pendientes.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		$datos = (!is_array($datos)) ? array() : $datos;
		$dict = array("{titulo}"=>"Listado de documentos", "{estado}"=>$estado);
		$render = $this->render_regex('repetir', $gui, $datos);
		$render = $this->render($dict, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
  
  function mostrar_pendientes_legalizar($datos, $estado) {
		$gui = file_get_contents("static/modules/archivos/listar_pendientes_legalizar.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		$datos = (!is_array($datos)) ? array() : $datos;
		$dict = array("{titulo}"=>"Listado de documentos", "{estado}"=>$estado);
		$render = $this->render_regex('repetir', $gui, $datos);
		$render = $this->render($dict, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
  
  function mostrar_legalizados($datos, $estado) {
		$gui = file_get_contents("static/modules/archivos/listar_legalizados.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		$datos = (!is_array($datos)) ? array() : $datos;
		$dict = array("{titulo}"=>"Listado de documentos", "{estado}"=>$estado);
		$render = $this->render_regex('repetir', $gui, $datos);
		$render = $this->render($dict, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
  
  function mostrar_intervenidos($datos, $estado, $array_msj) {
		$gui = file_get_contents("static/modules/archivos/listar_intervenidos.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		$datos = (!is_array($datos)) ? array() : $datos;
		$dict = array("{titulo}"=>"Listado de documentos intervenidos", "{estado}"=>$estado);
		$render = $this->render_regex('repetir', $gui, $datos);
		$render = $this->render($dict, $render);
    $render = $this->render($array_msj, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
	
	function consultar($datos, $seguimiento, $estado_id) {
		$tipo = $datos["tipo"];
		$gui_html = ($tipo == 1) ? "ver" : "ver_certificacion";
		$gui = file_get_contents("static/modules/archivos/{$gui_html}.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);

		for ($i=0; $i < count($seguimiento); $i++) {
			$carpeta = $seguimiento[$i]['archivo_id'];
			$archivo = $seguimiento[$i]['seguimiento_id'];
			if(FileHandler::check_file($carpeta, $archivo)==true) {
				$seguimiento[$i]['icono'] = "fa fa-file";
			} else {
				$seguimiento[$i]['icono'] = ""; 
			}
		}
    
    if ($estado_id == 6) {
      $gui_barcode = file_get_contents("static/modules/archivos/barcode.html");
		  $gui_btn_print = "block";
      $gui = str_replace('{barcode}', $gui_barcode, $gui);
    } else {
		  $gui_btn_print = "none";
      $msj = 'SU DOCUMENTO NO FUE ACEPTADO TODAVIA';
      $gui = str_replace('{barcode}', $msj, $gui);    
    }
		
		$dict = array("{titulo}"=>"Detalle del documento", "{disabled}"=>$disabled);
		$dict = array_merge($dict, $this->set_dict($datos));
		$render = $this->render_regex('repetir', $gui, $seguimiento);
		$render = str_replace("{gui_btn_print}", $gui_btn_print, $render);
		$render = $this->render($dict, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
  
  function consultar_legalizado($datos, $seguimiento, $estado_id) {
		$gui_html = ($tipo == 1) ? "ver_legalizado" : "ver_certificacion_legalizada";
		$gui = file_get_contents("static/modules/archivos/{$gui_html}.html");
		$gui_tbl_seguimiento = file_get_contents("static/modules/archivos/tbl_seguimiento_legalizado.html");
		$menu = file_get_contents("static/menu.html");
		$tipo = $datos["tipo"];
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);

		for ($i=0; $i < count($seguimiento); $i++) {
			$carpeta = $seguimiento[$i]['archivo_id'];
			$archivo = $seguimiento[$i]['seguimiento_id'];
			if(FileHandler::check_file($carpeta, $archivo)==true) {
				$seguimiento[$i]['icono'] = "fa fa-file";
			} else {
				$seguimiento[$i]['icono'] = ""; 
			}
		}
    
    	$dict = array("{titulo}"=>"Detalle del documento", "{disabled}"=>$disabled);
		$dict = array_merge($dict, $this->set_dict($datos));
		$gui_tbl_seguimiento = $this->render_regex('repetir', $gui_tbl_seguimiento, $seguimiento);
		$render = str_replace("{tbl_seguimiento}", $gui_tbl_seguimiento, $gui);
		$render = str_replace("{gui_btn_print}", $gui_btn_print, $render);
		$render = $this->render($dict, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
  
  function consultar_control_admin($datos, $seguimiento, $estado_id) {
		$tipo = $datos["tipo"];
		$gui_html = ($tipo == 1) ? "ver_control_admin" : "ver_certificacion_control_admin";
		$gui = file_get_contents("static/modules/archivos/{$gui_html}.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);

		for ($i=0; $i < count($seguimiento); $i++) {
			$carpeta = $seguimiento[$i]['archivo_id'];
			$archivo = $seguimiento[$i]['seguimiento_id'];
			if(FileHandler::check_file($carpeta, $archivo)==true) {
				$seguimiento[$i]['icono'] = "fa fa-file";
			} else {
				$seguimiento[$i]['icono'] = ""; 
			}
		}
    
    if ($estado_id == 6) {
      $gui_barcode = file_get_contents("static/modules/archivos/barcode.html");
		  $gui_btn_print = "block";
      $gui = str_replace('{barcode}', $gui_barcode, $gui);
    } else {
		  $gui_btn_print = "none";
      $msj = 'SU DOCUMENTO NO FUE ACEPTADO TODAVIA';
      $gui = str_replace('{barcode}', $msj, $gui);    
    }
		
		$dict = array("{titulo}"=>"Detalle del documento", "{disabled}"=>$disabled);
		$dict = array_merge($dict, $this->set_dict($datos));
		$render = $this->render_regex('repetir', $gui, $seguimiento);
		$render = str_replace("{gui_btn_print}", $gui_btn_print, $render);
		$render = $this->render($dict, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
	
	function mostrar_formulario_validar_tipo1($tipos_trabajo, $archivo, $array_verificar) {
		$gui = file_get_contents("static/modules/archivos/validar_tipo1.html");
		$menu = file_get_contents("static/menu.html");
		$gui_slt_tipos_trabajo = file_get_contents("static/common/slt_tipos_trabajo.html");
		$gui_slt_tipos_trabajo = $this->render_regex('repetir', $gui_slt_tipos_trabajo, $tipos_trabajo);		
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		$dict = array("{titulo}"=>"Validar trabajo");
		$render = $this->render($dict, $gui);
		$render = $this->render($array_verificar, $render);
		$render = str_replace('{slt_tipos_trabajo}', $gui_slt_tipos_trabajo, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
  
  function mostrar_formulario_validar_tipo2($tipos_trabajo, $archivo, $array_verificar) {
		$gui = file_get_contents("static/modules/archivos/validar_tipo2.html");
		$menu = file_get_contents("static/menu.html");
		
		$gui_slt_tipos_trabajo = file_get_contents("static/common/slt_tipos_trabajo.html");
		$gui_slt_tipos_trabajo = $this->render_regex('repetir', $gui_slt_tipos_trabajo, $tipos_trabajo);		
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		$dict = array("{titulo}"=>"Validar documento");
		$render = $this->render($dict, $gui);
		$render = $this->render($array_verificar, $render);
		$render = str_replace('{slt_tipos_trabajo}', $gui_slt_tipos_trabajo, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
  
  function mostrar_formulario_validar($tipos_trabajo, $array_msj) {
		$gui = file_get_contents("static/modules/archivos/validar.html");
		$menu = file_get_contents("static/menu.html");
		
		$gui_slt_tipos_trabajo = file_get_contents("static/common/slt_tipos_trabajo.html");
		$gui_slt_tipos_trabajo = $this->render_regex('repetir', $gui_slt_tipos_trabajo, $tipos_trabajo);		
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		$dict = array("{titulo}"=>"Validar documento");
		$render = $this->render($dict, $gui);
		$render = $this->render($array_msj, $render);
		$render = str_replace('{slt_tipos_trabajo}', $gui_slt_tipos_trabajo, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
	
	function mostrar_formulario_validar_certificacion($tipos_trabajo, $array_msj) {
		$gui = file_get_contents("static/modules/archivos/validar_certificacion.html");
		$menu = file_get_contents("static/menu.html");
		
		$gui_slt_tipos_trabajo = file_get_contents("static/common/slt_tipos_trabajo.html");
		$gui_slt_tipos_trabajo = $this->render_regex('repetir', $gui_slt_tipos_trabajo, $tipos_trabajo);		
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		$dict = array("{titulo}"=>"Validar documento");
		$render = $this->render($dict, $gui);
		$render = $this->render($array_msj, $render);
		$render = str_replace('{slt_tipos_trabajo}', $gui_slt_tipos_trabajo, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
	
	function mostrar_form_adjuntar($datos) {
		$gui = file_get_contents("static/modules/archivos/adjuntar.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);

		$dict = array("{titulo}"=>"Adjuntar documento");
		$dict = array_merge($dict, $this->set_dict($datos));
		$render = $this->render($dict, $gui);
		$template = $this->render_template($menu, $render);
		print $template;
	}

	function aprobados($datos) {
		$gui = file_get_contents("static/modules/archivos/listar_aprobados.html");
		$menu = file_get_contents("static/menu.html");

		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);

		$estado = (is_array($datos)) ? $datos[0]['estado'] : "";
		$dict = array("{titulo}"=>"Listado de documentos", "{estado}"=>$estado);

		$datos = (!is_array($datos)) ? array() : $datos;
		$render = $this->render_regex('repetir', $gui, $datos);
		$render = $this->render($dict, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}

	function reportes($estados=array(), $datos=array(), $estado_id=0, $contador_estados=array()) {
		$gui = file_get_contents("static/modules/archivos/reportes.html");
		$slt_estado = file_get_contents("static/common/slt_estados.html");
		$menu = file_get_contents("static/menu.html");
		
    $slt_estado = $this->render_regex('repetir', $slt_estado, $estados);
		$grupo_id = $_SESSION["sesion.grupo_id"];
    $administrador_display = ($grupo_id == 1) ? "block;" : "none;";
    $btn_display = (!empty($datos)) ? "block;" : "none;";
    
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		$dict = array("{titulo}"=>"Reportes", "{administrador}"=>$administrador_display, "{btn_display}"=>$btn_display);

		$render = $this->render_regex('repetir', $gui, $datos);
		$render = $this->render($dict, $render);
		$render = $this->render($contador_estados, $render);
		$render = str_replace('{slt_estado}', $slt_estado, $render);
		$render = str_replace('{estado_id}', $estado_id, $render);
    $render = str_replace('{theme_path}', THEME_PATH, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
  
  	function mostrar_form_buscar($datos=array(), $estados) {
		$gui = file_get_contents("static/modules/archivos/buscar.html");
		$tbl_buscar = file_get_contents("static/modules/archivos/tbl_buscar.html");
    	$slt_estado = file_get_contents("static/common/slt_estados.html");
		$menu = file_get_contents("static/menu.html");
		$grupo_id = $_SESSION["sesion.grupo_id"];
    	$administrador_display = ($grupo_id == 1) ? "block;" : "none;";
        
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		for ($i=0; $i < count($datos); $i++) {
			$carpeta = $datos[$i]['archivo_id'];
			$archivo = $datos[$i]['seguimiento_id'];
			if(FileHandler::check_file($carpeta, $archivo)==true) {
				$datos[$i]['icono'] = "";
			} else {
				$datos[$i]['icono'] = "invisible";
			}
		}
		
		$dict = array("{titulo}"=>"Buscar documento", "{administrador}"=>$administrador_display);

    	$slt_estado = $this->render_regex('repetir', $slt_estado, $estados);
		$tbl_buscar = $this->render_regex('repetir', $tbl_buscar, $datos);
		$render = str_replace("{tbl_buscar}", $tbl_buscar, $gui);
    	$render = str_replace('{slt_estado}', $slt_estado, $render);
		$render = $this->render($dict, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
  
  function mostrar_consultar_buscar($datos=array(), $estados) {
		$gui = file_get_contents("static/modules/archivos/consultar_buscar.html");
    $slt_estado = file_get_contents("static/common/slt_estados.html");
		$menu = file_get_contents("static/menu.html");
		$grupo_id = $_SESSION["sesion.grupo_id"];
    $administrador_display = ($grupo_id == 1) ? "block;" : "none;";
        
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		for ($i=0; $i < count($datos); $i++) {
			$carpeta = $datos[$i]['archivo_id'];
			$archivo = $datos[$i]['seguimiento_id'];
			if(FileHandler::check_file($carpeta, $archivo)==true) {
				$datos[$i]['icono'] = "";
			} else {
				$datos[$i]['icono'] = "invisible";
			}
		}
		
		$dict = array("{titulo}"=>"Consultar documentos", "{administrador}"=>$administrador_display);

    $slt_estado = $this->render_regex('repetir', $slt_estado, $estados);
		$render = $this->render_regex('repetir', $gui, $datos);
    $render = str_replace('{slt_estado}', $slt_estado, $render);
		$render = $this->render($dict, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
  
  function traer_formulario_archivo_ajax($bandera) {
    switch ($bandera) {
      case 1:
		    $gui = file_get_contents("static/modules/archivos/div_archivos_1.html");
        break;
      case 2:
		    $gui = file_get_contents("static/modules/archivos/div_archivos_2.html");
        break;
      case 3:
		    $gui = file_get_contents("static/modules/archivos/div_archivos_3.html");
        break;
      default:
		    $gui = file_get_contents("static/modules/archivos/div_archivos_1.html");
        break;
    }
      
		print $gui;
	}
  
  function mostrar_admin_control($datos=array()) {
		$gui = file_get_contents("static/modules/archivos/listar_admin_control.html");
		$menu = file_get_contents("static/menu.html");
		$grupo_id = $_SESSION["sesion.grupo_id"];
    $administrador_display = ($grupo_id == 1) ? "block;" : "none;";
    
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		
		for ($i=0; $i < count($datos); $i++) {
			$carpeta = $datos[$i]['archivo_id'];
			$archivo = $datos[$i]['seguimiento_id'];
			if(FileHandler::check_file($carpeta, $archivo)==true) {
				$datos[$i]['icono'] = "";
			} else {
				$datos[$i]['icono'] = "invisible";
			}
		}
		
		$dict = array("{titulo}"=>"Listado de documentos en circuito", "{administrador}"=>$administrador_display);

		$render = $this->render_regex('repetir', $gui, $datos);
		$render = $this->render($dict, $render);
		$template = $this->render_template($menu, $render);
		print $template;
	}
}
?>