<?php


class OpinionesTipos {

	function __construct() {
		$this->opiniontipo_id = 0;
		$this->denominacion = '';
	}
  
  function guardar() {
		if($this->opiniontipo_id == 0){
			$sql = "INSERT INTO opinionestipos (denominacion) VALUES (?)";
			$datos = array($this->denominacion);
			$this->opiniontipo_id = execute_query($sql, $datos);
		} else {
			$sql = "UPDATE opinionestipos SET denominacion = ? WHERE opiniontipo_id = ?";
			$datos = array($this->denominacion, $this->opiniontipo_id);
			execute_query($sql, $datos);
		}
	}
  
  function traer_opinionestipos() {
    $sql = "SELECT 
              ot.opiniontipo_id as opiniontipo_id,
              ot.denominacion as denominacion
            FROM 
              opinionestipos ot
            ORDER BY
              ot.denominacion ASC";
		$rst = execute_query($sql);
    if(!is_array[$rst]) $rst = array();
		return $rst;
  }
  
  function get() {
		$sql = "SELECT
							ot.opiniontipo_id as opiniontipo_id,
              ot.denominacion as denominacion
						FROM 
              opinionestipos ot
						WHERE
							ot.opiniontipo_id = ?";
		$datos = array($this->opiniontipo_id);
		$rst = execute_query($sql, $datos);
		return $rst[0];
	}
  
  function eliminar() {
    $sql = "DELETE FROM opinionestipos WHERE opiniontipo_id = ?";
		$datos = array($this->opiniontipo_id);
    execute_query($sql, $datos);
  }
}
?>