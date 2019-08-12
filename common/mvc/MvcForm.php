<?
/** formata��o padr�o */
	define("CTLPOS_DEFAULT", 0);
/** N�o quebra linha ap�s o controle */
	define("CTLPOS_NOBREAK", 1);
	define("CTLPOS_NOSPACE", 2);
	define("CTLPOS_RIGHT", 4);
	define("CTLPOS_LEFT", 8);
	define("CTLPOS_CENTER", 16);
/**
 * Usado em bot�es ou links que ativam um m�todo;
 * indica que aquele � o evento padr�o para quando o usu�rio apertar a tecla Enter.
 * Se n�o for utilizado dentro do formul�rio, Enter n�o funcionar�.
 */
	define("CTLEVT_DEFAULT", 32);
/** N�o cria label antes do controle, mesclando as duas c�lulas geradas por um controle padr�o numa s�. */
	define("CTLPOS_COLSPAN", 64);
/** N�o cria as tags de <tr> e </tr> antes e depois do controle respectivamente. */
	define("CTLPOS_NOTABLE", 128);
/** Coloca o controle a esquerda e o label a direita. Implica em colspan*/
	define("CTLPOS_LABELRIGHT", 256);


define("CTLVAL_DB", 128);
define("CTLVAL_INT", 256);
define("CTLVAL_FLOAT", 512);
define("CTLVAL_EMAIL", 1024);
define("CTLVAL_STRING", 2048);
define("CTLVAL_NOTNULL", 4096);
define("CTLVAL_IPNUMBER", 8192);

/**
 * Classe utilizada para a cria��o de formul�rios em HTML.
 */
class MvcForm {
	/**
	 * Nome do formul�rio. Usado quando h� mais de um formul�rio (duas classes extendendo a MvcForm na mesma p�gina.
	 * @var string */				public $name;
	/**
	 * Os controles "imprim�veis" do formul�rio
	 * @var array */				private $controls;
	private $controls_opt;
	/**
	 * Os controles ocultos do formul�rio
	 * @var array */				private $hidden;
	private $layout;
	/**
	 * For�ar� o uso do LayoutManager TopLabelLayout se for true
	 * @var boolean */			private $toplabel;
	/** @var LayoutManager */	private $lman;
	private $evt_def;
	private $jsValidatorPath;
	private $defaultValidator;
	/** @var array */				private $jsFiles;
	private $jsOnReady;
	
	private $useValidator;

	/**
	 * Onde ficam todos os dados enviados pelo formul�rio
	 * @var StdClass */			public $data;

	function __construct(LayoutManager $lman = null) {
		if (is_null($this->lman)) {
			$this->lman = (is_null($lman))?
									new SideLabelLayout :
									$lman;
		}
		elseif (!is_null($lman)) {
			trigger_error('Voc� est� tentando definir um LayoutManager via argumento do construtor do MvcForm quando esse j� foi definido no corpo da classe.');
		}
	}

	function setLayoutManager($lm) {
		$this->lman = $lm;
	}

	/**
	 * Imprime o in�cio do formul�rio:
	 * <ul>
	 *		<li>Tag <i>script</i> se necess�rio</li>
	 *		<li>Tag <i>form</i></li>
	 *		<li>Um <i>input hidden</i> que conter� a a��o</li>
	 *		<li>Todos os poss�veis <i>hiddens</i> que o form possa ter</li>
	 * </ul>
	 */
	private function printHeader() {
	
		if ($this->useValidator || $this->defaultValidator & CTLVAL_DB) {
			echo "<script language=\"javascript\" src=\"".$this->jsValidatorPath."/validator.js\"></script>\r\n";		
			$validtorJS = "if (tfv.exec())";
		}
		if (is_array($this->jsFiles)) {
			foreach($this->jsFiles as $jsFile => $dummy)
				echo "<script type=\"text/javascript\" src=\"$jsFile\"></script>\r\n";
		}
			
		echo "<script language=\"javascript\" type=\"text/javascript\">
				
				function resolve_check(form) {						
					var i = 0;
					while(i < form.length) {	
						if (form.elements[i].type == 'hidden') {
							var pos = form.elements[i].name.indexOf('_HDN_CHK');
							if(pos != -1) {		
								var auxname = form.elements[i].name.substring(0, pos);							
								if (form.elements[i+1].type == 'checkbox' && form.elements[i+1].name == auxname) {	
									var val = 0;
									if(form.elements[i+1].checked == true)
										val = 1;
									form.elements[i].value = val;
									i += 2;
								} else {
									i++;
								}
							} else
								i++;
						} else
							i++;						
					} 
					
					return form;				
				}
				
				function ".$this->name."do_action(acao) {
					form = document.getElementById('mvc_".$this->name."');
					if (form) {
						form = resolve_check(form);
						form.".$this->name."acao.value = acao;
						".($this->evt_def ? "if (acao == '$this->evt_def') {
							$validtorJS
								form.submit();
						} else " : "")."
							form.submit();
					}
				}
				function ".$this->name."do_action_param(acao, pname, param) {
					form = document.getElementById('mvc_".$this->name."');
					if (form) {
						form[pname].value = param;
						form.".$this->name."acao.value = acao;
						form.submit();
					}
				}
			</script>
			<form action=\"\" method=\"post\" name=\"".$this->name."\" id=\"mvc_".$this->name."\" enctype=\"multipart/form-data\">
			<input type=\"hidden\" name=\"".$this->name."acao\" value=\"$this->evt_def\"/>
			";
		
		if (is_array($this->hidden)) {
			foreach($this->hidden as $control) {
				if (isset($this->data->{$control->name}))
					$control->value = $this->data->{$control->name};
				$control->printControl();
			}
		}
		
	}
	
	/**
	 * M�todo p�blico usado para a cria��o dos controles HTML. Ex.: TextBox, ComboBox, Check etc.
	 * @param object $controle controle de formul�rio que vai ser adicionado
	 * @param string $controle_de_posicao op��o a ser adicionada no controle [opcional]
	 * @return sem retorno
	 * @example $this->addControl(new EditControl("cli_endereco", "Endere�o: ", "size=80"))
	 */
	public function addControl($_ctl, $pos = CTLPOS_DEFAULT) {
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
		if (isset($_ctl->hidden)) {
			$this->hidden[$_ctl->name] = &$_ctl;
		} else {
			$this->controls[$_ctl->name] = &$_ctl;
			$this->layout[$_ctl->name] = $pos;
			if ($pos & CTLEVT_DEFAULT)
				$this->evt_def = $_ctl->name;
			if (!$this->useValidator)
				$this->useValidator = $this->isNeedValidator($pos);
			$this->controls_opt[$_ctl->name] = $pos;
		}
	}

	/**
	 * documente-me!
	 * @param <type> $code
	 */
	public function addJsOnReady($code) {
		$this->jsOnReady[] = $code;
	}

	/**
	 * Imprime todos os controles do form.
	 */
	private function printControls() {
		$prev_l = CTLPOS_DEFAULT;
		if ($this->lman instanceof stdClass) {
			$totalControles = $this->lman->totalControles;
			$this->lman = ($this->toplabel)? new TopLabelLayout : new SideLabelLayout;
			$this->lman->totalControles = $totalControles;
		}
		$this->lman->startForm();
		foreach ($this->controls as $control) {
			$control->form = &$this;
			if (isset($this->data->{$control->name}))
				$control->value = $this->data->{$control->name};
				
			$l = $this->layout[$control->name];
			$this->lman->printControl($control, $l, $prev_l);
			$prev_l = $l;
		}
		$this->lman->endForm();
	}
	
	/**
	 * Imprime o form HTML na p�gina.
	 * @example $form->printForm();
	 */
	public function printForm() {
		
		if ($this->toplabel)
			$this->lman = new TopLabelLayout;

		$this->lman->totalControles = sizeof($this->controls);

		$this->printHeader();
		$this->printControls();
		echo "</form>\r\n";
		if ($this->defaultValidator & CTLVAL_DB)
			echo $this->returnScriptValidatorUsingDb();
		elseif ($this->useValidator)
			echo $this->returnScriptValidatorUsingFields();		
		if (is_array($this->jsOnReady)) {
			echo "<script language=\"javascript\">\r\n".implode("\r\n", $this->jsOnReady)."</script>\r\n";
		}
	}

	/**
	 * Indica qual vai ser o array de Request HTTP que vai ser usado nesse formul�rio.<br />
	 * � daqui que ser�o extra�dos os dados para serem inclu�dos em $this->data.<br />
	 * <ul>
	 *		<li>Seta o nome do formul�rio. Se n�o for chamado, a��es como o bot�o do DateControl n�o funcionar�o;</li>
	 *		<li>Transforma os dados do argumento em <tt>$this->data</tt>;</li>
	 *		<li>Chama o m�todo requerido na tela anterior, ou <tt>init()</tt> caso n�o haja nenhum;</li>
	 *		<li>Chama o m�todo <tt>beforeshow()</tt>, se houver.</li>
	 * </ul>
	 * <b>Nota:</b> <u>N�O</u> � poss�vel usar $_GET aqui. � necess�rio acessar os dados via POST pois
	 * � como o formul�rio ir� submeter seus dados padr�es
	 * @param array $vars $_POST ou $_REQUEST
	 */
	public function handle(&$vars) {
		if (!$this->name)
			$this->name = "form1";
		if (!empty($vars) && is_array($vars)) {
//			$this->clean();
			foreach ($vars as $k => $v) {
				$pos = strpos($k, "_HDN_CHK");
				if ($pos) {
					$k = substr($k, 0, $pos);
					//die($k);
				}
				if (!is_array($v))
					$this->data->{$k} = stripslashes($v);
				else
					$this->data->{$k} = $v;
			}
		}
		if (isset($vars[$this->name."acao"]))
			$mname = $vars[$this->name."acao"];
		else
			$mname = "init";
		if (method_exists($this, "beforeEvent"))
			$this->beforeEvent($mname);
		if (method_exists($this, $mname))
			$this->{$mname}($vars);
		else if ($mname != "_frm_noaction_" && $mname != "init")
			die("Method $mname inexistent");
			
		if (method_exists($this, "beforeshow"))
			$this->beforeshow();
	}

	/**
	 * Esvazia todas as vari�veis de $this->data que pertencem a um controle
	 */
	public function clean() {
		if (!is_array($this->controls))
			return;
		foreach($this->controls as $k => $v) {
			unset($this->data->{$k});
		}
	}

	public function isNeedValidator(&$pos) {
		if ($pos & CTLVAL_INT)
			return true;
		elseif ($pos & CTLVAL_FLOAT)
			return true;
		elseif ($pos & CTLVAL_EMAIL)
			return true;
		elseif ($pos & CTLVAL_STRING)
			return true;

		return false;
	}

	private function returnScriptValidatorUsingDb() {
		echo "<script language=\"javascript\" type=\"text/javascript\">\r\n";
		$first = true; //se for a primeira passagem, nao coloca a virgula
		foreach($this->data->columns as $columns) {
			$opt = $columns['OPT'];
			$field = $columns['OBJ'];
			$label = $this->controls[$field]->label;
			if ($opt && $field && $label) {
				if ($first)
					echo "var mvcFields = {\r\n";
				else
					echo ",\r\n";
				echo "\t'$field' : { 'l': '$label', ". ($opt & BZC_NOTNULL ? "'r' : true, " : "'r' : false, ");
				if ($opt & BZC_INTEGER)
					echo "'f' : 'integer', ";
				elseif ($opt & BZC_MAIL)
					echo "'f' : 'email', ";
				elseif ($opt & BZC_FLOAT)
					echo "'f' : 'real', ";
				echo "'t' : '$field'}";
				$first = false;
			}
		}
		echo "\r\n}\r\nvar tfv = new validator('".$this->name."',  mvcFields);\r\n";
		echo "</script>\r\n";	
	}
	
	private function returnScriptValidatorUsingFields() {
		echo "<script language=\"javascript\" type=\"text/javascript\">\r\n";
		$first = true; //se for a primeira passagem, nao coloca a virgula
		foreach($this->controls as $control) {
			$opt = $this->controls_opt[$control->name];
			$label = $control->label;
			$field = $control->name;
			if ($opt && $field && $label) {
				if ($first)
					echo "var mvcFields = {\r\n";
				else
					echo ",\r\n";
				echo "\t'$field' : { 'l': '$label', ". ($opt & CTLVAL_NOTNULL ? "'r' : true, " : "'r' : false, ");
				if ($opt & CTLVAL_INT)
					echo "'f' : 'integer', ";
				elseif ($opt & CTLVAL_EMAIL)
					echo "'f' : 'email', ";
				elseif ($opt & CTLVAL_IPNUMBER)
					echo "'f' : 'ipnumber', ";
				elseif ($opt & CTLVAL_FLOAT)
					echo "'f' : 'real', ";
				echo "'t' : '$field'}";
				$first = false;
			}
		}
		echo "\r\n}\r\nvar tfv = new validator('".$this->name."',  mvcFields);\r\n";
		echo "</script>\r\n";
	}

}
?>