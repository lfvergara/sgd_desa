<?php
$file = (isset($_GET['f'])) ? $_GET['f'] : '';
$accion = (isset($_GET['a'])) ? $_GET['a'] : '';
$archivo = FILES_PATH . "documentos/{$file}";

if(file_exists($archivo)) {
	switch ($accion) {
		case 'v':
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$mime = finfo_file($finfo, $archivo);
			finfo_close($finfo);
			header("Content-Type: {$mime}");
			ob_end_clean();
		    $imagen = readfile($archivo);
			break;
		case 'd':
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
		    $mime = finfo_file($finfo, "{$archivo}.sql.gz");
		    finfo_close($finfo);
		    header("Content-Type: {$mime}");
		    ob_end_clean();
		    readfile($archivo);
			exit;
			break;
	}
}
?>