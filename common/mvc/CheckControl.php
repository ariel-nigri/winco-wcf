<?php
/**
 * Classe da tag &lt;input type="checkbox" /&gt;<br /><br />
 *		Essa classe também gera um input <tt>hidden</tt> com o mesmo nome da checkbox, para que o dado seja enviado vazio no
 *		caso da opção não ter sido marcada (quando uma caixa de verificação não é marcada ela não é enviada para a página
 *		que processa o formulário).
 */
class CheckControl extends MvcControl {
	/** @var boolean */	public $value;
	/** @var string */	public $extra;

	/**
	 * Construtor da tag &lt;input type="checkbox" /&gt;
	 *		Também gera um input <tt>hidden</tt> com o mesmo nome da checkbox, para que o dado seja enviado vazio no
	 *		caso da opção não ter sido marcada (quando uma caixa de verificação não é marcada ela não é enviada para a página
	 *		que processa o formulário).
	 * @param string $_name Nome do Controle e da tag
	 * @param string $_label Texto que ficará <u>antes</u> da check (não, não dá pra incluir texto após a check)
	 * @param string $_extra Usado para passar algum atributo a mais, como 'checked'
	 * @example $this->addControl(new CheckControl("concorda", "Concorda?"));
	*/
	function __construct($_name, $_label, $_extra = "") {
		parent::__construct($_name, $_label);
		$this->extra = $_extra;
	}

	/**
	 * Imprime o controle.
	 */
	function printControl() {
		// we create a hidden control with same name because check controls dont include themselves in the postdata
		// when they are unchecked and this creates a problem to our current framwork
		echo "<input type=\"hidden\" name=\"".$this->name."_HDN_CHK\" /><input type=\"checkbox\" name=\"".$this->name."\" id=\"".$this->name."\" value=\"true\"".($this->value ? " checked=\"checked\"":"").($this->extra ? " ".$this->extra : "")." />";
	}
}
?>