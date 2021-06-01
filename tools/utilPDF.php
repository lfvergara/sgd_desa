<?php
	//firmar("D:\NetBeansProjects\UtilPDF\dist\UtilPDF.jar","D:\proyectos\CPC-System\FirmaPDF\doc.pdf","ARIEL GIMENEZ");

	function firmar ($jar, $archivo, $firmante){
		$script = '/usr/bin/java -jar "'.$jar.'" "FIRMAR" '.'" "'.$archivo.'" '.'"'.$firmante.'"';
		//print_r($script."\n");
		$result = shell_exec($script." 2>&1");
		//$result = shell_exec("java -jar '/home/cpcelr/public_html/sgd_desa/tools/FirmaPDF/FirmarPDF.jar' '/home/cpcelr/public_html/sgd_desa/static/doc.pdf' 'ARIEL GIMENEZ' 2>&1");
		//print_r($result."\n");
		var_dump($result);
		if ($result=="OK") {
			print_r($result);
		} else {
			echo "ERROR"; 
		}

	}

//adjuntar("D:\NetBeansProjects\UtilPDF\dist\UtilPDF.jar","D:\proyectos\CPC-System\FirmaPDF\doc.pdf","D:\proyectos\CPC-System\FirmaPDF\doc_fir.pdf",,"D:\proyectos\CPC-System\FirmaPDF\doc_final.pdf");
	function adjuntar ($jar, $archivo1, $adjunto, $archivo2){
		$script = '/usr/bin/java -jar "'.$jar.'" "ADJUNTAR" '.'" "'.$archivo1.'" '.'"'.$adjunto.'" '.'"'.$archivo2.'"';
		//print_r($script."\n");
		$result = shell_exec($script." 2>&1");
		//$result = shell_exec("java -jar '/home/cpcelr/public_html/sgd_desa/tools/FirmaPDF/FirmarPDF.jar' '/home/cpcelr/public_html/sgd_desa/static/doc.pdf' 'ARIEL GIMENEZ' 2>&1");
		//print_r($result."\n");
		var_dump($result);
		if ($result=="OK") {
			print_r($result);
		} else {
			echo "ERROR";
		}

	}
//unir("D:\NetBeansProjects\UtilPDF\dist\UtilPDF.jar","D:\proyectos\CPC-System\FirmaPDF\doc.pdf","D:\proyectos\CPC-System\FirmaPDF\doc_fir.pdf",,"D:\proyectos\CPC-System\FirmaPDF\doc_final.pdf");
	function unir ($jar, $archivo1, $adjunto, $archivo2){
		$script = '/usr/bin/java -jar "'.$jar.'" "UNIR" '.'" "'.$archivo1.'" '.'"'.$adjunto.'" '.'"'.$archivo2.'"';
		//print_r($script."\n");
		$result = shell_exec($script." 2>&1");
		//$result = shell_exec("java -jar '/home/cpcelr/public_html/sgd_desa/tools/FirmaPDF/FirmarPDF.jar' '/home/cpcelr/public_html/sgd_desa/static/doc.pdf' 'ARIEL GIMENEZ' 2>&1");
		//print_r($result."\n");
		var_dump($result);
		if ($result=="OK") {
			print_r($result);
		} else {
			echo "ERROR";
		}

	}
?>