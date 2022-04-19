<?php

class ModalForm {
	var $parentForm;
	var $return_url;
	
	// used by the calling form
	function ModalForm($_parent) {
		$this->data = new stdclass;
		$this->parentForm = $_parent;
	}
	
	function show($target_form, $return_event, $doit = true) {
		// create post with ModalForm data
		unset($this->parentForm->data->valid);		// READONLY
		unset($this->parentForm->data->error);		// READONLY
		unset($this->parentForm->data->erro);		// READONLY
		unset($this->parentForm->data->__order);	// READWRITE
		unset($this->parentForm->data->__qtype);	// READWRITE
		unset($this->parentForm->data->limit);		// READWRITE
		unset($this->parentForm->data->fetched);
		unset($this->parentForm->data->qr);
		unset($this->parentForm->data->columns);
		unset($this->parentForm->data->tables);
		unset($this->parentForm->data->key);
		$vars = (array) $this->data;

		// retrieve form name for submiting data back.
		$parent_name = $this->parentForm->name;
		unset ($this->parentForm->data->{$parent_name."acao"});

		// save caller DATA member (For state recovery)
		$vars["__modal_state"] = serialize($this->parentForm->data);
		//var_dump(unserialize($vars["__modal_state"]));
		//exit;
		// save caller URL
		$vars["__modal_return"] = serialize(array("URI" => $_SERVER["REQUEST_URI"], "name" => $parent_name, "action" => $return_event));

		// Create the form
		if ($doit)
			echo "<HTML><BODY onload=\"form1.submit()\"><FORM name=\"form1\" ACTION=\"$target_form\" METHOD=\"post\">\r\n";		
		foreach($vars as $k => $v) {
			echo  "<INPUT TYPE=\"hidden\" NAME=\"$k\" VALUE=\"".htmlspecialchars($v)."\">\r\n";
		}
		echo "</FORM></BODY></HTML>\r\n";
		exit;
	}

	function restore($parent) {
		$frm = new ModalForm($parent);
		$frm->data = unserialize($parent->data->__modal_results);
		unset($parent->data->__modal_results);
		return $frm;
	}
	
	function close($form, $doit = true) {
		$return_data = unserialize($form->data->__modal_return);
		$form_data = unserialize($form->data->__modal_state);
		if (!$form_data)
			die($form->data->__modal_state);
		unset($form->data->__modal_return);
		unset($form->data->__modal_state);
		$my_data = serialize($form->data);
		
		// create post with baseform data
		$vars = (array)	$form_data;
		
		// create the event.
		$vars[$return_data["name"]."acao"] = $return_data["action"];
		$vars["__modal_results"] = $my_data;

		// Create the form
		if ($doit)
			echo "<HTML><BODY onload=\"form1.submit()\"><FORM name=\"form1\" ACTION=\"$return_data[URI]\" METHOD=\"post\">\r\n";		
		foreach($vars as $k => $v) {
			if (is_object($v))
				continue;
			if (is_array($v)) {
				foreach ($v as $ak => $av) {
					if (is_object($av))
						continue;
					if (is_array($av)) {
						foreach ($av as $aak => $aav)
							echo  "<INPUT TYPE=\"hidden\" NAME=\"".$k."[$ak][$aak]\" VALUE=\"".htmlspecialchars($aav)."\">\r\n";
					} else
						echo  "<INPUT TYPE=\"hidden\" NAME=\"".$k."[$ak]\" VALUE=\"".htmlspecialchars($av)."\">\r\n";
				}
			} else
				echo  "<INPUT TYPE=\"hidden\" NAME=\"$k\" VALUE=\"".htmlspecialchars($v)."\">\r\n";
		}
		echo "</FORM></BODY></HTML>\r\n";
		exit;
	}
	
	function registerVars($form) {
		$this->addControl(new HiddenControl("__modal_state"));
		$this->addControl(new HiddenControl("__modal_return"));
	}
	function isModal($form) {
		return $form->data->__modal_return != "";
	}
}
