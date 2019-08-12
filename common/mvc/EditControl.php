<?php
/**
 * Tag &lt;input type="text" /&gt;
 */
class EditControl extends MvcControl {
	public $value;
	private $extra;
	private $after;

	/**
	 * Construtor da tag &lt;input type="text" /&gt;
	 * @param string $_name Nome do Controle e da tag
	 * @param string $_label Texto da label que aparecerá antes do campo
	 * @param string $_extra&nbsp;=&nbsp;"" Usado para passar algum atributo a mais, como 'size' ou 'maxlength'
	 * @param string $_after&nbsp;=&nbsp;"" Será impresso logo após o campo. Usado, por exemplo, para unidades
	 * @example $this->addControl(new EditControl("cli_endereco", "Endereço: ", "size=80"))
	 */
	function __construct($_name, $_label, $_extra = '', $_after = '') {
		parent::__construct($_name, $_label);
		$this->extra = $_extra;
		$this->after = $_after;
	}

	/**
	 * Imprime o controle.
	 */
	function printControl() {
		echo "<input type=\"text\" value=\"".htmlspecialchars($this->value)."\" name=\"".$this->name."\" id=\"".$this->name."\" $this->extra /> $this->after";
	}
}
?>
