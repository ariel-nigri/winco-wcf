<?php
	require "../MvcForm.php";
	require "../LayoutManager.php";
	require "../TableLayout.php";
	require "../SideLabelLayout.php";
	require "../MvcControl.php";
	require "../MvcContainer.php";
	require "../TextAreaControl.php";
	require "../EditControl.php";
	require "../ButtonControl.php";
	require "../RawControl.php";
	require "../RadioGroupControl.php";
	require "../CheckListControl.php";
	
	class testeTableLayout extends MvcForm {
		
		function beforeShow() {

			//linha 1
			$this->addControl(new EditControl('nome', 'Nome:', 'size="60"'));
			//linha 2
			$this->addControl(new EditControl('cpf', 'CPF:', 'size="14" style="font-style: monospace"'));
			$this->addControl(new EditControl('rg', 'RG:', 'size="12" style="font-style: monospace"'));
			$this->addControl(new EditControl('pis', 'PIS:', 'size="15" style="font-style: monospace"'));
			//linha 3
			$this->addControl(new EditControl('email', 'E-mail:'), CTLPOS_COLSPAN);
			$this->addControl(new TextAreaControl('comentarios', 'Comentários:', 'cols="50" rows="8"'));
			//linha 4
			$this->addControl(new TextAreaControl('filiacao', 'Filiação:', 'cols="10" rows="5"'));
			//linha 5
				$fs2 = new MvcContainer($this, "fs2", "Endereço");
					$fs2->addControl(new EditControl("rua", 'Rua:'));
					$fs2->addControl(new EditControl("numero", 'Número:', 'size="4"'));
					$fs2->addControl(new EditControl("cep", 'CEP:', 'size="9"'));
				$this->addControl($fs2);
				
				$fs3 = new MvcContainer($this, "fs3", "Prefiro ser contatado via...");
					$fs3->addControl(new CheckListControl("checklist_fs", '', array('Telefone fixo','Celular','E-mail','SMS')), CTLPOS_COLSPAN);
				$this->addControl($fs3);
			//linha 6
				$this->addControl(new ButtonControl('enviar', 'Enviar'));

		}
		
	}

	$ASCII_art = <<<layout
		| 250px | 200px | 300px |
		|                       |
		|          3,1          |
		|_______________________|
		|__1,1__|__1,1__|__1,1__|
		|__1,1__|      2,2      |
		|__1,1__|_______________|
		|______2,1______|__1,1__|
		|__________3,1__________|
layout;
	$lm = new TableLayout($ASCII_art);
	$form = new testeTableLayout($lm);
	$form->handle($_REQUEST);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Teste do TableLayout</title>
		<style type="text/css">
			table.table_mvcform {
				border-width: 0px;
				border-spacing: 5px;
			}
			table.table_mvcform td {
				/*border-width: 0px 1px 1px 0px;
				border-color: black;*/
				border-width: 0px;
				padding: 5px;
			}
			table.table_mvcform td label {
				display: inline-block;
				width: 80px;
				text-align: right;
			}
		</style>
	</head>
	<body>
		<?$form->printForm()?>
	</body>
</html>