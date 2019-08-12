<?php

/**
 * Container HTML que inicia com uma CheckBox para enable/disable. Por padrão é um fieldset, mas pode ser usado também para gerar divs e etc.
 */
class MvcBoxedContainer extends MvcContainer {
	private $title;
	/**
	 *
	 * @param <type> $_form O formulário onde esse controle será incluído; necessário para incluir os dados do formulário nos controles daqui
	 * @param string $_name Identificador do container
	 * @param <type> $_label O label do controle (usado num fieldset - tag <code>legend</code>)
	 * @param string $_tag&nbsp;=&nbsp;'div' A tag
	 * @param string $_extra&nbsp;=&nbsp;null Atributos HTML extras
	 */
	function __construct($_form, $_name, $_label, $_extra = null) {
		//construímos o container sem um label
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