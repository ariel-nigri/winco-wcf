<?php
/**
 * Classe da tag &lt;input type="password" /&gt;
 */
class PasswordControl extends MvcControl {
	var $value;
	var $extra;

	/**
	 * Construtor da tag &lt;input type="password" /&gt;
	 * @param string $_name Nome do Controle e da tag
	 * @param string $_label Nome da Label que aparecerá antes da sua Text
	 * @param string $_extra Usado para passar algum atributo a mais, como 'size' e 'maxlength'
	 * @example $this->addControl(new PasswordControl("password", "Senha: ", "size=6"))
	 */
	function __construct($_name, $_label, $_extra = "") {
		parent::__construct($_name, $_label);
		$this->extra = $_extra;
	}

	/**
	 * Imprime o controle.
	 */
	function printControl() {
		echo "<input type=\"password\" value=\"".htmlspecialchars($this->value)."\" name=\"".$this->name."\" id=\"".$this->name."\" $this->extra />";
	}
}
?>
