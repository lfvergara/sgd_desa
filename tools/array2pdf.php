<?php
require_once "tools/domPDF/dompdf_config.inc.php";


class Array2PDF extends View{
  function createPDF($comprobante) {
    $gui = file_get_contents("static/comprobante.html");
    $gui = str_replace('{comprobante}', $comprobante, $gui);
    $dompdf = new DOMPDF();
    $dompdf->load_html($gui);
    $dompdf->render();
    $dompdf->stream("comprobante.pdf");
    //return $dompdf->output();
    exit;
	}
  
  function createObleaPDF($archivo) {
    $tipo_trabajo = $archivo["tipo"];
    if ($tipo_trabajo == 1) {
      $gui = file_get_contents("static/oblea.html");
    } else {
      $gui = file_get_contents("static/oblea_tipo2.html");
    }
    
    $archivo_id = $archivo['archivo_id'];
    $archivo = $this->set_dict($archivo);
    $gui = $this->render($archivo, $gui);
    $directorio = FILES_PATH . $archivo_id;
    
    chmod($directorio, 0777);
    $output = FILES_PATH . $archivo_id . "/oblea";
    
    $dompdf = new DOMPDF();
    $dompdf->set_paper('A4', 'landscape');
    $dompdf->load_html($gui);
    $dompdf->render();
    //$dompdf->stream("oblea.pdf");
    
    $pdfoutput = $dompdf->output(); 
    $filename = $output;
    $fp = fopen($output, "a"); 
    fwrite($fp, $pdfoutput); 
    fclose($fp);
    
	}
}

function Array2PDF() {return new Array2PDF();} 
?>