<?php


class Eventos {

	function __construct() {
		$this->evento_id = 0;
		$this->denominacion = ''; 
		$this->ubicacion = ''; 
		$this->fecha = ''; 
	}
  
  function guardar() {
		if($this->evento_id == 0){
			$sql = "INSERT INTO eventos (denominacion, ubicacion, fecha) VALUES (?, ?, ?)";
			$datos = array($this->denominacion, 
			               $this->ubicacion,
			               $this->fecha);
			$this->evento_id = execute_query($sql, $datos);
		} else {
			$sql = "UPDATE eventos SET denominacion = ?, ubicacion = ?, fecha = ? WHERE evento_id = ?";
			$datos = array(
										$this->denominacion,
										$this->ubicacion,
                    $this->fecha,
										$this->evento_id);
			execute_query($sql, $datos);
		}
	}
  
  function cargar_modelo() {
		$sql = "SELECT
							e.evento_id,
              e.denominacion,
              e.ubicacion,
              e.fecha
						FROM 
              eventos e
						WHERE
							e.evento_id = ?";
		$datos = array($this->evento_id);
		$rst = execute_query($sql, $datos);
    foreach ($rst[0] as $clave=>$valor) $this->$clave = $valor;
	}
  
  function traer_eventos() {
    $sql = "SELECT 
              e.evento_id as evento_id,
              e.denominacion as denominacion,
              e.ubicacion as ubicacion,
              date_format(e.fecha, '%d/%m/%Y') as fecha_modificada,
              e.fecha as fecha
            FROM 
              eventos e
            ORDER BY
              e.fecha DESC";
		$rst = execute_query($sql);
    if(!is_array[$rst]) $rst = array();
		return $rst;
  }
  
  function get() {
		$sql = "SELECT
							e.evento_id as evento_id,
              e.denominacion as denominacion,
              e.ubicacion as ubicacion,
              e.fecha as fecha
						FROM 
              eventos e
						WHERE
							e.evento_id = ?";
		$datos = array($this->evento_id);
		$rst = execute_query($sql, $datos);
		return $rst[0];
	}
  
  function eliminar() {
    $sql = "DELETE FROM eventos WHERE evento_id = ?";
		$datos = array($this->evento_id);
    execute_query($sql, $datos);
  }
}
?>