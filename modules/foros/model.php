<?php


class Foros {

	function __construct() {
		$this->foro_id = 0;
		$this->tema = ''; 
		$this->contenido = ''; 
		$this->fecha = ''; 
		$this->usuario_id = 0; 
		$this->foroestado_id = 0;
		$this->codigo = ''; 
		$this->denominacion = ''; 
		$this->estado_foro_id = 0;
		$this->activo = 0;
		$this->mensaje = '';
	}
  
  function guardar() {
		if($this->foro_id == 0){
      $sql = "INSERT INTO foros (tema, contenido, fecha, usuario_id) VALUES (?, ?, NOW(), ?)";
			$datos = array($this->tema, 
			               $this->contenido, 
			               $this->usuario_id);
			$this->foro_id = execute_query($sql, $datos);
      $foro_id = $this->foro_id;
      
      $sql = "INSERT INTO forosestados (codigo, denominacion, fecha, usuario_id, foro_id) VALUES(?, ?, NOW(), ?, ?)";
      $datos = array($this->codigo, 
			               $this->denominacion, 
			               $this->usuario_id, 
										 $this->foro_id);
			$this->foroestado_id = execute_query($sql, $datos);
			$this->foro_id = $foro_id;
		} else {
			$sql = "UPDATE foros SET tema = ?, fecha = ?, usuario_id = ? WHERE foro_id = ?";
			$datos = array(
										$this->tema, 
			               $this->contenido, 
										$this->fecha, 
										$this->usuario_id,
										$this->foro_id);
			execute_query($sql, $datos);
		}
	}
  
  function cargar_modelo_foro() {
		$sql = "SELECT
							f.foro_id,
              f.tema,
              f.contenido,
              f.fecha,
              f.usuario_id
						FROM 
              foros f
						WHERE
							f.foro_id = ?";
		$datos = array($this->foro_id);
		$rst = execute_query($sql, $datos);
    foreach ($rst[0] as $clave=>$valor) $this->$clave = $valor;
	}
  
  function guardar_estado_foro() {
    $sql = "INSERT INTO forosestados (codigo, denominacion, fecha, usuario_id, foro_id) VALUES(?, ?, NOW(), ?, ?)";
    $datos = array($this->codigo, 
		               $this->denominacion, 
			             $this->usuario_id, 
									 $this->foro_id);
    $this->foroestado_id = execute_query($sql, $datos);
	}
  
  function guardar_respuesta_foro() {
    $sql = "INSERT INTO forosrespuestas (fecha, mensaje, activo, usuario_id, foro_id) VALUES(NOW(), ?, ?, ?, ?)";
    $datos = array($this->mensaje, 
		               $this->activo, 
		               $this->usuario_id, 
									 $this->foro_id);
		$this->fororespuesta_id = execute_query($sql, $datos);
  }
  
  function traer_foros_estados() {
    /**
    1 = PEN - PENDIENTE
    2 = ACT - ACTIVO
    3 = CER - CERRADO
    4 = REC - RECHAZADO
    */
     
    $sql = "SELECT 
              f.foro_id,
              f.tema,
              CONCAT(LEFT(f.contenido, 70), '...') AS contenido,
              date_format(f.fecha, '%d/%m/%Y') as fecha,
              CONCAT(ma.apellido, ' ', ma.nombre) as matriculado
            FROM 
              foros f INNER JOIN 
              forosestados fe ON f.foro_id = fe.foro_id INNER JOIN
							(
								SELECT foro_id, max(foroestado_id) AS max_sid
								FROM forosestados
								GROUP BY foro_id
							) m ON fe.foroestado_id = m.max_sid INNER JOIN
              matriculas m ON f.usuario_id = m.usuario_id INNER JOIN 
              matriculados ma ON m.matricula = ma.matricula
            WHERE
              fe.codigo = ?
            ORDER BY
              f.fecha DESC,
              f.foro_id DESC";
    $datos = array($this->codigo);
		$rst = execute_query($sql, $datos);
    if(!is_array[$rst]) $rst = array();
    return $rst;
  }
  
  function traer_foros_respuestas_estados() {
    /**
    1 = PEN - PENDIENTE
    2 = ACT - ACTIVO
    3 = CER - CERRADO
    4 = REC - RECHAZADO
    */
     
    $sql = "SELECT 
              f.foro_id,
              fe.denominacion as estado,
              f.tema,
              CONCAT(LEFT(f.contenido, 70), '...') AS contenido,
              date_format(f.fecha, '%d/%m/%Y') as fecha,
              CONCAT(ma.apellido, ' ', ma.nombre) as matriculado,
              (SELECT 
                COUNT(fr.fororespuesta_id)
               FROM
                forosrespuestas fr
               WHERE
                fr.foro_id = f.foro_id AND
                fr.activo = ?) as cantidad
            FROM 
              foros f INNER JOIN 
              forosestados fe ON f.foro_id = fe.foro_id INNER JOIN
							(
								SELECT foro_id, max(foroestado_id) AS max_sid
								FROM forosestados
								GROUP BY foro_id
							) m ON fe.foroestado_id = m.max_sid INNER JOIN
              matriculas m ON f.usuario_id = m.usuario_id INNER JOIN 
              matriculados ma ON m.matricula = ma.matricula
            WHERE
              fe.codigo = ?
            ORDER BY
              f.fecha DESC,
              f.foro_id DESC";
    $datos = array($this->activo, $this->codigo);
		$rst = execute_query($sql, $datos);
    if(!is_array[$rst]) $rst = array();
    return $rst;
  }
  
  function traer_foros_respuestas_matriculados() {
    /**
    1 = PEN - PENDIENTE
    2 = ACT - ACTIVO
    3 = CER - CERRADO
    4 = REC - RECHAZADO
    */
     
    $sql = "SELECT 
              f.foro_id,
              fe.denominacion as estado,
              f.tema,
              CONCAT(LEFT(f.contenido, 70), '...') AS contenido,
              date_format(f.fecha, '%d/%m/%Y') as fecha,
              CONCAT(ma.apellido, ' ', ma.nombre) as matriculado,
              (SELECT 
                COUNT(fr.fororespuesta_id)
               FROM
                forosrespuestas fr
               WHERE
                fr.foro_id = f.foro_id AND
                fr.activo = ?) as cantidad
            FROM 
              foros f INNER JOIN 
              forosestados fe ON f.foro_id = fe.foro_id INNER JOIN
							(
								SELECT foro_id, max(foroestado_id) AS max_sid
								FROM forosestados
								GROUP BY foro_id
							) m ON fe.foroestado_id = m.max_sid INNER JOIN
              matriculas m ON f.usuario_id = m.usuario_id INNER JOIN 
              matriculados ma ON m.matricula = ma.matricula
            WHERE
              fe.codigo IN ('ACT', 'CER')
            ORDER BY
              f.fecha DESC,
              f.foro_id DESC";
    $datos = array($this->activo);
		$rst = execute_query($sql, $datos);
    if(!is_array[$rst]) $rst = array();
    return $rst;
  }
  
  function get() {
		$sql = "SELECT
							f.foro_id,
              f.tema,
              f.contenido,
              date_format(f.fecha, '%d/%m/%Y') as fecha,
              CONCAT(ma.apellido, ' ', ma.nombre) AS matriculado,
              fe.codigo,
              fe.denominacion
						FROM 
              foros f INNER JOIN
              forosestados fe ON f.foro_id = fe.foro_id INNER JOIN
							(
								SELECT foro_id, max(foroestado_id) AS max_sid
								FROM forosestados
								GROUP BY foro_id
							) m ON fe.foroestado_id = m.max_sid INNER JOIN
              matriculas m ON f.usuario_id = m.usuario_id INNER JOIN
              matriculados ma ON m.matricula = ma.matricula
						WHERE
							f.foro_id = ?";
		$datos = array($this->foro_id);
		$rst = execute_query($sql, $datos);
		return $rst[0];
	}
  
  function cantidad_total_respuestas_pendientes() {
		$sql = "SELECT
              COUNT(fr.fororespuesta_id) AS cantidad
						FROM 
              foros f INNER JOIN
              forosestados fe ON f.foro_id = fe.foro_id INNER JOIN
							(
								SELECT foro_id, max(foroestado_id) AS max_sid
								FROM forosestados
								GROUP BY foro_id
							) m ON fe.foroestado_id = m.max_sid INNER JOIN
              forosrespuestas fr ON f.foro_id = fr.foro_id
						WHERE
              fe.codigo = ? AND
              fr.activo = ?";
		$datos = array($this->codigo, $this->activo);
		return execute_query($sql, $datos);
	}
  
  function lista_foros_respuestas_pendientes() {
		$sql = "SELECT
              f.foro_id,
              date_format(f.fecha, '%d/%m/%Y') as fecha,
              f.tema,
              CONCAT(ma.apellido, ' ', ma.nombre) AS matriculado,
							COUNT(fr.fororespuesta_id) AS cantidad
						FROM 
              foros f INNER JOIN
              forosestados fe ON f.foro_id = fe.foro_id INNER JOIN
							(
								SELECT foro_id, max(foroestado_id) AS max_sid
								FROM forosestados
								GROUP BY foro_id
							) m ON fe.foroestado_id = m.max_sid INNER JOIN
              matriculas m ON f.usuario_id = m.usuario_id INNER JOIN
              matriculados ma ON m.matricula = ma.matricula INNER JOIN
              forosrespuestas fr ON f.foro_id = fr.foro_id
						WHERE
              fe.codigo = ? AND
              fr.activo = ?
            GROUP BY
              f.foro_id";
		$datos = array($this->codigo, $this->activo);
		return execute_query($sql, $datos);
	}
  
  function lista_respuestas_foro_estado() {
		$sql = "SELECT
              fr.fororespuesta_id,
              date_format(fr.fecha, '%d/%m/%Y') as fecha,
              fr.mensaje,
              fr.activo,
							u.denominacion as usuario
						FROM 
              forosrespuestas fr INNER JOIN
              usuarios u ON fr.usuario_id = u.usuario_id
						WHERE
              fr.activo = ? AND
              fr.foro_id = ? 
            ORDER BY
              fr.fecha ASC";
		$datos = array($this->activo, $this->foro_id);
		return execute_query($sql, $datos);
	}
  
  function cambiar_activo_respuesta() {
    $sql = "UPDATE forosrespuestas SET activo = ? WHERE fororespuesta_id = ?";
		$datos = array($this->activo, $this->fororespuesta_id);
    execute_query($sql, $datos);
  }
  
  function eliminar() {
    $sql = "DELETE FROM foros WHERE foro_id = ?";
		$datos = array($this->foro_id);
    execute_query($sql, $datos);
    
    $sql = "DELETE FROM forosestados WHERE foro_id = ?";
		$datos = array($this->foro_id);
    execute_query($sql, $datos);
  }
}
?>