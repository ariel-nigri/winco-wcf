<?php
class TopLabelLayout extends LayoutManager {
	function printControl($control, $layout, $prevlayout) {
		// 4 casos
		// prev = 1, curr = 1
		// <td> ME </td>
		// prev = 1, curr = 0
		// <td>  ME </td> </tr> </table> </td> </tr>
		// prev = 0, curr = 1
		// <tr> <td> <table> <tr> <td> ME </td>
		// prev = 0, curr = 0
		// <tr> <td> ME </td> </tr>

		if ($prevlayout & CTLPOS_NOBREAK) {
			echo "\t\t\t\t\t<td valign=\"top\">";
		} else if ($layout & CTLPOS_NOBREAK) {
			echo "\t<tr>\r\n\t\t<td>\r\n\t\t\t<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\">\r\n\t\t\t\t<tr>\r\n\t\t\t\t\t<td valign=\"top\">";
		} else {
			echo "\t<tr>\r\n\t\t<td>";
		}
		if ($control->label)
			echo $control->getLabel();
		$control->printControl();
		if ($layout & CTLPOS_NOBREAK) {
			echo "</td>\r\n";
		} else if ($prevlayout & CTLPOS_NOBREAK) {
			echo "</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table></td>\r\n\t</tr>\r\n";
		} else {
			echo "</td>\r\n\t</tr>\r\n";
		}
	}
}
?>
