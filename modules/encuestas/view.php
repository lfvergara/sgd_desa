<?php


class EncuestasView extends View{
  function panel($encuestas) {
		$gui = file_get_contents("static/modules/encuestas/panel.html");
		$gui_tbl_encuestas = file_get_contents("static/modules/encuestas/tbl_encuestas.html");
		$menu = file_get_contents("static/menu.html");
    
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		$dict = array("{titulo}"=>"Gestión de Encuestas");
    if(!is_array($encuestas)){$encuestas=array();}
		$gui_tbl_encuestas = $this->render_regex("repetir", $gui_tbl_encuestas, $encuestas);
    $render = str_replace('{tbl_encuestas}', $gui_tbl_encuestas, $gui);
		$render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}
  
	function agregar() {
		$gui = file_get_contents("static/modules/encuestas/agregar.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
    $dict = array("{titulo}"=>"Agregar Encuesta");
    
		$render = $this->render($dict, $gui);
		print $this->render_template($menu, $render);
	}
	
	function editar($encuesta, $preguntas) {
		$gui = file_get_contents("static/modules/encuestas/editar.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
    $dict = array("{titulo}"=>"Actualización de Encuestas");
    
    if(!is_array($preguntas)){$preguntas=array();}
    $encuesta = $this->set_dict($encuesta);
		$render = $this->render_regex("repetir", $gui, $preguntas);    
		$render = $this->render($encuesta, $render);
		$render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}
  
  function consultar($encuesta, $preguntas) {
		$gui = file_get_contents("static/modules/encuestas/consultar.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
    $dict = array("{titulo}"=>"Actualización de Encuestas");
    
    foreach ($preguntas as $clave=>$valor) {
      $respuestas = $valor['respuestas'];
      $respuestas_txt = '';
      if(!empty($respuestas)) {
        $array_respuestas = array();
        foreach ($respuestas as $respuesta) $array_respuestas[] = $respuesta['respuesta'];
        $respuestas_txt = implode('<br>', $array_respuestas);
      } else {
        $respuestas_txt = 'Sin respuestas definidas.';
      }
      
      $preguntas[$clave]['respuestas_txt'] = $respuestas_txt;
    }
     
    if(!is_array($preguntas)){$preguntas=array();}
    $encuesta = $this->set_dict($encuesta);
		$render = $this->render_regex("repetir", $gui, $preguntas);    
		$render = $this->render($encuesta, $render);
		$render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}
  
  function resultados($encuesta, $encuestaresultados, $array_pregunta_respuesta) {
    $gui = file_get_contents("static/modules/encuestas/resultados.html");
		$gui_tbl_encuestaresultado = file_get_contents("static/modules/encuestas/tbl_encuestaresultado.html");
		$gui_lst_data_graficos = file_get_contents("static/modules/encuestas/lst_data_graficos.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
    $dict_theme = array("{titulo}"=>"Actualización de Encuestas");
    
    $array_preguntas_div = array();
    if (is_array($array_pregunta_respuesta)) {
      foreach ($array_pregunta_respuesta as $clave=>$valor) {
        $array = array('i'=>$valor['i'],
                       'pregunta'=>$valor['pregunta']);
        $array_preguntas_div[] = $array;
      }
    }    
    
    if(!is_array($encuestaresultados)){$encuestaresultados=array();}
    $encuesta = $this->set_dict($encuesta);
		$gui_tbl_encuestaresultado = $this->render_regex("repetir", $gui_tbl_encuestaresultado, $encuestaresultados);
    
    $render_pregunta = '';
    $cod_pregunta = $this->get_regex('repetir_data_graficos', $gui_lst_data_graficos);
    
    foreach ($array_pregunta_respuesta as $pregunta_respuesta) {
      $respuestas_array = $pregunta_respuesta['respuestas'];
      unset($pregunta_respuesta['respuestas']);
      $pregunta_respuesta = $this->set_dict($pregunta_respuesta);
      $div_pregunta = $this->render($pregunta_respuesta, $cod_pregunta);
      
      
			$lst_respuestas = file_get_contents("static/modules/encuestas/lst_data_grafico_respuestas.html");
      $cod_respuestas = $this->get_regex('repetir_data_respuestas', $lst_respuestas);
      $render_respuestas = '';
      foreach($respuestas_array as $dict) {
        $dict = $this->set_dict($dict);
        $lst_cantidad_respuesta = $this->render($dict, $cod_respuestas);
        $render_respuestas .= $lst_cantidad_respuesta;  
      }
        
      $div_pregunta = str_replace('{lst_data_grafico_respuestas}', $render_respuestas, $div_pregunta);
      $render_pregunta .= $div_pregunta;
    }
    
		$render = $this->render_regex("repetir_graficos", $gui, $array_preguntas_div);    
		$render = str_replace('{tbl_encuestaresultado}', $gui_tbl_encuestaresultado, $render);
		$render = str_replace('{lst_data_grafico}', $render_pregunta, $render);
		$render = str_replace('{theme_path}', THEME_PATH, $render);
		$render = $this->render($encuesta, $render);
		$render = $this->render($dict_theme, $render);
		print $this->render_template($menu, $render);
	}
  
  function consultar_resultado($encuesta, $resultado_encuesta, $resultado_pregunta_respuesta) {
    $gui = file_get_contents("static/modules/encuestas/consultar_resultado.html");
    $gui_tbl_resultado_pregunta_respuesta = file_get_contents("static/modules/encuestas/tbl_resultado_pregunta_respuesta.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
    $dict_theme = array("{titulo}"=>"Actualización de Encuestas");    
    
		$encuesta = $this->set_dict($encuesta);
		$resultado_encuesta = $this->set_dict($resultado_encuesta);
		$gui_tbl_resultado_pregunta_respuesta = $this->render_regex("repetir", $gui_tbl_resultado_pregunta_respuesta, $resultado_pregunta_respuesta);    
		$render = $this->render($encuesta, $gui);
		$render = $this->render($resultado_encuesta, $render);
		$render = str_replace('{tbl_resultado_pregunta_respuesta}', $gui_tbl_resultado_pregunta_respuesta, $render);
		$render = $this->render($dict_theme, $render);
		print $this->render_template($menu, $render);
	}
  
  function editar_pregunta($encuesta, $pregunta, $respuestas) {
		$gui = file_get_contents("static/modules/encuestas/editar_pregunta.html");
		$menu = file_get_contents("static/menu.html");
		
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
    $dict = array("{titulo}"=>"Encuesta: Configurar Pregunta-Respuesta");
    
    if(!is_array($respuestas)){$respuestas=array();}
    $encuesta = $this->set_dict($encuesta);
    $pregunta = $this->set_dict($pregunta);
		$render = $this->render_regex("repetir", $gui, $respuestas);    
		$render = $this->render($encuesta, $render);
		$render = $this->render($pregunta, $render);
		$render = $this->render($dict, $render);
		print $this->render_template($menu, $render);
	}
}
?>