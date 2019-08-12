<?php
/**
 * Grupo de tags &lt;input type="checkbox" /&gt;
 */
class CheckListControl extends MvcControl {
	var $value;
	var $choices;
	var $button;

	/**
	 * Grupo de tags &lt;input type="checkbox" /&gt;
	 * @param string $_name Nome do Controle e da tag
	 * @param string $_label Texto da label que aparecerá antes da check
	 * @param array(value&nbsp;=>&nbsp;texto) $_choices Array bidimensional com as checks que aparecerão dentro da lista
	 * @param null $_button&nbsp;=&nbsp;"" ???
	 * @example $this->addControl(new CheckListControl("allowed_nets", "Teste", $networks));
	 */
	function __construct($_name, $_label, $_choices, $_button = "") {
		parent::__construct($_name, $_label);
		$this->choices = $_choices;
		$this->button = $_button;
	}

	/**
	 * Imprime o controle.
	 */
	function printControl() {
		echo "<div style=\"height:85px; width:160px; border:solid 1px #9C9C9C; z-index:1; overflow:auto\">\r\n";
		if (!is_array($this->value))
			$this->value = Array();
		$i=0;
		if (is_array($this->choices)) {
			foreach($this->choices as $k => $v) {
				echo "\t<input type=\"checkbox\" name=\"".$this->name."[$i]\" value=\"$k\"".(in_array($k, $this->value) ? " checked=checked" : "")." />".htmlspecialchars($v);
				if($this->button) {
					echo "\t<input type=\"button\" value=\"".$this->button."\" name=\"".$k."\" id=\"".$k."\" onClick=\"javascript:".$this->form->name."do_action_param('".$this->name."', '".$this->button."', '".$k."')\" />";
				}
				echo "<br />\r\n";
				$i++;
			}
			if($this->button) {
				echo "<input type=\"hidden\" value=\"\" name=\"".$this->button."\" id=\"".$this->button."\" />";
			}
		}
		echo "</div>\r\n";
	}
}
?>
