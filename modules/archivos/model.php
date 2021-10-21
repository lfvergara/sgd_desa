<?php


class Archivos {

	function __construct() {
		$this->archivo_id = 0;
		$this->denominacion = ''; 
		$this->matricula = ''; 
		$this->tipo_id = 0; 
		$this->tipo = 0; 
		$this->tipo_trabajo = ''; 
		$this->tipo_documento = ''; 
		$this->documento = 0; 
		$this->ejercicio = 0;
		$this->activo_corriente = 0.0; 
		$this->activo_nocorriente = 0.0; 
		$this->activo = 0.0; 
		$this->pasivo_corriente = 0.0; 
		$this->pasivo_nocorriente = 0.0; 
		$this->pasivo = 0.0; 
		$this->patrimonio_neto = 0.0; 
		$this->venta_neta = 0.0; 
		$this->resultado_final = 0.0; 
		$this->bienes_uso = 0.0; 
		$this->origen_bienes_uso = 0.0; 
		$this->depreciacion_bienes_uso = 0.0; 
		$this->resultado_reexpresion_bienes_uso = 0.0; 
		$this->metodo_pago = ''; 
		$this->entidad_id = 0; 
		$this->entidad = ''; 
		$this->importe = 0.0; 
		$this->excedente = 0; 
		$this->numero_comprobante = ''; 
		$this->cuenta_id = 0; 
		$this->cuenta = ''; 
		$this->numero_cuenta = ''; 
		$this->comentario = ''; 
		$this->fecha = ''; 
		$this->fecha_inicio = ''; 
		$this->fecha_cierre = ''; 
		$this->fecha_informe = '';
		$this->adjunta_estadocontable = 0;
		$this->codigo_barras = '';
		$this->seguimiento_id = 0;
		$this->estado_id = 0;
		$this->numero_protocolo = '';
		$this->desde = '';
		$this->hasta = '';
		$this->acepta_observacion = 0;
		$this->firma_digital = 0;
		$this->intentos = 0;
		$this->delegacion_id = 0;
	}

	function guardar_archivo() {
		if($this->archivo_id == 0){
			$sql = "INSERT INTO archivos (denominacion, matricula, tipo_id, tipo_documento, documento, ejercicio, activo_corriente, activo_nocorriente, activo, pasivo_corriente, pasivo_nocorriente, pasivo, patrimonio_neto, venta_neta, resultado_final, bienes_uso, origen_bienes_uso, depreciacion_bienes_uso, resultado_reexpresion_bienes_uso, metodo_pago, entidad, importe, excedente, numero_comprobante, cuenta_id, comentario, fecha, fecha_inicio, fecha_cierre, fecha_informe, adjunta_estadocontable, firma_digital, codigo_barras, delegacion_id) 
					VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?)";
				
			$tipos_array = array(1,2,34,35,36,37);
			if(in_array($this->tipo_id, $tipos_array)) {
				$tipo_id = $this->tipo_id;
				$documento = $this->documento;
				$fecha_inicio = str_replace("-", "", $this->fecha_inicio);
				$fecha_cierre = str_replace("-", "", $this->fecha_cierre);
				$fecha_informe = str_replace("-", "", $this->fecha_informe);
				$ejercicio = $this->ejercicio;
				$activo_corriente = $this->activo_corriente * 100;
				$activo_nocorriente = $this->activo_nocorriente * 100;
				$pasivo_corriente = $this->pasivo_corriente * 100;
				$pasivo_nocorriente = $this->pasivo_nocorriente * 100;
				$patrimonio_neto = $this->patrimonio_neto * 100;
				$bienes_uso = $this->bienes_uso * 100;
				$venta_neta = $this->venta_neta * 100;
				$resultado_final = $this->resultado_final * 100;
				
				$code_bar = $tipo_id . $documento . $fecha_inicio . $fecha_cierre . $fecha_informe . $ejercicio . $activo_corriente . $activo_nocorriente . $pasivo_corriente . $pasivo_nocorriente . $patrimonio_neto . $bienes_uso . $venta_neta . $resultado_final;
				$code_bar = hash(md5, $code_bar);
				
			} else {
				$tipo_id = $this->tipo_id;
				$documento = $this->documento;
				$fecha_inicio = str_replace("-", "", $this->fecha_inicio);
				$fecha_cierre = str_replace("-", "", $this->fecha_cierre);
				$fecha_informe = str_replace("-", "", $this->fecha_informe);
				
				$code_bar = $tipo_id . $documento . $fecha_inicio . $fecha_cierre . $fecha_informe;
				$code_bar = hash(md5, $code_bar);
			}
				
			$datos = array($this->denominacion, 
						   $_SESSION["sesion.matricula"],
						   $this->tipo_id, 
						   $this->tipo_documento, 
						   $this->documento, 
						   $this->ejercicio,
						   $this->activo_corriente, 
						   $this->activo_nocorriente, 
						   $this->activo, 
						   $this->pasivo_corriente, 
						   $this->pasivo_nocorriente, 
						   $this->pasivo, 
						   $this->patrimonio_neto, 
						   $this->venta_neta, 
						   $this->resultado_final, 
						   $this->bienes_uso, 
						   $this->origen_bienes_uso, 
						   $this->depreciacion_bienes_uso, 
						   $this->resultado_reexpresion_bienes_uso, 
						   $this->metodo_pago, 
						   $this->entidad_id, 
						   $this->importe, 
						   $this->excedente, 
						   $this->numero_comprobante, 
						   $this->cuenta_id,
						   $this->comentario, 
						   $this->fecha_inicio, 
						   $this->fecha_cierre, 
						   $this->fecha_informe,
						   $this->adjunta_estadocontable, 
						   $this->firma_digital, 
						   $code_bar,
						   $this->delegacion_id);
			$this->archivo_id = execute_query($sql, $datos);
		} else {
			$sql = "UPDATE archivos SET denominacion = ?, matricula = ?, tipo_id = ?, tipo_documento = ?, documento = ?, ejercicio = ? , activo_corriente = ?, activo_nocorriente = ?, activo = ?, pasivo_corriente = ?, pasivo_nocorriente = ?, pasivo = ?, patrimonio_neto = ?, venta_neta = ?, resultado_final = ?, bienes_uso = ?, origen_bienes_uso = ?, depreciacion_bienes_uso = ?, resultado_reexpresion_bienes_uso = ?, metodo_pago = ?, entidad = ?, importe = ?, excedente = ?, numero_comprobante = ?, cuenta_id = ?, comentario = ?, fecha_inicio = ?, fecha_cierre = ?, fecha_informe = ?, adjunta_estadocontable = ?, firma_digital = ?, codigo_barras = ?, delegacion_id = ? WHERE archivo_id = ?";
			
			$tipos_array = array(1,2,34,35,36,37);
			if(in_array($this->tipo_id, $tipos_array)) {
				$tipo_id = $this->tipo_id;
				$documento = $this->documento;
				$fecha_inicio = str_replace("-", "", $this->fecha_inicio);
				$fecha_cierre = str_replace("-", "", $this->fecha_cierre);
				$fecha_informe = str_replace("-", "", $this->fecha_informe);
				$ejercicio = $this->ejercicio;
				$activo_corriente = $this->activo_corriente * 100;
				$activo_nocorriente = $this->activo_nocorriente * 100;
				$pasivo_corriente = $this->pasivo_corriente * 100;
				$pasivo_nocorriente = $this->pasivo_nocorriente * 100;
				$patrimonio_neto = $this->patrimonio_neto * 100;
				$bienes_uso = $this->bienes_uso * 100;
				$venta_neta = $this->venta_neta * 100;
				$resultado_final = $this->resultado_final * 100;
				
				$code_bar = $tipo_id . $documento . $fecha_inicio . $fecha_cierre . $fecha_informe . $ejercicio . $activo_corriente . $activo_nocorriente . $pasivo_corriente;
				$code_bar = $code_bar . $pasivo_nocorriente . $patrimonio_neto . $bienes_uso . $venta_neta . $resultado_final;
				$code_bar = hash(md5, $code_bar);
				
			} else {
				$tipo_id = $this->tipo_id;
				$documento = $this->documento;
				$fecha_inicio = str_replace("-", "", $this->fecha_inicio);
				$fecha_cierre = str_replace("-", "", $this->fecha_cierre);
				$fecha_informe = str_replace("-", "", $this->fecha_informe);
				
				$code_bar = $tipo_id . $documento . $fecha_inicio . $fecha_cierre . $fecha_informe;
				$code_bar = hash(md5, $code_bar);
			}
			
			$datos = array($this->denominacion, 
				     	   $_SESSION["sesion.matricula"],
				     	   $this->tipo_id, 
				     	   $this->tipo_documento, 
				     	   $this->documento, 
				     	   $this->ejercicio,
				     	   $this->activo_corriente, 
				     	   $this->activo_nocorriente, 
				     	   $this->activo, 
				     	   $this->pasivo_corriente, 
				     	   $this->pasivo_nocorriente, 
				     	   $this->pasivo, 
				     	   $this->patrimonio_neto, 
				     	   $this->venta_neta, 
				     	   $this->resultado_final, 
				     	   $this->bienes_uso, 
				     	   $this->origen_bienes_uso, 
				     	   $this->depreciacion_bienes_uso, 
				     	   $this->resultado_reexpresion_bienes_uso,
				     	   $this->metodo_pago, 
				     	   $this->entidad_id, 
				     	   $this->importe, 
				     	   $this->excedente, 
				     	   $this->numero_comprobante, 
				     	   $this->cuenta_id, 
				     	   $this->comentario, 
				     	   $this->fecha_inicio, 
				     	   $this->fecha_cierre, 
				     	   $this->fecha_informe,
				     	   $this->adjunta_estadocontable,
				     	   $this->firma_digital,
				     	   $code_bar,
				     	   $this->delegacion_id,
				     	   $this->archivo_id);
			execute_query($sql, $datos);
		}
	}
	
	function guardar_seguimiento() {
	    switch ($this->estado_id) {
	      case 4:
	        $sql = "SELECT r.revision_id AS REV_ID, r.intentos AS INTENTOS FROM revisiones r WHERE r.archivo_id = ?";
	        $datos = array($this->archivo_id);
	        $rst = execute_query($sql, $datos);
	        
	        if (!is_array($rst)) {
	          $sql = "INSERT INTO revisiones (fecha, acepta_observacion, intentos, archivo_id) VALUES (now(), ?, ?, ?)";
	          $datos = array(0, 0, $this->archivo_id);
	          execute_query($sql, $datos);
	        }
	        break;
	      case 2:
	        $sql = "SELECT COUNT(s.archivo_id) AS CANT FROM seguimiento s WHERE s.archivo_id = ? AND s.estado_id = ?";
	        $datos = array($this->archivo_id, 2);
	        $rst = execute_query($sql, $datos);
	        $cant_ingresos = $rst[0]['CANT'];        
	        $cant_ingresos = ($cant_ingresos == 1) ? 1 : $cant_ingresos + 1;
	        
	        $sql = "SELECT r.revision_id AS REV_ID, r.intentos AS INTENTOS FROM revisiones r WHERE r.archivo_id = ?";
	        $datos = array($this->archivo_id);
	        $rst = execute_query($sql, $datos);    
	        $this->intentos = $cant_ingresos;
			    
	        if (is_array($rst) AND !empty($rst)) {
	          $sql = "UPDATE revisiones SET fecha = now(), acepta_observacion = ?, intentos = ? WHERE revision_id = ?";
	          $datos = array($this->acepta_observacion, $this->intentos, $rst[0]['REV_ID']);
	          execute_query($sql, $datos);
	        } else {
	          $sql = "INSERT INTO revisiones (fecha, acepta_observacion, intentos, archivo_id) VALUES (now(), ?, ?, ?)";
	          $datos = array($this->acepta_observacion, $this->intentos, $this->archivo_id);
	          execute_query($sql, $datos);
	        }
	        break;
	    }
    
	    $sql = "INSERT INTO seguimiento (archivo_id, estado_id, comentario, fecha, usuario_id) VALUES (?, ?, ?, now(), ?)";
	    $datos = array($this->archivo_id, $this->estado_id, $this->comentario, $_SESSION['sesion.usuario_id']);
		
		$this->seguimiento_id = execute_query($sql, $datos);
	}
	
	function actualizar_datos_observados_eecc() {
		$sql = "UPDATE archivos SET denominacion = ?, tipo_documento = ?, documento = ?, fecha_inicio = ?, fecha_cierre = ?, fecha_informe = ?, ejercicio = ?, activo_corriente = ?, activo_nocorriente = ?, activo = ?, pasivo_corriente = ?, pasivo_nocorriente = ?, pasivo = ?, patrimonio_neto = ?, bienes_uso = ?, venta_neta = ?, resultado_final = ?, comentario = ?, metodo_pago = ?, entidad = ?, numero_comprobante = ?, importe = ?, excedente = ? WHERE archivo_id = ?";
		$datos = array($this->denominacion, $this->tipo_documento, $this->documento, $this->fecha_inicio, $this->fecha_cierre, $this->fecha_informe, $this->ejercicio, $this->activo_corriente, $this->activo_nocorriente, $this->activo, $this->pasivo_corriente, $this->pasivo_nocorriente, $this->pasivo, $this->patrimonio_neto, $this->bienes_uso, $this->venta_neta, $this->resultado_final, $this->comentario, $this->metodo_pago, $this->entidad, $this->numero_comprobante, $this->importe, $this->excedente, $this->archivo_id);
		execute_query($sql, $datos);
	}
  
  	function actualizar_datos_observados_certificacion() {
		$sql = "UPDATE archivos SET denominacion = ?, tipo_documento = ?, documento = ?, fecha_inicio = ?, fecha_cierre = ?, fecha_informe = ?, comentario = ?, metodo_pago = ?, entidad = ?, numero_comprobante = ?, importe = ?, excedente = ? WHERE archivo_id = ?";
		$datos = array($this->denominacion, $this->tipo_documento, $this->documento, $this->fecha_inicio, $this->fecha_cierre, $this->fecha_informe, $this->comentario, $this->metodo_pago, $this->entidad, $this->numero_comprobante, $this->importe, $this->excedente, $this->archivo_id);
		execute_query($sql, $datos);
	}
  
  	function guardar_protocolo() {
		$sql = "INSERT INTO protocolos (archivo_id, numero) VALUES (?, ?)";
		$datos = array($this->archivo_id, $this->numero_protocolo);
		execute_query($sql, $datos);
	}
  
  	function guardar_nuevo_protocolo($archivo_id) {
		$sql = "SELECT valor AS ULTIMO, anio AS ANIO FROM archivosprotocolo ORDER BY archivosprotocolo_id DESC LIMIT 1";
    	$rst = execute_query($sql);
    	$ultimo = $rst[0]['ULTIMO'];
    	$anio = $rst[0]['ANIO'];
    
    	$anio_actual = date('Y');
    	if ($anio == $anio_actual) {
      		$nuevo = $ultimo + 1;
    	} else {
      		$nuevo = 1;
    	}
    
		$sql = "INSERT INTO archivosprotocolo (valor, anio, archivo_id) VALUES (?, ?, ?)";
		$datos = array($nuevo, $anio_actual, $archivo_id);
		execute_query($sql, $datos);
	}
  
  	function guardar_intervencion($archivo_id) {
		$sql = "SELECT valor AS LAST_ID FROM archivosintervencion ORDER BY archivosintervencion_id DESC LIMIT 1";
	    $rst = execute_query($sql);
	    $ultimo = $rst[0]['LAST_ID'];
	    $nuevo = $ultimo + 1;
	    
		$sql = "INSERT INTO archivosintervencion (valor, archivo_id) VALUES (?, ?)";
		$datos = array($nuevo, $archivo_id);
		execute_query($sql, $datos);
	}
  
  	function traer_intervencion_archivo($archivo_id) {
		$sql = "SELECT valor AS INTERVENCION FROM archivosintervencion WHERE archivo_id = ?";
	    $datos = array($archivo_id);
	    $rst = execute_query($sql, $datos);
	    $numero_intervencion = $rst[0]['INTERVENCION'];
		return $numero_intervencion;
	}
  
  	function traer_protocolo_archivo($archivo_id) {
		$sql = "SELECT valor AS PROTOCOLO, anio AS ANIO FROM archivosprotocolo WHERE archivo_id = ?";
	    $datos = array($archivo_id);
	    $rst = execute_query($sql, $datos);
	    $numero_protocolo = $rst[0]['PROTOCOLO'];
	    $anio = $rst[0]['ANIO'];
	    $final = "{$numero_protocolo}/{$anio}";
		return $final;
	}

	function listar_estado() {
		$sql = "SELECT
					f.archivo_id,
					f.denominacion AS nombre,
					f.documento,
					f.matricula,
					u.denominacion,
					s.seguimiento_id,
					DATE_FORMAT(f.fecha, '%d/%m/%Y') as fecha,
					f.comentario,
					s.estado_id,
					e.denominacion AS estado,
              		(SELECT
                		us.denominacion
              		FROM
                		seguimiento se INNER JOIN
                		usuarios us ON se.usuario_id = us.usuario_id
              		WHERE  
                		se.archivo_id = f.archivo_id AND
                		se.estado_id IN (6,9) AND
                		us.grupo_id IN (1,3,4)
              		ORDER BY
                		se.seguimiento_id DESC
              		LIMIT 1) AS autorizador
				FROM
				 	archivos f INNER JOIN
					seguimiento s ON f.archivo_id = s.archivo_id INNER JOIN
					(SELECT archivo_id, max(seguimiento_id) AS max_sid
					 FROM seguimiento
					 GROUP BY archivo_id
					) m ON s.seguimiento_id = m.max_sid INNER JOIN
					estados e ON s.estado_id = e.estado_id INNER JOIN
					usuarios u ON s.usuario_id = u.usuario_id
				WHERE
					s.estado_id = ?";
		$datos = array($this->estado_id);
		return execute_query($sql, $datos);
	}
  
  	function listar_estado_legalizar() {
		$sql = "SELECT
					f.archivo_id,
					f.denominacion AS nombre,
					f.documento,
					f.matricula,
					u.denominacion,
					s.seguimiento_id,
					DATE_FORMAT(f.fecha, '%d/%m/%Y') as fecha,
					f.comentario,
					s.estado_id,
					e.denominacion AS estado,
              		(SELECT us.denominacion
		             FROM seguimiento se INNER JOIN
		                  usuarios us ON se.usuario_id = us.usuario_id
              		 WHERE se.archivo_id = f.archivo_id AND
                		   se.estado_id IN (6,9) AND
                		   us.grupo_id IN (1,3,4)
              		 ORDER BY se.seguimiento_id DESC
              		 LIMIT 1) AS autorizador
				FROM
					archivos f INNER JOIN
					seguimiento s ON f.archivo_id = s.archivo_id INNER JOIN
					(SELECT archivo_id, max(seguimiento_id) AS max_sid
					 FROM seguimiento
					 GROUP BY archivo_id
					) m ON s.seguimiento_id = m.max_sid INNER JOIN
					estados e ON s.estado_id = e.estado_id INNER JOIN
					usuarios u ON s.usuario_id = u.usuario_id
				WHERE
					s.estado_id IN (6,9)";
		return execute_query($sql);
	}
  
  	function listar_estado_pendiente_firma() {
		$sql = "SELECT
					f.archivo_id,
					f.denominacion AS nombre,
					f.documento,
					f.matricula,
					u.denominacion,
					s.seguimiento_id,
					DATE_FORMAT(f.fecha, '%d/%m/%Y') as fecha,
					f.comentario,
					s.estado_id,
					e.denominacion AS estado,
              		(SELECT
                		us.denominacion
              		 FROM
                		seguimiento se INNER JOIN
                		usuarios us ON se.usuario_id = us.usuario_id
              		 WHERE  
                		se.archivo_id = f.archivo_id AND
                		se.estado_id IN (13) AND
                		us.grupo_id IN (1,3,4)
              		 ORDER BY
                		se.seguimiento_id DESC
              		 LIMIT 1) AS autorizador
				FROM
				 	archivos f INNER JOIN
					seguimiento s ON f.archivo_id = s.archivo_id INNER JOIN
					(SELECT archivo_id, max(seguimiento_id) AS max_sid
					 FROM seguimiento
					 GROUP BY archivo_id
					) m ON s.seguimiento_id = m.max_sid INNER JOIN
					estados e ON s.estado_id = e.estado_id INNER JOIN
					usuarios u ON s.usuario_id = u.usuario_id
				WHERE
					s.estado_id IN (13)";
		return execute_query($sql);
	}
	
	function listar_estado_usuario() {
		$sql = "SELECT
					f.archivo_id,
					f.denominacion AS nombre,
					f.documento,
					f.matricula,
					u.denominacion,
					s.seguimiento_id,
					DATE_FORMAT(f.fecha, '%d/%m/%Y') as fecha,
					f.comentario,
					s.estado_id,
					e.denominacion AS estado
				FROM
					archivos f INNER JOIN
					seguimiento s ON f.archivo_id = s.archivo_id INNER JOIN
					(SELECT archivo_id, max(seguimiento_id) AS max_sid
					 FROM seguimiento
					 GROUP BY archivo_id
					) m ON s.seguimiento_id = m.max_sid INNER JOIN
					estados e ON s.estado_id = e.estado_id INNER JOIN
					usuarios u ON s.usuario_id = u.usuario_id
				WHERE
					s.estado_id = ? AND
					f.matricula = ?";
		$datos = array($this->estado_id, $_SESSION["sesion.matricula"]);
		return execute_query($sql, $datos);
	}
  
  	function listar_intervenido_usuario() {
		$sql = "SELECT
					f.archivo_id,
					f.denominacion AS nombre,
					f.documento,
					f.matricula,
					u.denominacion,
					s.seguimiento_id,
					DATE_FORMAT(f.fecha, '%d/%m/%Y') as fecha,
					f.comentario,
					s.estado_id,
					e.denominacion AS estado
				FROM
					archivos f INNER JOIN
					seguimiento s ON f.archivo_id = s.archivo_id INNER JOIN
					(SELECT archivo_id, max(seguimiento_id) AS max_sid
					 FROM seguimiento
					 GROUP BY archivo_id
					) m ON s.seguimiento_id = m.max_sid INNER JOIN
					estados e ON s.estado_id = e.estado_id INNER JOIN
					usuarios u ON s.usuario_id = u.usuario_id
				WHERE
					s.estado_id IN (11) AND
					f.matricula = ?";
		$datos = array($_SESSION["sesion.matricula"]);
		return execute_query($sql, $datos);
	}
  
  	function listar_legalizar_usuario() {
		$sql = "SELECT
					f.archivo_id,
					f.denominacion AS nombre,
					f.documento,
					f.matricula,
					u.denominacion,
					s.seguimiento_id,
					DATE_FORMAT(f.fecha, '%d/%m/%Y') as fecha,
					f.comentario,
					s.estado_id,
					e.denominacion AS estado
				FROM
					archivos f INNER JOIN
					seguimiento s ON f.archivo_id = s.archivo_id INNER JOIN
					(SELECT archivo_id, max(seguimiento_id) AS max_sid
					 FROM seguimiento
					 GROUP BY archivo_id
					) m ON s.seguimiento_id = m.max_sid INNER JOIN
					estados e ON s.estado_id = e.estado_id INNER JOIN
					usuarios u ON s.usuario_id = u.usuario_id
				WHERE
					s.estado_id IN (9,6) AND
					f.matricula = ?";
		$datos = array($_SESSION["sesion.matricula"]);
		return execute_query($sql, $datos);
	}
  
  	function listar_estado_reingresar_usuario() {
		$sql = "SELECT
					f.archivo_id,
					f.denominacion AS nombre,
					f.documento,
					f.matricula,
					u.denominacion,
					s.seguimiento_id,
					DATE_FORMAT(f.fecha, '%d/%m/%Y') as fecha,
					f.comentario,
					s.estado_id,
					e.denominacion AS estado
				FROM
					archivos f INNER JOIN
					seguimiento s ON f.archivo_id = s.archivo_id INNER JOIN
					(SELECT archivo_id, max(seguimiento_id) AS max_sid
					 FROM seguimiento
					 GROUP BY archivo_id
					) m ON s.seguimiento_id = m.max_sid INNER JOIN
					estados e ON s.estado_id = e.estado_id INNER JOIN
					usuarios u ON s.usuario_id = u.usuario_id
				WHERE
					s.estado_id IN (4,7) AND
					f.matricula = ?";
		$datos = array($this->estado_id, $_SESSION["sesion.matricula"]);
		return execute_query($sql, $datos);
	}
  
   function listar_validacion() {
		$sql = "SELECT
					f.archivo_id,
					f.denominacion AS nombre,
					t.denominacion AS tipo,
					f.documento,
					f.matricula,
					u.denominacion,
					s.seguimiento_id,
					DATE_FORMAT(f.fecha, '%d/%m/%Y') as fecha,
					DATE_FORMAT(f.fecha_inicio, '%d/%m/%Y') as fecha_inicio,
					DATE_FORMAT(f.fecha_cierre, '%d/%m/%Y') as fecha_cierre,
					DATE_FORMAT(f.fecha_informe, '%d/%m/%Y') as fecha_informe,
					f.comentario,
					s.estado_id,
					e.denominacion AS estado,
              		(SELECT
                		us.denominacion
              		FROM
		                seguimiento se INNER JOIN
		                usuarios us ON se.usuario_id = us.usuario_id
              		WHERE  
		                se.archivo_id = f.archivo_id AND
		                se.estado_id IN (6) AND
		                us.grupo_id IN (1,3,4)
              		ORDER BY
                		se.seguimiento_id DESC
              		LIMIT 1) AS autorizador
				FROM
					archivos f INNER JOIN
              		tipos t ON f.tipo_id = t.tipo_id INNER JOIN
					seguimiento s ON f.archivo_id = s.archivo_id INNER JOIN
					(SELECT archivo_id, max(seguimiento_id) AS max_sid
					 FROM seguimiento
					 GROUP BY archivo_id
					) m ON s.seguimiento_id = m.max_sid INNER JOIN
					estados e ON s.estado_id = e.estado_id INNER JOIN
					usuarios u ON s.usuario_id = u.usuario_id
				WHERE
					s.estado_id = ?";
		$datos = array(6);
		return execute_query($sql, $datos);
	}
  
  	function listar_estado_reporte() {
		$sql = "SELECT
					f.archivo_id,
					f.denominacion AS nombre,
					f.documento,
					f.matricula,
					u.denominacion,
					s.seguimiento_id,
					DATE_FORMAT(f.fecha, '%d/%m/%Y') as fecha,
					f.comentario,
					s.estado_id,
					e.denominacion AS estado,
              		(SELECT
                		us.denominacion
              		FROM
		                seguimiento se INNER JOIN
		                usuarios us ON se.usuario_id = us.usuario_id
              		WHERE  
		                se.archivo_id = f.archivo_id AND
		                se.estado_id IN (2,3,4,6,7,8,9) AND
		                us.grupo_id IN (1,3,4)
              		ORDER BY
                		se.seguimiento_id DESC
              		LIMIT 1) AS autorizador
				FROM
					archivos f INNER JOIN
					seguimiento s ON f.archivo_id = s.archivo_id INNER JOIN
					(SELECT archivo_id, max(seguimiento_id) AS max_sid
					 FROM seguimiento
					 GROUP BY archivo_id
					) m ON s.seguimiento_id = m.max_sid INNER JOIN
					estados e ON s.estado_id = e.estado_id INNER JOIN
					usuarios u ON s.usuario_id = u.usuario_id
				WHERE
					s.estado_id = ?";
		$datos = array($this->estado_id);
		return execute_query($sql, $datos);
	}
  
  	function listar_estado_reporte_fecha() {
		$sql = "SELECT
					f.archivo_id,
					f.denominacion AS nombre,
					f.documento,
					f.matricula,
					u.denominacion,
					s.seguimiento_id,
					DATE_FORMAT(f.fecha, '%d/%m/%Y') as fecha,
					f.comentario,
					s.estado_id,
					e.denominacion AS estado,
              		(SELECT
                		us.denominacion
              		 FROM
		                seguimiento se INNER JOIN
		                usuarios us ON se.usuario_id = us.usuario_id
              		 WHERE  
		                se.archivo_id = f.archivo_id AND
		                se.estado_id IN (2,3,4,6,7,8,9) AND
		                us.grupo_id IN (1,3,4)
              		 ORDER BY
                		se.seguimiento_id DESC
              		 LIMIT 1) AS autorizador
				FROM
					archivos f INNER JOIN
					seguimiento s ON f.archivo_id = s.archivo_id INNER JOIN
					(SELECT archivo_id, max(seguimiento_id) AS max_sid
					 FROM seguimiento
					 GROUP BY archivo_id
					) m ON s.seguimiento_id = m.max_sid INNER JOIN
					estados e ON s.estado_id = e.estado_id INNER JOIN
					usuarios u ON s.usuario_id = u.usuario_id
				WHERE
					s.estado_id = ? AND
              		s.fecha BETWEEN ? AND ?";
		$datos = array($this->estado_id, $this->desde, $this->hasta);
		return execute_query($sql, $datos);
	}
  
  	function contador_estados() {
		$sql = "SELECT
					COUNT(f.archivo_id) AS CANTIDAD
				FROM
					archivos f INNER JOIN
					seguimiento s ON f.archivo_id = s.archivo_id INNER JOIN
					(SELECT archivo_id, max(seguimiento_id) AS max_sid
					 FROM seguimiento
					 GROUP BY archivo_id
					) m ON s.seguimiento_id = m.max_sid INNER JOIN
					estados e ON s.estado_id = e.estado_id INNER JOIN
					usuarios u ON s.usuario_id = u.usuario_id
				WHERE
					s.estado_id = ?";
	    $datos = array(1);
	    $pend_ingreso = execute_query($sql, $datos);
	    $pend_ingreso = (is_array($pend_ingreso) AND !empty($pend_ingreso)) ? $pend_ingreso[0]['CANTIDAD'] : 0;
	      
	    $datos = array(2);
	    $pend_revision = execute_query($sql, $datos);
	    $pend_revision = (is_array($pend_revision) AND !empty($pend_revision)) ? $pend_revision[0]['CANTIDAD'] : 0;
	    
	    $datos = array(3);
	    $revision = execute_query($sql, $datos);
	    $revision = (is_array($revision) AND !empty($revision)) ? $revision[0]['CANTIDAD'] : 0;
    
		$datos = array(4);
        $observados = execute_query($sql, $datos);
        $observados = (is_array($observados) AND !empty($observados)) ? $observados[0]['CANTIDAD'] : 0;
    
        $datos = array(5);
        $corregidos = execute_query($sql, $datos);
        $corregidos = (is_array($corregidos) AND !empty($corregidos)) ? $corregidos[0]['CANTIDAD'] : 0;
    
        $datos = array(6);
        $aceptados = execute_query($sql, $datos);
        $aceptados = (is_array($aceptados) AND !empty($aceptados)) ? $aceptados[0]['CANTIDAD'] : 0;
    
        $datos = array(7);
        $rechazados = execute_query($sql, $datos);
        $rechazados = (is_array($rechazados) AND !empty($rechazados)) ? $rechazados[0]['CANTIDAD'] : 0;
    
        $datos = array(8);
        $legalizados = execute_query($sql, $datos);
        $legalizados = (is_array($legalizados) AND !empty($legalizados)) ? $legalizados[0]['CANTIDAD'] : 0;
    
        $datos = array(9);
        $validados = execute_query($sql, $datos);
        $validados = (is_array($validados) AND !empty($validados)) ? $validados[0]['CANTIDAD'] : 0;
      
        $array_cantidades = array('{pend_ingreso}'=>$pend_ingreso,
                                  '{pend_revision}'=>$pend_revision,
                                  '{revision}'=>$revision, 
                                  '{observados}'=>$observados, 
                                  '{corregidos}'=>$corregidos, 
                                  '{aceptados}'=>$aceptados, 
                                  '{rechazados}'=>$rechazados, 
                                  '{legalizados}'=>$legalizados, 
                                  '{validados}'=>$validados);
    
	  return $array_cantidades;
	}
  
  	function contador_estados_fecha() {
		$sql = "SELECT
					COUNT(f.archivo_id) AS CANTIDAD
				FROM
					archivos f INNER JOIN
					seguimiento s ON f.archivo_id = s.archivo_id INNER JOIN
					(SELECT archivo_id, max(seguimiento_id) AS max_sid
					 FROM seguimiento
					 GROUP BY archivo_id
					) m ON s.seguimiento_id = m.max_sid INNER JOIN
					estados e ON s.estado_id = e.estado_id INNER JOIN
					usuarios u ON s.usuario_id = u.usuario_id
				WHERE
					s.estado_id = ? AND
              	s.fecha BETWEEN ? AND ?";
		$datos = array(4, $this->desde, $this->hasta);
        $observados = execute_query($sql, $datos);
        $observados = (is_array($observados) AND !empty($observados)) ? $observados[0]['CANTIDAD'] : 0;
    
        $datos = array(7, $this->desde, $this->hasta);
        $rechazados = execute_query($sql, $datos);
        $rechazados = (is_array($rechazados) AND !empty($rechazados)) ? $rechazados[0]['CANTIDAD'] : 0;
    
        $datos = array(2, $this->desde, $this->hasta);
        $ingresados = execute_query($sql, $datos);
        $ingresados = (is_array($ingresados) AND !empty($ingresados)) ? $ingresados[0]['CANTIDAD'] : 0;
    
        $datos = array(6, $this->desde, $this->hasta);
        $aceptados = execute_query($sql, $datos);
        $aceptados = (is_array($aceptados) AND !empty($aceptados)) ? $aceptados[0]['CANTIDAD'] : 0;
      
      	$array_cantidades = array('{observados}'=>$observados, '{rechazados}'=>$rechazados, '{ingresados}'=>$ingresados, '{aceptados}'=>$aceptados);
    
		return $array_cantidades;
	}
  
  	function listar_seguimientos_archivos_fecha($desde, $hasta) {
		$sql = "SELECT 
              		s.archivo_id
        		FROM 
              		seguimiento s
           	 	WHERE
              		s.fecha BETWEEN '{$desde}' AND '{$hasta}'
            	GROUP BY
              		s.archivo_id";
	    $datos = array($desde, $hasta);
	    $res = execute_query($sql);
    
	    $array_ids = array();
	    foreach ($res as $clave=>$valor) $array_ids[] = $valor['archivo_id'];
	    $archivos_ids = implode(',', $array_ids);
    
    	$sql = "SELECT 
	              	a.archivo_id,
	              	a.denominacion,
	              	s.seguimiento_id,
	              	e.denominacion as estado, 
	              	s.fecha,
	              	s.comentario
            	FROM 
              		seguimiento s INNER JOIN
              		archivos a ON s.archivo_id = a.archivo_id INNER JOIN
              		estados e ON s.estado_id = e.estado_id
            	WHERE
              		a.archivo_id IN ({$archivos_ids}) AND
              		s.fecha >= '{$desde}'
            	ORDER BY
              		a.archivo_id ASC,
              		s.fecha ASC";
    
    	$datos = execute_query($sql);
    	return $datos;
	}
  
  	function listar_estado_usuario_legalizar() {
		$sql = "SELECT
					f.archivo_id,
					f.denominacion AS nombre,
					f.documento,
					f.matricula,
					u.denominacion,
					s.seguimiento_id,
					DATE_FORMAT(f.fecha, '%d/%m/%Y') as fecha,
					f.comentario,
					s.estado_id,
					e.denominacion AS estado
				FROM
					archivos f INNER JOIN
					seguimiento s ON f.archivo_id = s.archivo_id INNER JOIN
					(SELECT archivo_id, max(seguimiento_id) AS max_sid
					 FROM seguimiento
					 GROUP BY archivo_id
					) m ON s.seguimiento_id = m.max_sid INNER JOIN
					estados e ON s.estado_id = e.estado_id INNER JOIN
					usuarios u ON s.usuario_id = u.usuario_id
				WHERE
					s.estado_id IN (9,6) AND
					u.usuario_id = ?";
		$datos = array($_SESSION["sesion.usuario_id"]);
		return execute_query($sql, $datos);
	}
	
	function listar_estado_usuario_prueba() {
		$sql = "SELECT
					f.archivo_id,
					f.denominacion AS nombre,
					f.documento,
					f.matricula,
					u.denominacion,
					s.seguimiento_id,
					DATE_FORMAT(f.fecha, '%d/%m/%Y') as fecha,
					f.comentario,
					s.estado_id,
					e.denominacion AS estado
				FROM
					archivos f INNER JOIN
					seguimiento s ON f.archivo_id = s.archivo_id INNER JOIN
					(SELECT archivo_id, max(seguimiento_id) AS max_sid
					 FROM seguimiento
					 GROUP BY archivo_id
					) m ON s.seguimiento_id = m.max_sid INNER JOIN
					estados e ON s.estado_id = e.estado_id INNER JOIN
					usuarios u ON s.usuario_id = u.usuario_id
				WHERE
					s.estado_id = ? AND
					f.matricula = ?";
		$datos = array($this->estado_id, 'C1068');
		return execute_query($sql, $datos);
	}

	function verificar_estado() {
		$sql = "SELECT estado_id FROM seguimiento
				WHERE seguimiento_id = (SELECT max(seguimiento_id) FROM seguimiento WHERE archivo_id = ?)";
		$datos = array($this->archivo_id);
		$rst = execute_query($sql, $datos);
		$this->estado_id = $rst[0]['estado_id'];
	}

	function listar_evaluacion() {
		$sql = "SELECT
					f.archivo_id,
					DATE_FORMAT(f.fecha, '%d/%m/%Y') as fecha,
					DATE_FORMAT(s.fecha, '%d/%m/%Y') as fecha_seguimiento,
					f.denominacion AS nombre,
					f.documento,
					f.matricula,
					u.denominacion,
					s.seguimiento_id,
					f.comentario,
					s.estado_id,
					e.denominacion AS estado,
					d.denominacion AS delegacion
				FROM
					archivos f INNER JOIN
					seguimiento s ON f.archivo_id = s.archivo_id INNER JOIN
					(SELECT archivo_id, max(seguimiento_id) AS max_sid
					 FROM seguimiento
					 GROUP BY archivo_id
					) m ON s.seguimiento_id = m.max_sid INNER JOIN
					estados e ON s.estado_id = e.estado_id INNER JOIN
					usuarios u ON s.usuario_id = u.usuario_id INNER JOIN
					delegacion d ON f.delegacion_id = d.delegacion_id
				WHERE
					s.estado_id = (1)";
		return execute_query($sql);
	}
   
	function listar_autorizacion() {
		$sql = "SELECT
              		f.archivo_id,
              		DATE_FORMAT(f.fecha, '%d/%m/%Y') as fecha,
              		DATE_FORMAT(s.fecha, '%d/%m/%Y') as fecha_seguimiento,
              		f.denominacion AS nombre,
              		f.documento,
              		f.matricula,
              		u.denominacion,
              		s.seguimiento_id,
              		f.comentario,
              		s.estado_id,
             		e.denominacion AS estado,
              		t.denominacion AS tipo,
              		IF((SELECT
                		estado_id
              		FROM
                		seguimiento
              		WHERE  
                		archivo_id = f.archivo_id
              		ORDER BY
                		seguimiento_id DESC
              		LIMIT 1,1) = 1, 'warning', 'info') AS class_icon,
              		(SELECT
                		us.denominacion
              		FROM
                		seguimiento se INNER JOIN
                		usuarios us ON se.usuario_id = us.usuario_id
              		WHERE  
		                se.archivo_id = f.archivo_id AND
		                se.estado_id IN (2,3,4) AND
		                us.grupo_id IN (1,3,4)
              		ORDER BY
                		se.seguimiento_id DESC
              		LIMIT 1) AS autorizador
            	FROM
              		archivos f INNER JOIN
              		seguimiento s ON f.archivo_id = s.archivo_id INNER JOIN
              		(SELECT archivo_id, max(seguimiento_id) AS max_sid
              		 FROM seguimiento
              		 GROUP BY archivo_id
              		) m ON s.seguimiento_id = m.max_sid INNER JOIN
              		estados e ON s.estado_id = e.estado_id INNER JOIN
              		usuarios u ON s.usuario_id = u.usuario_id INNER JOIN
              		tipos t ON f.tipo_id = t.tipo_id
            	WHERE
              		s.estado_id IN (2,3)
            	ORDER BY
	            	class_icon DESC, fecha DESC";
		
		return execute_query($sql);
	}  
  
  	function listar_autorizacion_usuario() {
		$sql = "SELECT
              		f.archivo_id,
              		DATE_FORMAT(f.fecha, '%d/%m/%Y') as fecha,
              		f.denominacion AS nombre,
              		f.documento,
              		f.matricula,
              		u.denominacion,
              		s.seguimiento_id,
              		f.comentario,
              		s.estado_id,
              		e.denominacion AS estado,
              		t.denominacion AS tipo,
              		IF((SELECT
                		estado_id
              		FROM
                		seguimiento
              		WHERE  
                		archivo_id = f.archivo_id
              		ORDER BY
                		seguimiento_id DESC
              		LIMIT 1,1) = 1, 'warning', 'info') AS class_icon,
              		(SELECT
                		us.denominacion
              		FROM
                		seguimiento se INNER JOIN
                		usuarios us ON se.usuario_id = us.usuario_id
              		WHERE  
                		se.archivo_id = f.archivo_id AND
                		se.estado_id IN (2,3,4) AND
                		us.grupo_id IN (1,3,4)
              		ORDER BY
                		se.seguimiento_id DESC
              		LIMIT 1) AS autorizador
            	FROM
              		archivos f INNER JOIN
              		seguimiento s ON f.archivo_id = s.archivo_id INNER JOIN
              		(SELECT archivo_id, max(seguimiento_id) AS max_sid
              		 FROM seguimiento
              		 GROUP BY archivo_id
              		) m ON s.seguimiento_id = m.max_sid INNER JOIN
              		estados e ON s.estado_id = e.estado_id INNER JOIN
              		usuarios u ON s.usuario_id = u.usuario_id INNER JOIN
              		tipos t ON f.tipo_id = t.tipo_id
            	WHERE
              		s.estado_id IN (2,3) AND
              		u.usuario_id = ?
            	ORDER BY
	            	class_icon DESC, fecha DESC";
		$datos = array($_SESSION['sesion.usuario_id']);
		return execute_query($sql, $datos);
	}
  
	function listar_legalizacion() {
		$sql = "SELECT
					f.archivo_id,
					DATE_FORMAT(f.fecha, '%d/%m/%Y') as fecha,
					f.denominacion AS nombre,
					f.documento,
					f.matricula,
					u.denominacion,
					s.seguimiento_id,
					f.comentario,
					s.estado_id,
					e.denominacion AS estado
				FROM
					archivos f INNER JOIN
					seguimiento s ON f.archivo_id = s.archivo_id INNER JOIN
					(SELECT archivo_id, max(seguimiento_id) AS max_sid
					 FROM seguimiento
					 GROUP BY archivo_id
					) m ON s.seguimiento_id = m.max_sid INNER JOIN
					estados e ON s.estado_id = e.estado_id INNER JOIN
					usuarios u ON s.usuario_id = u.usuario_id
				WHERE
					s.estado_id IN (6)";
		return execute_query($sql);
	}
  
  	function get() {
		$sql = "SELECT
					f.archivo_id,
					f.tipo_id,
					t.denominacion AS tipo_trabajo,
					t.tipo,
					f.denominacion AS nombre,
					f.denominacion AS razon_social,
					f.tipo_documento,
					f.documento,
					f.matricula,
					f.importe AS importe,
					f.excedente,
              		CASE f.excedente
						WHEN 1 THEN 'Pago de Matrícula'
						WHEN 2 THEN 'Reintegro de Aranceles'
						WHEN 0 THEN 'Sin excedente'
					END AS lbl_excedente,
					f.numero_comprobante AS numero_comprobante,
					c.cuenta_id,
					c.denominacion AS cuenta,
					c.numero AS numero_cuenta,
					CASE f.metodo_pago
						WHEN 1 THEN 'Depósito'
						WHEN 2 THEN 'Transferencia'
						WHEN 3 THEN 'Cheque'
					END AS metodo_pago,
					f.codigo_barras AS codigo_barras,
					e.denominacion AS entidad,
					e.entidad_id AS entidad_id,
					DATE_FORMAT(f.fecha_inicio, '%Y%m%d') AS fecha_inicio,
					DATE_FORMAT(f.fecha_cierre, '%Y%m%d') AS fecha_cierre,
					DATE_FORMAT(f.fecha_informe, '%Y%m%d') AS fecha_informe,
					DATE_FORMAT(f.fecha_inicio, '%d/%m/%Y') AS fecha_inicio_resumen,
					DATE_FORMAT(f.fecha_cierre, '%d/%m/%Y') AS fecha_cierre_resumen,
					DATE_FORMAT(f.fecha_informe, '%d/%m/%Y') AS fecha_informe_resumen,
					DATE_FORMAT(f.fecha_inicio, '%Y-%m-%d') AS fecha_editar_inicio,
					DATE_FORMAT(f.fecha_cierre, '%Y-%m-%d') AS fecha_editar_cierre,
					DATE_FORMAT(f.fecha_informe, '%Y-%m-%d') AS fecha_editar_informe,
					f.ejercicio,
					f.activo_corriente,
					f.activo_nocorriente,
					f.activo,
					f.pasivo_corriente,
					f.pasivo_nocorriente,
					f.pasivo,
					f.patrimonio_neto,
					f.venta_neta,
					f.bienes_uso,
					f.resultado_final,
              		f.origen_bienes_uso, 
					f.depreciacion_bienes_uso, 
				  	f.resultado_reexpresion_bienes_uso,
					f.comentario,
	              	f.adjunta_estadocontable,
	              	f.firma_digital,
	              	d.denominacion AS delegacion
				FROM
					archivos f LEFT JOIN
					entidades e ON f.entidad = e.entidad_id LEFT JOIN
					tipos t ON f.tipo_id = t.tipo_id INNER JOIN
					cuentas c ON f.cuenta_id = c.cuenta_id INNER JOIN
					delegacion d ON f.delegacion_id = d.delegacion_id
				WHERE
					f.archivo_id = ?";
		$datos = array($this->archivo_id);
		$rst = execute_query($sql, $datos);
		return $rst[0];
	}
	
	function search($criterio) {
		$sql = "SELECT
					s.archivo_id,
					s.seguimiento_id,
					a.denominacion,
					e.denominacion AS estado,
					s.comentario,
					DATE_FORMAT(s.fecha, '%d/%m/%Y') AS fecha,
					e.estado_id
				FROM
					seguimiento s INNER JOIN
					estados e ON s.estado_id = e.estado_id INNER JOIN
					archivos a ON s.archivo_id = a.archivo_id INNER JOIN
					(SELECT archivo_id, max(seguimiento_id) AS max_sid
					 FROM seguimiento
					 GROUP BY archivo_id
					) m ON s.seguimiento_id = m.max_sid
				WHERE
					(a.matricula = ? OR ? <> 2) AND 
					(a.denominacion LIKE ? OR
					a.comentario LIKE ?)";
		$datos = array($_SESSION["sesion.matricula"], $_SESSION["sesion.grupo_id"], $criterio, $criterio);
		return execute_query($sql, $datos);
	}
  
 	function search_consultar() {
		$sql = "SELECT
					s.archivo_id,
					s.seguimiento_id,
					a.denominacion,
					e.denominacion AS estado,
					s.comentario,
					DATE_FORMAT(s.fecha, '%d/%m/%Y') AS fecha,
					e.estado_id
				FROM
					seguimiento s INNER JOIN
					estados e ON s.estado_id = e.estado_id INNER JOIN
					archivos a ON s.archivo_id = a.archivo_id INNER JOIN
					(SELECT archivo_id, max(seguimiento_id) AS max_sid
					 FROM seguimiento
					 GROUP BY archivo_id
					) m ON s.seguimiento_id = m.max_sid
				WHERE
					(a.matricula = ? OR ? <> 2)";
		$datos = array($_SESSION["sesion.matricula"], $_SESSION["sesion.grupo_id"]);
		return execute_query($sql, $datos);
	}

	function ver_detalle() {
		$sql = "SELECT
					s.seguimiento_id,
					s.archivo_id,
					e.denominacion AS estado,
					s.comentario,
              		date_format(s.fecha, '%d/%m/%Y') as fecha,
					'fa fa-file' AS icono
				FROM
					seguimiento s INNER JOIN
					estados e ON s.estado_id = e.estado_id
				WHERE
					s.archivo_id = ?
				ORDER BY
					s.seguimiento_id";
		$datos = array($this->archivo_id);
		return execute_query($sql, $datos);
	}
  
  	function ver_detalle_evaluar() {
		$sql = "SELECT
					s.seguimiento_id,
					s.archivo_id,
					e.denominacion AS estado,
					s.comentario,
             		date_format(s.fecha, '%d/%m/%Y') as fecha,
					'fa fa-file' AS icono
				FROM
					seguimiento s INNER JOIN
					estados e ON s.estado_id = e.estado_id
				WHERE
					s.archivo_id = ?
				ORDER BY
					s.seguimiento_id";
		$datos = array($this->archivo_id);
		return execute_query($sql, $datos);
	}

	function verificar_duplicidad() {
		$sql = "SELECT count(*) AS duplicado FROM facturas WHERE proveedor_id = ? AND punto_venta = ? AND num_factura = ?";
		$datos = array($this->proveedor_id, $this->punto_venta, $this->num_factura);
		$rst = execute_query($sql, $datos);
		return $rst[0]['duplicado'];
	}

	function guardar_autorizaciones() {
		$sql = "INSERT INTO autorizaciones (factura_id, responsable_id)
				SELECT ? AS factura_id, responsable_id
				FROM cadenas_responsables
				WHERE cadena_id = ?";
		$datos = array($this->factura_id, $this->cadena_id);
		execute_query($sql, $datos);
	}

	function agregar_nivel($responsable_id) {
		$sql = "INSERT INTO autorizaciones (factura_id, responsable_id) VALUES (?, ?)";
		$datos = array($this->factura_id, $responsable_id);
		execute_query($sql, $datos);
	}

	function autorizar() {
		$sql = "UPDATE autorizaciones
				SET autorizado = 1
				WHERE factura_id = ?
				AND responsable_id = (SELECT responsable_id FROM usuarios_responsables WHERE usuario_id = ?)";
		$datos = array($this->factura_id, $_SESSION['sesion.usuario_id']);
		execute_query($sql, $datos);
	}
  
  function actualizar_codigo_barras($codigo_barras, $archivo_id) {
		$sql = "UPDATE archivos
				SET codigo_barras = ?
				WHERE archivo_id = ?";
		$datos = array($codigo_barras, $archivo_id);
		execute_query($sql, $datos);
	}
  
  	function actualizar_firmadigital($archivo_id, $firmadigital) {
		$sql = "UPDATE archivos
				SET firma_digital = ?
				WHERE archivo_id = ?";
		$datos = array($firmadigital, $archivo_id);
		execute_query($sql, $datos);
	}
	
	function exportar_eecc() {
		$sql = "SELECT
					f.archivo_id,
					f.tipo_id,
					f.tipo_documento,
					f.documento,
					f.matricula,
					f.importe AS importe,
					f.numero_comprobante,
					f.entidad,
					c.numero AS numero_cuenta,
					f.fecha_inicio AS fecha_inicio,
					f.fecha_cierre AS fecha_cierre,
					f.fecha_informe AS fecha_informe,
					f.ejercicio,
					f.activo_corriente,
					f.activo_nocorriente,
					f.activo,
					f.pasivo_corriente,
					f.pasivo_nocorriente,
					f.pasivo,
					f.patrimonio_neto,
					f.venta_neta,
					f.bienes_uso,
					f.resultado_final,
              		CASE f.excedente
						WHEN 1 THEN '1'
						WHEN 2 THEN '1'
						WHEN 0 THEN '0'
					END AS excedente,
              		round(f.resultado_reexpresion_bienes_uso,2) as resultado_reexpresion_bienes_uso
				FROM
					archivos f INNER JOIN 
					cuentas c ON f.cuenta_id = c.cuenta_id
				WHERE
					f.archivo_id = ?";
		$datos = array($this->archivo_id);
		$rst = execute_query($sql, $datos);
		return $rst[0];
	}
	
	function exportar_otros() {
		$sql = "SELECT
              		f.archivo_id,
					f.tipo_id,
					f.tipo_documento,
					f.documento,
					f.matricula,
					f.importe AS importe,
					f.numero_comprobante,
					f.entidad,
					c.numero AS numero_cuenta,
					f.fecha_inicio AS fecha_inicio,
					f.fecha_cierre AS fecha_cierre,
					f.fecha_informe AS fecha_informe,
					CASE f.excedente
						WHEN 1 THEN '1'
						WHEN 2 THEN '1'
						WHEN 0 THEN '0'
					END AS excedente
				FROM
					archivos f INNER JOIN 
					cuentas c ON f.cuenta_id = c.cuenta_id
				WHERE
					f.archivo_id = ?";
		$datos = array($this->archivo_id);
		$rst = execute_query($sql, $datos);
		return $rst[0];
	}

	function verificar_pendientes() {
		$sql = "SELECT count(*) AS cantidad FROM autorizaciones WHERE factura_id = ? AND autorizado = 0";
		$datos = array($this->factura_id);
		$rst = execute_query($sql, $datos);
		return $rst[0]['cantidad'];
	}
	
	function verifica_codigo_barras() {
		$sql = "SELECT archivo_id FROM archivos WHERE codigo_barras = ?";
		$datos = array($this->codigo_barras);
		$rst = execute_query($sql, $datos);
		return $rst[0]['archivo_id'];
	}
	
	function listar_entidades() {
		$sql = "SELECT entidad_id, denominacion AS entidad FROM entidades ORDER BY denominacion ASC";
		return execute_query($sql);
	}
	
	function listar_tipos_trabajo() {
		$sql = "SELECT tipo_id, denominacion AS tipo_trabajo FROM tipos WHERE tipo = ? ORDER BY denominacion ASC";
		$datos = array($this->tipo);
		return execute_query($sql, $datos);
	}
	
	function listar_cuentas() {
		$sql = "SELECT cuenta_id, denominacion AS cuenta, numero AS numero_cuenta FROM cuentas ORDER BY denominacion ASC";
		$datos = array($this->tipo);
		return execute_query($sql, $datos);
	}
  
  	function listar_estados_seguimiento() {
    	$sql = "SELECT estado_id, denominacion AS estado FROM estados";
		return execute_query($sql);
  	}
	
	function verificar_ejercicio() {
		$sql = "SELECT documento FROM archivos WHERE ejercicio = ? AND documento = ? AND fecha_inicio = ? AND fecha_cierre = ?";
		$datos = array($this->ejercicio, $this->documento, $this->fecha_inicio, $this->fecha_cierre);
		$rst = execute_query($sql, $datos);
		if (isset($rst[0]["documento"])) {
			return "Existe";
		} else {
			return "Libre";
		}
	}
  
  	function verificar_rechazo($archivo_id) {
		$sql = "SELECT archivo_id FROM seguimiento WHERE archivo_id = {$archivo_id} AND estado_id = 7";
		$datos = array($this->ejercicio, $this->documento, $this->fecha_inicio, $this->fecha_cierre);
		$rst = execute_query($sql, $datos);
		if (isset($rst[0]["archivo_id"])) {
			return "danger";
		} else {
			return "info";
		}
	}
  
  	function verificar_tipo_archivo($tipo_id) {
		$sql = "SELECT tipo FROM tipos WHERE tipo_id = ?";
		$datos = array($tipo_id);
		$rst = execute_query($sql, $datos);
		return $rst[0]['tipo'];
	}
  	
	function eliminar_pendiente() {
		$datos = array($this->archivo_id);
		$sql = "DELETE FROM archivos WHERE archivo_id = ?";
		execute_query($sql, $datos);
		
		$sql1 = "DELETE FROM seguimiento WHERE archivo_id = ?";
		execute_query($sql1, $datos);
	}
  
  	function traer_matriculado($matricula) {
    	$sql = "SELECT m.correoelectronico, m.telefono, m.celular FROM matriculados m WHERE matricula = '{$matricula}'";
		$rst = execute_query($sql);
    	if(!is_array[$rst]) $rst = array();
		return $rst;
  	}
  
  	function traer_matriculado_completo($matricula) {
    	$sql = "SELECT m.apellido, m.nombre, m.correoelectronico, m.telefono, m.celular FROM matriculados m WHERE matricula = '{$matricula}'";
		$rst = execute_query($sql);
    	if(!is_array[$rst]) $rst = array();
		return $rst;
  	}
  
  	function traer_correo_matriculado_archivo_id($archivo_id) {
    	$sql = "SELECT 
              		concat(m.apellido, ' ', m.nombre) as matriculado,
              		m.matricula as matricula,
              		m.correoelectronico as correoelectronico
            	FROM 
              		archivos a inner join 
              		matriculados m on a.matricula = m.matricula
            	WHERE 
              		archivo_id = ?";
    	$datos = array($archivo_id);
		$rst = execute_query($sql, $datos);
    	if(!is_array[$rst]) $rst = array();
		return $rst;
  	}
  
  	function verifica_revision($archivo_id) {
    	$sql = "SELECT 
              		date_format(s.fecha, '%d/%m/%Y') AS FECHA,
              		e.denominacion AS ESTADO,
              		s.comentario AS OBSERVACION,
              		u.denominacion AS USUARIO
            	FROM 
              		seguimiento s inner join 
              		estados e on s.estado_id = e.estado_id inner join
              		usuarios u on s.usuario_id = u.usuario_id
            	WHERE 
              		s.archivo_id = ?
            	ORDER BY
              		s.seguimiento_id ASC";
    	$datos = array($archivo_id);
		$seguimientos = execute_query($sql, $datos);
    	if(!is_array[$seguimientos]) $seguimientos = array();
    
   		$sql = "SELECT 
              		r.archivo_id AS ARCHIVO_ID,
              		date_format(r.fecha, '%d/%m/%Y') AS FECHA,
              		r.acepta_observacion AS ACEPTA_OBSERVACION,
              		CASE r.acepta_observacion
              			WHEN 1 THEN 'ACEPTA OBSERVACIONES'
                		WHEN 2 THEN 'NO ACEPTA OBSERVACIONES' 
              		END AS RESPUESTA,
              		r.intentos AS INTENTOS
        		FROM 
              		revisiones r
        		WHERE 
              		r.archivo_id = ?";
    	$datos = array($archivo_id);
		$revision = execute_query($sql, $datos);
    	if(!is_array[$revision]) $revision = array();
    
    	$rst = array($seguimientos, $revision);
		return $rst;
  	}
  
  	function cantidad_pendientes() {
		$sql = "SELECT
					COUNT(*) AS CANTIDAD
				FROM
					archivos f INNER JOIN
					seguimiento s ON f.archivo_id = s.archivo_id INNER JOIN
					(SELECT archivo_id, max(seguimiento_id) AS max_sid
					 FROM seguimiento
					 GROUP BY archivo_id
					) m ON s.seguimiento_id = m.max_sid INNER JOIN
					estados e ON s.estado_id = e.estado_id INNER JOIN
					usuarios u ON s.usuario_id = u.usuario_id
				WHERE
					s.estado_id IN (?,?,?) AND
					f.matricula = ?";
		$datos = array(4, 7, 12, $_SESSION["sesion.matricula"]);
		return execute_query($sql, $datos);
	}
  
  	function cantidad_observado($archivo_id) {
		$sql = "SELECT
					COUNT(estado_id) AS CANTIDAD
				FROM
					seguimiento s 
				WHERE
					s.estado_id IN (4) AND
					s.archivo_id = ?";
    	$datos = array($archivo_id);
		return execute_query($sql, $datos);
	}
}
?>