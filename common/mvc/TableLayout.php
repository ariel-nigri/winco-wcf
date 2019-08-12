<?php
/**
 * LayoutManager baseado numa ASCII art que define a estrutura da tabela. Altamente customizável.
 */
class TableLayout extends LayoutManager {
	
	/** @var array */		private $caracteres_a_limpar = array("\r", "\t", '.', '_', '-', ' ', '+', '*', '~', '=');
	/** @var array */		private $unidades_permitidas = array('%', 'px', 'em', 'pc', 'cm', 'mm');

	/** @var string */	private $ASCII_art;
	/** @var array */		private $larguras;
	/** @var array */		private $celulas;
	
	/** Usado na iteração de controles para impressão da célula correta
	  * @var integer */	private $contador = 0;
	/** @var integer */	private $linhaAtual;
	/** @var integer */	private $linhaAnterior = 0;

	/**
	 * Construtor do LayoutManager de tabelas manipuláveis.<br />
	 * <u>Nota importante:</u> É usada a propriedade CSS "empty-cells" para ocultar as células que definem a largura de cada coluna. Por causa disso, se for
	 * setada "border-collapse: collapse" para a classe da tabela estas células passarão a possuir borda; muito cuidado.
	 *
	 * @param string $ASCII_art A string com o layout da tabela.<br />
	 * <u><strong>Regras para a string de layout:</strong></u><br />
	 * <ul>
	 *		<li>Os limites externos da tabela são opcionais, mas os limites internos são obrigatórios.
	 *				Ambos são indicados com um <code>pipe</code> "|".</li>
	 *		<li>As linhas da tabela ASCII art são delimitadas por quebras de linha na string.</li>
	 *		<li>Dentro de cada célula <u>devem</u> estar incluídas, somente uma vez, as "dimensões" X e Y da célula (tamanho do
	 *				<code>colspan</code> e <code>rowspan</code>), assim: x,y (aceita espaços ao redor da vírgula também).
	 *				As áreas sem isso serão <u>ignoradas</u>. Se houver outra célula na mesma linha é <u>imperativo</u> que as dimensões
	 *				estejam na primeira linha da célula.</li>
	 *		<li>Para preencher a ASCII art podem ser usados os seguintes caracteres: <em>ponto, underline ou traço</em> (<code>._-</code>),
	 *			além de tabs e espaços. Em <u>qualquer</u> lugar.</li>
	 *		<li>A primeira linha <u>pode</u> conter células indicando a largura de cada coluna. Seja inteligente: <u>não</u> indique a
	 *			largura de cada "tipo" de célula (célula de colspan="1", 2, 3, etc); indique a largura de cada "unidade": cada célula que
	 *			contenha estas dimensões devem corresponder ao colspan="1".<br />
	 *			<ul>
	 *				<li>As unidades permitidas são: <code><em>%, px, em, pc, mm, cm</em></code>.</li>
	 *				<li><u>Todas</u> as células devem conter unidades; não é permitido especificar a unidade na primeira célula e
	 *					 não nas seguintes, da mesma linha.</li>
	 *			</ul>
	 *		</li>
	 * </ul>
	 *
	 * @example <pre>$ASCII_art = &lt;&lt;&lt;'ASCII_art'
	 *		| 15% |     70%     | 15% |
	 *		---------------------------
	 *		|                         |
	 *		|           3,1           |
	 *		|_________________________|
	 *		| 1,3 |________2,1________|
	 *		|     |_____1,1_____|_1,1_|
	 *		|_____|_____1,1_____| 1,2 |
	 *		|________2,1________|_____|
	 * ASCII_art;
	 * $lm = new TableLayout($ASCII_art);</pre>
	 */
	function __construct($ASCII_art) {
		//antes de mais nada, organizamos nossos espaçadores e unidades
		foreach ($this->caracteres_a_limpar as $espaco) $sanitizacao[$espaco] = '';
		$unidades = implode('|', $this->unidades_permitidas);

		$this->ASCII_art = $ASCII_art;

		//quebramos a ASCII art limpa em um array, por linhas
		$linhas = explode("\n", strtr($this->ASCII_art, $sanitizacao));

		//iteraremos por cada linha para interagir com as células
		foreach ($linhas as $numLinha => $linha) {

			//iteraremos por cada célula para limpar e transformá-la num array (x, y, linha)
			//se a célula ficar vazia ela não será incluída no array de células
			$celulas = explode('|', $linha);
			$ha_medidas = false;
			$numCelulaVerificada = 0;
			foreach ($celulas as $numCelula => $celula) {
				if (strlen($celula) !== 0) {
					++$numCelulaVerificada;
					if ($numLinha == 0) {
						//estamos na primeira linha. Vamos verificar se aqui há medidas ou células
						if (preg_match("/([0-9]+[$unidades]|0)/", $celula) == 1) { //verificamos se o conteúdo da célula corresponde com o padrão [número][unidade]
							//ótimo, é uma medida

							if ($numCelulaVerificada > 1 && !$ha_medidas) //mas porra, já passamos da primeira célula e só encontramos uma medida agora?! fudeu!
								$this->trigger_error_medidas($numCelulaVerificada, $celulas);

							$ha_medidas = true;
							$this->larguras[] = $celula;
							continue;
						}
						elseif ($ha_medidas) {
							//como assim? Já encontramos alguma medida nessa primeira linha e essa célula aqui não contém medida?!
							//putz, fudeu!
							$this->trigger_error_medidas($numCelulaVerificada, $celulas);
						}
					}
					if (preg_match('/[0-9]+,[0-9]/', $celula) !== 0) { //não está vazia e está no formato "x,y"
						$conteudoDaCelula = explode(',', $celula);
						array_push($conteudoDaCelula, $numLinha); //aqui também incluímos o número da linha na qual ela está contida
						$this->celulas[] = array_combine(array('x', 'y', 'linha'), $conteudoDaCelula);
					}
				}
			}
		}
//		var_dump($this);
	}

	/**
	 * Causa um erro avisando sobre problemas quando parseando por medidas na primeira linha.<br />
	 * Virou método porque é usado mais de uma vez em diferentes partes do código.<br />
	 * Não usa trigger_error porque esta função gera lixo desnecessário na tela
	 * @param integer $numCelulaVerificada
	 * @param array $celulas
	 */
	private function trigger_error_medidas($numCelulaVerificada, array $celulas) {
		var_dump($celulas);
		echo "<pre>$this->ASCII_art</pre>";
		echo '<div style="background-color: orange; text-align: center; padding: 50px; font-weight: bold;">';
		echo "Ocorreu um erro parseando por medidas na primeira linha. Estou no <big>{$numCelulaVerificada}º</big> elemento.<br />
				Será que você não esqueceu de incluir a unidade (ou colocou uma unidade não-aceita)?<br />
				Verifique os dados que imprimi aí em cima. <tt>;D</tt>";
		echo '</div>';
		exit;
	}

	public function startForm() {
		//antes de construirmos a tabela, vamos verificar se o número de controles bate com o total de células
		$totalCelulas = sizeof($this->celulas);
		if ($this->totalControles != $totalCelulas)
			trigger_error("LayoutParserError: BONG! Há um número diferente de controles e células ($this->totalControles != $totalCelulas)", E_USER_WARNING);

		//Agora vamos à montagem da tabela!
		echo "\n\t".'<table class="table_mvcform" style="empty-cells:hide">'."\n";
		
		//criamos a linha de larguras, se ela for necessária
		if (isset($this->larguras)) {
			echo "\t\t<tr style=\"height: 1px;\">\n";
			foreach ($this->larguras as $medida) echo "\t\t\t<td style=\"".(($medida !== '0')? "width: $medida;":'')." height: 1px;\"></td>\n";
			echo "\t\t</tr>\n";
		}
	}

	public function printControl($ctl, $layout, $prevlayout) {
		$this->linhaAtual = $this->celulas[$this->contador]['linha'];
		if ($this->linhaAtual != $this->linhaAnterior) echo "\t\t<tr>\n";

		$celula =& $this->celulas[$this->contador];
		//separamos colspan e rowspan
		$colspan = ($celula['x'] > 1)? " colspan=\"{$celula['x']}\"" : '';
		$rowspan = ($celula['y'] > 1)? " rowspan=\"{$celula['y']}\"" : '';
		//e imprimimos a célula com o controle
		echo "\t\t\t<td{$colspan}{$rowspan}>";
		if (!empty($ctl->label)) {
			if ($layout & CTLPOS_LABELRIGHT) {
				$ctl->printControl();
				echo " ".$ctl->getLabel();
			} else {
				echo $ctl->getLabel()." ";
				$ctl->printControl();
			}
		} else
			$ctl->printControl();
		//if (!empty($ctl->label)) echo $ctl->getLabel();
		//$ctl->printControl();
		echo "</td>\n";

		if (isset($this->celulas[++$this->contador]))
			if ($this->celulas[$this->contador]['linha'] != $this->linhaAtual) echo "\t\t</tr>\n";
		$this->linhaAnterior = $this->linhaAtual;
	}

}
?>