<?php
abstract class LayoutManager {

	/** @var integer */ public $totalControles;

	public function startForm() {
		echo "\r\n\t<table class=\"table_mvcform\" style=\"width: auto;\">\r\n";
	}

	public function endForm() {
		echo "\t</table>\r\n";
	}

	abstract function printControl($control, $layout, $prevlayout);

}
?>
