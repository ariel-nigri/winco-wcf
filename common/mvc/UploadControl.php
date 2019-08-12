<?php
/*
 * TODO devemos mudar o enctype do formul�rio e fazer com que ele receba os tipos vindos daqui
 */
/**
 * Tag &lt;input type="file" /&gt;
 */
class UploadControl extends MvcControl {
	/** @var string */	private	$extra;
	/** @var array */		public	$file_types;

	/**
	 * Construtor da tag &lt;input type="text" /&gt;
	 * @param string $_name Nome do Controle e da tag
	 * @param string $_label Texto da label que aparecer� antes do campo
	 * @param string $_extra&nbsp;=&nbsp;"" Usado para passar algum atributo a mais, como 'size' ou 'maxlength'
	 * @param array $file_types&nbsp;=&*nbsp;null Cont�m os tipos de arquivo que devem ser aceitos pelo formul�rio. Se houver mais de um
	 *		UploadControl, os tipos de ambos ser�o mesclados
	 * @example $this->addControl(new EditControl("cli_endereco", "Endere�o: ", "size=80"))
	 */
	function __construct($_name, $_label, $_extra = "", array $file_types = null) {
		parent::__construct($_name, $_label);
		$this->extra = $_extra;
		$this->file_types = $file_types;
	}

	function __toString() {
		return "<input type=\"file\" name=\"".$this->name."\" id=\"".$this->name."\" $this->extra />";
	}

	/**
	 * Imprime o controle.
	 */
	function printControl() {
		echo $this;
	}
}
?>