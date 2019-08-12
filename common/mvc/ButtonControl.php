<?php
/**
 * Classe da tag &lt;input type="button" /&gt;. Chama um m�todo do MvcForm, e <u>n�o</u> gera label.
 */
class ButtonControl extends MvcControl {
	var $caption;
	var $extra;

	/**
	 * Construtor da tag &lt;input type="button" /&gt;. Chama um m�todo do MvcForm, e <u>n�o</u> gera label.
	 * @param string $_name Nome do Controle e da tag e do m�todo que ele tentar� chamar quando for ativado
	 * @param string $_caption Texto do bot�o
	 * @param string $_extra&nbsp;=&nbsp;"" Atributos extras para o bot�o
	 * @example $this->addControl(new ButtonControl("save", "Salvar"));
	 */
	function __construct($_name, $_caption, $_extra="") {
		parent::__construct($_name, null);
		$this->caption = $_caption;
		$this->extra = $_extra;
	}

	/**
	 * Imprime o controle.
	 */
	function printControl() {
		echo "<input type=\"button\" value=\"".$this->caption."\" name=\"".$this->name."\" id=\"".$this->name."\" onclick=\"javascript:".$this->form->name."do_action('".$this->name."')\" ".$this->extra."/>";
	}
}
?>
