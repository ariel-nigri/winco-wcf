<?php
/**
 * Classe da tag &lt;input type="hidden" /&gt;. Ela é gerada logo após a tag &lt;form&gt;
 */
class HiddenControl extends MvcControl {
	public $value;

	/**
	 * Construtor da tag &lt;input type="hidden" /&gt;
	 * @param string $_name Nome do Controle e da tag
	 * @param string $_value&nbsp;=&nbsp;"" Valor da tag. Se vazio, fará com que o MvcForm preencha o campo com o valor de $this->data->{$_name}
	 * @example $this->addControl(new HiddenControl("id", "123"));
 	 */
	function __construct($_name, $_value = "") {
		parent::__construct($_name, null);
		$this->value = $_value;
		$this->hidden = true;
	}

	/**
	 * Imprime o controle.
	 */
	function printControl() {
		echo "<input type=\"hidden\" name=\"".$this->name."\" id=\"".$this->name."\" value=\"".htmlspecialchars($this->value)."\" />\r\n";
	}
}
