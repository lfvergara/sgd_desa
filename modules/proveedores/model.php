<?php


class Proveedores {

	function __construct(){
		$this->proveedor_id = 0;
		$this->cuit = 0;
		$this->denominacion = '';
	}

	function get_from_cuit() {
		$sql = "SELECT proveedor_id, cuit, denominacion	FROM proveedores WHERE cuit = ?";
		$datos = array($this->cuit);
		$rst = execute_query($sql, $datos);
		if(is_array($rst)) {
			foreach ($rst[0] as $propiedad => $valor) $this->$propiedad = $valor;
		}
	}

	function save() {
		$sql = "INSERT INTO proveedores (cuit, denominacion) VALUES (?, ?)";
		$datos = array($this->cuit, $this->denominacion);
		$this->proveedor_id = execute_query($sql, $datos);
	}
}
?>
