<?php
require_once "tools/domPDF/dompdf_config.inc.php";


class Array2PDFRevision extends View{
  function createPDFRevision($array_revision) {
    $gui = file_get_contents("static/comprobante_revision.html");
    $gui_lst_seguimientos = file_get_contents("static/lst_seguimiento.html");
    $seguimientos = $array_revision[0];
    $revision = $array_revision[1];
    $revision = $revision[0];
    $revision = $this->set_dict($revision);
    
    $gui_lst_seguimientos = $this->render_regex('LST_SEGUIMIENTOS', $gui_lst_seguimientos, $seguimientos);	
    $gui = str_replace('{lst_seguimientos}', $gui_lst_seguimientos, $gui);
    $gui = $this->render($revision, $gui);
    $dompdf = new DOMPDF();
    $dompdf->load_html($gui);
    $dompdf->render();
    $dompdf->stream("comprobante.pdf");
    //return $dompdf->output();
    exit;
	}
}

function Array2PDFRevision() {return new Array2PDFRevision();} 
?>