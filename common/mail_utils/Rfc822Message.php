<?php

/* usage

$msg = new Rfc822Message;
$msg->setFrom('nigri@winco.com.br', 'Ariel Nigri');
$msg->setRecipient('to', '"Kátia Kac" <kkac@winco.com.br>, haim.nigri@gmail.com');
$msg->setOriginalMessage('INBOX', 2344);
$msg->setEncodedHeader('Subject', 'Liquidação');
$msg->setRawHeaders("Priority: 3\r\n");
$msg->setBody('dual', '<html><body><p>alo</p></body></html>');
$msg->media[] = array('part_id' => '4');
$msg->media[] = array('cid' => '12346', 'filename' => '/my/file/name.jpg');

$msg->attachments[] = array('part_id' => '5.2');
$msg->attachments[] = array('name' => 'myfile.txt', 'type' => 'text/plain', 'filename' => '/my/file/name.exe');
$msg->output("c:\\myfilename.eml");

*/
	

/*
 We will keep this info here for a while but probably never use it
 */
$mime_types_array = array(
	'.gif'		=> 'image/gif',
	'.jpeg'		=> 'image/jpeg',
	'.jpg'		=> 'image/jpeg',
	'.png'		=> 'image/png',
	'.pdf'		=> 'application/pdf',
	'.zip'		=> 'application/x-zip-compressed',
	'.rar'		=> 'image/jpeg',
	'.ppt'		=> 'application/vnd.ms-powerpoint',
	'.pps'		=> 'application/vnd.ms-powerpoint',
	'.pptx'		=> 'application/vnd.ms-powerpoint',
	'.ppsx'		=> 'application/vnd.ms-powerpoint',
	'.doc'		=> 'application/msword',
	'.docx'		=> 'application/msword',
	'.xls'		=> 'application/vnd.ms-excel',
	'.xlsx'		=> 'application/vnd.ms-excel',
	'.htm'		=> 'text/html',
	'.html'		=> 'text/html',
	'.txt'		=> 'text/plain',
	'.exe'		=> 'application/executable',
);

class Rfc822Message {
	//private
	private $headers;
	private $text;
	private $text_format;
	private $mp_count = 1;
	private $orig_msg;
	private $msg_type = 'new';
	private $sender_email;
	private $fp;
	
	// public
	public $msg_id;
	public $env_to = array();
	public $media = array();
	public $attachments = array();

	// composed message (after calling generate_output)
	public $msg_headers;
	public $msg_subject;
	public $msg_to;
	public $msg_extra_headers;
	public $msg_body;

	private function startMultipart($type) {
		++$this->mp_count;
		fputs($this->fp, "Content-type: multipart/$type; boundary=\"----=_NextPart_{$this->msg_id}.{$this->mp_count}\"\r\n");
		$this->newPart();
	}
	private function newPart() {
		fputs($this->fp, "\r\n------=_NextPart_{$this->msg_id}.{$this->mp_count}\r\n");
	}
	
	private function endMultipart() {
		fputs($this->fp, "\r\n------=_NextPart_{$this->msg_id}.{$this->mp_count}--\r\n");
		--$this->mp_count;
	}
	
	private function include_files($file_info_array, $file_type) {
		foreach ($file_info_array as $file_info) {
			$this->newPart();
			
			// if $file_info['part_id']  exists, then we are forwarding some file from
			// another message. Otherwise we need to encode a file.
			if (!empty($file_info['part_id'])) {
				// print_r($orig_msg);
				$this->orig_msg->setPart($file_info['part_id']);
				while ($line = $this->orig_msg->getLine()) {
					fputs($this->fp, $line);
				}
			} else {
				if (!empty($file_info['type']))
					$mime_type = $file_info['type'];
				else {
					$ext = strtolower(strrchr($file_info['name'], '.'));
					$mime_type = isset($mime_types_array[$ext]) ? $mime_types_array[$ext] : 'application/octet-stream';
				}
				fputs($this->fp, "Content-Type: $mime_type;\r\n\tname=\"{$file_info['name']}\"\r\n");
				if ($file_type == 'attachment')
					fputs($this->fp, "Content-Disposition: attachment;\r\n\tfilename=\"{$file_info['name']}\"\r\n");
				else
					fputs($this->fp, "Content-ID: <{$file_info['name']}>\r\n");
				if (!empty($file_info['data'])) {
					fputs($this->fp, "Content-Transfer-Encoding: {$file_info['encoding']}\r\n\r\n");
					fputs($this->fp, chunk_split($file_info['data']));
				} else {
					fputs($this->fp, "Content-Transfer-Encoding: base64\r\n\r\n");
					fputs($this->fp, chunk_split(base64_encode(file_get_contents($file_info['filename']))));
				}
			}
		}
	}

	// public functions
	function setFrom($from_email, $from_name = '', $utf8 = false) {
		if (empty($from_name))
			$from_name = $from_email;
		$this->headers .= "From: ".encode_email($from_name, $from_email, $utf8)."\r\n";
		$this->sender_email = $from_email;
	}
	
	function setRecipient($type, $to_string) {
		$rec_array = parse_mail_header($to_string, false); // false means, no mime decode to perform.
		foreach ($rec_array as $rec) {
			$em = strtolower($rec[1]);
            // validate the email.
            if ($em != 'undisclosed-recipients:') {
				if (!preg_match('/^[-a-z0-9._=+\/&%$#!]{1,64}@[a-z0-9-_]{1,63}\.[a-z.0-9-_]{2,125}$/', $em))
					return false;
				$this->env_to[] = $em;
            }
			$msg_to[] = encode_email($rec[0], $em, true); // true means, the string is in UTF8 format.
		}
		$type = ucfirst($type);
		if ($type == 'To' || $type == 'Cc')
			$this->headers .= ("$type: ".implode(",\r\n\t", $msg_to)."\r\n");
		return true;
	}
	function setOriginalMessage($msg_obj, $msg_type) {
		$this->orig_msg = $msg_obj;
		$this->msg_type = $msg_type;
		
		if ($msg_type == 'reply') {
			$id_orig = '';
			$c = '';
			foreach ($msg_obj->headers as $header) {
				if (!strcasecmp(key($header), 'message-id'))
					$id_orig = trim(current($header)," \r\n");
				if (!strcasecmp(key($header), 'references')) {
					$ref_orig = ' '.trim(current($header)," \r\n");
					if (strlen($ref_orig) > 150)
						$ref_orig .= "\r\n\t";
				}
			}
			if ($id_orig)
				$this->headers .= "References:{$ref_orig} {$id_orig}\r\nIn-Reply-To: {$id_orig}\r\n";
		}
	}
	
	function setEncodedHeader($type, $value) {
		$this->headers .= (ucfirst($type).': '.encode_subject($value, true)."\r\n");
	}
	
	function setRawHeaders($header) {
		$this->headers .= $header;
	}
	
	// returns array of locally referenced media (TODO, of course!)
	function setBody($type, $text) {
		$this->text_format = $type;
		if ($type != 'plain') {
			$doc = new DOMDocument('1.0');
			@$doc->loadHTML(
				"<html><head><meta http-equiv=\"Content-type\" content=\"text/html; charset=UTF-8\" /></head><body><style>body, td { font: 10pt Arial; }</style>$text</body></html>\r\n"
			);
			// Find all embeded images that were transformed to external.
			//
			$imglist = $doc->getElementsByTagName('img');
			foreach ($imglist as $img) {
				$imgsrc = $img->getAttribute('data-cid');
				if (!empty($imgsrc)) {
					$this->media[] = array('part_id' => strtok($imgsrc, ':'));
					$img->removeAttribute('data-cid');
					$img->setAttribute('src', 'cid:'.strtok(''));
				} else {
					$prot = strtok($img->getAttribute('src'), ':');
					if ($prot == 'data') {
						// found image data, must move it to attachemnt
						$type = strtok(';');
						$encoding = strtok(',');
						$name = uniqid().'.'.basename($type);
						$img->setAttribute('src', 'cid:'.$name);
						$this->media[] = array('type' => $type, 'name' => $name, 'encoding' => $encoding, 'data' => strtok(''));
					}
				}
			}
			// We prefer to leave the text returned by the editor, so if no images are found, we reuse the original text.
			// also, no encoding is preferred in the HTML body, so we cut all up to the body.
			if (count($this->media)) {
				$txt = $doc->saveHTML();
				$this->text = "<html><head></head>".substr($txt, strpos($txt, '<body'));
			} else
				$this->text = "<html><head></head><body><style>body, td { font: 10pt Arial; }</style>$text</body></html>\r\n";
		} else
			$this->text = $text;
	}
	function generate_output($filename = null) {
		$tmpfile = $filename ? $filename : tempnam('/tmp', 'm-');

		$this->msg_id = sprintf("%08x", time()).'-'.session_id().'-'.($_SESSION['qSeq']++);
		$this->fp = fopen($tmpfile, 'w');

		if (!$this->fp)
			return false;

		// out main headers
		fputs($this->fp, $this->headers);

		// MessageId
		// MIME-VERSION
		// X-Mailer
		// Date
		fputs($this->fp, "Date: " . date("r") . "\r\nMime-Version: 1.0\r\nX-Mailer: Winconnection Webmail\r\nMessage-ID: <".$this->msg_id.strrchr($this->sender_email, '@').">\r\n");
		
		if (count($this->attachments))
			$this->startMultipart('mixed');

		if (count($this->media))
			$this->startMultipart('related');

		switch ($this->text_format) {
		case 'plain':
		case 'html':
			fputs($this->fp, "Content-type: text/{$this->text_format}; charset=\"UTF-8\"\r\nContent-transfer-encoding: quoted-printable\r\n\r\n");
			fputs($this->fp, quoted_printable_encode($this->text));
			break;
		case 'dual':
			$this->startMultipart('alternative');
			fputs($this->fp, "Content-type: text/plain; charset=\"UTF-8\"\r\nContent-transfer-encoding: quoted-printable\r\n\r\n");
			$html_body = strstr($this->text, "</styl");
			fputs($this->fp, quoted_printable_encode(convert_html_to_plain($html_body, true)));
			$this->newPart();
			fputs($this->fp, "Content-type: text/html; charset=\"UTF-8\"\r\nContent-transfer-encoding: quoted-printable\r\n\r\n");
			fputs($this->fp, quoted_printable_encode($this->text)."\r\n");
			$this->endMultipart();
		}
		if (count($this->media)) {
			$this->include_files($this->media, 'inline');
			$this->endMultipart();
		}
		if (count($this->attachments)) {
			$this->include_files($this->attachments, 'attachment');
			$this->endMultipart();
		}
		fclose($this->fp);
		if (!$filename) {
			$composed = file_get_contents($tmpfile);
			$hdrsplit = strpos($composed, "\r\n\r\n");

			$this->msg_headers = substr($composed, 0, $hdrsplit);
			$this->msg_body = substr($composed, $hdrsplit + 4);

			// lets filter the headers
			$hdr_array = explode("\r\n", $this->msg_headers);
			foreach ($hdr_array as $l) {
				$k = strtok($l, ':');
				$v = strtok('');
				if ($v[0] == ' ')
					$v = substr($v, 1);
				switch ($k) {
				case 'To':
					if ($this->msg_to)
						$this->msg_to .= ', ';
					$this->msg_to .= $v;
					break;
				case 'Subject':
					$this->msg_subject = $v;
					break;
				case '':
					break;
				default:
					$this->msg_extra_headers[$k] = $v;
				}
			}
			unlink($tmpfile);
		}
		return true;
	}
}
