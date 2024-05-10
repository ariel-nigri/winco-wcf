<?php

require 'GoogleAuthenticator.php';

function genGoogleAuthenticatorSecretAndUrl($name, &$secret, &$qrCodeUrl) {
	// iphone nao consegue ler o qrcode se tiver espaco no nome
	$name = str_replace(" ", "", $name);
	$ga = new PHPGangsta_GoogleAuthenticator();
	$secret = $ga->createSecret();
	$qrCodeUrl = $ga->getQRCodeGoogleUrl($name, $secret);	
}

function verifyGoogleAuthenticatorCode($secret, $code) {		
	$ga = new PHPGangsta_GoogleAuthenticator();
	return $ga->verifyCode($secret, $code, 2);
}
