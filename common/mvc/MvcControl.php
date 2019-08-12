<?php
/**
 * Classe abstrata padrão que todos os Controles devem extender<br /><br />
 * Possui os seguintes métodos:
 * <ul>
 *		<li>__construct($_name, $_label)</li>
 *		<li><i>abstract</i> printControl()</li>
 * </ul>
 * @author igor.santos
 */
abstract class MvcControl {
	/** @var string */			public $name;
	/** @var string */			public $label;
	/** @var bool */				public $hidden;
	/** @var array|string */	public $jsFiles;

	function __construct($_name, $_label) {
		$this->name = $_name;
		$this->label = $_label;
	}

	/*
	 * NÃO HÁ NECESSIDADE DE IMPLEMENTAR ISSO.
	 * Se aparecer algum caso de uso, implementar.
	 */
	//TODOS os controles devem possuir __toString. É por aqui que eles serão impressos na tela
//	abstract function __toString();

	function printControl() {
		echo $this;
	}
	
	/**
	 * retorna a string <label for="nome" id="label_nome">Label</label>
	 * @return string a tag <code>label</code> com o texto
	 */
	function getLabel() {
		if(isset($this->label) && $this->label)
			return "<label for=\"$this->name\" id=\"label_$this->name\">".(isset($this->label)?$this->label:'')."</label>";
	}
}
?>