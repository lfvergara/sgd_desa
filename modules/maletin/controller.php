<?php
require_once "modules/maletin/view.php";
require_once "modules/maletin/model.php";


class MaletinController {

	function __construct() {
		$this->model = new Maletin();
		$this->view = new MaletinView();
	}
  
	function panel() {
    SessionHandling::check();
    //SessionHandling::checkGrupo('1,4,99');
		$maletines = $this->model->traer_maletines();
    $this->view->panel($maletines);
	}	
}
?>