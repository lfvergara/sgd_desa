<?php


class Maletin {

	function __construct() {
		$this->maletin_id = 0;
		$this->orden = 0; 
		$this->titulo = ''; 
		$this->imagen = ''; 
		$this->contenido = ''; 
		$this->activo = ''; 
		$this->fecha = ''; 
	}
	
	function traer_maletines() {
    $sql = "SELECT 
              cmlt.mlt_id as maletin_id,
              cmlt.mlt_orden as orden,
              cmlt.mlt_titulo as titulo,
              cmlt.mlt_imagen as imagen,
              cmlt.mlt_contenido as contenido,
              cmlt.mlt_activo as activo,
              cmlt.mlt_fecha as fecha,
              IF(cmlt.mlt_imagen IS NULL or cmlt.mlt_imagen = '', 'none', 'block') as img_display
            FROM 
              cpcelr_contenidos.maletin cmlt
            WHERE 
              cmlt.mlt_activo = ?
            ORDER BY
              cmlt.mlt_orden ASC";
		$datos = array(1);
		$rst = execute_query($sql, $datos);
    if(!is_array[$rst]) $rst = array();
		return $rst;
  }
}
?>