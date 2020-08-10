<?php

/**
 * Classe utilizada para a criação de tabelas no MvcForm
 * @param string $_name Identificador do controle
 * @param string $_label Texto que aparecerá antes da tabela
 * @param DataSource $_datasrc&nbsp;=&nbsp;null de onde a sua tabela puxará os dados para ser preenchida
 * @example $tbl = new TableControl("table2", "Tabela de dados", new TestDbSource);
*/
if (!defined('BZC_INTEGER')) {
	// bug: this should not be used here, but it is!
	define("BZC_INTEGER", 	1);
	define("BZC_STRING", 	2);
	define("BZC_DATE", 		3);
	define("BZC_BOOLEAN", 	4);
	define("BZC_MONEY", 	5);
	define("BZC_TYPE", 		0xf);
}

class TableControl extends MvcControl {
	private $columns;
	private $datasrc;
	
	function __construct($_name, $_label, $_datasrc = null) {
		parent::__construct($_name, $_label);
		$this->datasrc = $_datasrc;
	}
	
	/**
	 * Adiciona uma coluna baseando-se num campo do DataSource
	 * @param string $obj_col Nome do campo no DataSource, e identificador da coluna
	 * @param string $table_col&nbsp;=&nbsp;false Título da coluna
	 * @param const $options&nbsp;=&nbsp;BZC_STRING Tipo do campo para que haja formatação ou não
	 * @param null $customsrc&nbsp;=&nbsp;null Não sei ainda
	 * @example $tbl->addColumn("number", "Numero", BZC_STRING);
	 */
	public function addColumn($obj_col, $table_col = false, $options = BZC_STRING, $customsrc = null) {
		if (!$table_col)
			$table_col = $obj_col;
		if($customsrc)
			$this->customsrc[$obj_col] = $customsrc;
		$this->columns[$obj_col]["DB"] = $table_col;
		$this->columns[$obj_col]["OBJ"] = $obj_col;
		$this->columns[$obj_col]["OPT"] = $options;
	}
	
	/**
	* Adiciona uma coluna de conteúdo fixo
	* @param string $obj_col Nome da coluna
	* @param string $col_title Título da coluna
	* @param string $col_value Conteúdo fixo
	* @example $tbl->addStaticColumn("REMOVE", "", "[Remover]");
	*/
	public function addStaticColumn($obj_col, $col_title, $col_value) {
		$this->columns[$obj_col]["DB"] = $col_title;
		$this->columns[$obj_col]["OBJ"] = $obj_col;
		$this->columns[$obj_col]["STATIC"] = $col_value;
		$this->columns[$obj_col]["OPT"] = 0;
	}
	
	/**
	 * Adiciona um evento à uma coluna <b>já adicionada</b>
	 * @param string $obj_col Nome do campo do DataSource, e nome da coluna
	 * @param string $evt Nome do evento que ele deverá executar quando clicado
	 * @param string $field&nbsp;=&nbsp;false Nome do campo ou o valor que deverá ser retornado quando o evento for acionado
	 * @example $tbl->addEvent("name", "clickname", "number");
	 */
	public function addEvent($obj_col, $evt, $field = false) {
		$this->columns[$obj_col]["EVT"] = $evt;
		$this->columns[$obj_col]["EVT_FIELD"] = ($field ? $field : $obj_col);
	}
	
	/**
	 * Adiciona uma coluna com checkboxes
	 * @param string $_col_name Nome do campo do DataSource
	 * @param string $_header Nome da coluna na Tabela
	 * @param string $_idxfield Nome do campo ou o valor que deverá ser retornado
	 * @example $tbl->addEvent("name", "clickname", "number");
	 */
	public function addCheck($_col_name, $_header, $_idxfield) {
		$this->columns[$_col_name]["DB"] = $_header;
		$this->columns[$_col_name]["OBJ"] = $_col_name;
		$this->columns[$_col_name]["CHK_FIELD"] = $_idxfield;
	}

	/**
	 * @deprecated nunca foi usada direito. Melhor evitar (ou testar, usar, e documentar).
	 */
	public function addEdit($obj_col, $edt = false) {
		$this->columns[$obj_col]["EDT"] = ($edt ? $edt : $obj_col);
	}

	/**
	 * @deprecated nunca foi usada direito. Melhor evitar (ou testar, usar, e documentar).
	 */
	public function addButton($obj_col, $_but, $_act = false) {
		$this->columns[$obj_col]["BUT"] = $_but;
		$this->columns[$obj_col]["BUT_ACT"] = ($_act ? $_act : $_but);
	}

	public function printControl() {
		if (!isset($this->columns))
			$this->getDefaultColumns();
		if (!isset($this->eventData))
			$this->eventData = $this->name;
		echo '<input type="hidden" name="'.$this->eventData.'"><table class="mvctable">';
		echo '<thead><tr>';
		foreach ($this->columns as $column) {
			echo "<th>".$column["DB"]."</th>\r\n";
		}
		echo '</tr></thead>';
		$idx = 0; // for the addEdit
		if (is_object($this->datasrc)) {
			while ($this->datasrc->fetch()) {
				echo "<tbody><tr>";
				$class = "";
				foreach ($this->columns as $column) {
					switch ($column["OPT"] & BZC_TYPE) {
						case BZC_INTEGER:
							$class = "mvctable_integer";
							break;
						case BZC_DATE:
							$class = "mvctable_date";
							break;
						case BZC_MONEY:
							$class = "mvctable_money";
							break;
						default:
							$class = "mvctable_string";
					}
					if(!empty($this->customsrc[$column["OBJ"]]) && function_exists($this->customsrc[$column["OBJ"]]))
						$val = $this->customsrc[$column["OBJ"]]($this);
						//$val = "asdf";
					else if (isset($column["STATIC"]))
						$val = $column["STATIC"];					
					else
						$val = $this->datasrc->{$column["OBJ"]};
					echo "<td class=\"$class\" name=\"".$column["DB"]."\">";
					if (!empty($column["EVT"])) {
						$lnkval = $this->datasrc->{$column["EVT_FIELD"]};
						echo "<a href=\"javascript:".$this->form->name."do_action_param('$column[EVT]', '$this->eventData', '$lnkval')\">$val</a>";
					}
					else if(!empty($column["CHK_FIELD"])) {
						if ($this->datasrc->{$column["OBJ"]})
							$checked = " CHECKED";
						else
							$checked = "";
						$value = $this->datasrc->{$column["CHK_FIELD"]};
						echo "<input type=\"checkbox\" value=\"".htmlspecialchars($value)."\"$checked name=\"".$this->name.$column["OBJ"]."[]\" id=\"".$column["OBJ"]."_".$idx."\" />";
					}
					else if(!empty($column["EDT"])) {
						$inputval = $this->datasrc->{$column["EDT"]};
						echo "<input type=\"text\" value=\"".htmlspecialchars($inputval)."\" name=\"".$column["OBJ"]."_".$idx."\" id=\"".$column["OBJ"]."_".$idx."\" />";
					}
					else if(!empty($column["BUT"])) {
						echo "<input type=\"button\" value=\"".$column["BUT"]."\" name=\"".$column["OBJ"]."_".$idx."\" id=\"".$column["OBJ"]."_".$idx."\" onclick=\"javascript:".$this->form->name."do_action_param('".$column["BUT_ACT"]."', '".$this->name."', '".$idx."')\"/>";
					}
					else
						echo $val;
					echo "</td>\r\n";
				}
				echo "</tr></tbody>\r\n";
				$idx++;
			}
		}
		echo '</table>';
	}
	
	private function getDefaultColumns() {
		$this->columns = $this->datasrc->columns;
	}
}

?>
