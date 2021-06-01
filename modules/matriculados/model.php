<?php


class Matriculados {

  function __construct() {
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
    $this->matricula_id = 0;
    $this->idioma_id = 0;
    $this->experiencianivel_id = 0;
    $this->denominacion = '';
    $this->matriculadoidioma_id = 0;
    $this->matriculadocurso_id = 0;
    $this->matriculadoestudio_id = 0;
    $this->matriculadoexperiencia_id = 0;
    $this->titulacion = '';
    $this->universidad = '';
    $this->nota = '';
    $this->desde = '';
    $this->hasta = '';
    $this->actividades = '';
    $this->descripcion = '';
    $this->cargo = '';
    $this->empresa = '';
    $this->ubicacion = '';
    $this->actual = 0;
    $this->provincia_id = 0;
    $this->localidad = '';
    $this->fecha_nacimiento = '';
    $this->actualizacion = 0;
  }

  function save() {
    if($this->matriculado_id == 0){
			$sql = "INSERT INTO matriculados (documento, matricula, apellido, nombre, correoelectronico, correoelectronico_visible_web, telefono, telefono_visible_web,
              celular, celular_visible_web, direccion, direccion_visible_web) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$datos = array($this->documento, $this->matricula, $this->apellido, $this->nombre, $this->correoelectronico, $this->correoelectronico_visible_web, $this->telefono, $this->telefono_visible_web,
                     $this->celular, $this->celular_visible_web, $this->direccion, $this->direccion_visible_web);
      $this->matriculado_id = execute_query($sql, $datos);
		} else {
			$sql = "UPDATE matriculados SET documento = ?, matricula = ?, apellido = ?, nombre = ?, correoelectronico = ?, correoelectronico_visible_web = ?, telefono = ?, telefono_visible_web = ?,
              celular = ?, celular_visible_web = ?, direccion = ?, direccion_visible_web = ? WHERE matriculado_id = ?";
			$datos = array($this->documento, $this->matricula, $this->apellido, $this->nombre, $this->correoelectronico, $this->correoelectronico_visible_web, $this->telefono, $this->telefono_visible_web,
                     $this->celular, $this->celular_visible_web, $this->direccion, $this->direccion_visible_web, $this->matriculado_id);
			execute_query($sql, $datos);
		}
  }

	function delete() {
		$sql = "DELETE FROM matriculados WHERE matriculado_id = ?";
		$datos = array($this->matriculado_id);
		execute_query($sql, $datos);
	}
	
  function listar() {
    $sql = "SELECT
              m.matriculado_id,
              m.documento,
              m.matricula,
              m.apellido,
              m.nombre,
              m.correoelectronico,
              m.telefono,
              m.celular,
              m.direccion
            FROM
              matriculados m
						ORDER BY
							m.apellido ASC";
    return execute_query($sql);
  }
  
  function listar_estado_actualizado() {
    $sql = "SELECT
              m.matriculado_id,
              m.documento,
              m.matricula,
              m.apellido,
              m.nombre,
              m.correoelectronico,
              m.telefono,
              m.celular,
              m.direccion
            FROM
              matriculados m INNER JOIN
              matriculas ma ON m.matricula = ma.matricula INNER JOIN
              usuarios u ON ma.usuario_id = u.usuario_id 
            WHERE
              u.actualizacion = ?
						ORDER BY
							m.apellido ASC";
    $datos = array($this->actualizacion);
    return execute_query($sql, $datos);
  }

  function get() {
    $sql = "SELECT
              m.matriculado_id,
              m.documento,
              m.matricula,
              m.apellido,
              m.nombre,
              m.correoelectronico,
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
  
  function verifica_actualizacion() {
    $sql = "SELECT 
              u.actualizacion
            FROM 
              usuarios u INNER JOIN 
              matriculas m ON u.usuario_id = m.usuario_id INNER JOIN
              matriculados mt ON m.matricula = mt.matricula
            WHERE	
              mt.matriculado_id = ?";
    $datos = array($this->matriculado_id);
    $rst = execute_query($sql, $datos);
    return $rst[0]['actualizacion'];
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
  }
  
  function traer_matricula_matriculado() {
    $sql = "SELECT 
              mo.matriculado_id,
              CONCAT(mo.apellido, ' ', mo.nombre) AS matriculado,
              mo.matricula,
              mo.correoelectronico,
              mo.telefono,
              mo.celular,
              mo.direccion
            FROM 
              matriculados mo INNER JOIN
              matriculas ma ON mo.matricula = ma.matricula
            WHERE
              ma.matricula_id = ?";
    $datos = array($this->matricula_id);
    $rst = execute_query($sql, $datos);
    return $rst[0];
  }
  
  function get_provincias() {
    $sql = "SELECT p.provincia_id, p.denominacion FROM provincias p";
    return execute_query($sql);
  }
  
  function get_idiomas() {
    $sql = "SELECT i.idioma_id, i.denominacion FROM idiomas i";
    return execute_query($sql);
  }
  
  function get_experienciasnivel() {
    $sql = "SELECT en.experiencianivel_id, en.denominacion FROM experiencianivel en";
    return execute_query($sql);
  }
  
  function get_matriculado_experiencia() {
    $sql = "SELECT 
              me.matriculadoexperiencia_id, 
              me.cargo, 
              me.empresa, 
              me.ubicacion, 
              date_format(me.desde, '%d/%m/%Y') as desde, 
              CASE me.actual
                WHEN 0 THEN date_format(me.hasta, '%d/%m/%Y')
                WHEN 1 THEN 'ACTUAL'
              END AS hasta,
              me.actual,
              me.descripcion
            FROM 
              matriculadosexperiencias me
            WHERE  
              me.matriculado_id = ?
            ORDER BY
              me.actual DESC, me.hasta DESC, me.desde DESC";
   $datos = array($this->matriculado_id);
   return execute_query($sql, $datos);
  }
  
  function guardar_experiencia_matriculado() {
    $sql = "INSERT INTO matriculadosexperiencias (matriculado_id, cargo, empresa, ubicacion, desde, hasta, actual, descripcion) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		$datos = array($this->matriculado_id, $this->cargo, $this->empresa, $this->ubicacion, $this->desde, $this->hasta, $this->actual, $this->descripcion);
    execute_query($sql, $datos);
  }
  
  function eliminar_experiencia_matriculado() {
    $sql = "DELETE FROM matriculadosexperiencias WHERE matriculadoexperiencia_id = ?";
		$datos = array($this->matriculadoexperiencia_id);
    execute_query($sql, $datos);
  }
  
  function get_matriculado_estudios() {
    $sql = "SELECT 
              me.matriculadoestudio_id, 
              me.universidad, 
              me.titulacion, 
              date_format(me.desde, '%d/%m/%Y') as desde, 
              date_format(me.hasta, '%d/%m/%Y') as hasta, 
              me.actividades, 
              me.descripcion
            FROM 
              matriculadosestudios me
            WHERE  
              me.matriculado_id = ?";
   $datos = array($this->matriculado_id);
   return execute_query($sql, $datos);
  }
  
  function guardar_estudio_matriculado() {
    $sql = "INSERT INTO matriculadosestudios (matriculado_id, universidad, titulacion, nota, desde, hasta, actividades, descripcion) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		$datos = array($this->matriculado_id, $this->universidad, $this->titulacion, $this->nota, $this->desde, $this->hasta, $this->actividades, $this->descripcion);
    execute_query($sql, $datos);
  }
  
  function eliminar_estudio_matriculado() {
    $sql = "DELETE FROM matriculadosestudios WHERE matriculadoestudio_id = ?";
		$datos = array($this->matriculadoestudio_id);
    execute_query($sql, $datos);
  }
  
  function get_matriculado_cursos() {
    $sql = "SELECT 
              mc.matriculadocurso_id, 
              mc.denominacion, 
              mc.numero, 
              mc.fecha
            FROM 
              matriculadoscursos mc
            WHERE  
              mc.matriculado_id = ?";
   $datos = array($this->matriculado_id);
   return execute_query($sql, $datos);
  }
  
  function guardar_curso_matriculado() {
    $sql = "INSERT INTO matriculadoscursos (matriculado_id, denominacion, numero, fecha) VALUES (?, ?, ?, ?)";
		$datos = array($this->matriculado_id, $this->denominacion, $this->numero, $this->fecha);
    execute_query($sql, $datos);
  }
  
  function eliminar_curso_matriculado() {
    $sql = "DELETE FROM matriculadoscursos WHERE matriculadocurso_id = ?";
		$datos = array($this->matriculadocurso_id);
    execute_query($sql, $datos);
  }
  
  function get_matriculado_idiomas() {
    $sql = "SELECT 
              mi.matriculadoidioma_id, 
              i.denominacion, 
              en.denominacion as experiencianivel
            FROM 
              matriculadosidiomas mi INNER JOIN
              idiomas i ON mi.idioma_id = i.idioma_id INNER JOIN
              experiencianivel en ON mi.experiencianivel_id = en.experiencianivel_id
            WHERE  
              mi.matriculado_id = ?";
   $datos = array($this->matriculado_id);
   return execute_query($sql, $datos);
  }
  
  function guardar_idioma_matriculado() {
    $sql = "INSERT INTO matriculadosidiomas (matriculado_id, idioma_id, experiencianivel_id) VALUES (?, ?, ?)";
		$datos = array($this->matriculado_id, $this->idioma_id, $this->experiencianivel_id);
    execute_query($sql, $datos);
  }
  
  function eliminar_idioma_matriculado() {
    $sql = "DELETE FROM matriculadosidiomas WHERE matriculadoidioma_id = ?";
		$datos = array($this->matriculadoidioma_id);
    execute_query($sql, $datos);
  }
  
  function traer_matriculadoestudio() {
    $sql = "SELECT me.matriculado_id FROM	matriculadosestudios me GROUP BY	me.matriculado_id";
		return execute_query($sql);
  }
  
  function traer_matriculadocurso() {
    $sql = "SELECT mc.matriculado_id FROM	matriculadoscursos mc GROUP BY	mc.matriculado_id";
		return execute_query($sql);
  }
  
  function traer_matriculadoidioma() {
    $sql = "SELECT mi.matriculado_id FROM	matriculadosidiomas mi GROUP BY	mi.matriculado_id";
		return execute_query($sql);
  }
  
  function traer_matriculadoexperiencia() {
    $sql = "SELECT me.matriculado_id FROM	matriculadosexperiencias me GROUP BY	me.matriculado_id";
		return execute_query($sql);
  }
  
  function traer_matriculados_curriculums($matriculados_ids) {
    $sql = "SELECT m.matriculado_id, CONCAT(m.apellido, ' ', m.nombre) AS matriculado, m.matricula FROM	matriculados m WHERE m.matriculado_id IN ({$matriculados_ids})";
		return execute_query($sql);
  }
  
  function exportar_matriculados_curriculums($matriculados_ids) {
    $sql = "SELECT 
              m.matriculado_id, 
              CONCAT(m.apellido, ' ', m.nombre) AS matriculado, 
              m.matricula,
              m.correoelectronico,
              m.telefono,
              m.celular,
              m.direccion
            FROM	
              matriculados m 
            WHERE 
              m.matriculado_id IN ({$matriculados_ids})";
		return execute_query($sql);
  }
  
  function get_matriculado_detalle() {
    $sql = "SELECT 
              md.matriculadodetalle_id, 
              md.fecha_nacimiento, 
              date_format(md.fecha_nacimiento, '%d/%m/%Y') as fecha_ordenada, 
              md.localidad, 
              p.denominacion as provincia
            FROM 
              matriculadosdetalle md INNER JOIN
              provincias p ON md.provincia_id = p.provincia_id
            WHERE  
              md.matriculado_id = ?";
   $datos = array($this->matriculado_id);
   return execute_query($sql, $datos);
  }
  
  function buscar_curriculum($txt_where) {
    $sql = "SELECT 
	            m.matriculado_id,
	            m.matricula,
	            CONCAT(m.apellido, ' ', m.nombre) AS matriculado,
              (YEAR(CURDATE())-YEAR(md.fecha_nacimiento)) AS edad,
              md.localidad,
              p.denominacion as provincia,
              me.universidad,
              m.celular,
              m.correoelectronico
            FROM 
	            matriculados m LEFT JOIN
              matriculadosdetalle md ON m.matriculado_id = md.matriculado_id LEFT JOIN
              matriculadosestudios me ON m.matriculado_id = me.matriculado_id LEFT JOIN
              matriculadosidiomas mi ON m.matriculado_id = mi.matriculado_id LEFT JOIN
              matriculadosexperiencias mex ON m.matriculado_id = mex.matriculado_id LEFT JOIN
              matriculadoscursos mc ON m.matriculado_id = mc.matriculado_id LEFT JOIN
              provincias p ON md.provincia_id = p.provincia_id
            {$txt_where}";
   return execute_query($sql);
  }
  
  function guardar_detalle_matriculado() {
    $sql = "DELETE FROM matriculadosdetalle WHERE matriculado_id = ?";
		$datos = array($this->matriculado_id);
    execute_query($sql, $datos);
    
    $sql = "INSERT INTO matriculadosdetalle (matriculado_id, fecha_nacimiento, localidad, provincia_id) VALUES (?, ?, ?, ?)";
		$datos = array($this->matriculado_id, $this->fecha_nacimiento, $this->localidad, $this->provincia_id);
    execute_query($sql, $datos);
  }
  
  function get_cantidad_actualizados() {
    $sql = "SELECT count(*) as cantidad FROM matriculados m INNER JOIN matriculas ma ON m.matricula = ma.matricula INNER JOIN usuarios u ON ma.usuario_id = u.usuario_id WHERE u.actualizacion = ?";
		$datos = array(2);
    return execute_query($sql, $datos);
  }
  
  
}
?>