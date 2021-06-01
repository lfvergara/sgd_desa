<?php


class Encuestas {

	function __construct() {
		$this->encuesta_id = 0;
		$this->denominacion = ''; 
		$this->fecha = ''; 
		$this->activa = 0;
		$this->pregunta_id = 0;
		$this->pregunta = '';
		$this->respuesta_id = 0;
		$this->respuesta = '';
		$this->matricula_id = 0;
		$this->encuestaresultado_id = 0;
	}

	function guardar() {
		if($this->encuesta_id == 0){
			$sql = "INSERT INTO encuestas (denominacion, fecha, activa) VALUES (?, ?, ?)";
			$datos = array($this->denominacion, 
			               $this->fecha, 
										 $this->activa);
			$this->encuesta_id = execute_query($sql, $datos);
		} else {
			$sql = "UPDATE encuestas SET denominacion = ?, fecha = ?, activa = ? WHERE encuesta_id = ?";
			$datos = array(
										$this->denominacion, 
                    $this->fecha,
										$this->activa,
										$this->encuesta_id);
			execute_query($sql, $datos);
		}
	}
	
	function listar() {
		$sql = "SELECT
							e.encuesta_id,
							e.denominacion as encuesta,
							e.fecha as fecha_editar,
							DATE_FORMAT(e.fecha, '%d/%m/%Y') as fecha,
							CASE e.activa
                WHEN 0 THEN 'Inactiva'
                WHEN 1 THEN 'Activa'
              END AS activa,
              CASE e.activa
                WHEN 0 THEN 'danger'
                WHEN 1 THEN 'success'
              END AS class,
              CASE e.activa
                WHEN 0 THEN 'inline-block'
                WHEN 1 THEN 'none'
              END AS display_activar
						FROM
							encuestas e";
    return execute_query($sql);
	}
	
	function get() {
		$sql = "SELECT
							e.encuesta_id,
							e.denominacion as encuesta,
							e.fecha as fecha_editar,
							DATE_FORMAT(e.fecha, '%d/%m/%Y') as fecha,
							e.activa,
              CASE e.activa
                WHEN 0 THEN 'Inactiva'
                WHEN 1 THEN 'Activa'
              END AS estado
						FROM
							encuestas e
						WHERE
							e.encuesta_id = ?";
		$datos = array($this->encuesta_id);
		$rst = execute_query($sql, $datos);
		return $rst[0];
	}
  
  function get_pregunta() {
		$sql = "SELECT
							p.pregunta_id,
							p.encuesta_id,
							p.denominacion as pregunta
						FROM
							preguntas p
						WHERE
							p.pregunta_id = ?";
		$datos = array($this->pregunta_id);
		$rst = execute_query($sql, $datos);
		return $rst[0];
	}
  
  function traer_preguntas_encuesta() {
		$sql = "SELECT
							p.pregunta_id,
							p.denominacion as pregunta
						FROM
							preguntas p
						WHERE
							p.encuesta_id = ?";
		$datos = array($this->encuesta_id);
		return execute_query($sql, $datos);
	}
  
  function traer_respuestas_pregunta() {
		$sql = "SELECT
							r.respuesta_id,
							r.denominacion as respuesta
						FROM
							respuestas r
						WHERE
							r.pregunta_id = ?";
		$datos = array($this->pregunta_id);
		return execute_query($sql, $datos);
	}
	
  function activar_encuesta() {
		$sql = "UPDATE encuestas SET activa = 1 WHERE encuesta_id = ?";
		$datos = array($this->encuesta_id);
		execute_query($sql, $datos);
	}
  
  function desactivar_encuestas() {
		$sql = "UPDATE encuestas SET activa = 0";
		execute_query($sql);
	}
  
  function guardar_pregunta() {
    $sql = "INSERT INTO preguntas(denominacion, encuesta_id) VALUES(?,?)";
    $datos = array($this->denominacion, $this->encuesta_id);
		execute_query($sql, $datos);
  }
  
  function actualizar_pregunta() {
    $sql = "UPDATE preguntas SET denominacion = ?, encuesta_id = ? WHERE pregunta_id = ?";
    $datos = array($this->denominacion, $this->encuesta_id, $this->pregunta_id);
		execute_query($sql, $datos);
  }
  
  function eliminar_pregunta() {
    $sql = "DELETE FROM preguntas WHERE pregunta_id = ?";
    $datos = array($this->pregunta_id);
		execute_query($sql, $datos);
  }
  
  function eliminar_respuestas_pregunta() {
    $sql = "DELETE FROM respuestas WHERE pregunta_id = ?";
    $datos = array($this->pregunta_id);
		execute_query($sql, $datos);
  }
  
  function guardar_respuesta() {
    $sql = "INSERT INTO respuestas(denominacion, pregunta_id) VALUES(?,?)";
    $datos = array($this->denominacion, $this->pregunta_id);
		execute_query($sql, $datos);
  }
  
  function eliminar_respuesta() {
    $sql = "DELETE FROM respuestas WHERE respuesta_id = ?";
    $datos = array($this->respuesta_id);
		execute_query($sql, $datos);
  }
  
  function guardar_resultado_encuesta() {
    $sql = "INSERT INTO encuestaresultado(fecha, matricula_id, encuesta_id) VALUES(?,?,?)";
    $datos = array($this->fecha, $this->matricula_id, $this->encuesta_id);
    $this->encuestaresultado_id = execute_query($sql, $datos);
  }
  
  function guardar_resultado_pregunta_respuesta() {
    $sql = "INSERT INTO encuestapreguntaresultado(pregunta, respuesta, encuestaresultado_id) VALUES(?,?,?)";
    $datos = array($this->pregunta, $this->respuesta, $this->encuestaresultado_id);
    $this->encuestaresultado_id = execute_query($sql, $datos);
  }
  
  function traer_resultados_encuesta() {
    $sql = "SELECT 
              er.encuestaresultado_id,
              mo.matricula,
              CONCAT(mo.apellido, ' ', mo.nombre) AS matriculado
            FROM 
              encuestaresultado er INNER JOIN
              matriculas ma ON er.matricula_id = ma.matricula_id INNER JOIN
              matriculados mo ON ma.matricula = mo.matricula
            WHERE 
              er.encuesta_id = ?";
    $datos = array($this->encuesta_id);
    return execute_query($sql, $datos);
  }
  
  function traer_resultado_encuesta() {
    $sql = "SELECT 
              CONCAT(mo.apellido, ' ', mo.nombre) AS matriculado,
              mo.matricula,
              date_format(er.fecha, '%d/%m/%Y') AS fecha_resultado
            FROM 
              encuestaresultado er INNER JOIN
              matriculas m ON er.matricula_id = m.matricula_id INNER JOIN
              matriculados mo ON m.matricula = mo.matricula
            WHERE
              er.encuestaresultado_id = ?";
    $datos = array($this->encuestaresultado_id);
    $rst = execute_query($sql, $datos);
		return $rst[0];
  }
  
  function traer_resultados_pregunta_encuesta() {
    $sql = "SELECT 
              epr.encuestapreguntaresultado_id,
              epr.pregunta,
              epr.respuesta
            FROM 
              encuestapreguntaresultado epr
            WHERE
              epr.encuestaresultado_id = ?";
    $datos = array($this->encuestaresultado_id);
    return execute_query($sql, $datos);
  }
  
  function cantidad_respuestas_encuesta() {
    $sql = "SELECT
              epr.pregunta AS PREGUNTA,
              epr.respuesta AS RESPUESTA,
              COUNT(epr.respuesta) AS CANT
            FROM
              encuestapreguntaresultado epr INNER JOIN
              encuestaresultado er ON epr.encuestaresultado_id = er.encuestaresultado_id
            WHERE
              er.encuesta_id = ?
            GROUP BY
              epr.pregunta, epr.respuesta";
    $datos = array($this->encuesta_id);
    return execute_query($sql, $datos);
  }
  
  function traer_encuesta_activa() {
    $sql = "SELECT 
              e.encuesta_id,
              e.denominacion as encuesta,
              e.fecha
            FROM 
              encuestas e
            WHERE 
              e.activa = ?";
    $datos = array(1);
    return execute_query($sql, $datos);
  }
}
?>