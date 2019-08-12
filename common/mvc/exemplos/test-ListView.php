<?

require "../MvcForm.php";
require "../LayoutManager.php";
require "../SideLabelLayout.php";
require "../MvcControl.php";
require "../SelectControl.php";
require "../CheckControl.php";
require "../EditControl.php";
require "../ButtonControl.php";
require "../ListView.php";


class ListviewTest extends MvcForm {
	function testevent() {}
	
	function beforeShow() {
		$data = array(
			array("nome" => "Ariel", "endereco" => "Barra", "situacao" => "bad"),
			array("nome" => "Mariano", "endereco" => "Flamengo"),
			array("endereco" => "Barra", "nome" => "Ariel"),
			array("nome" => "Mariano", "endereco" => "Flamengo", "ativo" => true),
			array("nome" => "Ariel", "endereco" => "Barra"),
			array("nome" => "Mariano", "endereco" => "Flamengo"),
			array("nome" => "Leandro Mantovam", "endereco" => "São Caetano do Sul", "nomenovo" => "Paulista")
		);
		$lv = new ListView("mylistview", "Minha lista", $data);
		$lv->setOption(
			"class", "list",
			"class_head", "list_head",
			"class_body", "list_body",
			"height", 50,
			"width", 500,
			"ondblclick", "buttonedit",
			"upButton", "buttonup",
			"downButton", "buttondown",
			"delButton", "buttondel"
		);
		$values = array("ok" => "OK", "bad" => "BAD");
		$lv->addControl(new SelectControl("situacao", "Situacao", $values), 100);
		$lv->addColumn("nome", "Nome", 80);
		$lv->addColumn("endereco", "Endereço", 100);
		$lv->addControl(new CheckControl("ativo", "Ativo"), 50);
		$lv->addControl(new EditControl("nomenovo", "Nome Novo"), 80);
		$this->addControl($lv);
		// return values will be in:
		// mylistview[selected],
		// mylistview[ativo][0..n]
		// mylistview[nomenovo][0..n]
		// mylistview[items]
		
		$this->addControl(new ButtonControl("buttonup", "Up"), CTLPOS_NOBREAK);
		$this->addControl(new ButtonControl("buttondown", "Down"));
		$this->addControl(new ButtonControl("testevent", "Submit"));
	}
}


$form = new ListviewTest;
$form->handle($_REQUEST);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style>
.list {
	background-color: #e0e0e0;
	overflow-x: hidden;
}
.selected {
	background-color: blue;
	color: #ffffff;
}

.list_head {
	table-layout: fixed;
	overflow: hidden;
	white-space: nowrap;
	cursor: default;
	width: 0px;
	background-color: #c0c0ff;
}

.list_body {
	table-layout: fixed;
	white-space: nowrap;
	cursor: default;
	width: 0px;
	overflow-x: hidden;
}

.list_body td, .list_head td {
	text-overflow: ellipsis;
	overflow:hidden;
}

</style>
<title>Teste de listview</title></head>
<body>
	<?$form->printForm();?>
</body>
</html>
