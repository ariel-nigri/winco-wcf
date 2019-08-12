<?php
/**
 * Classe da tag &lt;input type="password" /&gt;
 */
class PageControl extends MvcControl {
	var $value;
	var $extra;
	var $pages;
	var $jsFiles = 'tpl/js/pagecontrol.js';

	/**
	 * Construtor da tag &lt;input type="password" /&gt;
	 * @param string $_name Nome do Controle e da tag
	 * @param string $_label Nome da Label que aparecerá antes da sua Text
	 * @param string $_extra Usado para passar algum atributo a mais, como 'size' e 'maxlength'
	 * @example $this->addControl(new PasswordControl("password", "Senha: ", "size=6"))
	 */
	function __construct($_name, $_label, $_extra = "") {
		parent::__construct($_name, $_label);
		$this->extra = $_extra;
	}

	function addPage($obj) {
		$this->pages[$obj->name] = $obj;
		return $obj;
	}
	
	/**
	 * Imprime o controle.
	 */
	function printControl() {
		if (!$this->value)
			$this->value = key($this->pages);
		echo "<div class=\"pagecontrol\" style=\"height: 350px; margin-bottom: 50px; width: 100%;\">
		      <input type=\"hidden\" name=\"$this->name\" id=\"$this->name\" value=\"$this->value\" />\r\n<ul id=\"".$this->name."_ul\">";
		foreach ($this->pages as $k => $page)
			echo "<li id=\"${k}_tab\"><a href=\"javascript:changetab('$this->name', '$k')\">$page->label</a></li>\r\n";
		echo "</ul>";
		foreach ($this->pages as $k => $page) {
			$page->form = $this->form;
			echo "<div class=\"page\" id=\"$k\" style=\"display: none;\">";
			$page->printControl();
			echo "</div>";
		}
		echo "</div>\r\n";
		$this->form->addJsOnReady("changetab('$this->name', '$this->value');");
	}
}
?>
