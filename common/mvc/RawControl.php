<?php
/**
 * Classe de um controle cru.
 * @param string $_name Nome do controle
 * @param string $_value Conteúdo do controle
 * @example $this->addControl(new RawControl("link", "<a href=\"http://www.winco.com.br\">Controle \"cru\"</a>"));
 */
class RawControl extends MvcControl {
	private $value;

	/**
	 * Construtor do controle cru. Simplesmente imprime o conteúdo direto na tela.
	 */
	function __construct($_name, $_value) {
		parent::__construct($_name, null);
		$this->value = $_value;
	}

	/**
	 * Imprime o controle.
	 */
	function printControl() {
		echo $this->value;
	}
}
?>
