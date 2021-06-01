<?php


class Novedades {

	function __construct() {
		$this->novedad_id = 0;
		$this->denominacion = ''; 
		$this->contenido = ''; 
		$this->activo = ''; 
		$this->destacado = ''; 
		$this->fecha = ''; 
	}
  
  function guardar() {
		if($this->novedad_id == 0){
			$sql = "INSERT INTO novedades (denominacion, contenido, activo, destacado, fecha) VALUES (?, ?, ?, ?, ?)";
			$datos = array($this->denominacion, 
			               $this->contenido, 
										 $this->activo,
										 $this->destacado,
			               $this->fecha);
			$this->novedad_id = execute_query($sql, $datos);
		} else {
			$sql = "UPDATE novedades SET denominacion = ?, contenido = ?, activo = ?, destacado = ?, fecha = ? WHERE novedad_id = ?";
			$datos = array(
										$this->denominacion, 
										$this->contenido, 
										$this->activo,
										$this->destacado,
                    $this->fecha,
										$this->novedad_id);
			execute_query($sql, $datos);
		}
	}
  
  function cargar_modelo_novedad() {
		$sql = "SELECT
							n.novedad_id,
              n.denominacion,
              n.contenido,
              n.activo,
              n.destacado,
              n.fecha
						FROM 
              novedades n
						WHERE
							n.novedad_id = ?";
		$datos = array($this->novedad_id);
		$rst = execute_query($sql, $datos);
    foreach ($rst[0] as $clave=>$valor) $this->$clave = $valor;
	}
  
  function activar_novedad() {
			$sql = "UPDATE novedades SET activo = ? WHERE novedad_id = ?";
			$datos = array(1, $this->novedad_id);
			execute_query($sql, $datos);
	}
  
  function desactivar_novedad() {
			$sql = "UPDATE novedades SET activo = ? WHERE novedad_id = ?";
			$datos = array(0, $this->novedad_id);
			execute_query($sql, $datos);
	}
  
  function destacar_novedad() {
			$sql = "UPDATE novedades SET destacado = ? WHERE novedad_id = ?";
			$datos = array(1, $this->novedad_id);
			execute_query($sql, $datos);
	}
  
  function desactivar_destacado_novedades() {
			$sql = "UPDATE novedades SET destacado = ?";
			$datos = array(0);
			execute_query($sql, $datos);
	}
	
	function traer_novedades() {
    $sql = "SELECT 
              n.novedad_id as novedad_id,
              n.denominacion as denominacion,
              CONCAT(LEFT(n.contenido, 450), '...') as contenido,
              n.activo as activo,
              date_format(n.fecha, '%d/%m/%Y') as fecha,
              IF(n.destacado = 0, 'times', 'check') as destacado_icon,
              IF(n.destacado = 0, 'danger', 'success') as destacado_class,
              IF(n.destacado = 0, 'DESTACAR', '') as destacado_text,
              IF(n.activo = 0, 'times', 'check') as activo_icon,
              IF(n.activo = 0, 'danger', 'success') as activo_class,
              IF(n.activo = 0, 'ACTIVAR', 'DESACTIVAR') as activo_text,
              IF(n.activo = 0, 'activar', 'desactivar') as activo_url,
              IF(n.activo = 0, 'success', 'danger') as activo_class_url,
              CASE n.activo
                WHEN 0 THEN 'inline-block'
                WHEN 1 THEN 'none'
              END AS display_activar,
              CASE n.destacado
                WHEN 0 THEN 'inline-block'
                WHEN 1 THEN 'none'
              END AS display_destacar
            FROM 
              novedades n
            ORDER BY
              n.fecha";
		$rst = execute_query($sql);
    if(!is_array[$rst]) $rst = array();
		return $rst;
  }
  
  function get() {
		$sql = "SELECT
							n.novedad_id as novedad_id,
              n.denominacion as denominacion,
              n.contenido as contenido,
              n.activo as activo,
              n.fecha as fecha,
              CASE n.activo
                WHEN 0 THEN 'Inactiva'
                WHEN 1 THEN 'Activa'
              END AS estado_activo,
              CASE n.destacado
                WHEN 0 THEN 'Inactiva'
                WHEN 1 THEN 'Activa'
              END AS estado_destacado
						FROM 
              novedades n
						WHERE
							n.novedad_id = ?";
		$datos = array($this->novedad_id);
		$rst = execute_query($sql, $datos);
		return $rst[0];
	}
  
  function listar_novedades_activas() {
    $sql = "SELECT 
              n.novedad_id as novedad_id,
              n.denominacion as denominacion,
              CONCAT(LEFT(n.contenido, 450), '...') as contenido,
              n.activo as activo,
              n.destacado as destacado,
              date_format(n.fecha, '%d/%m/%Y') as fecha,
              IF(n.destacado = 0, 'times', 'check') as destacado_icon,
              IF(n.destacado = 0, 'danger', 'success') as destacado_class,
              IF(n.destacado = 0, 'DESTACAR', '') as destacado_text,
              IF(n.activo = 0, 'times', 'check') as activo_icon,
              IF(n.activo = 0, 'danger', 'success') as activo_class,
              IF(n.activo = 0, 'ACTIVAR', 'DESACTIVAR') as activo_text,
              IF(n.activo = 0, 'activar', 'desactivar') as activo_url,
              IF(n.activo = 0, 'success', 'danger') as activo_class_url,
              CASE n.activo
                WHEN 0 THEN 'inline-block'
                WHEN 1 THEN 'none'
              END AS display_activar,
              CASE n.destacado
                WHEN 0 THEN 'inline-block'
                WHEN 1 THEN 'none'
              END AS display_destacar
            FROM 
              novedades n
            WHERE
              n.activo = 1
            ORDER BY
              n.destacado DESC, n.fecha DESC";
		$rst = execute_query($sql);
    if(!is_array[$rst]) $rst = array();
		return $rst;
  }
  
  function eliminar() {
    $sql = "DELETE FROM novedades WHERE novedad_id = ?";
		$datos = array($this->novedad_id);
    execute_query($sql, $datos);
  }
}
?>