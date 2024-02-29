<?php

function convert_html_to_plain($txt, $is_html = false, $prefix = '', $maxlen = 70) {
	if ($is_html) {
		$tr_table = array('&nbsp;' => ' ', '&gt;' => '>', '&lt;' => '<',
			'&quot;' => '"');
		$txt = html_entity_decode(strip_tags($txt), ENT_COMPAT, 'UTF-8');
	}
	$maxlen -= strlen($prefix);
	// se html tirar tags, criar newlines.
	$llen = 0;
	$ret = $prefix;
	for ($i = 0; $i < strlen($txt); $i++) {
		switch($txt[$i]) {
		case "\r":
			break;
		case "\n":
			$ret .= "\r\n$prefix";
			$llen = 0;
			break;
		case ' ':
			if ($llen > $maxlen) {
				$llen = 0;
				$ret .= " \r\n$prefix";
			}
		default:
			$ret .= $txt[$i];
			++$llen;
		}
	}
	return $ret;
}


function mime_decode_token($str, $start, &$end)
{
	$cpos = strpos($str, '?', $start);	// end of chaarset
	if ($cpos) {
		$epos = strpos($str, '?', $cpos + 1); // end of encoding
		if ($epos) {
			$endpos = strpos($str, '?=', $epos+1); // end of encoded string
			if ($endpos) {
				// $charset nao e usado..
				switch ($str[$cpos + 1]) {
				case 'q':
				case 'Q':
					$ret = quoted_printable_decode(str_replace('_', ' ', substr($str, $epos + 1, $endpos - $epos - 1)));
					break;
				case 'B':
				case 'b':
					$ret = base64_decode(substr($str, $epos + 1, $endpos - $epos - 1));
					break;
				default:
					$ret = substr($str, $epos + 1, $endpos - $epos - 1);
				}
				$end = $endpos + 2;
				if (strtoupper(substr($str, $start, $cpos - $start)) != 'UTF-8')
					$ret = utf8_encode($ret);
				return $ret;
			}
		}
	}
	$end = strlen($str);
	return substr($str, $start);
}

//
// TEST STRINGS FOR THIS
//echo mime_decode('=?utf-8?B?S2Fyb2zDrW5hIEtvxI3DrQ==?=').'<br />';
//echo mime_decode('Re: =?ISO-8859-1?Q?Reuni=E3o_hoje_na_SAP?=').'<br />';
//echo mime_decode('Receita Federal.- =?ISO-8859-1?Q?=C9_bom_saber?=').'<br />';
//echo mime_decode('=?UTF-8?B?RGFzaGJvYXJkIFJlcG9ydCBmb3IgQVZHIENvcnBvcmF0ZSAocHVibGljLCBBTA==?==?UTF-8?B?TCk=?=').'<br />';
// echo mime_decode('=?ISO-8859-1?Q?Ita=FA Mail=2E?=');


function mime_decode($str) {
	if (empty($str))
		return '';
	$ret = '';
	$last_i = 0;
	$c = strlen($str);
	$state = '';
	for ($i = 0; $i < $c; $i++) {
		switch ($state) {
		case '=':
			if ($str[$i] == '?') {
				$ret .= utf8_encode(substr($str, $last_i, $i - $last_i - 1));
				$ret .= mime_decode_token($str, $i + 1, $last_i);
				$i = $last_i - 1;
			}
			$state = '';
			break;
		default:
			if ($str[$i] == '=')
				$state = '=';
			else
				$state = '';
			break;
		}
	}
	if ($i > $last_i)
		$ret .= utf8_encode(substr($str, $last_i));
	return $ret;
}

$today = date('d/m/Y');

// set mime decode to false whe the string is already in any 8-bit format (either UTF or ISO)
// to prevent double-encoding to the charset, especially UTF8.  This is useful when processing
// headers that are still not in the RFC822 message file.
function parse_mail_header($str, $do_mime_decode = true)
{
	$c = strlen($str);
	$i = 0;
	do {
		$name = $email = $curr_token = $state = '';
		$end_item = $escaping = false;
		
		while ($i < $c && !$end_item) {
			switch ($state) {
			case '"':
				if ($str[$i] == '\\')
					$escaping = true;
				else {
					if (!$escaping && $str[$i] == '"')
						$state = '';
					else
						$curr_token .= $str[$i];
					$escaping  = false;
				}
				break;
			case '':
				switch ($str[$i]) {
				case '"':
					$state = '"';
					break;
				case '<':
					if ($do_mime_decode)
						$name = trim(mime_decode($curr_token));
					else
						$name = trim($curr_token);
					$curr_token = '';
					break;
				case '(':
					$email = trim($curr_token);
					$curr_token = '';
					break;
				case '>':
				case ')':
					for ($i++; $i < $c; $i++) {
						if ($str[$i] == ';' || $str[$i] == ',')
							break;
					}
				case ',':
				case ';':
					$end_item = true;
					break;
				default:
					$curr_token .= $str[$i];
				}
			}
			$i++;
		}
		$curr_token = trim($curr_token);
		
		if ($curr_token) {
			if (empty($name))
				$name = $curr_token;
			if (empty($email))
				$email = $curr_token;
			$res[] = array($name, $email);
		}
	} while ($i < $c);
	if (!isset($res))
		$res[] = array('undisclosed-recipients:', 'undisclosed-recipients:');
	return $res;
}

function parse_header($obj, $hn, $hv)
{
	$hname = strtolower($hn);
	$hval = str_replace("\r\n", '', $hv);
	switch ($hname) {
	case 'received':
		if (empty($obj->datarec)) {
			$v = strrpos($hval, ',');
			if ($v) {
				$tm = strtotime(substr($hval, $v + 2));
				$obj->datarec = date('d/m/Y', $tm);
				if ($obj->datarec == $GLOBALS['today'])
					$obj->datarec = date('H:i', $tm);
			}
		}
		break;
	case 'subject':
		$obj->subject = trim(mime_decode($hval));
		break;
	case 'from':
		$em = parse_mail_header($hval);
		$obj->sender = $em[0];
		break;
	case 'to':
	case 'cc':
		$obj->{$hname} = parse_mail_header($hval);
		break;
	case 'date':
		$obj->date_ut = strtotime($hval);
		$obj->date = date('l, F j Y; H:i', $obj->date_ut);
		break;
	}
}

function parse_msg_headers($msg, $obj) {
	foreach($msg->headers as $header) {
		parse_header($obj, key($header), current($header));
	}
	if ($msg->parts['0']->type == 'multipart' && $msg->parts['0']->subtype == 'mixed')
		$obj->attach = '@';
	else
		$obj->attach = '';
		
	if (!isset($obj->datarec)) {
		if (!empty($obj->date_ut))
			$obj->datarec = date('d/m/Y', $obj->date_ut);
		else
			$obj->datarec = date('d/m/Y');
	}
	if (empty($obj->sender))
		$obj->sender = array('(sender not specified)', '(sender not specified)');
	if (empty($obj->subject))
		$obj->subject = '(no subject)';
}

function my_quoted_printable_encode($str) {
	$len = strlen($str);
	$res = '';
	for ($i = 0; $i < $len; $i++) {
		$c = ord($str[$i]);
		if ($c < 32 && $c != 13 && $c != 10 || $c == 0x3d || $c > 126) {
			$res .= sprintf("=%02X", $c);
		} else {
			$res .= chr($c);
		}
	}
	return $res;
}


function encode_email($label, $email, $is_utf8 = false)
{
	$enc = my_quoted_printable_encode($label);
	if (strlen($enc) == strlen($label)) {
		return '"'.str_replace('"', '', $label).'" <'.$email.'>';
	} else {
		return ($is_utf8 ? '=?UTF-8?Q?' : '=?iso-8859-1?Q?').str_replace(array('"', '<', '>', ' '), array('', '=3C', '=3E', '_'), $enc)."?= <$email>";
	}
}

function encode_subject($str, $is_utf8 = false) {
	// BUG: tem que decodificar o subject antes de codificar de novo...
	$enc = my_quoted_printable_encode($str);
	if (strlen($enc) == strlen($str)) {
		return $str;
	} else {
		return ($is_utf8 ? '=?UTF-8?Q?' : '=?iso-8859-1?Q?').str_replace(array('<', '>', ' '), array('=3C', '=3E', '_'), $enc).'?=';
	}
}
