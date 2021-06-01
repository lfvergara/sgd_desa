<?php


class ProveedoresView extends View{

	function mantenimiento($datos) {
		$gui = file_get_contents("static/modules/centrales/mantenimiento.html");

		$dict = array("{titulo}"=>"Mantenimiento de Centrales");

		$render = $this->render_regex('repetir', $gui, $datos);
		$render = $this->render($dict, $render);
		$template = $this->render_template($render);
		print $template;
	}

}
?>
