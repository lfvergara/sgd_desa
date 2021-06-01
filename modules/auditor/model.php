<?php


class Auditor {

  function __construct() {
    $this->auditor_id = 0;
    $this->recurso = '';
    $this->objeto = '';
    $this->usuario = '';
    $this->navegador = '';
    $this->sistemaoperativo = '';
    $this->ip = '';
    $this->fecha = '';
    $this->hora = '';
    $this->detalle = '';
  }

  function save() {
    if($this->auditor_id == 0){
			$sql = "INSERT INTO auditor (recurso, objeto, usuario, navegador, sistemaoperativo, ip, fecha, hora, detalle) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$datos = array($this->recurso, $this->objeto, $this->usuario, $this->navegador, $this->sistemaoperativo, $this->ip, $this->fecha, $this->hora, $this->detalle);
			$this->auditor_id = execute_query($sql, $datos);
		} else {
			$sql = "UPDATE auditor SET recurso = ?, objeto = ?, usuario = ?, navegador = ?, sistemaoperativo = ?, ip = ?, fecha = ?, hora = ?, detalle = ? WHERE auditor_id = ?";
			$datos = array($this->recurso, $this->objeto, $this->usuario, $this->navegador, $this->sistemaoperativo, $this->ip, $this->fecha, $this->hora, $this->detalle, $this->auditor_id);
			execute_query($sql, $datos);
		}
  }

	function listar() {
    $sql = "SELECT
              a.auditor_id,
              a.recurso,
              a.objeto,
              a.usuario,
              a.navegador,
              a.sistemaoperativo,
							a.ip,
              a.fecha,
              a.hora,
              a.detalle
            FROM
              auditor a
						ORDER BY
							a.usuario ASC, a.fecha DESC, a.detalle DESC
            LIMIT 5000";
    return execute_query($sql);
  }
  
  function listar_ultimos_cinco() {
    $sql = "SELECT
              a.auditor_id,
              a.recurso,
              a.objeto,
              a.usuario,
              a.navegador,
              a.sistemaoperativo,
							a.ip,
              a.fecha,
              a.hora,
              a.detalle
            FROM
              auditor a
            WHERE
              a.objeto NOT LIKE '%Exporta%'
						ORDER BY
							a.fecha DESC
            LIMIT 5";
    return execute_query($sql);
  }

  function get() {
    $sql = "SELECT
              a.auditor_id,
              a.recurso,
              a.objeto,
              a.usuario,
              a.navegador,
              a.sistemaoperativo,
							a.ip,
              a.fecha,
              a.hora,
              a.detalle
            FROM
              auditor a
            WHERE
              auditor_id = ?";
    $datos = array($this->auditor_id);
    $rst = execute_query($sql, $datos);
    return $rst[0];
  }
  
  function descargar_informe($criterio) {
    $sql = "SELECT
              a.auditor_id,
              a.recurso,
              a.objeto,
              a.usuario,
              a.navegador,
              a.sistemaoperativo,
              a.ip,
              a.fecha,
              a.hora,
              a.detalle
            FROM
              auditor a
            WHERE
              a.detalle LIKE '{$criterio}'
            ORDER BY
              a.detalle DESC, a.fecha ASC, a.hora ASC";
    return execute_query($sql);
  }
}
?>
