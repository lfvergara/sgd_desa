<?php


function create_csv($rst, $nombre) {
	$file = fopen("descargas/$nombre","w");
	
	foreach($rst as $fila=>$datos) {
		fputcsv($file,$datos,";");
	}
	
	fclose($file);
}
?>