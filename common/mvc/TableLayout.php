<?php
/**
 * LayoutManager baseado numa ASCII art que define a estrutura da tabela. Altamente customiz�vel.
 */
class TableLayout extends LayoutManager {
	
	/** @var array */		private $caracteres_a_limpar = array("\r", "\t", '.', '_', '-', ' ', '+', '*', '~', '=');
	/** @var array */		private $unidades_permitidas = array('%', 'px', 'em', 'pc', 'cm', 'mm');

	/** @var string */	private $ASCII_art;
	/** @var array */		private $larguras;
	/** @var array */		private $celulas;
	
	/** Usado na itera��o de controles para impress�o da c�lula correta
	  * @var integer */	private $contador = 0;
	/** @var integer */	private $linhaAtual;
	/** @var integer */	private $linhaAnterior = 0;

	/**
	 * Construtor do LayoutManager de tabelas manipul�veis.<br />
	 * <u>Nota importante:</u> � usada a propriedade CSS "empty-cells" para ocultar as c�lulas que definem a largura de cada coluna. Por causa disso, se for
	 * setada "border-collapse: collapse" para a classe da tabela estas c�lulas passar�o a possuir borda; muito cuidado.
	 *
	 * @param string $ASCII_art A string com o layout da tabela.<br />
	 * <u><strong>Regras para a string de layout:</strong></u><br />
	 * <ul>
	 *		<li>Os limites externos da tabela s�o opcionais, mas os limites internos s�o obrigat�rios.
	 *				Ambos s�o indicados com um <code>pipe</code> "|".</li>
	 *		<li>As linhas da tabela ASCII art s�o delimitadas por quebras de linha na string.</li>
	 *		<li>Dentro de cada c�lula <u>devem</u> estar inclu�das, somente uma vez, as "dimens�es" X e Y da c�lula (tamanho do
	 *				<code>colspan</code> e <code>rowspan</code>), assim: x,y (aceita espa�os ao redor da v�rgula tamb�m).
	 *				As �reas sem isso ser�o <u>ignoradas</u>. Se houver outra c�lula na mesma linha � <u>imperativo</u> que as dimens�es
	 *				estejam na primeira linha da c�lula.</li>
	 *		<li>Para preencher a ASCII art podem ser usados os seguintes caracteres: <em>ponto, underline ou tra�o</em> (<code>._-</code>),
	 *			al�m de tabs e espa�os. Em <u>qualquer</u> lugar.</li>
	 *		<li>A primeira linha <u>pode</u> conter c�lulas indicando a largura de cada coluna. Seja inteligente: <u>n�o</u> indique a
	 *			largura de cada "tipo" de c�lula (c�lula de colspan="1", 2, 3, etc); indique a largura de cada "unidade": cada c�lula que
	 *			contenha estas dimens�es devem corresponder ao colspan="1".<br />
	 *			<ul>
	 *				<li>As unidades permitidas s�o: <code><em>%, px, em, pc, mm, cm</em></code>.</li>
	 *				<li><u>Todas</u> as c�lulas devem conter unidades; n�o � permitido especificar a unidade na primeira c�lula e
	 *					 n�o nas seguintes, da mesma linha.</li>
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
		//antes de mais nada, organizamos nossos espa�adores e unidades
		foreach ($this->caracteres_a_limpar as $espaco) $sanitizacao[$espaco] = '';
		$unidades = implode('|', $this->unidades_permitidas);

		$this->ASCII_art = $ASCII_art;

		//quebramos a ASCII art limpa em um array, por linhas
		$linhas = explode("\n", strtr($this->ASCII_art, $sanitizacao));

		//iteraremos por cada linha para interagir com as c�lulas
		foreach ($linhas as $numLinha => $linha) {

			//iteraremos por cada c�lula para limpar e transform�-la num array (x, y, linha)
			//se a c�lula ficar vazia ela n�o ser� inclu�da no array de c�lulas
			$celulas = explode('|', $linha);
			$ha_medidas = false;
			$numCelulaVerificada = 0;
			foreach ($celulas as $numCelula => $celula) {
				if (strlen($celula) !== 0) {
					++$numCelulaVerificada;
					if ($numLinha == 0) {
						//estamos na primeira linha. Vamos verificar se aqui h� medidas ou c�lulas
						if (preg_match("/([0-9]+[$unidades]|0)/", $celula) == 1) { //verificamos se o conte�do da c�lula corresponde com o padr�o [n�mero][unidade]
							//�timo, � uma medida

							if ($numCelulaVerificada > 1 && !$ha_medidas) //mas porra, j� passamos da primeira c�lula e s� encontramos uma medida agora?! fudeu!
								$this->trigger_error_medidas($numCelulaVerificada, $celulas);

							$ha_medidas = true;
							$this->larguras[] = $celula;
							continue;
						}
						elseif ($ha_medidas) {
							//como assim? J� encontramos alguma medida nessa primeira linha e essa c�lula aqui n�o cont�m medida?!
							//putz, fudeu!
							$this->trigger_error_medidas($numCelulaVerificada, $celulas);
						}
					}
					if (preg_match('/[0-9]+,[0-9]/', $celula) !== 0) { //n�o est� vazia e est� no formato "x,y"
						$conteudoDaCelula = explode(',', $celula);
						array_push($conteudoDaCelula, $numLinha); //aqui tamb�m inclu�mos o n�mero da linha na qual ela est� contida
						$this->celulas[] = array_combine(array('x', 'y', 'linha'), $conteudoDaCelula);
					}
				}
			}
		}
//		var_dump($this);
	}

	/**
	 * Causa um erro avisando sobre problemas quando parseando por medidas na primeira linha.<br />
	 * Virou m�todo porque � usado mais de uma vez em diferentes partes do c�digo.<br />
	 * N�o usa trigger_error porque esta fun��o gera lixo desnecess�rio na tela
	 * @param integer $numCelulaVerificada
	 * @param array $celulas
	 */
	private function trigger_error_medidas($numCelulaVerificada, array $celulas) {
		var_dump($celulas);
		echo "<pre>$this->ASCII_art</pre>";
		echo '<div style="background-color: orange; text-align: center; padding: 50px; font-weight: bold;">';
		echo "Ocorreu um erro parseando por medidas na primeira linha. Estou no <big>{$numCelulaVerificada}�</big> elemento.<br />
				Ser� que voc� n�o esqueceu de incluir a unidade (ou colocou uma unidade n�o-aceita)?<br />
				Verifique os dados que imprimi a� em cima. <tt>;D</tt>";
		echo '</div>';
		exit;
	}

	public function startForm() {
		//antes de construirmos a tabela, vamos verificar se o n�mero de controles bate com o total de c�lulas
		$totalCelulas = sizeof($this->celulas);
		if ($this->totalControles != $totalCelulas)
			trigger_error("LayoutParserError: BONG! H� um n�mero diferente de controles e c�lulas ($this->totalControles != $totalCelulas)", E_USER_WARNING);

		//Agora vamos � montagem da tabela!
		echo "\n\t".'<table class="table_mvcform" style="empty-cells:hide">'."\n";
		
		//criamos a linha de larguras, se ela for necess�ria
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
		//e imprimimos a c�lula com o controle
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