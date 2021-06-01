<?php


class Usuarios {

  function __construct() {
    $this->usuario_id = 0;
    $this->denominacion = '';
    $this->correoelectronico = '';
    $this->clave = '';
    $this->token = '';
    $this->actualizacion = 0;
    $this->nivel = 0;
    $this->grupo_id = 0;
    $this->matricula_id = 0;
    $this->matricula = '';
    $this->matriculado_id = 0;
    $this->documento = 0;
    $this->matricula = '';
    $this->apellido = '';
    $this->nombre = '';
    $this->correoelectronico = '';
    $this->correoelectronico_visible_web = 0;
    $this->telefono = 0;
    $this->telefono_visible_web = 0;
    $this->celular = 0;
    $this->celular_visible_web = 0;
    $this->direccion = '';
    $this->direccion_visible_web = 0;
    $this->encuesta_id = 0;
    $this->pregunta_id = 0;
  }

  function save() {
    if($this->usuario_id == 0){
			$sql = "INSERT INTO usuarios (denominacion, correoelectronico, token, actualizacion, nivel, grupo_id) VALUES (?, ?, ?, ?, ?, ?)";
			$datos = array($this->denominacion, $this->correoelectronico, $this->token, 0, $this->nivel, $this->grupo_id);
			$this->usuario_id = execute_query($sql, $datos);
		} else {
			$sql = "UPDATE usuarios SET denominacion = ?, correoelectronico = ?, nivel = ?, grupo_id = ? WHERE usuario_id = ?";
			$datos = array($this->denominacion, $this->correoelectronico, $this->nivel, $this->grupo_id, $this->usuario_id);
			execute_query($sql, $datos);
		}
  }

	function guardar_matricula() {
		$sql = "INSERT INTO matriculas (usuario_id, matricula) VALUES (?, ?)";
		$datos = array($this->usuario_id, $this->matricula);
		$this->matricula_id = execute_query($sql, $datos);
	}
	
	function actualizar_matricula() {
		$sql = "UPDATE matriculas SET matricula = ? WHERE usuario_id = ?";
		$datos = array($this->matricula, $this->usuario_id);
		execute_query($sql, $datos);
	}
	
	function eliminar_matricula() {
		$sql = "DELETE FROM matriculas WHERE usuario_id = ?";
		$datos = array($this->usuario_id);
		execute_query($sql, $datos);
	}
	
  function update_token() {
    $sql = "UPDATE usuarios SET token = ? WHERE usuario_id = ?";
    $datos = array($this->token, $this->usuario_id);
    execute_query($sql, $datos);
  }

  function listar() {
    $sql = "SELECT
              u.usuario_id,
              u.denominacion AS usuario,
              u.correoelectronico,
              u.token,
              u.nivel,
              CONCAT(u.grupo_id, ' - ', g.denominacion) AS grupo,
							m.matricula
            FROM
              usuarios u INNER JOIN
              grupos g ON u.grupo_id = g.grupo_id LEFT JOIN
							matriculas m ON u.usuario_id = m.usuario_id
						ORDER BY
							u.usuario_id ASC";
    return execute_query($sql);
  }

  function get() {
    $sql = "SELECT
              u.usuario_id,
              u.denominacion,
              u.nivel,
              u.grupo_id,
              g.denominacion AS grupo,
							m.matricula,
							m.matricula_id,
              u.actualizacion
            FROM
              usuarios u INNER JOIN
              grupos g ON u.grupo_id = g.grupo_id LEFT JOIN
							matriculas m ON u.usuario_id = m.usuario_id
            WHERE
              token = ?";
    $datos = array($this->token);
    $rst = execute_query($sql, $datos);
    return $rst[0];
  }
  
  function get_by_denominacion() {
    $sql = "SELECT
              u.usuario_id,
              u.denominacion,
              u.correoelectronico,
              u.nivel,
              u.grupo_id,
              g.denominacion AS grupo,
							m.matricula
            FROM
              usuarios u INNER JOIN
              grupos g ON u.grupo_id = g.grupo_id LEFT JOIN
							matriculas m ON u.usuario_id = m.usuario_id
            WHERE
              u.denominacion = ?";
    $datos = array($this->denominacion);
    $rst = execute_query($sql, $datos);
    return $rst[0];
  }
	
	function get_usuario() {
    $sql = "SELECT
              u.usuario_id,
              u.denominacion,
              u.correoelectronico,
              u.nivel,
              u.grupo_id,
              g.denominacion AS grupo,
							m.matricula,
							m.matricula_id
            FROM
              usuarios u INNER JOIN
              grupos g ON u.grupo_id = g.grupo_id LEFT JOIN
							matriculas m ON u.usuario_id = m.usuario_id
            WHERE
              u.usuario_id = ?";
    $datos = array($this->usuario_id);
    $rst = execute_query($sql, $datos);
    return $rst[0];
  }

  function evaluar() {
    $nuevo = $this->verificar_existencia();
    $token = $this->verificar_token();

    if($nuevo == 0 and $token == 0) return 0;
    if($nuevo == 1) {
      $this->usuario_id = $this->get_id_from_denominacion();
      return 1;
    }
    if($token == 1) return 2;
  }

  function get_id_from_denominacion() {
    $sql = "SELECT usuario_id FROM usuarios WHERE denominacion = ?";
    $datos = array($this->denominacion);
    $rst = execute_query($sql, $datos);
    return $rst[0]['usuario_id'];
  }

  function verificar_existencia() {
    $sql = "SELECT count(*) AS existe FROM usuarios WHERE denominacion = ? AND token = ''";
    $datos = array($this->denominacion);
    $rst = execute_query($sql, $datos);
    return $rst[0]['existe'];
  }
	
	function verificar_matricula() {
    $sql = "SELECT matricula FROM matriculas WHERE matricula = ?";
    $datos = array($this->matricula);
    $rst = execute_query($sql, $datos);
		if (isset($rst[0]["matricula"])) {
			return "Existe";
		} else {
			return "Libre";
		}
		return $this->matricula;
  }	
	
	function verificar_denominacion() {
    $sql = "SELECT denominacion FROM usuarios WHERE denominacion = ?";
    $datos = array($this->denominacion);
    $rst = execute_query($sql, $datos);
		if (isset($rst[0]["denominacion"])) {
			return "Existe";
		} else {
			return "Libre";
		}
		return $this->matricula;
  }	

  function get_token() {
    $user = hash(ALG_USER, $this->denominacion);
    $pass = hash(ALG_PASS, $this->clave);
    $this->token = hash(ALG_TOKEN, $user . $pass);
  }

  function verificar_token() {
    $this->get_token();
    $sql = "SELECT count(*) AS cantidad FROM usuarios WHERE token = ?";
    $datos = array($this->token);
    $rst = execute_query($sql, $datos);
    return $rst[0]['cantidad'];
  }
	
	function reset() {
    $sql = "UPDATE usuarios SET token = '' WHERE usuario_id = ?";
    $datos = array($this->usuario_id);
    execute_query($sql, $datos);
  }
	
	function actualizar_token() {
		$user = hash(ALG_USER, $this->denominacion);
    $pass = hash(ALG_PASS, $this->clave);
    $this->token = hash(ALG_TOKEN, $user . $pass);
		
		$sql = "UPDATE usuarios SET token = ? WHERE usuario_id = ?";
    $datos = array($this->token, $this->usuario_id);
    execute_query($sql, $datos);
	}
  
  function verificar_matricula_matriculado() {
    $sql = "SELECT matriculado_id FROM matriculados WHERE matricula = ?";
    $datos = array($this->matricula);
    $rst = execute_query($sql, $datos);
		if (isset($rst[0]["matriculado_id"])) {
			return $rst[0]["matriculado_id"];
		} else {
			return 0;
		}
  }	
  
  function guardar_matriculado() {
    $sql = "INSERT INTO matriculados (documento, matricula, apellido, nombre, correoelectronico, correoelectronico_visible_web, telefono, telefono_visible_web, 
                                      celular, celular_visible_web, direccion, direccion_visible_web, visible_web) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $datos = array($this->documento, $this->matricula, $this->apellido, $this->nombre, $this->correoelectronico, $this->correoelectronico_visible_web, $this->telefono, $this->telefono_visible_web, 
                   $this->celular, $this->celular_visible_web, $this->direccion, $this->direccion_visible_web, $this->visible_web);
    execute_query($sql, $datos);		
  }
  
  function actualizar_matriculado() {
    $sql = "UPDATE matriculados SET correoelectronico = ?, correoelectronico_visible_web = ?, telefono = ?, telefono_visible_web = ?, celular = ?, celular_visible_web = ?, 
            direccion = ?, direccion_visible_web = ? WHERE matriculado_id = ?";
    $datos = array($this->correoelectronico, $this->correoelectronico_visible_web, $this->telefono, $this->telefono_visible_web, $this->celular, $this->celular_visible_web, 
                   $this->direccion, $this->direccion_visible_web, $this->matriculado_id);
    execute_query($sql, $datos);		
  }
  
  function get_matriculado() {
    $sql = "SELECT
              m.matriculado_id,
              m.documento,
              m.matricula,
              m.apellido,
              m.nombre,
              m.correoelectronico,
              m.correoelectronico as ed_correoelectronico,
              m.correoelectronico_visible_web,
              m.telefono,
              m.telefono_visible_web,
              m.celular,
              m.celular_visible_web,
              m.direccion,
              m.direccion_visible_web
            FROM
              matriculados m
            WHERE
              m.matriculado_id = ?";
    $datos = array($this->matriculado_id);
    $rst = execute_query($sql, $datos);
    return $rst[0];
  }
  
  function desactivar_actualizacion() {
    $sql = "UPDATE usuarios SET actualizacion = ? WHERE usuario_id = ?";
    $datos = array($this->actualizacion, $this->usuario_id);
    execute_query($sql, $datos);		
  }
  
  function verificar_encuesta_activa() {
    $sql = "SELECT e.encuesta_id FROM encuestas e WHERE e.activa = 1";
    return execute_query($sql);    
  }
  
  function verificar_encuestaresultado() {
    $sql = "SELECT er.encuestaresultado_id FROM encuestaresultado er WHERE er.encuesta_id = ? AND matricula_id = ?";
    $datos = array($this->encuesta_id, $this->matricula_id);
    return execute_query($sql, $datos);
  }
  
  function traer_encuesta() {
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
  
  function traer_eventos() {
		$sql = "SELECT
							e.evento_id,
							e.denominacion as denominacion,
							e.ubicacion as ubicacion,
							DATE_FORMAT(e.fecha, '%d | %m') as fecha_modificada
						FROM
							eventos e
						WHERE
							e.fecha >= CURDATE()";
		$rst = execute_query($sql);
		return $rst;
	}
}
?>
