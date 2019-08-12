<?php
/**
 * Classe do controle de Data. Inclui um campo de texto e um botão de calendário
 * @param string $_name Name do Controle e da tag
 * @param string $_label Texto que aparecerá antes do campo
 * @param string $_jsdir&nbsp;=&nbsp;"" Pasta onde fica o JS do calendário (calendar.js)
 * @param string $_value&nbsp;=&nbsp;"" Valor do campo
 * @example $this->addControl(new DateControl("inicio", "Início", "../functions/calendar/", "12/04/2007"));
 */
class DateControl extends MvcControl {
	var $value;
	var $form;
	var $jsdir;

	/**
	 * Construtor do controle de Data. Inclui um campo de texto e um botão de calendário
	 */
	function DateControl($_name, $_label, $_jsdir = "", $_value = "") {
		parent::__construct($_name, $_label);
		//parent::__construct();
		$this->jsdir = $_jsdir;
		$this->value = $_value;
		$this->name = $_name;
		$this->label = $_label;
	}

	/**
	 * Imprime o controle.
	 */
	function printControl() {
		static $init = 0;
		if (!$init) {
			echo "<script type=\"text/javascript\" id=\"CalDateScript\" src=\"".$this->jsdir."calendar.js\"></script>\r\n";
			$init = 1;
		}
		echo "<input type=\"text\" name=\"".$this->name."\" id=\"".$this->name."\" value=\"".htmlspecialchars($this->value)."\" size=\"27\"/>\r\n".
		"<input type=\"button\" name=\"".$this->name."_BT_DATE\" id=\"".$this->name."_BT_DATE\" value=\" &#9660; \" onclick=\"javascript:CalPopupCalendar_".LANGUAGE."(this, ".$this->form->name.'.'.$this->name.")\" />\r\n";
	}
}
?>
