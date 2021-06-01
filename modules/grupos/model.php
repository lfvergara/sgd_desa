<?php
/**
 *
 */
class Grupos {

  function __construct(){
    $this->grupo_id = 0;
    $this->denominacion = '';
  }

  function listar() {
    $sql = "SELECT grupo_id, denominacion FROM grupos";
    return execute_query($sql);
  }
}

?>
