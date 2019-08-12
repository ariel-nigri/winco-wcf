<?php
/**
 * Container HTML. Por padr�o � um fieldset, mas pode ser usado tamb�m para gerar divs e etc.
 */
class MvcContainer extends MvcControl {
	/** @var MvcForm */			public		$form;
	/** @var string */			protected	$extra;
	/** @var string */			public		$tag = 'fieldset';
	/** @var bool */				protected	$toplabel;
	/** @var string */			public		$label;
	/** @var string */			public		$legend;
	/** @var LayoutManager */	protected	$lman;
	//Dados dos controles adicionados
	/** @var array */				public		$controls;
	/** @var array */				public		$hidden;
	/** @var array
	 * Layout de cada um dos controles
	 */								protected	$layout;
	/** @var array
	 * Op��es de cada um dos controles (CTLPOS_*, etc)
	 */								protected	$controls_opt;
	
	/**
	 *
	 * @param <type> $_form O formul�rio onde esse controle ser� inclu�do; necess�rio para incluir os dados do formul�rio nos controles daqui
	 * @param string $_name Identificador do container
	 * @param <type> $_label O label do controle (usado num fieldset - tag <code>legend</code>)
	 * @param string $_tag&nbsp;=&nbsp;'div' A tag
	 * @param string $_extra&nbsp;=&nbsp;null Atributos HTML extras
	 */
	function __construct($_form, $_name, $_label = '', $_tag = 'fieldset', $_extra = null) {

		parent::__construct($_name, null);
		$this->form = $_form;
		$this->tag = $_tag;
		if ($this->tag == 'fieldset')
			$this->legend = $_label;
		else
			$this->label = $_label;
		$this->extra = $_extra;
		
	}

	function setLayoutManager($lm) {
		$this->lman = $lm;
	}

	/**
	 * M�todo p�blico usado para a cria��o dos controles HTML. Ex.: TextBox, ComboBox, Check etc.
	 * @param MvcControl Controle a ser adicionado
	 * @param cons Op��es para o controle
	 * @example $this->addControl(new EditControl("cli_endereco", "Endere�o: ", "size=80"))
	 */
	function addControl($_ctl, $pos = CTLPOS_DEFAULT) {
		if (isset($_ctl->jsFiles)) {
			if (!is_array($_ctl->jsFiles))
				$this->jsFiles[$_ctl->jsFiles] = true;
			else {
				foreach($_ctl->jsFiles as $key => $value) {
					if (is_bool($value)) $this->jsFiles[$key] = true;
					else $this->jsFiles[$value] = true;
				}
			}
		}
		if ($_ctl->hidden) {
			$this->hidden[$_ctl->name] = &$_ctl;
		} else {
			$this->controls[$_ctl->name] = &$_ctl;
			$this->layout[$_ctl->name] = $pos;
			if ($pos & CTLEVT_DEFAULT)
				$this->evt_def = $_ctl->name;
			$this->controls_opt[$_ctl->name] = $pos;
		}
	}

	function printControl() {
		$prev_l = CTLPOS_DEFAULT;
		if (!isset($this->lman))
			$this->lman = ($this->toplabel)? new TopLabelLayout : new SideLabelLayout;
			
		$this->lman->totalControles = sizeof($this->controls);

		echo "<$this->tag $this->extra id=\"$this->name\">";
		if ($this->legend && $this->tag == 'fieldset')
			echo "<legend>".$this->legend."</legend>";

		if (method_exists($this, 'beforeControls')) $this->beforeControls();

		$this->lman->startForm();
		foreach ($this->controls as $control) {
			$control->form = $this->form;
			if (isset($this->form->data->{$control->name}))
				$control->value = $this->form->data->{$control->name};
				
			$l = $this->layout[$control->name];
			$this->lman->printControl($control, $l, $prev_l);
			$prev_l = $l;
		}
		$this->lman->endForm();
		echo "</$this->tag>";
	}

}


?>