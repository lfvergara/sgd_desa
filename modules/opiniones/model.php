<?php


class Opiniones {

	function __construct() {
		$this->opinion_id = 0;
		$this->opinion = '';
		$this->fecha = '';
		$this->hora = '';
		$this->matriculado_id = 0;
		$this->opiniontipo_id = 0;
	}
  
  function guardar() {
		if($this->opinion_id == 0){
			$sql = "INSERT INTO opiniones (opinion, fecha, hora, matriculado_id, opiniontipo_id) VALUES (?,?,?,?,?)";
			$datos = array($this->opinion,
                     $this->fecha,
                     $this->hora,
                     $this->matriculado_id,
                     $this->opiniontipo_id);
			$this->opinion_id = execute_query($sql, $datos);
		} else {
			$sql = "UPDATE opiniones SET opinion = ?, fecha = ?, hora = ?, matriculado_id = ?, opiniontipo_id = ? WHERE opinion_id = ?";
			$datos = array($this->opinion, $this->fecha, $this->hora, $this->matriculado_id, $this->opiniontipo_id, $this->opinion_id);
			execute_query($sql, $datos);
		}
	}
  
  function traer_opiniones() {
    $sql = "SELECT 
              o.opinion_id as opinion_id,
              CONCAT(LEFT(o.opinion,75), '...') as opinion,
              o.fecha as fecha,
              o.hora as hora,
              ot.denominacion as tipo,
              CONCAT(m.apellido, ' ', m.nombre) as matriculado,
              m.correoelectronico as correoelectronico,
              m.celular as celular
            FROM 
              opiniones o INNER JOIN
              opinionestipos ot ON o.opiniontipo_id = ot.opiniontipo_id INNER JOIN
              matriculados m ON o.matriculado_id = m.matriculado_id
            ORDER BY
              o.fecha DESC";
		$rst = execute_query($sql);
    if(!is_array[$rst]) $rst = array();
		return $rst;
  }
  
  function listar_tipo_opinion() {
    $sql = "SELECT 
              o.opinion_id as opinion_id,
              o.opinion as opinion,
              o.fecha as fecha,
              o.hora as hora,
              ot.denominacion as tipo,
              CONCAT(m.apellido, ' ', m.nombre) as matriculado,
              m.correoelectronico as correoelectronico,
              m.celular as celular
            FROM 
              opiniones o INNER JOIN
              opinionestipos ot ON o.opiniontipo_id = ot.opiniontipo_id INNER JOIN
              matriculados m ON o.matriculado_id = m.matriculado_id
            WHERE
              o.opiniontipo_id = ?
            ORDER BY
              o.fecha DESC";
		$datos = array($this->opiniontipo_id);
		$rst = execute_query($sql, $datos);
    if(!is_array[$rst]) $rst = array();
		return $rst;
  }
  
  function get() {
		$sql = "SELECT
							o.opinion_id as opinion_id,
              o.opinion as opinion,
              o.fecha as fecha,
              o.hora as hora,
              ot.denominacion as tipo,
              CONCAT(m.apellido, ' ', m.nombre) as matriculado,
              m.matricula as matricula,
              m.correoelectronico as correoelectronico,
              m.celular as celular
            FROM 
              opiniones o INNER JOIN
              opinionestipos ot ON o.opiniontipo_id = ot.opiniontipo_id INNER JOIN
              matriculados m ON o.matriculado_id = m.matriculado_id
						WHERE
							o.opinion_id = ?";
		$datos = array($this->opinion_id);
		$rst = execute_query($sql, $datos);
		return $rst[0];
	}
  
  function eliminar() {
    $sql = "DELETE FROM opiniones WHERE opinion_id = ?";
		$datos = array($this->opinion_id);
    execute_query($sql, $datos);
  }
}
?>