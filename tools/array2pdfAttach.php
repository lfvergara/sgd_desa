<?php
require_once "tools/attachmentFiles.php";


class Array2PDFAttach {
  function attachPDF($archivo_id, $ultima_presentacion, $adjunta_estadocontable, $tipoarchivo, $denominacion, $protocolo) {
    $jar = '/srv/websites/' . APP_NAME . '/tools/UtilPDF/UtilPDF.jar';
    $flag_informe = 0;
    //$protocolo = str_replace("/","_",$protocolo);
    $protocolo = $protocolo . '_' . date('Y');
    $nombre_final = $protocolo . "_" . $denominacion . ".pdf";
    if(FileHandler::check_file($archivo_id, 'informe')==true) $flag_informe = 1;
    
    switch ($tipoarchivo) {
      case 3:
        $flag_anexo = 0;
        $flag_informe = 0;
        if(FileHandler::check_file($archivo_id, 'informe')==true) $flag_informe = 1;

        if(is_null($ultima_presentacion) OR empty($ultima_presentacion) OR $ultima_presentacion == '' OR $ultima_presentacion == 0) {
          $flag_anexo = 0;  
        } else {
          if(FileHandler::check_file($archivo_id, $ultima_presentacion)==true) {
            if($adjunta_estadocontable == 1) {
              $flag_anexo = 1;
            } else {
              $flag_anexo = 0;
            }
          }
        }

        if ($flag_informe == 1) {
          if ($flag_anexo == 1) {
            $ini_ruta_oblea = FILES_PATH . $archivo_id . "/oblea";
            $fin_ruta_oblea = FILES_PATH . $archivo_id . "/oblea.pdf";
            $ini_ruta_balance = FILES_PATH . $archivo_id . "/" . $ultima_presentacion;
            $fin_ruta_balance = FILES_PATH . $archivo_id . "/" . $ultima_presentacion . ".pdf";
            $ini_ruta_informe = FILES_PATH . $archivo_id . "/informe";
            $fin_ruta_informe = FILES_PATH . $archivo_id . "/informe.pdf";

            copy($ini_ruta_oblea, $fin_ruta_oblea);
            copy($ini_ruta_balance, $fin_ruta_balance);
            copy($ini_ruta_informe, $fin_ruta_informe);

            $archivo1 = FILES_PATH . $archivo_id . "/oblea.pdf";
            $adjunto = FILES_PATH . $archivo_id . "/" . $ultima_presentacion . ".pdf";
            $archivo2 = FILES_PATH . $archivo_id . "/obleaTemporal.pdf";
            $script = '/usr/bin/java -jar "'.$jar.'" "ADJUNTAR" '.' "'.$archivo1.'" '.'"'.$adjunto.'" '.'"'.$archivo2.'"';
            $result = shell_exec($script." 2>&1");

            $archivo1 = FILES_PATH . $archivo_id . "/obleaTemporal.pdf";
            $adjunto = FILES_PATH . $archivo_id . "/informe.pdf";
            $archivo2 = FILES_PATH . $archivo_id . "/{$nombre_final}";
            $script = '/usr/bin/java -jar "'.$jar.'" "ADJUNTAR" '.' "'.$archivo1.'" '.'"'.$adjunto.'" '.'"'.$archivo2.'"';
            $result = shell_exec($script." 2>&1");
          } else {
            $ini_ruta_oblea = FILES_PATH . $archivo_id . "/oblea";
            $fin_ruta_oblea = FILES_PATH . $archivo_id . "/oblea.pdf";
            $ini_ruta_informe = FILES_PATH . $archivo_id . "/informe";
            $fin_ruta_informe = FILES_PATH . $archivo_id . "/informe.pdf";
            copy($ini_ruta_oblea, $fin_ruta_oblea);
            copy($ini_ruta_informe, $fin_ruta_informe);

            $archivo1 = FILES_PATH . $archivo_id . "/oblea.pdf";
            $adjunto = FILES_PATH . $archivo_id . "/informe.pdf";
            $archivo2 = FILES_PATH . $archivo_id . "/{$nombre_final}";

            $script = '/usr/bin/java -jar "'.$jar.'" "ADJUNTAR" '.' "'.$archivo1.'" '.'"'.$adjunto.'" '.'"'.$archivo2.'"';
            $result = shell_exec($script." 2>&1");
          }
        } else {
          if ($flag_anexo == 1) {
            $ini_ruta_oblea = FILES_PATH . $archivo_id . "/oblea";
            $fin_ruta_oblea = FILES_PATH . $archivo_id . "/oblea.pdf";
            $ini_ruta_balance = FILES_PATH . $archivo_id . "/" . $ultima_presentacion;
            $fin_ruta_balance = FILES_PATH . $archivo_id . "/" . $ultima_presentacion . ".pdf";
            copy($ini_ruta_oblea, $fin_ruta_oblea);
            copy($ini_ruta_balance, $fin_ruta_balance);

            $archivo1 = FILES_PATH . $archivo_id . "/oblea.pdf";
            $adjunto = FILES_PATH . $archivo_id . "/" . $ultima_presentacion . ".pdf";
            $archivo2 = FILES_PATH . $archivo_id . "/{$nombre_final}";

            $script = '/usr/bin/java -jar "'.$jar.'" "ADJUNTAR" '.' "'.$archivo1.'" '.'"'.$adjunto.'" '.'"'.$archivo2.'"';
            $result = shell_exec($script." 2>&1");
          } else {
            $ini_ruta_oblea = FILES_PATH . $archivo_id . "/oblea";
            $fin_ruta_oblea = FILES_PATH . $archivo_id . "/{$nombre_final}";
            copy($ini_ruta_oblea, $fin_ruta_oblea);
          }
        }   
        break;
      case 8:
        if(FileHandler::check_file($archivo_id, $ultima_presentacion)==true) $flag_ultimapresentacion = 1;
        if ($flag_ultimapresentacion == 1) {
          $ini_ruta_oblea = FILES_PATH . $archivo_id . "/oblea";
          $ini_ruta_balance = FILES_PATH . $archivo_id . "/" . $ultima_presentacion;
          $fin_ruta_oblea = FILES_PATH . $archivo_id . "/oblea.pdf";
          $fin_ruta_balance = FILES_PATH . $archivo_id . "/" . $ultima_presentacion . ".pdf";
          copy($ini_ruta_oblea, $fin_ruta_oblea);
          copy($ini_ruta_balance, $fin_ruta_balance);
          
          $archivo1 = FILES_PATH . $archivo_id . "/oblea.pdf";
          $adjunto = FILES_PATH . $archivo_id . "/" . $ultima_presentacion . ".pdf";
          $archivo2 = FILES_PATH . $archivo_id . "/{$nombre_final}";
          $script = '/usr/bin/java -jar "'.$jar.'" "ADJUNTAR" '.' "'.$archivo1.'" '.'"'.$adjunto.'" '.'"'.$archivo2.'"';
          $result = shell_exec($script." 2>&1");
        }    
        break;
      default:
        $ini_ruta_oblea = FILES_PATH . $archivo_id . "/oblea";
        $ini_ruta_balance = FILES_PATH . $archivo_id . "/" . $ultima_presentacion;
        $fin_ruta_oblea = FILES_PATH . $archivo_id . "/oblea.pdf";
        $fin_ruta_balance = FILES_PATH . $archivo_id . "/" . $ultima_presentacion . ".pdf";
        copy($ini_ruta_oblea, $fin_ruta_oblea);
        copy($ini_ruta_balance, $fin_ruta_balance);
        
        if ($flag_informe == 0) {
          if($adjunta_estadocontable == 1) {
            $archivo1 = FILES_PATH . $archivo_id . "/oblea.pdf";
            $adjunto = FILES_PATH . $archivo_id . "/" . $ultima_presentacion . ".pdf";
            $archivo2 = FILES_PATH . $archivo_id . "/{$nombre_final}";

            $script = '/usr/bin/java -jar "'.$jar.'" "ADJUNTAR" '.' "'.$archivo1.'" '.'"'.$adjunto.'" '.'"'.$archivo2.'"';
            $result = shell_exec($script." 2>&1");
          } else {
            $ini_ruta_oblea = FILES_PATH . $archivo_id . "/oblea";
            $fin_ruta_oblea = FILES_PATH . $archivo_id . "/{$nombre_final}";
            copy($ini_ruta_oblea, $fin_ruta_oblea);
          }          
        } else {
          
          if($adjunta_estadocontable == 1) {
            $ini_ruta_informe = FILES_PATH . $archivo_id . "/informe";
            $fin_ruta_informe = FILES_PATH . $archivo_id . "/informe.pdf";
            copy($ini_ruta_informe, $fin_ruta_informe);

            $archivo1 = FILES_PATH . $archivo_id . "/oblea.pdf";
            $adjunto = FILES_PATH . $archivo_id . "/" . $ultima_presentacion . ".pdf";
            $archivo2 = FILES_PATH . $archivo_id . "/obleaTemporal.pdf";
            $script = '/usr/bin/java -jar "'.$jar.'" "ADJUNTAR" '.' "'.$archivo1.'" '.'"'.$adjunto.'" '.'"'.$archivo2.'"';
            $result = shell_exec($script." 2>&1");

            $archivo1 = FILES_PATH . $archivo_id . "/obleaTemporal.pdf";
            $adjunto = FILES_PATH . $archivo_id . "/informe.pdf";
            $archivo2 = FILES_PATH . $archivo_id . "/{$nombre_final}";
            $script = '/usr/bin/java -jar "'.$jar.'" "ADJUNTAR" '.' "'.$archivo1.'" '.'"'.$adjunto.'" '.'"'.$archivo2.'"';
            print_r($script);exit;
            $result = shell_exec($script." 2>&1");
          } else {
            $ini_ruta_informe = FILES_PATH . $archivo_id . "/informe";
            $fin_ruta_informe = FILES_PATH . $archivo_id . "/informe.pdf";
            copy($ini_ruta_informe, $fin_ruta_informe);
            
            $archivo1 = FILES_PATH . $archivo_id . "/oblea.pdf";
            $adjunto = FILES_PATH . $archivo_id . "/informe.pdf";
            $archivo2 = FILES_PATH . $archivo_id . "/{$nombre_final}";
            $script = '/usr/bin/java -jar "'.$jar.'" "ADJUNTAR" '.' "'.$archivo1.'" '.'"'.$adjunto.'" '.'"'.$archivo2.'"';
            $result = shell_exec($script." 2>&1");
          }
        }
        break;
    }
	}
}

function Array2PDFAttach() {return new Array2PDFAttach();} 
?>