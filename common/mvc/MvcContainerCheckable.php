<?php
/**
 *
 *
 *
 *
 * TODO FALTAR ADICIONAR O JS!!!
 *
 *
 *
 *
 * 
 */
/**
 * Container HTML que inicia com uma CheckBox para enable/disable. Por padrão é um fieldset, mas pode ser usado também para gerar divs e etc.
 */
class MvcContainerCheckable extends MvcContainer {
	/** @var CheckControl */	private $check;
	/** @var string */			public $jsFiles = '../common/mvc/MvcContainerCheckable.js';
	
	/**
	 *
	 * @param <type> $_form O formulário onde esse controle será incluído; necessário para incluir os dados do formulário nos controles daqui
	 * @param string $_name Identificador do container
	 * @param <type> $_label O label do controle (usado num fieldset - tag <code>legend</code>)
	 * @param string $_tag&nbsp;=&nbsp;'div' A tag
	 * @param string $_extra&nbsp;=&nbsp;null Atributos HTML extras
	 */
	function __construct($_form, $_name, CheckControl $_label, $_tag = 'fieldset', $_extra = null) {
		//construímos o container sem um label
		parent::__construct($_form, $_name, null, $_tag, $_extra);

		//registramos o check no container, mas retiramos todas as suas referências, para que ele não seja impresso automaticamente
		(empty($_label->extra))? $_label->extra = 'onchange="onOff(this)"' : $_label->extra .= ' onchange="onOff(this)"';
		if ($this->form->data->{$_label->name}) $_label->extra .= ' checked="checked"';
		$this->check = $_label;
		$this->addControl($this->check);
		unset($this->controls[$_label->name]);
		unset($this->layout[$_label->name]);
		unset($this->controls_opt[$_label->name]);

		//adicionamos o código para inicializar o status do container
		$this->form->addJsOnReady("onOff(document.getElementById('{$this->check->name}'));");
	}

	function beforeControls() {
		echo '<legend>';
		$this->check->printControl();
		echo $this->check->label;
		echo '</legend>';
	}
}


?>