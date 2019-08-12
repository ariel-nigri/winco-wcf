<?php
/**
 * Classe da tag &lt;textarea&gt;
 */
class TextAreaControl extends MvcControl {
	public $value;
	private $extra;

	/**
	 * Construtor da tag &lt;textarea&gt;
	 * @param string $_name Nome do Controle e da tag
	 * @param string $_label Texto que aparecerá antes do campo
	 * @param string $_extra Usado para passar algum atributo a mais, como 'wrap'
	 * @example $this->addControl(new TextAreaControl("comentarios", "Comentários: ", "wrap='off'"))
	 */
	function __construct($_name, $_label, $_extra = "") {
		parent::__construct($_name, $_label);
		$this->extra = $_extra;
	}

	/**
	 * Imprime o controle.
	 */
	function printControl() {
		echo "<textarea name=\"".$this->name."\" id=\"".$this->name."\" ".$this->extra.">".htmlspecialchars($this->value)."</textarea>";
	}
}
?>
