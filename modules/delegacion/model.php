<?php


class Delegacion {

  function __construct() {
    $this->delegacion_id = 0;
    $this->denominacion = '';
  }

  function save() {
    if ($this->delegacion_id == 0) {
		  $sql = "INSERT INTO delegacion (denominacion) VALUES (?)";
			$datos = array($this->denominacion);
      $this->delegacion_id = execute_query($sql, $datos);
		} else {
			$sql = "UPDATE delegacion SET denominacion = ? WHERE delegacion_id = ?";
			$datos = array($this->denominacion, $this->delegacion_id);
			execute_query($sql, $datos);
		}
  }

	function delete() {
		$sql = "DELETE FROM delegacion WHERE delegacion_id = ?";
		$datos = array($this->delegacion_id);
		execute_query($sql, $datos);
	}
	
  function listar() {
    $sql = "SELECT
              d.delegacion_id,
              d.denominacion
            FROM
              delegacion d
						ORDER BY
							d.denominacion ASC";
    return execute_query($sql);
  }
  
  function get() {
    $sql = "SELECT
              d.delegacion_id,
              d.denominacion
            FROM
              delegacion d
            WHERE
              d.delegacion_id = ?";
    $datos = array($this->delegacion_id);
    $rst = execute_query($sql, $datos);
    return $rst[0];
  }
}
?>