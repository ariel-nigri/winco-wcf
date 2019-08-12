<?
//FIXME quando a ListView é carregada, um elemento aparece selecionado, mas o dado só é preenchido quando algum elemento é clicado efetivamente
/**
 * Cria uma tabela dinâmica. É possível redimensionar colunas e adicionar controles, além de colunas normais de dados
 */
class ListView extends MvcControl {
	private $dataset;
	private $col_names;
	private $col_widths;
	private $controls;
	public 	$value;
	private $nohead;

	/**
	 * Cria uma tabela dinâmica. É possível redimensionar colunas e adicionar controles, além de colunas normais de dados
	 * @param string $_name Identificador do controle
	 * @param string $_label Texto que vira antes do controle
	 * @param array $_dataset Array com os dados
	 */
	function __construct($_name, $_label, $_dataset) {
		parent::__construct($_name, $_label);
		$this->dataset = $_dataset;
		$this->jsFiles = '../tpl/js/wclistview.js';
	}

	/**
	 * Adiciona uma coluna baseando-se num campo do Dataset
	 * @param string $col Nome do campo no DataSet, e identificador da coluna
	 * @param string $name Título da coluna
	 * @param integer $width Largura da coluna
	 */
	public function addColumn($col, $name, $width) {
		$this->col_names[$col] = $name;
		$this->col_widths[$col] = $width;
	}

	/**
	 * Adiciona uma coluna de controle
	 * @param MvcControl $_ctl Objeto do Controle desejado
	 * @param integer $width Largura inicial da coluna
	 */
	public function addControl(MvcControl $_ctl, $width) {
		$col = $_ctl->name;
		$this->col_names[$col] = $_ctl->label;
		$this->col_widths[$col] = $width;
		$this->controls[$col] = $_ctl;
	}

	/**
	 * Usado para incluir opções diversas ao controle, como classes CSS, comportamentos, etc<br />
	 * Recebe uma lista dupla de valores, onde o primeiro é a opção e o segundo, o valor.
	 *
	 * @param string $class Classe CSS da lista
	 * @param string $class_head Classe CSS do cabeçalho
	 * @param string $class_body Classe CSS do corpo
	 * @param integer $height Altura total da lista
	 * @param integer $width Largura total da lista
	 * @param string $ondblclick Botão a ativar quando houver duplo-clique
	 * @param string $upButton que botão ativará a ação de subir um item na lista
	 * @param string $downButton que botão ativará a ação de descer um item na lista
	 * @param string $delButton que botão ativará a ação de apagar um item da lista
	 *
	 * @example <code>$list->setOption(<br />
	 *		"class", "list",<br />
	 *		"height", 50,<br />
	 *		"width, 100<br />
	 * );</code>
	 * 
	 */
	public function setOption() {
		$a = func_get_args();
		$n = func_num_args();
		for ($i = 0; $i < $n; $i += 2)
			$this->{$a[$i]} = $a[$i + 1];
	}
	
	public function printControl() {
		// prepare the html attributes
		$class = empty($this->class) ? "" : " class=\"$this->class\"";
		$class_head = empty($this->class_head) ? "" : " class=\"$this->class_head\"";
		$class_body = empty($this->class_body) ? "" : " class=\"$this->class_body\"";
		$css = empty($this->width) ? "" : "width: {$this->width}px";
		if (!empty($css)) $css = ' style="'.$css.'"';
		$sth = $stb = $std = "";
		if (!$class_head)
			$sth = " style=\"width: 100%; table-layout: fixed; white-space: nowrap; cursor: default;\"";
		if (!$class_body) {
			$stb = " style=\"width: 100%; table-layout: fixed; white-space: nowrap; cursor: default;\"";
			$std = 'overflow-y: auto; text-overflow: ellipsis;';
		}
		
		// create the main div
		echo "<div$class$css>";
		// now the header table.
			echo "<table$sth$class_head><tr>";
		if (!$this->nohead) {
			$c = 0;
			$markerWidth = 10;
			foreach($this->col_names as $col => $name)
				echo '<th style="width: '.($this->col_widths[$col]-($c++ == 0 ? $markerWidth/2 : $markerWidth))."px; $std\">$name</th>\r\n";
		}
		echo "</tr></table>\r\n";
		
		// now the body div and table
		if (!is_array($this->value))
			$this->value = array('selected' => '-1', 'items' => implode(',', array_keys($this->dataset)));
		else if (!isset($this->value['items']))
			$this->value['items'] = implode(',', array_keys($this->dataset));
		
		$ds_idx = $this->value['items'] ==  '' ? array() : explode(',', $this->value['items']);
		echo "<div style=\"height: ".(empty($this->height)? 100 : $this->height)."px; overflow-y: scroll; overflow-x:hidden;\">";
		if (count($ds_idx) > 0) {
			echo "<table id=\"$this->name\"$stb$class_body>\r\n<colgroup>";
			foreach ($this->col_names as $col => $dummy) {
				echo '<col style="width: '.$this->col_widths[$col].'px;" />';
			}
			echo "</colgroup>\r\n";
			foreach($ds_idx as $idx) {
				echo "<tr wc_idx=\"$idx\">";
				foreach ($this->col_names as $col => $dummy) {
					if (isset($this->controls[$col])) {
						$c = $this->controls[$col];
						$c->form = $this->form;
						$c->name = $this->name.$col."[$idx]";
						if (isset($this->form->data->{$this->name.$col}[$idx])) {
							$c->value = $this->form->data->{$this->name.$col}[$idx];
						} else if (isset($this->dataset[$idx][$col]))
							$c->value = $this->dataset[$idx][$col];
						else
							$c->value = '';
						echo '<td>'; $c->printControl(); echo "</td>\r\n";
					} else
						echo '<td>'.$this->dataset[$idx][$col]."</td>\r\n";
				}
				echo "</tr>\r\n";
				$firstrow = false;
			}
			echo '</table>';
		} else
			echo "<table id=\"$this->name\"$stb$class_body><colgroup></colgroup><tr></tr></table>";

		echo '<input type="hidden" name="'.$this->name.'[selected]" id="'.$this->name.'[selected]" value="'.$this->value['selected'].'" />';
		if (isset($this->upButton)) {
			$opts = ", upButton: '$this->upButton', downButton: '$this->downButton', orderInput: '$this->name[items]'";
			echo '<input type="hidden" name="'.$this->name.'[items]" id="'.$this->name.'[items]" value="'.$this->value['items'].'" />';
		} else
			$opts = '';
		echo "</div></div>\r\n";


		
		// tell the form to output our 'onReady' code.
		$this->form->addJsOnReady("WcListView.init('$this->name', { selInput: '$this->name[selected]', colResize: true $opts } );");
	}
}

?>