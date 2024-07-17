<?php
/**
 * Classe da tag &lt;a&gt; que chama um método do MvcForm. Imprime um <tt>hidden</tt> de mesmo nome se precisar enviar algum valor.
 * @param string $_name Nome do Controle e também nome do método que ele tentará chamar quando for clicado
 * @param string $_caption Texto do link
 * @param string $_value&nbsp;=&nbsp;"" Argumento a ser enviado com o link. Se a string for o nome de um atributo de $this->data, esse valor será enviado.<br />
 *		Será acessável via $this->data->[nome do link | atributo]
 * @param string $_extra atributos extra a serem colocados no controle link em HTML
 * @example $this->addControl(new LinkControl("link_metodo", "Controle de link", "123"));
 */
class LinkControl extends MvcControl {
	var $caption;
	var $value;
	var $extra;

	/**
	 * Construtor da tag &lt;a&gt; que chama um método do MvcForm
	 */
	function __construct($_name, $_caption, $_value = "", $_extra = '') {
		parent::__construct($_name, null);
		$this->caption = $_caption;
		$this->value = $_value;
        $this->extra = $_extra;
	}

	/**
	 * Imprime o controle.
	 */
	function printControl() {
		echo "<a href=\"javascript:".$this->form->name."do_action('".$this->name."')\"$this->extra>".$this->caption."</a>";
		if (trim($this->value) != "")
			echo "<input type=\"hidden\" value=\"".$this->value."\" name=\"".$this->name."\" id=\"".$this->name."\" />";
	}
}
?>
