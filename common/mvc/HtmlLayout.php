<?php
class HtmlLayout extends LayoutManager {
	
	var $layoutString;
	var $layout_arr;
	var $layout_idx;
	
	/**
	* Construtor do HTML layout
	* @param string $layout String com o layout do html
	* @example $this->addControl(new HtmlLayout('<div id="a">#control_1#</div><div id="b">#control_2#</div>'));
	*/
	function __construct($layout) {
		$this->layoutString = $layout;	
	}
	
	function startForm() {
		$this->layout_arr = explode("#", $this->layoutString);
		$this->layout_idx = 0;
		echo $this->layout_arr[$this->layout_idx++];
	}

	function printControl($control, $layout, $prevlayout) {
		if ($this->layout_arr[$this->layout_idx++] != $control->name)
			die("erro no layout string, controle esperado = {$control->name}, recebido = {$this->layout_arr[$this->layout_idx++]}");
		$control->printControl();
		echo $this->layout_arr[$this->layout_idx++];
	}
}
?>
