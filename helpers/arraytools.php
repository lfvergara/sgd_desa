<?php

/**
 * Herramientas para manipular arrays
 */
class ArrayTools {

  function create_csv($rst, $nombre) {
    $file = fopen("descargas/$nombre","w");

    foreach($rst as $fila=>$datos) {
      fputcsv($file,$datos,";");
    }

    fclose($file);
  }

  static function to_xml($array, $xml = false){
    if($xml === false){
        $xml = new SimpleXMLElement('<data/>');
    }
    foreach($array as $key => $value){
        if(is_array($value)){
            ArrayTools::to_xml($value, $xml->addChild($key));
        }else{
            $xml->addChild($key, $value);
        }
    }
    return $xml->asXML();
}

}

?>
