Implementação de Google Authenticator
=====================================

Para a utilização da Autenticação por Duplo Fator foi criado o diretório 'common/auth/' contento as classes dos tipos de autenticaзгo por duplo fator dispуniveis.

Para facilitar a utilizaзгo foi criado o arquivo 'functions.php' ( 'common/auth/functions.php' ) que inclui as classes de autenticaзгo e possui mйtodos para acessб-las.

Para acessar diretamente um tipo de autenticaзгo, basta incluir sua classe.


Vamos explicar os mйtodos existentes em 'funcitons.php':


///////////////////////////////////
///	Google Authenticator	///
///////////////////////////////////

=> void genGoogleAuthenticatorSecret($name, &$secret, &$qrCodeUrl)

Gera a chave (secret) do Google Authenticator e retorna a chave e a url do QR Code para ler a chave


in: name => nome que serб exibido no celular para identificar a conta

out: secret => chave do google authenticator gerada

out: qrCodeUrl => url do QR Code para ser scaneado


=> bool verifyGoogleAuthenticatorCode($secret, $code)

	Verifica se o cуdigo informado й vбlido


in: secret => chave do google authenticator

in: code => cуdigo gerado no celular

return: true se cуdigo correto, ou false caso contrбrio