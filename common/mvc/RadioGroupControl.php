<?php
/**
 * Classe de grupo da tag &lt;input type="radio" /&gt;
 * @version 1.0 + onChange
 * @property $onChange o nome do método que deve ser chamado caso a combobox seja alterada
 */
class RadioGroupControl extends MvcControl {
	var $value;
	var $choices;
	var $onChange;
	var $br;

	/**
	 * Construtor de grupo da tag &lt;input type="radio" /&gt;
	 * @property $onChange o nome do método que deve ser chamado caso a combobox seja alterada
	 *
	 * @param string $_name Name das tags
	 * @param string $_label Texto que aparecerá antes do grupo
	 * @param array(value&nbsp;=>&nbsp;texto) $_choices&nbsp;=&nbsp;array() Opções que irão compor o grupo
	 * @param string $_br Opcao para exibir os radios um do lado do outro. Deve ser passado "no_br"
	 * @example $this->addControl(new RadioGroupControl("rd", "Escolha", $choices));
	 * @example $this->addControl(new RadioGroupControl("rd2", "Escolha", $choices, "no_br"));
	 */
	function __construct($_name, $_label, $_choices = array(), $_br = '') {
		parent::__construct($_name, $_label);
		$this->choices = $_choices;
		$this->br = $_br;
	}

	/**
	 * Imprime o controle.
	 */
	function printControl() {
		$evt = '';
		
		if ($this->onChange) {
			$evt = " onclick=\"".$this->form->name."do_action('$this->onChange')\"";
		}
		
		//echo "<table><tr><td>\r\n";
		if (is_array($this->choices)) {
			$c = count($this->choices);
			$tot = 0;
			foreach ($this->choices as $k => $v) {
				$tot++;
				echo "<input type=\"radio\" name=\"".$this->name."\" id=\"".$this->name."_$k\" value=\"$k\"".($k == $this->value? " checked=\"checked\"":"").$evt." /><label for=\"".$this->name."_$k\" id=\"label_".$this->name."_$k\">&nbsp;".htmlspecialchars($v)."</label>".(($this->br == "no_br" || ($this->br == "no_br2" && $c == $tot)) ? '' : "<br />\r\n");
			}
		}
		//echo "</td></tr></table>\r\n";
	}
}
?>