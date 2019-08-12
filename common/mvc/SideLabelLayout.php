<?php
class SideLabelLayout extends LayoutManager {
	function printControl($ctl, $layout, $prevlayout) {
		// 4 casos
		// prev = 0 curr = 0
		// <TR> <TD> label </TD> <TD> ctl </TD> </TR>
		// prev = 0 curr = 1
		// <TR> <TD> label </TD> <TD> ctl &nbsp
		// prev = 1 curr = 1
		// label &nbsp; ctl &nbsp;
		// prev = 1 curr = 0
		// label &nbsp; ctl </TD></TR>
		// print_r($prevlayout);
		// echo "\r\n";
		// echo "---- LAYOUT == $layout || PREVLAYOUT == $prevlayout ---\n";
		if ($layout == CTLPOS_NOTABLE && $prevlayout != CTLPOS_NOTABLE)
			$this->endForm();
		if ($prevlayout == CTLPOS_NOTABLE && $layout != CTLPOS_NOTABLE)
			$this->startForm();
		if ($prevlayout & CTLPOS_NOBREAK) {
			if ($layout & CTLPOS_LABELRIGHT) {
				$ctl->printControl();
				echo "&nbsp;";
				echo $ctl->getLabel();
			} else {
				echo $ctl->getLabel();
				$ctl->printControl();
			}	
		} else if ($layout & CTLPOS_LABELRIGHT) {
			echo "\t<tr>\r\n\t\t<td colspan=\"2\">";
			$ctl->printControl();
			echo " ".$ctl->getLabel();
		} else {
			if ($layout & CTLPOS_COLSPAN) {
				echo "\t<tr>\r\n\t\t<td colspan=\"2\">\r\n";
			} else if ($layout & CTLPOS_NOTABLE) {
				echo "\n";
			} else {
				$label = $ctl->getLabel();
				if (!empty($label))
					echo "\t<tr>\r\n\t\t<th>".$ctl->getLabel()."&nbsp;</th>\r\n\t\t<td>";
				else
					echo "\t<tr>\r\n\t\t<td colspan=\"2\">\r\n";
			}
			$ctl->printControl();
		}
		if ($layout & CTLPOS_NOBREAK) {
			echo "&nbsp;";
		} else if ($layout & CTLPOS_NOTABLE) {
			echo "\n";
		} else {
			echo "</td>\r\n\t</tr>\r\n";
		}
	}
}
?>
