<?php


class ReportesView extends View{

	function panel($estados_archivos, $encuesta_activa, $encuesta_pregunta_respuesta, $provincias, $idiomas, $datos_matriculados, $ultimas_cinco_auditor) {
    $gui = file_get_contents("static/modules/reportes/panel.html");
		$menu = file_get_contents("static/menu.html");
    $slt_estado = file_get_contents("static/common/slt_estados.html");
    $tbl_auditor = file_get_contents("static/modules/reportes/tbl_auditor.html");
    $lst_graficos_encuesta = file_get_contents("static/modules/reportes/lst_graficos_encuesta.html");
    $gui_lst_data_graficos = file_get_contents("static/modules/encuestas/lst_data_graficos.html");
    $slt_provincias = file_get_contents("static/common/slt_provincias.html");
    $slt_provincias = $this->render_regex("repetir", $slt_provincias, $provincias);
    $slt_idiomas = file_get_contents("static/modules/matriculados/slt_idioma.html");
    $slt_idiomas = $this->render_regex("repetir", $slt_idiomas, $idiomas);
    
		$grupo_id = $_SESSION["sesion.grupo_id"];
    $administrador_display = ($grupo_id == 1) ? "block;" : "none;";
    
		$restricciones = $this->genera_menu();
		$menu = $this->render($restricciones, $menu);
		$dict_reportes = array("{titulo}"=>"HOME", "{administrador}"=>$administrador_display);
		$dict_reportes = array_merge($dict_reportes, $datos_matriculados);
		
    if (!empty($encuesta_pregunta_respuesta)) {
      $array_preguntas_div = array();
      if (is_array($encuesta_pregunta_respuesta)) {
        foreach ($encuesta_pregunta_respuesta as $clave=>$valor) {
          $array = array('i'=>$valor['i'], 'pregunta'=>$valor['pregunta']);
          $array_preguntas_div[] = $array;
        }
      }
      
      $render_pregunta = '';
      $cod_pregunta = $this->get_regex('repetir_data_graficos', $gui_lst_data_graficos);
      foreach ($encuesta_pregunta_respuesta as $pregunta_respuesta) {
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
      
      $lst_graficos_encuesta = $this->render_regex("repetir_graficos", $lst_graficos_encuesta, $array_preguntas_div);    
      $gui = str_replace('{lst_graficos_encuesta}', $lst_graficos_encuesta, $gui);
      $gui = str_replace('{lst_data_grafico}', $render_pregunta, $gui);
    } else {
      
    }
      
    $encuesta_activa = $this->set_dict($encuesta_activa);
		$slt_estado = $this->render_regex('repetir', $slt_estado, $estados_archivos);
		$tbl_auditor = $this->render_regex('repetir', $tbl_auditor, $ultimas_cinco_auditor);
    
		$render = $this->render($dict_reportes, $gui);
    $render = $this->render($encuesta_activa, $render);
		$render = str_replace('{slt_estado}', $slt_estado, $render);
    $render = str_replace('{slt_provincias}', $slt_provincias, $render);
    $render = str_replace('{slt_idiomas}', $slt_idiomas, $render);
    $render = str_replace('{tbl_auditor}', $tbl_auditor, $render);
    $render = str_replace('{theme_path}', THEME_PATH, $render);
		print $this->render_template($menu, $render);
	}
}
?>