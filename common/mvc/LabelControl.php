<?php
/**
 * Gera um bloco de texto, com htmlspecialchars().
 */
class LabelControl extends MvcControl {
	public $value;

	/**
	 * Gera um bloco de texto, com htmlspecialchars().
	 * @param string $_name Nome do controle
	 * @param string $_label label do texto
	 * @param string $_value Texto a ser exibido
	 * @example $this->addControl(new LabelControl("label1", "Nome: ", "Thyago Simas"));
	 */
	function __construct($_name, $_label, $_value = "") {
		parent::__construct($_name, $_label);
		$this->value = $_value;
	}

	/**
	 * Imprime o controle.
	 */
	function printControl() {
		echo htmlspecialchars($this->value)."\r\n";
	}
}
?>