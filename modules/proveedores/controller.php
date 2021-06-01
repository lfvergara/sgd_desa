<?php
require_once "modules/proveedores/view.php";
require_once "modules/proveedores/model.php";

class ProveedoresController {

	function __construct() {
		$this->model = new Proveedores();
		$this->view = new ProveedoresView();
	}

}
?>
