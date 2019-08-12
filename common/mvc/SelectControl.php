<?php
/**
 * Classe da tag &lt;select&gt;<br />
 * PS: o atributo da doc property tá causando alguns bugs na leitura da doc da classe
 * @version 1.0 turbinada
 */
class SelectControl extends MvcControl {
	var $value;

	/**
	 * <h3>estruturas de exemplo pro $_choices</h3>
	 * <h4>COMUM</h4><pre>
	 *
	 * $_choices = array(
	 *	.	chave1 => valor1,
	 *	.	chave1 => valor2,
	 * );
	 * </pre>
	 *
	 * <hr />
	 *
	 * <h4>COM ATRIBUTOS EXTRAS</h4><pre>
	 *
	 * $_choices = array(
	 *	.	chave1 => array("value" => valor1, "extra" => extra1)
	 * );
	 * </pre>
	 *
	 * <hr />
	 *
	 * <h4>COM GRUPOS</h4><pre>
	 *
	 * $_choices = array(
	 *	.	optgroup1 => array(chave1 => valor1)
	 * );
	 * </pre>
	 *
	 * <hr />
	 *
	 * <h4>COM GRUPOS E ATRIBUTOS EXTRAS</h4><pre>
	 *
	 * $_choices = array(
	 *	.	optgroup1 => array(
	 *	.		chave1 => array("value" => valor1, "extra" => extra1)
	 *	.	)
	 * );
	 * </pre>
	 * @var array
	 */
	var $choices;
	var $onChange;
	var $optgroup;

	/**
	 * Construtor da tag &lt;select&gt;<br />, com opções extras
	 * @property $onChange o nome do método que deve ser chamado caso a combobox seja alterada
	 * @param string $_name Nome do Controle e da tag
	 * @param string $_label Texto que aparecerá antes da combo
	 * @param array(valor&nbsp;=>&nbsp;texto) $_choices Array com as opções que aparecerão dentro da combo. Ver doc do atributo 'choices' para mais info.
	 * @param string $_extra&nbsp;=&nbsp;"" Usado para passar algum atributo a mais, como 'multiple', 'size'
	 * @param bool $optgroup&nbsp;=&nbsp;false Se true, entende que $_choices é um array de grupos, que contêm um array de opções
	 * @example $this->addControl(new SelectControl("combo", "Escolha", $choices));
	 */
	function __construct($_name, $_label, $_choices, $_extra = "", $optgroup = false) {
		parent::__construct($_name, $_label);
		$this->choices = $_choices;
		$this->extra = $_extra;
		$this->optgroup = $optgroup;
	}

	/**
	 * Imprime o controle.
	 */
	function printControl() {
		$evt = "";
		if ($this->onChange) {
			$evt = " onchange=\"".$this->form->name."do_action('$this->onChange')\"";
		}
		echo "<select name=\"".$this->name."\" id=\"".$this->name."\"$evt" . ($this->extra ? " ".$this->extra : "") . ">\r\n";
		if (is_array($this->choices)) {
			foreach ($this->choices as $k => $v) {
				if (is_array($v)) {
					if ($this->optgroup) {
						echo "\t<optgroup label=\"$k\">\r\n";
						foreach ($v as $key => $value) {
							if (is_array($value))
								echo "\t<option value=\"$key\"".($key == $this->value && isset($this->value) ? " selected=\"selected\"":"")." ".$value['_extra'].">".htmlspecialchars($value['_value'])."</option>\r\n";
							else
								echo "\t<option value=\"$key\"".($key == $this->value && isset($this->value) ? " selected=\"selected\"":"").">".htmlspecialchars($value)."</option>\r\n";
						}
						echo "\t</optgroup>\r\n";
					}
					else
						echo "\t<option value=\"$k\"".($k == $this->value && isset($this->value) ? " selected=\"selected\"":"")." ".$v['_extra'].">".htmlspecialchars($v['_value'])."</option>\r\n";
				}
				else
					echo "\t<option value=\"$k\"".($k == $this->value && isset($this->value) ? " selected=\"selected\"":"").">".htmlspecialchars($v)."</option>\r\n";
			}
		}
		echo "</select>\r\n";
	}
}
?>