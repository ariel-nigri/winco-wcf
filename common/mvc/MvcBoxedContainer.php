<?php

/**
 * Container HTML que inicia com uma CheckBox para enable/disable. Por padr�o � um fieldset, mas pode ser usado tamb�m para gerar divs e etc.
 */
class MvcBoxedContainer extends MvcContainer {
	private $title;
	/**
	 *
	 * @param <type> $_form O formul�rio onde esse controle ser� inclu�do; necess�rio para incluir os dados do formul�rio nos controles daqui
	 * @param string $_name Identificador do container
	 * @param <type> $_label O label do controle (usado num fieldset - tag <code>legend</code>)
	 * @param string $_tag&nbsp;=&nbsp;'div' A tag
	 * @param string $_extra&nbsp;=&nbsp;null Atributos HTML extras
	 */
	function __construct($_form, $_name, $_label, $_extra = null) {
		//constru�mos o container sem um label
		parent::__construct($_form, $_name, NULL, "div", $_extra);
		
		$this->title = $_label;
	}

	function beforeControls() {
		if($this->title) {
			echo '<h1>';
			echo $this->title;
			echo '</h1>';
		}
	}
}


?>