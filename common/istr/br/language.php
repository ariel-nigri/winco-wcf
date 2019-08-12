<?php


// Login page
define("LOGIN_PROGRAM_NAME", "Administrador");
define("LOGIN_MSG_LOGIN", "Usuário:");
define("LOGIN_MSG_PASSWORD", "Senha:");
define("LOGIN_MSG_BUTTON", "Entrar");
define("LOGIN_ERR_NOSCRIPT", "Você deve habilitar o JavaScript nesta máquina. Entre em <strong>Internet Explorer</strong> -> <strong>Ferramentas</strong> -> <strong>Opções da Internet</strong> -> <strong>Segurança</strong> -> <strong>Nível Personalizado</strong> ->  escolha <strong>Médio</strong> e clique em <strong>Redifinir</strong>.");
define("LOGIN_ERR_NOSCRIPT2", "Para ter acesso ao Portal de Gerência do Winco Talk Manager, você deve habilitar o JavaScript nesta máquina.<br /><br />Entre em <strong>Internet Explorer</strong> -> <strong>Ferramentas</strong> -> <strong>Opções da Internet</strong> -> <strong>Segurança</strong> -> <strong>Nível Personalizado</strong> ->  escolha <strong>Médio</strong> e clique em <strong>Redifinir</strong>.");
define("LOGIN_MSG_DICAS", "Dicas");
define("LOGIN_MSG_DICAS_DE_USO", "Veja algumas dicas de uso");
define("LOGIN_MSNG_MANUAL", "Manual");
define("LOGIN_MSG_READ_MANUAL", "Ler agora");
define("LOGIN_MSG_UPDATE", "Update e Renovação");
define("LOGIN_MSG_SEE_UPDATES", "Disponíveis");
define("LOGIN_MSG_REC_PASS", "Esqueceu a senha?");
define("LOGIN_MSG_REC_PASS_REQUEST", "Recuperar senha");
define("LOGIN_MSG_REC_PASS_STEPS", "Veja o passo-a-passo");
define("LOGIN_MSG_CONTINUE_CONNECTED", "Continuar conectado");
define("LOGIN_MSG_FOOTER1", "Winconnection é um produto Winco Tecnologia & Sistemas Copyright © 2001-");
define("LOGIN_MSG_WTM_FOOTER1", "Winco Talk Manager é um produto Winco Tecnologia & Sistemas. Copyright © 2001-");
define("LOGIN_MSG_FOOTER2", ". Todos os direitos reservados");
define("LOGIN_MSG_FOLLOW", "Siga-nos no Facebook e veja dicas de configuração<br />e notícias sobre segurança de rede");
define("LOGIN_MSG_DOWNLOAD_WTM_AGENT", "Agente WTM para Desktop");
define("LOGIN_ERR_NOT_RUNNING", "O serviço Winco Talk Manager não está em execução");
define("LOGIN_ERR_PLEASE_RESTART", "Por favor inicie o serviço. (tentando novamente a cada 15 segundos...)");
define("LOGIN_ERR_USER_NOT_ADMIN", "Usuário não tem privilégios de administrador");
define("LOGIN_ERR_INVALID_LOGIN", "Login inválido");
define("LOGIN_SITE", "Acesse nosso site aqui!");

// buttons
define("BT_MSG_ADD", "Adicionar");
define("BT_MSG_EDIT", "Editar");
define("BT_MSG_DEL", "Excluir");
define("BT_MSG_SAVE", "Salvar");
define("BT_MSG_CREATE", "Criar");
define("BT_MSG_CANCEL", "Cancelar");
define("BT_MSG_BACK", "&lt;&nbsp;Voltar");
define("BT_MSG_NEXT", "Avançar &gt;");
define("BT_MSG_END", 'Finalizar');

return;

// general strings
define("GENERAL_MSG_GENERAL", "Geral");
define("GENERAL_MSG_INIT_LOG", "Avançado");
define("GENERAL_MSG_AUTO_START", "Iniciar automaticamente");
define("GENERAL_MSG_SAVE_LOG", "Salvar LOG em");
define("GENERAL_MSG_PORT", "Porta TCP");
define("GENERAL_MSG_NETWORK_ALLOWED", 'Acesso permitido a redes');
define("GENERAL_MSG_PERMISSION_GROUP", 'Permissões de acesso por grupo');
define("GENERAL_MSG_SSL_CONFIG", 'Ativar criptografia SSL para este serviço');
define("GENERAL_MSG_SSL_CERT", 'Nome do servidor no certificado a ser usado:');
define("GENERAL_MSG_SSLCERT", 'Certificado:');
define("GENERAL_MSG_SSL_NO_CERT", 'Não utilizar');
define("PATH_CALENDAR", "../tpl/calendar/");
define("LANGUAGE", "BR");
define("GENERAL_INIT_TYPE", "Tipo de inicialização");
define("GENERAL_MSG_INIT_TITLE", "Inicialização");
define("GENERAL_MSG_LOG_TITLE", "Log");
define("GENERAL_MSG_PORT2", "Porta");
define("GENERAL_MSG_PRODUCT_WTM", "Winco Talk Manager");


//errors
define("ERR_SAVING", 'Erro salvando configurações.');
define("ERR_READING", 'Erro lendo parâmetros do servidor.');
define("ERR_SEQ", "Erro de sequência, reinicie a operação.");
define("ERR_GET_NET", "Erro obtendo lista de redes.");
define("ERR_TYPE_FIELD", "O preechimento do(s) campo(s) abaixo é obrigatório:<br />");

// start options
define("START_OPT_MSG_MAN", "Manual");
define("START_OPT_MSG_AUTO", "Automática");
define("START_OPT_MSG_LAST", "Manter o último estado");

//BACKUP
define("BACKUP_MSG_CREATE", "Gerar");
define("BACKUP_MSG_RESTORE", "Restaurar");
define("BACKUP_MSG_DOWNLOAD", 'Download');
define("BACKUP_MSG_CREATE_LBL1", 'Clique no botão abaixo para gerar um backup das configurações atuais do Winconnection.');
define("BACKUP_MSG_CREATE_BT", 'Gerar Backup');
define("BACKUP_MSG_CREATE_LBL2", "<strong>OBS: o arquivo de backup será gerado no diretório 'backup'. Para fazer o download do backup criado clique na aba 'Download'.</strong>");
define("BACKUP_MSG_RESTORE_LBL1", "Selecione abaixo o arquivo de backup que deseja restaurar e clique em ' Restaurar '.");
define("BACKUP_MSG_RESTORE_BKP_FILE", 'Arquivo de backup: ');
define("BACKUP_MSG_RESTORE_BT", 'Restaurar');
define("BACKUP_MSG_RESTORE_LBL2", "<strong>ATENÇÃO: após restaurar o backup, o Winconnection será reiniciado automaticamente. Você será redirecionado para a página de login.</strong>");
define("BACKUP_MSG_DOWNLOAD_LBL1", "Abaixo estão listados os backups disponíveis no servidor. Selecione o backup desejado e clique em ' Download '.");
define("BACKUP_MSG_DOWNLOAD_BKP_FILE", 'Backups disponíveis no servidor: ');
define("BACKUP_MSG_DOWNLOAD_BT", 'Download');
define("BACKUP_ERR_TITLE", 'Backup');
define("BACKUP_ERR_SELECT_A_FILE", 'Selecione um arquivo.');
define("BACKUP_ERR_INVALID_FILE_FORMAT", 'Formato de arquivo inválido.');
define("BACKUP_ERR_RESTORING_BKP", 'Erro restaurando backup.');
define("BACKUP_ERR_DOING_BKP", 'Erro gerando backup.');
define("BACKUP_MSG_BKP_SUCCESFULLY_DONE", 'Backup gerado com sucesso!');
define("BACKUP_ERR_RESTARTING_SERVER", 'Erro restartando servidor Winconnection.');
define("BACKUP_MSG_WAIT_REDIRECT", 'Backup restaurado com sucesso. Aguarde ...<br /><br />Você será redirecionado para a página de login.');
define("BACKUP_ERR_GETTING_DATA_PATH", "Erro obtendo path de dados do Winconnection");



// CLUSTER_SLAVE
define("CLUSTERS_MSG_HOST", 'Hostname ou IP do servidor master');
define("CLUSTERS_MSG_KEY", 'Chave de acesso');
define("CLUSTERS_MSG_PORT", 'Porta TCP do servidor master');
define("CLUSTERS_MSG_TEXT1", "O Winconnection Branch Office permite centralizar o gerenciamento das políticas de acesso à internet através do serviço de cluster. As regras definidas na matriz são automaticamente copiadas para as filiais.<br/><br/>O serviço Cluster Slave contém as informações para conexão com a matriz. A chave de acesso é gerada pela matriz no momento em que este cadastra uma filial.");

// dashboard
define("DASHBOARD_MSG_INFO", 'Informações Gerais');
define("DASHBOARD_MSG_TIME_ACTIVE", 'Tempo de Atividade');
define("DASHBOARD_MSG_SERVER_VERSION", 'Versão');
define("DASHBOARD_MSG_DRIVER_VERSION", 'Driver');
define("DASHBOARD_MSG_MQUEUE", 'E-Mails na fila de Envio');
define("DASHBOARD_MSG_CONN_USERS", 'Usuários conectados');
define("DASHBOARD_MSG_TOT_USERS", 'Usuários permitidos');
define("DASHBOARD_MSG_LIC_EXPIRATION", 'Expiração da Licença');
define("DASHBOARD_MSG_LIC_SUPORT_EXP", 'Expiração do Contrato de Suporte');
define("DASHBOARD_MSG_LIC_NETFILTER_EXP", 'Expiração da Licença do Netfilter');
define("DASHBOARD_MSG_DAYS", ' dias');
define("DASHBOARD_MSG_MEMORY_USE", 'Uso de Memória');
define("DASHBOARD_MSG_MEMORY_USED", 'Utilizada');
define("DASHBOARD_MSG_MEMORY_FREE", 'Disponível');
define("DASHBOARD_MSG_MEMORY_PHYSIC", 'Física');
define("DASHBOARD_MSG_MEMORY_VIRTUAL", 'Virtual');
define("DASHBOARD_MSG_LINK_USE", 'Uso de Link (média dos últimos 5 minutos)');
define("DASHBOARD_MSG_LINK_USE_DOWN", 'Download');
define("DASHBOARD_MSG_LINK_USE_UP", 'Upload');
define("DASHBOARD_MSG_TITLE", "Sumário");
define("DASHBOARD_MSG_LINKS", "Uso da Internet");
define("DASHBOARD_MSG_ALL_CONN", "Todas as conexões");
define("DASHBOARD_MSG_DOWNLOAD", "Entrada");
define("DASHBOARD_MSG_UPLOAD", "Saída");
define("DASHBOARD_MSG_MAX_SPEED", "Máxima");
define("DASHBOARD_MSG_CONNECTED_USERS", "Usuários conectados");
define("DASHBOARD_MSG_CONN_STATE", "Estado da conexão");
define("DASHBOARD_MSG_MAILS_IN_QUEUE", "E-mails na fila de envio");
define("DASHBOARD_MSG_MI_FILTER", "Filtro de IM");
define("DASHBOARD_MSG_ACTIVE_CONN", "Conexões ativas");
define("DASHBOARD_MSG_MONITORED_PROTO", "Protocolos monitorados");
define("DASHBOARD_MSG_VPN_SERVER", "Servidor VPN");
define("DASHBOARD_MSG_REMOTE", "Acesso Remoto");
define("DASHBOARD_MSG_NOTIFICATIONS", "Notificações");
define("DASHBOARD_MSG_LICENSE", "Contrato de licença");
define("DASHBOARD_MSG_AUTHOR", "Autor:");
define("DASHBOARD_MSG_ABOUT_WC", "Sobre o Winconnection");
define("DASHBOARD_MSG_ILIMITED", "ilimitado");

// DDNS
define("DDNS_MSG_INTERFACE", "Registrar IP utilizando");
define("DDNS_MSG_DOMAIN", "Domínio DDNS:");
define("DDNS_MSG_PASSW", "Senha do domínio:");
define("DDNS_MSG_CURRENT_IP", "IP atual:");
define("DDNS_MSG_REGISTER_INTERNAL_IP", "Registrar sempre o IP válido");
define("DDNS_MSG_LABEL1", "<strong>O cliente DDNS não pode ser configurado neste programa.</strong>");
define("DDNS_MSG_LABEL2", "Configure-o através do Assistente de Configuração do sistema DDNS:");
define("DDNS_MSG_LABEL3", "<i>Menu Iniciar -> Programas -> DDNS -> Assistente de Configuração</i>");
define("DDNS_MSG_ANYIF", '-  Associada ao gateway padrão  -');
define("DDNS_MSG_USE", 'Usar o IP da interface');
define("DDNS_MSG_USE_GW", 'Caso a interface escolhida não possua IP, utilizar o IP do gateway padrão');
define("DDNS_MSG_DOMAIN_CONFIG", 'Configuração de domínio');
define("DDNS_MSG_IP_CONFIG", 'Configuração de IP');
define("DDNS_MSG_ALERT_CHANGE_IP", "<br />A atualização do IP Atual pode levar alguns segundos pois somente será atualizado quando o IP for registrado/atualizado com sucesso nos servidores DDNS.<br /><br />Caso ele ainda não tenha sido atualizado, selecione novamente o item Cliente DDNS no menu lateral e acompanhe o log para saber se a atualização foi bem sucedida.");
define("DDNS_MSG_ALERT", "Aviso");

// DHCP
define("DHCP_MSG_LEASE", "Leases");
define("DHCP_MSG_INTERNAL_NETWORK_INTERFACE", "Interface de Rede Interna");
define("DHCP_MSG_IP", "IP");
define("DHCP_MSG_SUBMASK", "Máscara de subrede");
define("DHCP_MSG_DHCP", "DHCP");
define("DHCP_MSG_IP_START", "Primeiro IP da rede");
define("DHCP_MSG_DEFAULT_GATEWAY", "Gateway default");
define("DHCP_MSG_DOMAIN_NAME", "Nome do domínio");
define("DHCP_MSG_DNS_PSERVER", "Servidor DNS (dos clientes)");
define("DHCP_MSG_DNS_SSERVER", "Servidor DNS secundário");
define("DHCP_MSG_MAX_IPS", "Número máximo de endereços IP");
define("DHCP_MSG_IP_DURATION", "Tempo de alocação dos IPs [horas]");
define("DHCP_MSG_LEASE_LIST", "Lista de Leases");
define("DHCP_MSG_MAC", "Endereço Mac");
define("DHCP_MSG_STATUS", "Status");
define("DHCP_MSG_DESCRIPTION", "Descrição");
define("DHCP_MSG_STATUS_TYPE_FREE", "Liberado");
define("DHCP_MSG_STATUS_TYPE_BLOCK", "Bloqueado");
define("DHCP_MSG_STATUS_TYPE_ALLOCATED", "Alocado");
define("DHCP_MSG_STATUS_TYPE_IP_IS_INUSE", "IP em uso");
define("DHCP_MSG_LABEL1", "<br/><strong>Lease</strong> quer dizer locação de determinado IP.");
define("DHCP_MSG_LABEL2", "A lista de Leases contém os IPs que foram locados no servidor.");
define("DHCP_MSG_TEXT1", 'O Winconnection permite fazer um lease (locação) de determinado IP.<br/><br/>Para isto, é necessário cadastrar o IP desejado, juntamente com o endereço MAC da máquina, na lista abaixo.');

// DHCP_leases
define("DHCP_LEASE_MSG_DHP_LEASE", "DHCP Lease");
define("DHCP_LEASE_MSG_OPTIONAL", "Parâmetros Opcionais");
define("DHCP_LEASE_MSG_PDNS", "DNS");
define("DHCP_LEASE_MSG_SDNS", "DNS secundário");
define("DHCP_LEASE_MSG_WPAD", "Script automático (WPAD)");

// MAIL_ALIAS
define("MAIL_ALIAS_TITLE_WINDOW", "Lista de e-mails");
define("MAIL_ALIAS_LIST_NAME", "Nome da Lista");
define("MAIL_ALIAS_DESCRIPTION", "Descrição");
define("MAIL_ALIAS_EMAIL", "E-Mail");
define("MAIL_ALIAS_DELETE", "Remover");
define("MAIL_ALIAS_MEMBERS", "Membros");
define("MAIL_ALIAS_LIST", 'E-mails');
define("MAIL_ALIAS_ADD_MAIL", 'Adicione pelo menos um e-mail à lista.');
define("MAIL_ALIAS_MAIL_EXIST", 'E-mail / usuário já existe na lista.');
define("MAIL_ALIAS_INVALID_CHAR", 'O nome da lista contém caracteres inválidos.');
define("MAIL_ALIAS_NEW", 'Novo e-mail');

// DMZ
define("DMZ_MSG_INIT_TEXT", "O Firewall do Winconnection vem configurado de forma a proteger a interface de rede externa contra ataques em todas as portas.<br/><br/>Para liberar uma porta no firewall, basta criar uma regra de entrada. Além disso, é possível criar regras de redirecionamento (porta mapeada).");
define("DMZ_MSG_RULES_FW", 'Regras de Entrada e Redirecionamento (Porta Mapeada)');
define("DMZ_MSG_DESC", "Descrição");
define("DMZ_MSG_PORT", "Porta de entrada");
define("DMZ_MSG_IP", "Destino");

// DMZ rules
define("DMZ_RULE_MSG_NEW_RULE", 'Nova regra');
define("DMZ_RULE_MSG_PORT", '<porta>');
define("DMZ_RULE_MSG_RULE", 'Regra');
define("DMZ_RULE_MSG_ENABLE",  "Habilitada");
define("DMZ_RULE_MSG_DESC", "Descrição");
define("DMZ_RULE_MSG_INCOMING_IP", "IP de origem");
define("DMZ_RULE_MSG_INCOMING_MASK", "Máscara de rede");
define("DMZ_RULE_MSG_INIT_PORT",  "Porta Inicial");
define("DMZ_RULE_MSG_END_PORT", "Porta Final");
define("DMZ_RULE_MSG_PROTOCOL", "Protocolo");
define("DMZ_RULE_MSG_REDIRECT", "Redirecionar conexão para outro computador");
define("DMZ_RULE_MSG_DEST_IP", "Destino");
define("DMZ_RULE_MSG_DEST_PORT", "Porta");
define("DMZ_RULE_MSG_MASKERADE", "Mascarar o IP de origem com o IP desta máquina");
define("DMZ_RULE_MSG_MAX_PORT", 'O número da porta tem que pertencer ao range 0 - 65535.');
define("DMZ_RULE_MSG_ENTER", 'Regra de Entrada');
define("DMZ_RULE_MSG_REDIR", 'Redirecionamento');
define("DMZ_RULE_MSG_TIP", "Dicas");
define("DMZ_RULE_MSG_TEXT1", "<li>IP de origem e Máscara de rede são opcionais;</li><li>Para liberar apenas uma porta no firewall, use os mesmos valores para Porta inicial e Porta final;</li><li>Para redirecionar a conexão para outra máquina, preencha os dados na aba <strong>Redirecionamento</strong>.</li>");
define("DMZ_RULE_MSG_OTHER_PROTO", "-- outro protocolo --");
define("DMZ_RULE_MSG_OTHER_PROTO_NUM", 'Número do protocolo');
define("DMZ_RULE_MSG_TITLE", "Regra de Entrada e Redirecionamento");

// DNS
define("DNS_MSG_AUTO_CONFIG", 'Configuração automática');
define("DNS_MSG_MAN_CONFIG", 'Configuração manual');
define("DNS_MSG_EXTERN_DNS", "Servidor DNS externo:");

// EMAIL_CFG
define("EMAIL_CFG_MSG_QUARANTINE", "Quarentena");
define("EMAIL_CFG_MSG_PHP", "Interface PHP onDispatcher");
define("EMAIL_CFG_MSG_ENABLE", 'Habilitar');
define("EMAIL_CFG_MSG_BKP", 'Cópia de Segurança das mensagens de e-mail');
define("EMAIL_CFG_MSG_HOUR", 'Hora');
define("EMAIL_CFG_MSG_DAY", 'Dias da semana');
define("EMAIL_CFG_MSG_QUOTAS_TITLE", 'Cotas de E-mail');
define("EMAIL_CFG_MSG_USER", 'Usuário');
define("EMAIL_CFG_MSG_QUOTA_MB", 'Cota [Mb]');
define("EMAIL_CFG_MSG_USED", 'Usado');
define("EMAIL_CFG_MSG_ESTABILISH", 'Estabelecer cota para usuário');
define("EMAIL_CFG_ERR_USER_HAS_QUOTA", 'Usuário já possui cota.');
define("EMAIL_CFG_MSG_QUOTA", 'Cotas');
define("EMAIL_CFG_MSG_TEXT1", 'Se o usuário não possuir uma cota especificada, significa que ele não possui limite de armazenamento.');
define("EMAIL_CFG_MSG_NOTE", 'Nota');
define("EMAIL_CFG_MSG_INVALID_QUOTA", 'Adicione um valor válido para a cota.');
define("EMAIL_CFG_MSG_USED_SPACE", 'Espaço utilizado');
define("EMAIL_CFG_MSG_DEFAULT_QUOTA", 'Cota padrão');
define("EMAIL_CFG_MSG_SIZE", 'Tamanho [Mb]');
define("EMAIL_CFG_MSG_SIZE_0", 'PS: 0 significa sem limite');
define("EMAIL_CFG_MSG_TITLE", "Armazenamento");

// FTPSRV
define("FTPSRV_MSG_READWRITE", 'Leitura / Escrita');
define("FTPSRV_MSG_NO_PERMISSION", 'Nenhuma');
define("FTPSRV_MSG_READ", 'Leitura');
define("FTPSRV_MSG_WRITE", 'Escrita');
define("FTPSRV_MSG_ACCESS_RULES", 'Regras de Acesso');
define("FTPSRV_MSG_USER_ACCOUNT", 'Conta de usuário do Windows/AD que será utilizada para logins anônimos e de usuários da base do Winconnection sem conta na máquina local');
define("FTPSRV_MSG_USER", 'Usuário');
define("FTPSRV_MSG_PASSW", 'Senha');
define("FTPSRV_MSG_DIR_BASE", 'Diretório base dos arquivos');
define("FTPSRV_MSG_DIR", 'Diretório');
define("FTPSRV_MSG_PERMISSIONS", 'Permissões');
define("FTPSRV_MSG_RULE_VALID_FOR", 'Válida para');
define("FTPSRV_MSG_LOG_LEVEL", 'Nível de Log');
define("FTPSRV_MSG_TITLE", 'Regra de Acesso FTP');

// FTPSRV_rule
define("FTPSRV_RULE_MSG_ORIGIN", 'Origem');
define("FTPSRV_RULE_MSG_PERMISSIONS", 'Permissões');
define("FTPSRV_RULE_MSG_DIR_BASE", 'Diretório Base');
define("FTPSRV_RULE_MSG_TEXT1", 'Passo 1 de 3: Selecione a Origem do Acesso');
define("FTPSRV_RULE_MSG_TEXT2", "Selecione abaixo a Origem do Acesso. Você pode adicionar mais de uma origem a esta regra.");
define("FTPSRV_RULE_MSG_TEXT3", "Para ir ao próximo passo, clique em Avançar.");
define("FTPSRV_RULE_MSG_ADD_ORIGIN", 'Adicionar origem...');
define("FTPSRV_RULE_MSG_ALL", 'Todos');
define("FTPSRV_RULE_MSG_USER", 'Usuário');
define("FTPSRV_RULE_MSG_GROUP", 'Grupo');
define("FTPSRV_RULE_MSG_TYPE", "Tipo");
define("FTPSRV_RULE_MSG_DESCRIPTION", "Descrição");
define("FTPSRV_RULE_MSG_TEXT4", 'Passo 3 de 3: Permissões');
define("FTPSRV_RULE_MSG_TEXT5", "Marque as permissões que serão habilitadas.");
define("FTPSRV_RULE_MSG_READ", 'Leitura');
define("FTPSRV_RULE_MSG_WRITE", 'Escrita');
define("FTPSRV_RULE_MSG_TEXT6", 'Passo 2 de 3: Diretório Base');
define("FTPSRV_RULE_MSG_TEXT7", "Indique o diretório base dos arquivos.");
define("FTPSRV_RULE_MSG_DIR", 'Diretório');
define("FTPSRV_RULE_MSG_USE_ANONYMOUS", 'Impersonar este(s) usuário(s) como usuário anônimo');
define("FTPSRV_RULE_MSG_USER_ANONYMO", 'Usuário anônimo');

// GROUP
define("GROUP_ERR_READING_GROUPS", 'Erro lendo parâmetros do grupo.');
define("GROUP_MSG_NAME", "Nome");
define("GROUP_MSG_NAME2", "Nome do Grupo");
define("GROUP_MSG_GROUP", "Tipo do Grupo");
define("GROUP_MSG_WC_GROUP", 'Winconnection');
define("GROUP_MSG_DESC", 'Descrição');
define("GROUP_MSG_AD_GROUP", 'Active Directory (AD)');
define("GROUP_GLOBAL_CFG", 'Replicar este grupo para as filiais');
define("GROUP_CLUSTER_OPT", 'Opções de Cluster');
define("GROUP_MSG_TEXT_AD", "Para incluir grupos do Active Directory (AD) ative a opção de Autenticação de Domínio na seção <strong>Configurações Gerais</strong>.");
define("GROUP_MSG_TITLE", "Cadastro de Grupo");

// HTTP
define("HTTP_MSG_URLS_LIST", 'Listas');
define("HTTP_MSG_URLS_LIST2", 'Listas de Sites');
define("HTTP_MSG_ACCESS_NAV", 'Controle de acesso à navegação');
define("HTTP_MSG_AUTH", 'Exigir autenticação');
define("HTTP_MSG_EXPIRATION_TIME", 'Tempo de inatividade para expirar logins dos usuários [minutos]:');
define("HTTP_MSG_MINUTES", 'minutos');
define("HTTP_MSG_REQ_PASS", 'Pedir senha sempre que o usuário abre o browser');
define("HTTP_MSG_CAPTURE", 'Ativar proxy transparente (capturar conexões HTTP e HTTPS)');
define("HTTP_MSG_BLOCK_UNKNOWN_CERTIFICATES", "Bloquear certificados desconhecidos");
define("HTTP_MSG_USE_SOCKAUTHD", "Usar o Agente Winconnection para Desktops quando disponível");
define("HTTP_MSG_USE_DOMAIN_AUTH", "Usar a autenticação integrada do Windows");
define("HTTP_MSG_USE_DOMAIN_AUTH_TRANSP", "Usar a autenticação integrada também no proxy transparente");
define("HTTP_MSG_ACT_CONTENT_CONTROL", 'Ativar');
define("HTTP_MSG_CONTENT_CONTROL", 'Controle Automático de Conteúdo');
define("HTTP_MSG_LICENSE", 'Licença:');
define("HTTP_MSG_ACCESS_RULES", 'Regras de Acesso');
define("HTTP_MSG_ADVANCED_RULE", 'Regras Avançadas');
define("HTTP_MSG_GROUP_RULE", 'Regras por Grupo');
define("HTTP_MSG_VALID_TO", "Válida para");
define("HTTP_MSG_ON_ACCESS", "Ao acessar");
define("HTTP_MSG_ACTION", "Ação");
define("HTTP_MSG_NEW_RULE", 'Nova');
define("HTTP_MSG_EDIT_RULE", 'Editar');
define("HTTP_MSG_DEL_RULE", 'Excluir');
define("HTTP_MSG_CONFIGURE", "Configurar");
define("HTTP_MSG_OTHER_PROXY", 'Acessar através de outro proxy');
define("HTTP_MSG_PROXY_BELOW", 'Usar o proxy abaixo');
define("HTTP_MSG_PORT", 'Porta [HTTP]');
define("HTTP_MSG_PORT_HTTPS", 'Porta [HTTPS]');
define("HTTP_MSG_TEXT1", 'A Lista de Sites é um recurso que visa simplificar a criação de Regras de Acesso, permitindo a criação de uma lista de sites correlatos.<br/><br/>Ao criar uma Regra de Acesso, o administrador da rede poderá optar por usar a lista de sites ao invés de ter que digitar várias URLs.<br />&nbsp;<br />');
define("HTTP_MSG_NEW_LIST", 'Nova');
define("HTTP_MSG_EDIT_LIST", 'Editar');
define("HTTP_MSG_DEL_LIST", 'Excluir');
define("HTTP_MSG_ALL", "Todos");
define("HTTP_MSG_ALL2", "Tudo");
define("HTTP_MSG_ULS_WITHOUT_HOSTNAME", "Sites sem hostname");
define("HTTP_MSG_BLOCK", 'Bloquear');
define("HTTP_MSG_ALLOW", 'Permitir');
define("HTTP_MSG_RESTRICT", 'Restringir');
define("HTTP_MSG_GLOBAL_RULE", 'Regras Globais');
define("HTTP_MSG_GLOBAL_RULE_TXT", 'As regras de acesso globais só serão aplicadas se você utilizar o serviço de CLUSTER MASTER.');
define("HTTP_ERR_GET_SERVICE", "Erro obtendo lista de serviços.");
define("HTTP_MSG_CACHE", 'Ativar o CACHE');
define("HTTP_MSG_CACHE_SIZE", 'Tamanho máximo do cache [Mb]');
define("HTTP_MSG_CACHE_DIR", 'Diretório do cache');
define("HTTP_MSG_TEXT2", "O Winconnection 6 possui uma nova maneira de criar regras de acesso, através de Wizard, tornando o processo simples e melhor. Estas regras serão chamadas de Regras Avançadas.");
define("HTTP_MSG_TEXT3", "Você pode a qualquer momento optar por usar as Regras Avançadas ou as Regras por Grupo (regras antigas do Winconnection 4).");
define("HTTP_MSG_RULE_TYPE", 'Tipo de regra a ser utilizada');
define("HTTP_MSG_TEXT4", "Com o Winconnection Branch Office é possível replicar Regras de Acesso entre vários Winconnection, usando os serviços Cluster Master e Cluster Slave.<br/><br/>As regras globais listadas abaixo serão replicadas a todos os Winconnections.");
define("HTTP_MSG_INIT_LOG", 'Inic. & Log');
define("HTTP_MSG_BLOCK1", 'Regras globais só podem ser adicionadas se o serviço Cluster Master estiver instalado.');
define("HTTP_MSG_BLOCK2", 'Regras globais só podem ser excluídas se o serviço Cluster Master estiver instalado.');
define("HTTP_ERR_DEL_LIST", 'Esta lista está sendo utilizada por uma ou mais regras');
define("HTTP_BYPASS_HOSTS", "<< Lista de Exceções HTTP (BYPASS_HOSTS) >>");
define("HTTP_BYPASS_IPS", "<< Lista de Exceções HTTPS (BYPASS_IPS) >>");
define("HTTP_BYPASS_NO_DELETE", "A Lista de Exceções não pode ser excluida.");
define("HTTP_MSG_ALLOW_IF_PROXY_SET", 'Permitir acesso somente se o usuário estiver utilizando proxy no browser');
define("HTTP_MSG_IP_ADDRESS", "Endereço IP");
define("HTTP_MSG_NETFILTER_EXPIRED", "Validade da licença: ");
define("HTTP_MSG_NETFILTER_EXPIRED2", "Sua licença expirou em: ");
define("HTTP_MSG_ENABLE_SCAM", 'Ativar filtro Anti-Phishing');
define("HTTP_MSG_USE_NETFILTER", "Classificar sites usando o Netfilter");
define("HTTP_MSG_SCAM_TEXT", "<br />O filtro Anti-Phishing impede o acesso a sites reportados como fraudulentos, protegendo seus usuários contra golpes na Internet.<br />");
define("HTTP_MSG_SCAM_TITLE", "Anti-Phishing");
define("HTTP_MSG_DEFAULT_HOST", "Host para proxy reverso");
define("HTTP_MSG_DEFAULT_PORT", "Porta para proxy reverso");
define("HTTP_MSG_EXPLAIN_RULES", "As regras de acesso permitem controlar os sites que podem ou não ser acessados. Além disso, é possível limitar o tempo de navegação, a taxa de transfêrencia e bloquear extensões de arquivos.<br /><br />A verificação das regras é feita em sequência, de cima para baixo.  A primeira regra que coincidir com a origem (dispositivo fazendo acesso) e o destino (site acessado) da conexão será aplicada.  Uma vez aplicada a regra, a verificação é concluída e as demais regras serão ignoradas.");

// HTTP_group
define("HTTP_GROUP_MSG_ACCESS_RULES", 'Regras de Acesso');
define("HTTP_GROUP_MSG_ACT_CONTENT_CONTROL", 'Ativar o controle de conteúdo');
define("HTTP_GROUP_MSG_BLOCK_ACCESS", 'Proibir acesso aos sites abaixo');
define("HTTP_GROUP_MSG_ENABLE_ACCESS", 'Permitir acesso aos sites e listas abaixo');
define("HTTP_GROUP_MSG_URLS_LIST", 'Regras');
define("HTTP_GROUP_MSG_NAME", "Lista / Site");
define("HTTP_GROUP_MSG_HOUR", 'Horários');
define("HTTP_GROUP_MSG_USE_FILTER", "Usar o Controle Automático de Conteúdo para bloquear os sites que não estejam na lista");
define("HTTP_GROUP_MSG_BLOCK_BY_IP", "Proibir que sites não listados sejam acessados diretamente pelo endereço IP");
define("HTTP_GROUP_MSG_SITES", 'Sites não listados/classificados');
define("HTTP_GROUP_MSG_BLOCK_ACCESS2", 'Proibir acesso');
define("HTTP_GROUP_MSG_ENABLE_ACCESS2", 'Permitir acesso de acordo com a seguinte regra');
define("HTTP_GROUP_MSG_RULE", "Regra");
define("HTTP_GROUP_MSG_ACCESS_CONTROL", 'Controle Aut. de Conteúdo');
define("HTTP_GROUP_MSG_CATEGORY", "Selecione abaixo as categorias de sites proibidos.");
define("HTTP_GROUP_MSG_BLOCKED_SITES_LIST", 'Lista de Sites proibidos');
define("HTTP_GROUP_MSG_CHANGE_HOUR", 'Alterar Horário');
define("HTTP_GROUP_ERR_SEQ", "Erro de sequência, reinicie a operação.");
define("HTTP_GROUP_MSG_AUTO_CONTROL", "As regras do controle automático de conteúdo só serão aplicadas se a opção de 'Ativar Controle Automático de Conteúdo' estiver selecionada na configuração do Filtro Web.");
define("HTTP_GROUP_MSG_TITLE", "Controle de Acesso");

// HTTP_GroupSites
define("HTTP_GROUPSITES_GROUP", 'Grupo');
define("HTTP_GROUPSITES_URLS_OR_SITE", 'URL ou sites');
define("HTTP_GROUPSITES_TEXT1", 'O Controle de Conteúdo pode ser feito através de um site ou de uma lista de sites.<br/><br/>Selecione uma das opções abaixo.');
define("HTTP_GROUPSITES_GROUP_SITES", 'Lista de sites');
define("HTTP_GROUPSITES_LIST", "Lista");
define("HTTP_GROUPSITES_TIP", 'Dica');
define("HTTP_GROUPSITES_TEXT2", 'Você pode utilizar * como coringa (Wildcard). Exemplos:');
define("HTTP_GROUPSITES_TIP1", "www.site.com.br - controla o acesso ao site 'www.site.com.br'");
define("HTTP_GROUPSITES_TIP2", "*.site.com.br - controla o acesso aos sites terminados com '.site.com.br'");
define("HTTP_GROUPSITES_TIP3", "www.site.* - controla o acesso aos sites iniciado por 'www.site'");
define("HTTP_GROUPSITES_TIP4", "*sex* - controla o acesso aos sites que contém o termo 'sex'");
define("HTTP_GROUPSITES_TIP5", "/playboy - controla o acesso aos sites que contém o diretório playboy");
define("HTTP_GROUPSITES_ACCESS_RULES", "Regras de acesso");
define("HTTP_GROUPSITES_PROTOCOL", "Protocolos permitidos");
define("HTTP_GROUPSITES_DOWNLOAD", 'Download de arquivos (somente HTTP e FTP)');
define("HTTP_GROUPSITES_EXTENSIONS", 'Extensões de arquivos (separado por vírgula)');
define("HTTP_GROUPSITES_ALLOW_EXTENSIONS", 'Ao invésde proibir, apenas permitir as extensões acima');
define("HTTP_GROUPSITES_RULES_TIME", "Horário");
define("HTTP_GROUPSITES_PERIOD_ALLOWED", 'Período de tempo:');
define("HTTP_GROUPSITES_CHANGE", "Alterar");
define("HTTP_GROUPSITES_TIME_ALLOWED", 'Tempo máximo por dia, quando permitido [minutos]:');
define("HTTP_GROUPSITES_ERR_SEQ", "Erro de sequência, reinicie a operação.");
define("HTTP_GROUPSITES_ERR_NAME", "URL / Lista de sites");
define("HTTP_GROUPSITES_MSG_TITLE", "Regra de Acesso");
define("HTTP_GROUPSITES_MSG_REST", "Restrições");

// HTTP_horarios
define("HTTP_TIME_SUNDAY", "Domingo");
define("HTTP_TIME_MONDAY", "Segunda");
define("HTTP_TIME_TUESDAY", "Terça");
define("HTTP_TIME_WEDNESDAY", "Quarta");
define("HTTP_TIME_THURASDAY", "Quinta");
define("HTTP_TIME_FRIDAY", "Sexta");
define("HTTP_TIME_SATURDAY", "Sábado");
define("HTTP_TIME_A", " a ");
define("HTTP_TIME_AS", " às ");
define("HTTP_TIME_TIME", 'Horário');
define("HTTP_TIME_ALL_DAY", 'Todos os dias / 24h por dia');
define("HTTP_TIME_ONLY_TIME_BELOW", 'Apenas nos horários abaixo');
define("HTTP_TIME_DAY", 'Dia');
define("HTTP_TIME_HOUR", 'Hora');
define("HTTP_TIME_DENIED", 'proibidos');
define("HTTP_TIME_WEEKDAYS", 'Dias da semana');
define("HTTP_TIME_ADD_TIME", "Incluir horário");
define("HTTP_TIME_TITLE", "Período de Tempo");

// HTTP_listaSites
define("HTTP_LISTA_SITES_LIST", 'Lista de Sites');
define("HTTP_LISTA_SITES_TEXT1", 'Digite um nome para a lista e adicione sites membros.');
define("HTTP_LISTA_SITES_TEXT2", 'Após criá-la, você poderá adicionar ou remover sites a qualquer momento.');
define("HTTP_LISTA_SITES_LIST_NAME", 'Nome da Lista');
define("HTTP_LISTA_SITES_MEMBERS", 'Sites membros');
define("HTTP_LISTA_SITES_REMOVE", 'Remover');
define("HTTP_LISTA_SITES_ADD", "Incluir site");
define("HTTP_LISTA_SITES_READ_FILE", 'Ler URLs do arquivo');
define("HTTP_LISTA_SITES_ERR1", 'Adicione pelo menos um site à lista.');
define("HTTP_LISTA_SITES_FILE", 'Arquivo:');
define("HTTP_LISTA_SITES_EXPORT_TITLE", 'Exportar lista de sites');
define("HTTP_LISTA_SITES_READFILE", "Ler do arquivo ...");
define("HTTP_LISTA_SITES_SUCCESS", 'Lista importada com sucesso.');
define("HTTP_LISTA_SITES_ADVICE", 'Aviso');
define("HTTP_LISTA_SITES_EXPORT", 'Exportar');
define("HTTP_LISTA_SITES_TITLE", 'Lista de Sites');
define("HTTP_LISTA_SITES_TITLE_ADD", 'Site Membro');

// HTTP_listaSites_add
define("HTTP_LISTA_SITE_ADD_MSG_SITE", 'Site');
define("HTTP_LISTA_SITE_ADD_MSG_ONLY", 'Uma única URL');
define("HTTP_LISTA_SITE_ADD_MSG_FILE", 'URLs de um arquivo');
define("HTTP_LISTA_SITE_ADD_MSG_EXAMPLE", 'Dica');
define("HTTP_LISTA_SITE_ADD_MSG_TEXT1", "Você pode utilizar * como coringa (Wildcards). Exemplos:");
define("HTTP_LISTA_SITE_ADD_MSG_TEXT2", "www.site.com.br - controla o acesso ao site 'www.site.com.br'");
define("HTTP_LISTA_SITE_ADD_MSG_TEXT3", "*.site.com.br - controla o acesso aos sites terminados com '.site.com.br'");
define("HTTP_LISTA_SITE_ADD_MSG_TEXT4", "www.site.* - controla o acesso aos sites iniciado por 'www.site'");
define("HTTP_LISTA_SITE_ADD_MSG_TEXT5", "*sex* - controla o acesso aos sites que contém o termo 'sex'");
define("HTTP_LISTA_SITE_ADD_MSG_TEXT6", "/playboy - controla o acesso aos sites que contém o diretório playboy");
define("HTTP_LISTA_SITE_ADD_MSG_TEXT7", "Você deve informar a url inteira. Exemplos:");
define("HTTP_LISTA_SITE_ADD_MSG_TEXT8", "Você deve informar o IP do site. Exemplos:");
define("HTTP_LISTA_SITE_ADD_ERR1", 'Adicione pelo menos um site');

// HTTP_rule
define("HTTP_RULE_ACCESS_ORIGIN", 'Origem');
define("HTTP_RULE_DEST", 'Destino');
define("HTTP_RULE_SCHEDULE", 'Permissões');
define("HTTP_RULE_RESTRICTION", 'Restrições');
define("HTTP_RULE_ORIGIN", 'Origem');
define("HTTP_RULE_SELECT_USERS", 'Selecione os usuários e/ou grupos aos quais a regra se aplica');
define("HTTP_RULE_TYPE", "Tipo");
define("HTTP_RULE_DESCRIPTION", "Descrição");
define("HTTP_RULE_ORIGIN_ALL", "Todos");
define("HTTP_RULE_ORIGIN_USER", "Usuário");
define("HTTP_RULE_ORIGIN_GROUP", "Grupo");
define("HTTP_RULE_ORIGIN_IP", "IP (ex: 10.20.30.1-10.20.30.5 ou 10.20.30.5)");
define("HTTP_RULE_ADD_ITEM", 'Para adicionar um item a lista, selecione o tipo e escreva o valor');
define("HTTP_RULE_USER_LIST", "Lista de usuários");
define("HTTP_RULE_GROUP_LIST", "Lista de grupos");
define("HTTP_RULE_DESTINATION", 'Destino');
define("HTTP_RULE_SELECT_DEST", 'Escolha para qual(is) destino(s) esta regra se aplica.');
define("HTTP_RULE_DEST_LIST", 'Lista');
define("HTTP_RULE_DEST_CAT", "Categoria");
define("HTTP_RULE_SITES_WITHOUT_HOST", "Sites sem hostname");
define("HTTP_RULE_URL", "URL (pode ter 'wildcards' * e ?)");
define("HTTP_RULE_LIST_SITES_URL", "Lista de sites/URLS");
define("HTTP_RULE_CATEGORY_FILTER", "Categoria (Controle Aut. de Conteúdo)");
define("HTTP_RULE_ALL_SITES_IP", "Sites acessados por IP (ex. http://192.168.3.10)");
define("HTTP_RULE_TIME", 'Hora do dia');
define("HTTP_RULE_CHANGE", "Alterar Horário");
define("HTTP_RULE_ONLINE", 'Tempo online');
define("HTTP_RULE_RESTRICT_ONLINE", 'Tempo de navegação [minutos]:');
define("HTTP_RULE_MINUTES", 'minutos');
define("HTTP_RULE_DOWNLOAD", 'Download de arquivos');
define("HTTP_RULE_DENY_EXT", 'Extensão de arquivos proibidos');
define("HTTP_RULE_USE_COMAS", '(separe por virgula)');
define("HTTP_RULE_ALLOW_INSTEAD_DENY", 'Ao invés de proibir, apenas permitir as extensões acima');
define("HTTP_RULE_ERR_SEQ", "Erro de sequência, reinicie a operação.");
define("HTTP_RULE_ERR_ORIGIN1", "A origem <strong>TODOS</strong> só pode ser adicionada na lista se ela estiver vazia.");
define("HTTP_RULE_ERR_ORIGIN2", "A origem não pôde ser adicionada na lista porque a lista possui a origem <strong>TODOS</strong>. Para adicioná-la remova a origem <strong>TODOS</strong>.");
define("HTTP_RULE_ERR_DEST1", "O destino <strong>TODOS</strong> só pode ser adicionado na lista se ela estiver vazia.");
define("HTTP_RULE_ERR_DEST2", "O destino não pôde ser adicionado na lista porque a lista possui o destino <strong>TODOS</strong>. Para adicioná-lo remova o destino <strong>TODOS</strong>.");
define("HTTP_RULE_ERR_ORIGIN3", 'Adicione pelo menos uma origem.');
define("HTTP_RULE_ERR_DEST3", 'Adicione pelo menos um destino.');
define("HTTP_RULE_TRANSF", 'Transferência');
define("HTTP_RULE_TRANSF_LIMIT", 'Limite de transferência diária [KB]:');
define("HTTP_RULE_MSG_STEP1", 'Passo 1 de 4: Selecione a Origem do Acesso');
define("HTTP_RULE_MSG_STEP1_TEXT1", "Selecione abaixo a Origem do Acesso. Você pode adicionar mais de uma origem a esta regra.");
define("HTTP_RULE_MSG_STEP1_TEXT2", "Para ir ao próximo passo, clique em Avançar.");
define("HTTP_RULE_MSG_ADD_ORIGIN", 'Adicionar origem...');
define("HTTP_RULE_MSG_ORIGINS", 'Origem(ns)');
define("HTTP_RULE_MSG_STEP2", 'Passo 2 de 4: Selecione o destino');
define("HTTP_RULE_MSG_STEP2_TEXT1", 'Escolha na lista abaixo a qual(is) destino(s) esta regra se aplica.');
define("HTTP_RULE_MSG_STEP2_TEXT2", 'Para ir ao próximo passo, clique em Avançar.');
define("HTTP_RULE_MSG_STEP2_TEXT3", '<br />Para verificar a classificação de uma URL, utilize o <a href="#" onclick="parent.show_class_url(); return false;">classificador de URLs</a>.');
define("HTTP_RULE_MSG_ADD_DESTINATION", 'Adicionar destino...');
define("HTTP_RULE_MSG_STEP3", 'Passo 3 de 4: Permissões do Acesso');
define("HTTP_RULE_HOUR_OPTION1", "Liberar o acesso todos os dias, 24 horas por dia.");
define("HTTP_RULE_HOUR_OPTION2", "Bloquear o acesso");
define("HTTP_RULE_HOUR_OPTION3", "Definir um horário para navegação");
define("HTTP_RULE_HOUR_SELECT", 'Selecione o(s) horário(s)');
define("HTTP_RULE_HOURS", "Horários");
define("HTTP_RULE_MSG_STEP4", 'Passo 4 de 4: Restrições do Acesso');
define("HTTP_RULE_MSG_STEP4_TEXT1", "Quais restrições devem ser aplicadas a esta regra?");
define("HTTP_RULE_MSG_RESTRICTIONS", 'Restrições');
define("HTTP_RULE_BLOCK1", '<span class="warning">As regras globais só podem ser editadas se o serviço Cluster Master estiver instalado.</span><br><br>');
define("HTTP_RULE_NOT_LOG", 'Não salvar logs deste acesso');
define("HTTP_RULE_ERR_CAT1", "'<strong>Todas as categorias</strong>' só pode ser adicionada se não houver nenhuma categoria já adicionada no destino.");
define("HTTP_RULE_ERR_CAT2", "A categoria não pôde ser adicionada na lista porque a lista possui a categoria <strong>Todas as categorias</strong>. Para adicioná-la, remova a categoria <strong>'Todas as categorias'</strong>.");
define("HTTP_RULE_TITLE", "Regra de Acesso Web");

// HTTPSRV
define("HTTPSRV_MSG_SERVER", 'Servidor WWW');
define("HTTPSRV_MSG_DOC_ROOT", 'Diretório base para serviços dos sites');
define("HTTPSRV_MSG_DIR", 'Diretório');
define("HTTPSRV_MSG_DIR_ALIAS_LIST", 'Aliases para diretórios');
define("HTTPSRV_MSG_ALIAS", "Alias");
define("HTTPSRV_MSG_DEST_DIR", "Diretório destino");
define("HTTPSRV_MSG_SERVER_EXT", 'Extensões de servidor');
define("HTTPSRV_MSG_ASSOCIATION_TEXT", 'Associações entre extensões e programas CGI');
define("HTTPSRV_MSG_ASSOCIATION_LIST", 'Lista de associações');
define("HTTPSRV_MSG_EXT", "Extensão");
define("HTTPSRV_MSG_ASSOCIATED_PROG", "Programa associado");
define("HTTPSRV_MSG_SEARCH", 'Procurar');
define("HTTPSRV_MSG_TXT1", "O(s) seguinte(s) alias(es) já estava(m) criado(s) e <strong>NÃO</strong> foi(ram) criado(s) novamente:<br />");
define("HTTPSRV_MSG_TXT2", "<br /><br />Caso seja necessário recriar o(s) alias(es) citado(s), apague primeiro o(s) existente(s).");
define("HTTPSRV_MSG_TXT3", "Alerta");
define("HTTPSRV_MSG_ADMIN_ALIAS", 'Aliases Administrativos');
define("HTTPSRV_MSG_ADMIN_ALIAS_ADD", "Adicionar aliases administrativos neste Servidor");

// HTTPSRV_alias
define("HTTPSRV_ALIAS_MSG_ALIASES", 'Alias:');
define("HTTPSRV_ALIAS_MSG_DIR", "Diretório destino:");
define("HTTPSRV_ALIAS_MSG_ENABLE_LOG", 'Habilitar exibição de log no Administrador');

// HTTPSRV_cgi
define("HTTPSRV_CGI_EXT", "Extensão de arquivo:");
define("HTTPSRV_CGI_ASSOCIATED_CGI", "CGI associado:");

// IMAP
define("IMAP_MSG_ACCESS_CONTROL", 'Controle de Acesso');
define("IMAP_MSG_TEXT", "Os grupos listados abaixo são os grupos que tem permissão de recebimento de e-mail. Caso queira adicionar um novo grupo, habilite o grupo desejado na configuração de algum domínio do SMTP.");

// IMFILTER
define("IMFILTER_MSG_ACCESS", 'Permissões por Grupo');
define("IMFILTER_MSG_EXCEPTION", 'Permissões por Usuário');
define("IMFILTER_MSG_CAPTURE", 'Através do serviço Socks5');
define("IMFILTER_MSG_CAPTUR_IMS", 'Interceptar conexões ao serviço MSN / Live Messenger');
define("IMFILTER_MSG_GROUPS", 'Grupos de Usuários');
define("IMFILTER_MSG_RULE_BY_USER", 'Regras por Usuários');
define("IMFILTER_MSG_ID", 'Identificação');
define("IMFILTER_MSG_IM", 'Rede');
define("IMFILTER_MSG_ALLOW", 'Permitir');
define("IMFILTER_MSG_TRANSF_FILES", 'Transf. arquivos');
define("IMFILTER_MSG_FILTER_CONTACTS", 'Filtrar contatos');
define("IMFILTER_MSG_VISIBILITY", 'Filtro de Contatos');
define("IMFILTER_MSG_ALLOWED_IMS", 'Serviço de IM');
define("IMFILTER_MSG_OPTIONS", 'Permissões e Opções');
define("IMFILTER_MSG_ALLOW_ACCESS", 'Permitir o acesso');
define("IMFILTER_MSG_ALLOW_TRANSF_FILE", "Permitir transferência de arquivos");
define("IMFILTER_MSG_ALLOW_SEND_FILE", 'Permitir envio de arquivos para qualquer usuário');
define("IMFILTER_MSG_ALLOW_RECV_FILE", 'Permitir recebimento de arquivos de qualquer usuário');
define("IMFILTER_MSG_ALLOW_WINK", 'Permitir o uso de efeitos multimídia (winks)');
define("IMFILTER_MSG_SAVE_GROUP_MSG", 'Gravar conversas (chats)');
define("IMFILTER_MSG_SAVE_USER_MSG", 'Gravar conversas (chats)');
define("IMFILTER_MSG_BLOCK_OFFLINE_MSG", 'Permitir mensagens offline');
define("IMFILTER_MSG_WITHOUT_RESTRICT", 'Sem restrição');
define("IMFILTER_MSG_WITH_RESTRICT", 'Filtrar contatos');
define("IMFILTER_MSG_ALLOW_LOCAL_USERS", 'Permitir contato entre usuários locais');
define("IMFILTER_MSG_ALLOW_LOCAL_FILE_TRANSF", 'Permitir transferência de arquivos somente entre usuários locais');
define("IMFILTER_MSG_ALLOW_EMAIL", 'Permitir contato');
define("IMFILTER_MSG_ALLOWED_LIST", 'Contatos permitidos');
define("IMFILTER_MSG_BLOCK_BT", 'Bloquear &#9660;');
define("IMFILTER_MSG_BLOCKED_LIST", 'Contatos bloqueados');
define("IMFILTER_MSG_ALLOW_BT", 'Permitir &#9650;');
define("IMFILTER_MSG_TITLE_GRP", 'Regra do Grupo');
define("IMFILTER_MSG_TITLE_EXC", 'Regra do Usuário');
define("IMFILTER_MSG_DFUSER", "[Usuários não listados]");
define("IMFILTER_MSG_LOGCHAT_TITLE", "Aviso de gravação");
define("IMFILTER_MSG_DEFAULT_RULE1", "<strong>Regra padrão para usuários não listados</strong>");
define("IMFILTER_MSG_DEFAULT_RULE2", "Esta regra aplica-se a todos os usuários que não pertencem a nenhum grupo e que não possuam uma regra específica associada.");
define("IMFILTER_MSG_SKYPEMSN_OPTIONS", "Opções para Skype e MSN");
define("IMFILTER_MSG_SKYPE_CONFIG", "Configurações gerais");
define("IMFILTER_MSG_SKYPE_OPTIONS", "Opções exclusivas para Skype");
define("IMFILTER_MSG_SKYPE_CONFIG_MULTIMIDIA", "Configurações de multimídia");
define("IMFILTER_MSG_ALLOW_AUDIOVIDEO", "Permitir uso de áudio/vídeo");
define("IMFILTER_MSG_ALLOW_PHONECALL", "Permitir ligações para telefones");
define("IMFILTER_MSG_SAVE_CALLS", "Gravar áudio das chamadas Skype");
define("IMFILTER_MSG_SAVE_PHONE_CALLS", "Gravar ligações para telefones");
define("IMFILTER_MSG_MSN_OPTIONS", "Opções exclusivas para MSN");
define("IMFILTER_MSG_LOGCHAT_TITLE2", "Aviso de gravação de conversa (somente para Agentes WTM anteriores à versão 2.0)");
define("IMFILTER_MSG_LOGCHAT_ENABLE", "Ativar");
define("IMFILTER_MSG_LOGCHAT_TEXT", 'Texto do Aviso');
define("IMFILTER_ERR_INVALID_LOGIN", "Login inválido.");
define("IMFILTER_MSG_TO_GROUP", " para o grupo </i>\"");
define("IMFILTER_MSG_ALLOW_SKYPE", 'Permitir uso de Skype');
define("IMFILTER_MSG_ALLOW_MSN", 'Permitir MSN / Live Messenger');
define("IMFILTER_MSG_FILTER_TO_GROUP", "Fitlro de contatos para o grupo </i>\"");
define("IMFILTER_MSG_CONCTACT_LOGIN", "Login do contato");
define("IMFILTER_MSG_NOTIFICATION", "Winco Talk Manager informa: Esta conversa está sendo gravada pela gerência.");
define("IMFILTER_MSG_NOTIFICATION2", "<br /><strong>Obs.:</strong> A mensagem acima pode ser personalizada em outras versões do Winco Talk Manager.");
define("IMFILTER_MSG_ACTKEY", 'Código de Ativação');
define("IMFILTER_MSG_CODE", 'Código');
define("IMFILTER_MSG_NEWCODE", 'Novo código');
define("IMFILTER_MSG_FEATURE_WTMPRO", " <i>(versão WTM PRO)</i>");
define("IMFILTER_MSG_UNAVAIBLE_VERSION", " <i>(indisponível nesta versão)</i>");
define("IMFILTER_MSG_GROUPS_TXT", "<br /><strong>Marque na lista abaixo os grupos de usuários que poderão acessar serviços de IM (Skype e MSN).<br />Em seguida, configure o controle de acesso para cada um dos grupos selecionados.<br /><br />OBS.: Para grupos pertencentes ao domínio do AD é preciso cadastrar os logins conforme descrito neste</strong> <a target=\"_blank\" href=\"http://winconnection.winco.com.br/suporte/suporte-winconnection-7/tutoriais-winconnection-7/como-estabelecer-credenciais-do-msn-skype-para-os-usuarios-de-um-dominio-active-directory-importado-pelo-winconnection/\">link</a>.");
define("IMFILTER_MSG_USERS_TXT", "<br /><strong>Cadastre na lista abaixo os usuários de Skype e MSN que poderão acessar estes serviços.<br />Em seguida, configure as permissões de acesso para cada um destes usuários.<br /><br />OBS.: As Permissões por Usuário tem precedência sobre as Permissões por Grupo.</strong>");
define("IMFILTER_MSG_PERM_YES", "Sim");
define("IMFILTER_MSG_PERM_NO", "Não");
define("IMFILTER_MSG_PERM_ALL", "Todas");
define("IMFILTER_MSG_GEN_TITLE", "<strong>Controle de conexões para o serviço MSN / Live Messenger:</strong><br /><br />");
define("IMFILTER_MSG_GEN_TEXT1", "<u>Quando o Winconnection é o gateway padrão</u>");
define("IMFILTER_MSG_GEN_TEXT2", 'Interceptar os acessos no NAT de Saída');
define("IMFILTER_MSG_GEN_TEXT3", "<u>Nos outros casos</u>");
define("IMFILTER_MSG_GEN_TEXT4", "* A interceptação também pode ser feita por DNS, <a href=\"javascript:form1do_action('link')\">veja como configurar o servidor de nomes do dominio</a>");
define("IMFILTER_MSG_GEN_TEXT5", "<strong>Controle de conexões para o serviço Skype:</strong><br /><br />");
define("IMFILTER_MSG_GEN_TEXT6", "<u>Quando o Winconnection é o gateway padrão</u>");
define("IMFILTER_MSG_GEN_TEXT7", '&#8226; O acesso deve ser configurado no NAT de Saída');
define("IMFILTER_MSG_GEN_TEXT8", "<u>Nos outros casos</u>");
define("IMFILTER_MSG_GEN_TEXT9", '&#8226; O controle do acesso será realizado pelo próprio agente Winconnection instalado nas estações de trabalho');
define("IMFILTER_MSG_LINK", "Crie uma zona de \"forward lookup\" com o nome <strong>messenger.hotmail.com</strong>, e crie nesta zona um registro \"A\", deixando o nome do host vazio e colocando o IP do servidor Winconnection no registro criado.");
define("IMFILTER_MSK_LINK_TITLE", "Configuração DNS para interceptar conexões MSN");
define("IMFILTER_MSG_ALTKEY", "Senha de Alteração/Desinstalação do Agente WTM");
define("IMFILTER_MSG_LABEL_PASS", "A senha abaixo será pedida pelo Agente WTM sempre que ele for configurado, encerrado ou desinstalado.");
define("IMFILTER_MSG_LABEL_NOPASS","Deixe em branco caso não deseje usar uma senha para estas funções.");
define("IMFILTER_MSG_ALERT_SPACE", "A senha de Alteração/desintalação não pode conter espaços.");
define("IMFILTER_MSG_ADD_LOG_EMPTY", '<< vazio >>');
define("IMFILTER_MSG_ADD_LOG_GROUPS", 'GRUPOS: ');
define("IMFILTER_MSG_ADD_LOG_BEFORE", 'ANTES: ');
define("IMFILTER_MSG_WRONG_LOGIN_SKYPE", "O campo Login deve ser preenchido com o nome mostrado no perfil do usuário (Nome Skype), e não com o e-mail utilizado para efetuar o login do Skype. Por exemplo, <i>live:user</i> está correto, mas <i>user@hotmail.com</i> está incorreto.");
define("IMFILTER_MSG_AGENT_MIN_VERSION", "Versão mínima permitida para o Agente WTM");
define("IMFILTER_MSG_AGENT_MIN_VERSION_ALERT", '
Para bloquear versões antigas do Agente WTM, informe neste campo a <strong>versão mínima permitida</strong>.

Se um de seus usuários tentar se conectar com uma versão inferior à esta, o Skype será bloqueado e um aviso será exibido solicitando a atualização do Agente <i>(este aviso só será exibido a partir da versão 2.0)</i>.
 
Obs.:

- A versão informada deve conter apenas números e pontos, sendo necessário substituir "a" por "1", "b" por "2" e assim por diante. 

Para as versões 2.1.<strong>b</strong> e 2.2.<strong>a</strong>, por exemplo, digite 2.1.<strong>2</strong> e 2.2.<strong>1</strong> respectivamente.

- Se este campo for deixado em branco, qualquer versão do Agente WTM será aceita.

- Se este campo for preenchido com uma versão maior que a atual, nenhum Agente WTM será permitido.

Verifique a última versão do Agente WTM em <a href="https://talkmanager.winco.com.br/agente-wtm-release-notes/" target="_blank">https://talkmanager.winco.com.br/agente-wtm-release-notes/</a>
');
define("IMFILTER_ERR_INVALID_AGENT_VERSION", 'A versão informada deve conter apenas números e pontos, sendo necessário substituir <strong>a</strong> por <strong>1</strong>, <strong>b</strong> por <strong>2</strong> e assim por diante.

As versões 2.1.<strong>b</strong> e 2.2.<strong>a</strong>, por exemplo, devem ser informadas como 2.1.<strong>2</strong> e 2.2.<strong>1</strong>');
define("IMFILTER_ERR_INVALID_AGENT_VERSION2", 'A versão mínima informada deve ser 2.0 ou posterior, verifique e tente novamente.');

// IMSRV
define("IMSRV_MSG_TEXT", 'Com o Winco Messenger, você pode trocar mensagens de texto e arquivos entre seus colegas de trabalho sem ter que permitir o uso de programas como o MSN, que acabam sendo usados para bater papo com os amigos e diminuindo a produtividade.');

// MAIL_DISPATCHER
define("MAIL_DISPATCHER_MSG_AV_AUTO", "detecção automática");
define("MAIL_DISPATCHER_MSG_AV_NONE", "desativar anti-vírus");
define("MAIL_DISPATCHER_MSG_AV_AVG", 'AVG');
define("MAIL_DISPATCHER_MSG_MS_FAST", "Mais rápido");
define("MAIL_DISPATCHER_MSG_MS_LEAST_CPU", "Menos CPU");
define("MAIL_DISPATCHER_MSG_MS_LEAST_DISK_SPACE", "Menos espaço em disco");
define("MAIL_DISPATCHER_MSG_MS_LEAST_MEMORY", "Menos memória");
define("MAIL_DISPATCHER_MSG_MS_LEAST_NET", "Menos uso de rede");
define("MAIL_DISPATCHER_MSG_MS_MOST_ACCURATE", "Mais acurado");
define("MAIL_DISPATCHER_MSG_MS_SAFE", "Mais seguro");
define("MAIL_DISPATCHER_MSG_MS_SERVER", "Servidor");
define("MAIL_DISPATCHER_MSG_RULES_NO_ACTION", "Nenhuma ação");
define("MAIL_DISPATCHER_MSG_RULES_ACCEPT", "Aceitar mensagem");
define("MAIL_DISPATCHER_MSG_RULES_MARK", "Marcar assunto");
define("MAIL_DISPATCHER_MSG_RULES_QUA", "Mover para quarentena");
define("MAIL_DISPATCHER_MSG_RULES_DEL", "Deletar mensagem");
define("MAIL_DISPATCHER_MSG_RULES_COPY", "Copiar para");
define("MAIL_DISPATCHER_MSG_RULES_MOVE", "Mover para");
define("MAIL_DISPATCHER_MSG_RULES_RESP_MSG", "Responder usando a mensagem");
define("MAIL_DISPATCHER_MSG_RULES_RESP_DEL", "Responder e descartar");
define("MAIL_DISPATCHER_MSG_MF", 'Filtro de E-mail');
define("MAIL_DISPATCHER_MSG_KEEP_MSG", "Manter mensagens na quarentena por [dias]");
define("MAIL_DISPATCHER_MSG_KEEP_MSG_DAYS", 'dias');
define("MAIL_DISPATCHER_MSG_ALLOW_PHP", "Habilitar Interface PHP onDispatch");
define("MAIL_DISPATCHER_MSG_AV", 'Anti-vírus');
define("MAIL_DISPATCHER_MSG_MAKER", 'Fabricante');
define("MAIL_DISPATCHER_MSG_NOTIFY_POSTMASTER", "Notificar o postmaster quando um vírus for encontrado em uma rede confiável");
define("MAIL_DISPATCHER_MSG_WHITELIST", 'Endereços de e-mail que não serão verificados por vírus');
define("MAIL_DISPATCHER_MSG_MAIL_ADDRESS", "E-mail");
define("MAIL_DISPATCHER_MSG_MS", 'Anti-SPAM');
define("MAIL_DISPATCHER_MSG_ACTIVE_SPAM", "Ativar o SpamCatcher da MailShell");
define("MAIL_DISPATCHER_MSG_LICENSE", 'Licença');
define("MAIL_DISPATCHER_MSG_PROFILE", 'Perfil');
define("MAIL_DISPATCHER_MSG_RULE", 'Regra global para SPAM');
define("MAIL_DISPATCHER_MSG_PONTUATION", 'Ao encontrar mensagens com pontuação acima de');
define("MAIL_DISPATCHER_MSG_OPTIONS", 'Opções');
define("MAIL_DISPATCHER_MSG_ACTION", 'Ação');
define("MAIL_DISPATCHER_MSG_SETTINGS", 'Configurações');
define("MAIL_DISPATCHER_MSG_GLOBAL_RULES", 'Regras Globais');
define("MAIL_DISPATCHER_MSG_MSG_SIZE", 'Tamanho máximo das mensagens');
define("MAIL_DISPATCHER_MSG_INT_MSG", 'Mensagens internas [kb]');
define("MAIL_DISPATCHER_MSG_EXT_MSG", 'Mensagens externas[kb]');
define("MAIL_DISPATCHER_MSG_PS_LIMIT", "PS: '0' significa sem limite");
define("MAIL_DISPATCHER_MSG_ATT_FILTER", 'Filtro de anexos (extensões de arquivos)');
define("MAIL_DISPATCHER_MSG_DENIED_EXT", 'Extensões de arquivos (separado por vírgula)');
define("MAIL_DISPATCHER_MSG_BLOCK", 'Bloquear');
define("MAIL_DISPATCHER_MSG_ALLOW", 'Permitir');
define("MAIL_DISPATCHER_MSG_ALLOW_EXT", "Permitir, ao invés de bloquear");
define("MAIL_DISPATCHER_MSG_RULES", 'Regras de E-mail');
define("MAIL_DISPATCHER_MSG_STRING", "Nome");
define("MAIL_DISPATCHER_MSG_GP_RULES", 'Regras por Grupo');
define("MAIL_DISPATCHER_MSG_GROUPS", 'Grupos');
define("MAIL_DISPATCHER_MSG_IN_SET", "Configuração de Entrada");
define("MAIL_DISPATCHER_MSG_OUT_SET", "Configuração de Saída");
define("MAIL_DISPATCHER_MSG_IN_SET2", "Entrada");
define("MAIL_DISPATCHER_MSG_OUT_SET2", "Saída");
define("MAIL_DISPATCHER_ERR_MAXQUARANTINE", "Tempo de permanência da mensagem na quarentena");
define("MAIL_DISPATCHER_ERR_MAX_INT", "Tamanho máximo das mensagens internas");
define("MAIL_DISPATCHER_ERR_MAX_EXT", "Tamanho máximo das mensagens externas");
define("MAIL_DISPATCHER_MSG_NOAUTH", "<< Usuários não autenticados >>");
define("MAIL_DISPATCHER_ERR_NOAUTH", "Usuários não-autenticados não possuem configuração de entrada.");
define("MAIL_DISPATCHER_MSG_ACTIVATE_AVG", 'Ativar escaneamento de e-mail utilizando o AVG anti-vírus');
define("MAIL_DISPATCHER_ERR_LICENSE", "Licença do SpamCatcher");
define("MAIL_DISPATCHER_ERR_SPAMSCORE", "Pontuação do SpamCatcher");
define("MAIL_DISPATCHER_MSG_GROUP_TEXT", 'Selecione os grupos abaixo para alterar as configurações específicas para aquele grupo. Todos os grupos com acesso a e-mail estão listados.');
define("MAIL_DISPATCHER_MSG_ALLOW_ALL_EXT", "Permitir todas as extensões");
define("MAIL_DISPATCHER_MSG_ALLOW_EXT_BELOW", "Permitir as extensões abaixo");
define("MAIL_DISPATCHER_MSG_BLOCK_ALL_EXT", "Bloquear todas as extensões");
define("MAIL_DISPATCHER_MSG_BLOCK_EXT_BELOW", "Bloquear as extensões abaixo");
define("MAIL_DISPATCHER_MSG_EXTENSIONS", 'Extensões');
define("MAIL_DISPATCHER_MSG_PS_EXT", 'PS: separe as extensões por vírgula');
define("MAIL_DISPATCHER_ERR_EXTENSIONS", 'Extensões de arquivos');
define("MAIL_DISPATCHER_MSG_MAIL_WHITELIST", 'Whitelist de E-mails');
define("MAIL_DISPATCHER_MSG_MAIL_RULES", "Regras de E-mail");
define("MAIL_DISPATCHER_MSG_NEW_RULES", "Regras Avançadas e por usuário");
define("MAIL_DISPATCHER_MSG_OLD_RULES", "Regras globais e por grupo");
define("MAIL_DISPATCHER_MSG_EXEC_ACTION_BELOW", ', executar a ação abaixo:');
define("MAIL_DISPATCHER_MSG_HELP_CREATE_RULES", "Veja como criar regras de SPAM por destinatários e/ou remetentes");
define("MAIL_DISPATCHER_MSG_HELP_CREATE_RULES_TXT", "Para criar regras de SPAM diferenciadas por destinatário, siga os procedimentos de acordo com o modelo de regras utilizado na sua instalação (selecionável na aba 'Regras de
E-mail').

<strong>1) Usando regras avançadas e por usuário:</strong>
Utilize o campo 'Pontuação do Anti-Spam', na aba 'Mais filtros' na hora que estiver criando a regra de e-mail.
 
<strong>2) Usando regras globais e por grupo:</strong>
Utilize o campo próprio para isso nas regras de entrada dos grupos.");
define("MAIL_DISPATCHER_MSG_HELP_TITLE", "Regras de SPAM");
define("MAIL_DISPATCHER_MSG_NUM_THREADS", "Número de entregas simultâneas para destinos remotos");
define("MAIL_DISPATCHER_MSG_DEPRECATED_ALERT", "ATENÇÃO: Este tipo de regra será descontinuado em breve. Saiba mais.");
define("MAIL_DISPATCHER_MSG_DEPRECATED_ALERT2", "<br />Com a incorporação das <strong>'Regras Avançadas e por usuário'</strong>, as <strong>'Regras globais e por grupo'</strong> tornaram-se obsoletas e serão retiradas do Winconnection nas próximas versões.<br /><br />Recomendamos que você comece a utilizar o quanto antes as <strong>'Regras Avançadas e por usuário'</strong>, que são muito mais eficientes e mais fáceis de configurar.");

// MAIL_DISPATCHER_group_config
define("MAIL_DISPATCHER_GROUP_MSG_RULES_ACCEPT", "Aceitar mensagem");
define("MAIL_DISPATCHER_GROUP_MSG_RULES_MARK", "Marcar assunto");
define("MAIL_DISPATCHER_GROUP_MSG_RULES_QUA", "Mover para quarentena");
define("MAIL_DISPATCHER_GROUP_MSG_RULES_DEL", "Deletar mensagem");
define("MAIL_DISPATCHER_GROUP_MSG_RULES_COPY", "Copiar para");
define("MAIL_DISPATCHER_GROUP_MSG_RULES_MOVE", "Mover para");
define("MAIL_DISPATCHER_GROUP_ERR_RECV_GRP", 'Erro ao tentar receber a lista de Grupos!');
define("MAIL_DISPATCHER_GROUP_ERR_RECV_CONFIG_GRP", 'Erro ao tentar receber a configuração do grupo!');
define("MAIL_DISPATCHER_GROUP_MSG_MSG_SIZE", 'Tamanho máximo das mensagens');
define("MAIL_DISPATCHER_GROUP_MSG_INT_DOM", 'Domínio interno');
define("MAIL_DISPATCHER_GROUP_MSG_EXT_DOM", 'Domínio externo');
define("MAIL_DISPATCHER_GROUP_MSG_PS_LIMIT", "PS: '0' significa sem limite");
define("MAIL_DISPATCHER_GROUP_MSG_MS", 'Anti-SPAM');
define("MAIL_DISPATCHER_GROUP_MSG_PONTUATION", 'Pontuação');
define("MAIL_DISPATCHER_GROUP_MSG_ACTION", 'Ação');
define("MAIL_DISPATCHER_GROUP_MSG_RULES", 'Regras');
define("MAIL_DISPATCHER_GROUP_MSG_STRING", "Nome");
define("MAIL_DISPATCHER_GROUP_MSG_ATT_INT", 'Filtro de anexo - Domínio interno');
define("MAIL_DISPATCHER_GROUP_MSG_ATT_EXT", 'Filtro de anexo - Domínio externo');
define("MAIL_DISPATCHER_GROUP_MSG_DENIED_EXT", 'Extensões de arquivos (separado por vírgula)');
define("MAIL_DISPATCHER_GROUP_MSG_ALLOW_EXT", "Permitir, ao invés de bloquear");
define("MAIL_DISPATCHER_GROUP_MSG_MAX_SIZE_INT", "Tamanho máximo das mensagens de domínios internos");
define("MAIL_DISPATCHER_GROUP_MSG_MAX_SIZE_EXT", "Tamanho máximo das mensagens de domínios externos");
define("MAIL_DISPATCHER_GROUP_MSG_MAX_SIZE", "Tamanho [Kb]");
define("MAIL_DISPATCHER_GROUP_MSG_TITLE", "Configuração de Entrada");

// MAIL_DISPATCHER_out_group_config
define("MAIL_DISPATCHER_OUT_CONFIG_ERR_RECV_CONFIG_GRP", 'Erro ao tentar receber a configuração do grupo!');
define("MAIL_DISPATCHER_OUT_CONFIG_OUT_SETTINGS", 'Configurações de saída');
define("MAIL_DISPATCHER_OUT_CONFIG_MAX_SIZE", "Tamanho máximo das mensagens: [kB]");
define("MAIL_DISPATCHER_OUT_CONFIG_PS_LIMIT", "PS: '0' significa sem limite");
define("MAIL_DISPATCHER_OUT_CONFIG_DENY_EXT", 'Extensões de arquivos (separado por vírgula)');
define("MAIL_DISPATCHER_OUT_CONFIG_ALLOW_EXT", "Permitir, ao invés de bloquear");
define("MAIL_DISPATCHER_OUT_CONFIG_USE_SIGN", 'Usar assinatura HTML');
define("MAIL_DISPATCHER_OUT_CONFIG_SIGN", '<b>Assinatura de E-mail</b>');
define("MAIL_DISPATCHER_OUT_CONFIG_BLOCK_SEND", 'Bloquear envio de e-mail para domínios externos');
define("MAIL_DISPATCHER_OUT_TITLE", 'Configuração de Saída');

// MAIL_DISPATCHER_rules
define("MAIL_DISPATCHER_RULES_MSG_RULES_ACCEPT", "Aceitar mensagem");
define("MAIL_DISPATCHER_RULES_MSG_RULES_MARK", "Marcar assunto");
define("MAIL_DISPATCHER_RULES_MSG_RULES_QUA", "Mover para quarentena");
define("MAIL_DISPATCHER_RULES_MSG_RULES_DEL", "Deletar mensagem");
define("MAIL_DISPATCHER_RULES_MSG_RULES_COPY", "Copiar para");
define("MAIL_DISPATCHER_RULES_MSG_RULES_MOVE",  "Mover para");
define("MAIL_DISPATCHER_RULES_MSG_RULES_RESP_MSG", "Responder usando a mensagem");
define("MAIL_DISPATCHER_RULES_MSG_RULES_RESP_DEL", "Responder e descartar");
define("MAIL_DISPATCHER_RULES_MSG_FROM", "De");
define("MAIL_DISPATCHER_RULES_MSG_TO", "Para");
define("MAIL_DISPATCHER_RULES_MSG_CC", "Cc");
define("MAIL_DISPATCHER_RULES_MSG_DATE", "Data");
define("MAIL_DISPATCHER_RULES_MSG_SUBJECT", "Assunto");
define("MAIL_DISPATCHER_RULES_MSG_PRIORITY", "Prioridade");
define("MAIL_DISPATCHER_RULES_MSG_ORIG_ADDRESS", "Endereço original");
define("MAIL_DISPATCHER_RULES_MSG_END_ADDRESS", "Endereço final");
define("MAIL_DISPATCHER_RULES_MSG_MFROM", "E-mail de");
define("MAIL_DISPATCHER_RULES_MSG_SENDER_IP", "IP do remetente");
define("MAIL_DISPATCHER_RULES_MSG_SIZE", "Tamanho em bytes");
define("MAIL_DISPATCHER_RULES_MSG_OP_CONTAIN", "tem toda(s) a(s) palavra(s)");
define("MAIL_DISPATCHER_RULES_MSG_OP_NOT_CONTAIN", "não tem toda(s) a(s) palavra(s)");
define("MAIL_DISPATCHER_RULES_MSG_OP_CONTAIN_ANY", "tem alguma das palavras");
define("MAIL_DISPATCHER_RULES_MSG_OP_NOT_CONTAIN_ANY", "não tem nenhuma das palavras");
define("MAIL_DISPATCHER_RULES_MSG_OP_CONTAIN_EXACT", "tem a frase");
define("MAIL_DISPATCHER_RULES_MSG_OP_NOT_CONTAIN_EXACT", "não tem a frase");
define("MAIL_DISPATCHER_RULES_MSG_OP_EQUAL", "igual a");
define("MAIL_DISPATCHER_RULES_MSG_OP_NOT_EQUAL", "diferente de");
define("MAIL_DISPATCHER_RULES_MSG_OP_START", "começa com");
define("MAIL_DISPATCHER_RULES_MSG_OP_NOT_START", "não começa com");
define("MAIL_DISPATCHER_RULES_MSG_OP_END", "termina com");
define("MAIL_DISPATCHER_RULES_MSG_OP_NOT_END", "não termina com");
define("MAIL_DISPATCHER_RULES_MSG_OP_IN_LIST", "na lista");
define("MAIL_DISPATCHER_RULES_MSG_OP_NOT_IN_LIST", "não está na lista");
define("MAIL_DISPATCHER_RULES_MSG_OP_RECENT", "a partir de");
define("MAIL_DISPATCHER_RULES_MSG_OP_OLD", "mais antiga que");
define("MAIL_DISPATCHER_RULES_MSG_OP_GREATER", "maior que");
define("MAIL_DISPATCHER_RULES_MSG_OP_LESS", "menor que");
define("MAIL_DISPATCHER_RULES_MSG_OP_CONTAIN_VALUE", "contém o valor");
define("MAIL_DISPATCHER_RULES_MSG_OP_NOT_CONTAIN_VALUE", "não contém o valor");
define("MAIL_DISPATCHER_RULES_MSG_BASIC_INFO", 'Informação básica');
define("MAIL_DISPATCHER_RULES_MSG_NAME", "Nome");
define("MAIL_DISPATCHER_RULES_MSG_ACTION", 'Ação');
define("MAIL_DISPATCHER_RULES_MSG_CRITERION", 'Critério');
define("MAIL_DISPATCHER_RULES_MSG_FIELD", 'Campo');
define("MAIL_DISPATCHER_RULES_MSG_COND", 'Condição');
define("MAIL_DISPATCHER_RULES_MSG_VALUE", 'Valor');
define("MAIL_DISPATCHER_RULES_MSG_MEET_CRITERION", 'Atender a todos os critérios abaixo');
define("MAIL_DISPATCHER_RULES_ERR_VALUE", 'O campo valor não pode ser nulo.');
define("MAIL_DISPATCHER_RULES_ERR_NUM_RULE", 'É preciso criar pelo menos uma regra antes de salvar.');
define("MAIL_DISPATCHER_RULES_MSG_DATE_DIV", "/");
define("MAIL_DISPATCHER_RULES_ERR_DATE", 'Formato da data: dd/mm/aaaa');
define("MAIL_DISPATCHER_RULES_MSG_DT_FORMAT", 'd/m/Y');
define("MAIL_DISPATCHER_RULES_MSG_DT_EXPRESSION", "/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/");
define("MAIL_DISPATCHER_RULES_MSG_RULE", 'Regra');
define("MAIL_DISPATCHER_RULES_MSG_INVALID_CHAR", 'O nome da regra não pode conter o caracter $.');
define("MAIL_DISPATCHER_RULES_TITLE", 'Regra de E-mail');

// MAIL_DISPATCHER_rules7
define("MAIL_DISPATCHER_RULES7_ACTION_PASS", "Aceitar mensagem");
define("MAIL_DISPATCHER_RULES7_ACTION_TAG", "Marcar assunto da mensagem");
define("MAIL_DISPATCHER_RULES7_ACTION_DELETE", "Excluir mensagem");
define("MAIL_DISPATCHER_RULES7_ACTION_SIGN", "Adicionar assinatura na mensagem");
define("MAIL_DISPATCHER_RULES7_ACTION_MOVE", "Mover mensagem para quarentena");
define("MAIL_DISPATCHER_RULES7_ACTION_COPY", "Copiar mensagem para outro destinatário");
define("MAIL_DISPATCHER_RULES7_ACTION_MOVE_RC", "Mover mensagem para outro destinatário");
define("MAIL_DISPATCHER_RULES7_ACTION_MOVE_FOLDER", "Mover mensagem para a pasta IMAP do usuário");
define("MAIL_DISPATCHER_RULES7_ACTION_MOVE_FOLDER2", "Mover mensagem para a pasta IMAP");
define("MAIL_DISPATCHER_RULES7_ACTION_CHANGE_SENDER", "Alterar o remetente da mensagem");
define("MAIL_DISPATCHER_RULES7_ACTION_REPLY", "Responder mensagem");
define("MAIL_DISPATCHER_RULES7_ACTION_REPLY_DISCARD", "Responder mensagem e excluí-la");
define("MAIL_DISPATCHER_RULES7_ACTION_ALLOW_ALL_ATTACH", "Permitir todas as extensões de arquivos");
define("MAIL_DISPATCHER_RULES7_ACTION_ALLOW_SPECIFIC_ATTACH", "Permitir apenas as extensões especificadas");
define("MAIL_DISPATCHER_RULES7_ACTION_BLOCK_ALL_ATTACH", "Bloquear todas as extensões de arquivos");
define("MAIL_DISPATCHER_RULES7_ACTION_BLOCK_SPECIFIC_ATTACH", "Bloquear apenas as extensões especificadas");
define("MAIL_DISPATCHER_RULES7_ACTION_CHANGE_SENDER", "Alterar o remetente da mensagem");
define("MAIL_DISPATCHER_RULES7_GROUP_MV_CP", 'Mover / Copiar');
define("MAIL_DISPATCHER_RULES7_GROUP_RESP", 'Resposta automática');
define("MAIL_DISPATCHER_RULES7_GROUP_ATT", 'Anexos');
define("MAIL_DISPATCHER_RULES7_SND_INT", "Remetente interno");
define("MAIL_DISPATCHER_RULES7_SND_EXT", "Remetente externo");
define("MAIL_DISPATCHER_RULES7_SND_NET", "Rede");
define("MAIL_DISPATCHER_RULES7_USR", "Usuário");
define("MAIL_DISPATCHER_RULES7_GRP", "Grupo");
define("MAIL_DISPATCHER_RULES7_MAIL", "E-mail");
define("MAIL_DISPATCHER_RULES7_DMN", "Domínio");
define("MAIL_DISPATCHER_RULES7_IP", "IP (ex: 10.20.30.5 ou 10.20.30.1-10.20.30.5)");
define("MAIL_DISPATCHER_RULES7_RCPT_INT", "Destinatário interno");
define("MAIL_DISPATCHER_RULES7_RCPT_EXT", "Destinatário externo");
define("MAIL_DISPATCHER_RULES7_FIELD_SPAM", "Pontuação do Anti-Spam");
define("MAIL_DISPATCHER_RULES7_FIELD_NEW", "Adicionar outro header ...");
define("MAIL_DISPATCHER_RULES7_GENERAL", "Geral");
define("MAIL_DISPATCHER_RULES7_SENDER", "Remetente");
define("MAIL_DISPATCHER_RULES7_RECIPIENT", "Destinatário");
define("MAIL_DISPATCHER_RULES7_OTHER_FILTERS", "Mais filtros");
define("MAIL_DISPATCHER_RULES7_ACTION", "Ação");
define("MAIL_DISPATCHER_RULES7_TXT1", 
"As regras de e-mail permitem ao administrador da rede controlar os e-mails enviados e/ou 
recebidos na sua rede.<br /><br />
É possível filtrar os e-mails por remetentes, destinatários e outros filtros opcionais.<br /><br />
Quando um e-mail é recebido pelo Winconnection (entrando ou saindo da rede), é verificado 
se existe alguma regra para ser aplicada nele.<br /><br />
O primeiro passo é verificar se o remetente definido na regra casa com o remetente do e-mail. 
Se sim, é verificado o destinatário. Se o destinatário também casar, os outros filtros são 
verificados. Se todos os parâmetros casarem, executamos a ação definida na regra.");
define("MAIL_DISPATCHER_RULES7_1_5", 'Passo 1 de 5: ');
define("MAIL_DISPATCHER_RULES7_2_5", 'Passo 2 de 5: ');
define("MAIL_DISPATCHER_RULES7_3_5", 'Passo 3 de 5: ');
define("MAIL_DISPATCHER_RULES7_4_5", 'Passo 4 de 5: ');
define("MAIL_DISPATCHER_RULES7_5_5", 'Passo 5 de 5: ');
define("MAIL_DISPATCHER_RULES7_1_3", 'Passo 1 de 3: ');
define("MAIL_DISPATCHER_RULES7_2_3", 'Passo 2 de 3: ');
define("MAIL_DISPATCHER_RULES7_3_3", 'Passo 3 de 3: ');
define("MAIL_DISPATCHER_RULES7_STEP1", 'Nome para exibição');
define("MAIL_DISPATCHER_RULES7_STEP1_DESC", "Esse nome será exibido na lista de regras");
define("MAIL_DISPATCHER_RULES7_RULE_NAME", 'Nome / descrição');
define("MAIL_DISPATCHER_RULES7_STEP2", 'Selecione o remetente do e-mail');
define("MAIL_DISPATCHER_RULES7_STEP2_DESC", "Você pode adicionar 1 ou mais remetentes a esta regra");
define("MAIL_DISPATCHER_RULES7_ALL", "Todos");
define("MAIL_DISPATCHER_RULES7_LIST_BELOW", "A lista abaixo");
define("MAIL_DISPATCHER_RULES7_ADD_SND", "Adicionar remetente ...");
define("MAIL_DISPATCHER_RULES7_RCPT_LIST", 'Lista de Remetentes');
define("MAIL_DISPATCHER_RULES7_ANY_SND", "Qualquer remetente");
define("MAIL_DISPATCHER_RULES7_DESC1", "Usuário da rede interna autenticado");
define("MAIL_DISPATCHER_RULES7_DESC2", "Usuário não autenticado");
define("MAIL_DISPATCHER_RULES7_STEP3", 'Selecione o destinatário do e-mail');
define("MAIL_DISPATCHER_RULES7_STEP3_DESC", "Você pode adicionar 1 ou mais destinatários a esta regra");
define("MAIL_DISPATCHER_RULES7_ADD_RCPT", "Adicionar destinatário ...");
define("MAIL_DISPATCHER_RULES7_SND_LIST", 'Lista de Destinatários');
define("MAIL_DISPATCHER_RULES7_ANY_RCPT", "Qualquer destinatário");
define("MAIL_DISPATCHER_RULES7_DESC3", "Usuário que não pertence a rede interna");
define("MAIL_DISPATCHER_RULES7_STEP4", 'Mais filtros');
define("MAIL_DISPATCHER_RULES7_STEP4_DESC", "Deseja acrescentar filtros de cabeçalho (header) a esta regra?");
define("MAIL_DISPATCHER_RULES7_STEP4_OP1", "Não");
define("MAIL_DISPATCHER_RULES7_STEP4_OP2", "Sim");
define("MAIL_DISPATCHER_RULES7_NEW_FIELD", 'Header');
define("MAIL_DISPATCHER_RULES7_STEP5", 'Ação');
define("MAIL_DISPATCHER_RULES7_STEP5_DESC", "Qual ação deve ser tomada?");
define("MAIL_DISPATCHER_RULES7_CONT_PROC", 'Continuar processamento das regras');
define("MAIL_DISPATCHER_RULES7_ERR_ADD_SND1", "Preencha o campo com o remetente.");
define("MAIL_DISPATCHER_RULES7_ERR_ADD_SND2", "A opção 'Qualquer remetente' só pode ser adicionada se a lista estiver vazia.");
define("MAIL_DISPATCHER_RULES7_ERR_ADD_SND3", "O remetente não pôde ser adicionado à lista porque a lista possui a opção 'Qualquer remetente'. Para adicioná-lo remova a opção 'Qualquer remetente'.");
define("MAIL_DISPATCHER_RULES7_ERR_ADD_RCPT1", "Preencha o campo com o valor do destinatário.");
define("MAIL_DISPATCHER_RULES7_ERR_ADD_RCPT2", "A opção 'Qualquer destinatário' só pode ser adicionada se a lista estiver vazia.");
define("MAIL_DISPATCHER_RULES7_ERR_ADD_RCPT3", "O destinatário não pôde ser adicionado à lista porque a lista possui a opção 'Qualquer destinatário'. Para adicioná-lo remova a opção 'Qualquer destinatário'.");
define("MAIL_DISPATCHER_RULES7_ERR_NEW_FIELD", "Digite o header");
define("MAIL_DISPATCHER_RULES7_ERR_FIELD", "Digite um valor");
define("MAIL_DISPATCHER_RULES7_ERR_ACTION", "Parâmetro da ação");
define("MAIL_DISPATCHER_RULES7_SIGN_WARN", "<br /><br />OBS: A assinatura modifica o conteúdo da mensagem. É boa prática assinar somente as mensagens de origem interna.");
define("MAIL_DISPATCHER_RULES7_BY_USER", " do usuário ");
define("MAIL_DISPATCHER_RULES7_USER_RULES", 'Regras por Usuário');
define("MAIL_DISPATCHER_RULES7_ENABLE_USER_RULE", 'Aplicar regras dos usuários');
define("MAIL_DISPATCHER_RULES7_TXT2", "O Winconnection 7 possibilita a criação de regras de e-mail específicas para cada usuário.<br /><br />A diferença destas regras para as Regras Avançadas de e-mail é que estas podem ser criadas, editadas e excluidas pelo próprio usuário através do Painel de Controle do Usuário. O administrador do sistema tem total acesso as regras criadas pelos usuários, e também pode criar, editar e excluí-las regras.<br /><br />As regras dos usuários são executadas por último. Sendo assim, uma regra Avançada pode anular uma regra do usuário.");
define("MAIL_DISPATCHER_RULES7_ERR_SETTING_USER_RIGHT", "Erro alterando status do usuário");
define("MAIL_DISPATCHER_RULES7_ERR_GETTING_USER_RIGHT", "Erro obtendo lista de permissões");
define("MAIL_DISPATCHER_RULES7_MSG_FILTERS", "Filtros");
define("MAIL_DISPATCHER_RULES7_ERR_NO_FILTERS", "Adicione pelo menos 1 filtro");
define("MAIL_DISPATCHER_RULES7_MSG_DEFAULT_RULE_NAME", "Minha Regra");
define("MAIL_DISPATCHER_RULES7_MSG_ANY_SENDER", "Qualquer remetente");
define("MAIL_DISPATCHER_RULES7_SENDER_LIST_BELOW", "A lista de remetentes abaixo");
define("MAIL_DISPATCHER_RULES7_MSG_ANY_RCPT", "Qualquer destinatário");
define("MAIL_DISPATCHER_RULES7_RCPT_LIST_BELOW", "A lista de destinatários abaixo");
define("MAIL_DISPATCHER_RULES7_USER_STEP4_DESC", "Adicione pelo menos 1 critério ao filtro");

// MAIL_DISPATCHER_spam_options
define("MAIL_DISPATCHER_SPAM_SPAMCATCHER", 'Spamcatcher');
define("MAIL_DISPATCHER_SPAM_SPAMCATCHER_SET", 'Lista');
define("MAIL_DISPATCHER_SPAM_MAIL", "E-mail");
define("MAIL_DISPATCHER_SPAM_VALUE", 'Novo item:');
define("MAIL_DISPATCHER_SPAM_READFILE", "Ler do arquivo ...");
define("MAIL_DISPATCHER_SPAM_SUCCESS", 'Lista importada com sucesso.');
define("MAIL_DISPATCHER_SPAM_ADVICE", 'Aviso');
define("MAIL_DISPATCHER_SPAM_INVALID_FILE", "Formato de arquivo não suportado.<br/><br/>Salve novamente seu arquivo no Bloco de Notas utilizando a codificação \'ANSI\'.");
define("MAIL_DISPATCHER_SPAM_ERASE_LIST", 'Limpar lista');
define("MAIL_DISPATCHER_SPAM_EXISTING_ITEM", "O item que você está tentando adicionar já existe na lista.");
define("MAIL_DISPATCHER_SPAM_EXIST", "Item existente");
define("MAIL_DISPATCHER_SPAM_ADD_A_ITEM", 'Incluir um item');
define("MAIL_DISPATCHER_SPAM_IMPORT", 'Importar');
define("MAIL_DISPATCHER_SPAM_DEL_ITEM", 'Excluir item');
define("MAIL_DISPATCHER_SPAM_ADD_ITEM_OK", 'Item adicionado com sucesso');
define("MAIL_DISPATCHER_SPAM_TITLE", 'Opções do Anti-SPAM');

// MANAGER
define("MANAGER_MSG_TITLE", "Opções do Administrador");

// NETWORK
define("NETWORK_MSG_CTL_BLOCK", "Bloqueado para todos os serviços");
define("NETWORK_MSG_CTL_CONFIG", "Configurado por serviço");
define("NETWORK_MSG_CTL_ALLOW", "Permitido para todos os serviços");
define("NETWORK_MSG_TYPE_IP_MASK", "IP / Máscara");
define("NETWORK_MSG_TYPE_RANGE", "Range de IPs");
define("NETWORK_MSG_TYPE_ONE_HOST", "Um único host");
define("NETWORK_MSG_CONFIG_ADVANCE", 'Avançado');
define("NETWORK_MSG_NET_NAME", "Nome da rede");
define("NETWORK_MSG_ACCESS_LEVEL", "Acesso a Serviços");
define("NETWORK_MSG_ADDRESS", 'Endereço');
define("NETWORK_MSG_ADDRESS_IP", "Endereço IP");
define("NETWORK_MSG_MASK_END_IP", "Máscara");
define("NETWORK_MSG_EXP_TIME", "Data de expiração");
define("NETWORK_MSG_SECONDS", 'segundos');
define("NETWORK_MSG_CREATOR", "Criador");
define("NETWORK_MSG_COMMENT", "Comentário");
define("NETWORK_MSG_NAME", 'Nome');
define("NETWORK_MSG_BASIC_CONFIG", 'Configurações básicas');
define("NETWORK_MSG_DATE", 'd/m/Y');
define("NETWORK_MSG_DATE_EX", '(dd/mm/yyyy)');
define("NETWORK_MSG_DATE_SEPARATOR", '/');
define("NETWORK_MSG_OTHER", 'Vigência');
define("NETWORK_MSG_OBS", '* A rede será excluida automaticamente na data de expiração.');
define("NETWORK_MSG_TITLE", "Cadastro de Rede Lógica");

// NETWORK_balRules
define("NETWORK_BALRULES_MSG_RULE", "Regra");
define("NETWORK_BALRULES_MSG_TYPE_ONLY", "apenas");
define("NETWORK_BALRULES_MSG_TYPE_PREF", "preferencialmente");
define("NETWORK_BALRULES_ERR_RECV_NET", 'Erro ao tentar receber a lista de Redes!');
define("NETWORK_BALRULES_MSG_IP_LOW", "IP Inicial");
define("NETWORK_BALRULES_MSG_IP_HIGH", "IP Final");
define("NETWORK_BALRULES_MSG_PORT_LOW", "Porta Inicial");
define("NETWORK_BALRULES_MSG_PORT_HIGH", "Porta Final");
define("NETWORK_BALRULES_MSG_BALTYPE", "Utilizar");
define("NETWORK_BALRULES_MSG_INTERFACE_BELOW", 'a(s) interface(s) abaixo');
define("NETWORK_BALRULES_MSG_INTERFACE_LIST", 'Interfaces Externas');
define("NETWORK_BALRULES_ERR_SEL_INTERFACE", 'Selecione pelo menos uma interface.');
define("NETWORK_BALRULES_MSG_TIP", 'Dica de Configuração');
define("NETWORK_BALRULES_MSG_TEXT1", "Para adicionar somente um ip e uma porta, basta repetir seus valores no ip e porta final.");
define("NETWORK_BALRULES_MSG_DESTINATION_CONFIG", 'Configurações de destino');
define("NETWORK_BALRULES_MSG_TEXT2", '<strong>Criando regra para qualquer destino da internet</strong>

IP Inicial: 0.0.0.0
IP Final:   255.255.255.255

<strong>Criando regra para todas as portas</strong>

Porta Inicial: 1
Porta Final:   65535');
define("NETWORK_BALRULES_MSG_SERVICE", 'Serviço');
define("NETWORK_BALRULES_MSG_ANYONE", "Qualquer um");
define("NETWORK_BALRULES_MSG_WEB_FILTER", "Filtro Web");
define("NETWORK_BALRULES_MSG_TPROXY", "Proxy Transparente");
define("NETWORK_BALRULES_MSG_PORTMAP_TCP", "Porta TCP Mapeada");
define("NETWORK_BALRULES_MSG_POPMAP", "Mapeador POP");
define("NETWORK_BALRULES_MSG_SMTP", "Servidor SMTP");
define("NETWORK_BALRULES_MSG_TITLE", "Regra de Balanceamento");

// NETWORK_CFG
define("NETWORK_CFG_MSG_TYPE_ONLY", "apenas");
define("NETWORK_CFG_MSG_TYPE_PREF", "preferencialmente");
define("NETWORK_CFG_ERR_RECV_NET", 'Erro ao tentar receber a lista de Redes!');
define("NETWORK_CFG_MSG_NET_CONFIG", 'Balanceamento de link');
define("NETWORK_CFG_MSG_ENABLE", "Habilitado no modo WRR");
define("NETWORK_CFG_MSG_ALGORITHM", "Habilitado no modo DWRR");
define("NETWORK_CFG_MSG_RULE_LIST", 'Regras de Balanceamento / Roteamento');
define("NETWORK_CFG_MSG_IP_RANGE", "IP destino");
define("NETWORK_CFG_MSG_PORT_RANGE", "Porta");
define("NETWORK_CFG_MSG_BALTYPE", "Balanceamento");
define("NETWORK_CFG_MSG_INTERFACE", "Interfaces");
define("NETWORK_CFG_MSG_TEXT1", "A política de balanceamento e distribuição do uso dos links utiliza os pesos definidos pelo 
usuário na configuração de cada interface para estabelecer a prioridade na escolha do link a ser utilizado.<br/><br/>Além disso, é possível criar regras de utilização dos links, selecionando a interface a ser utilizada quando determinado ip acessar determinada porta.");
define("NETWORK_CFG_MSG_DISABLE", 'Desabilitado');
define("NETWORK_CFG_TITLE", "Balanceamento de Links");

// NETWORK_FW
define("NETWORK_FW_MSG_ENABLE", "Habilitar o Filtro de Pacotes");
define("NETWORK_PS_MSG_ENABLE", "Bloquear o IP (somente com Filtro de Pacotes habilitado)");
define("NETWORK_PS_MSG_THRESHOLD", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Após tentativa número");
define("NETWORK_PS_MSG_BLOCKPERIOD", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Duração do bloqueio (minutos)");
define("NETWORK_FW_MSG_REPLY_PING", "Responder a requisições de ping (ICMP ECHO)");
define("NETWORK_FW_MSG_ALLOW_ACCESS", "Permitir que programas neste computador acessem toda a Internet");
define("NETWORK_FW_MSG_LOG_BLOCKED", "Registrar pacotes bloqueados na janela de LOG");
define("NETWORK_FW_MSG_ENABLE_LOG", 'Ativar o registro de bytes enviados e recebidos na conexão da internet.');
define("NETWORK_FW_MSG_DHCP", 'Permitir configurações de interface externa via DHCP');
define("NETWORK_FW_MSG_TITLE", "Firewall");
define("NETWORK_CID_MSG_ENABLE", 'Ação a ser tomada em caso de detecção');
define("NETWORK_CID_MSG_BLOCKPERIOD", 'Período de bloqueio para de injeção código inválido [minutos]');
define("CID_TYPE_DISABLED", 'ignorar');
define("CID_TYPE_BLOCK_CONNECTION", 'somente a conexão');
define("CID_TYPE_BLOCK_IP", 'o IP ou');
define("NETWORK_FW_MSG_TAB_IPS", "Sistema de Prevenção de Intrusão (IDS/IPS)");
define("NETWORK_FW_MSG_TAB_LOGS", "Logs");
define("NETWORK_FW_MSG_TPROXY", 'Proxy Transparente');
define("NETWORK_FW_MSG_EXPLOITE", 'Injeção de Código Malicioso');
define("NETWORK_FW_MSG_BRUTAL_FORCE", 'Ataque de Força Bruta na Autenticação');
define("NETWORK_FW_MSG_GENERAL", "Configurações gerais de acesso");
define("NETWORK_FW_MSG_OBS", "Observação");
define("NETWORK_FW_MSG_OBS_TXT", "O Winconnection controla automaticamente a abertura de portas do Firewall conforme a necessidade, baseado nas configurações realizadas nos menus de <strong>Conectividade</strong> e de <strong>Serviços</strong>.");
define("NETWORK_FW_MSG_ADVANCED", "Avançado");
define("NETWORK_FW_MSG_BLOCK", "Bloquear");
define("NETWORK_FW_MSG_BLOCK_IP", "Bloquear o IP");
define("NETWORK_FW_MSG_REMEMBER_MINUTES", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Logins falhos são lembrados por (minutos)");
define("NETWORK_FW_ERR_ATTEMPTS_PORTSCAN", "Número de tentativas do Port Scan");
define("NETWORK_FW_ERR_BLOCK_TIME_PORTSCAN", "Duração do bloqueio do Port Scan");
define("NETWORK_FW_ERR_BLOCK_TIME_CODEINJECT", "Duração do bloqueio na Injeção de Código Malicioso");
define("NETWORK_FW_ERR_ATTEMPTS_BFORCE", "Número de tentativas no Ataque de Força Bruta");
define("NETWORK_FW_ERR_BLOCK_TIME_BFORCE", "Tempo de permanência do bloqueio de Ataque de Força Bruta");
define("NETWORK_FW_ERR_BLOCK_TIME_BFORCE2", "Duração do bloqueio do Ataque de Força Bruta");

// NETWORK_IF
define("NETWORK_IF_MSG_INT", 'Interna');
define("NETWORK_IF_MSG_EXT", 'Externa');
define("NETWORK_IF_MSG_DIAL_UP", 'Configurações de Dial-Up');
define("NETWORK_IF_MSG_RESUME", "Resumo");
define("NETWORK_IF_MSG_SUMMARY", 'Resumo da Interface');
define("NETWORK_IF_MSG_NAME", "Nome:");
define("NETWORK_IF_MSG_MAC", "Mac:");
define("NETWORK_IF_MSG_MEDIA", "Tipo de mídia:");
define("NETWORK_IF_MSG_FAULTY", "Está defeituoso:");
define("NETWORK_IF_MSG_INTERFACE_INFO", 'Informações da Interface');
define("NETWORK_IF_MSG_ENABLE", "Gerenciar pelo Winconnection");
define("NETWORK_IF_MSG_IP", "IP padrão");
define("NETWORK_IF_MSG_TYPE", "Tipo:");
define("NETWORK_IF_MSG_USER_WEIGHT", "Prioridade para utilização [1-9999]");
define("NETWORK_IF_MSG_EFF_WEIGHT", "Peso efetivo");
define("NETWORK_IF_MSG_IN_SPEED", "Velocidade nominal de Download (Kbps)");
define("NETWORK_IF_MSG_OUT_SPEED", "Velocidade nominal de Upload (Kbps)");
define("NETWORK_IF_MSG_USE_DIAL_UP", "Usar conexão Dial-Up");
define("NETWORK_IF_MSG_USERNAME", "Usuário");
define("NETWORK_IF_MSG_PASSW", "Senha");
define("NETWORK_IF_ERR_NAT", 'Erro salvando interface NAT.');
define("NETWORK_IF_ERROR", "Interface com defeito");
define("NETWORK_IF_MSG_OBS", "Observação:");
define("NETWORK_IF_MSG_SHARE", "Compartilhar conexão com a internet através dessa interface");
define("NETWORK_IF_MSG_ACTIVE", "Ativo");
define("NETWORK_IF_MSG_INACTIVE", "Inativo/Falha");
define("NETWORK_IF_MSG_STATUS", 'Status:');
define("NETWORK_IF_MSG_BAL_AND_BAND", 'Balanceamento de Carga e Controle de Banda');
define("NETWORK_IF_MSG_AFTERDIAL1", 'Executar o seguinte programa após a conexão');
define("NETWORK_IF_MSG_AFTERDIAL2", 'Caminho completo do programa');
define("NETWORK_IF_MSG_AFTERDIAL3", "* Um exemplo de programa encontra-se no diretório raiz do Winconnection 7 (dial_login.bat).");
define("NETWORK_IF_WARN_NAT", '<storng>Cuidado:</strong> A máscara de rede do compartilhamento da Internet (NAT de saída) foi alterada manualmente em outra oportunidade.
<br/><br/>	           
Agora, a interface de compartilhamento da Internet está sendo alterada. Isto fará com que a referida máscara seja alterada para um valor igual ao usado pela interface selecionada agora.
<br/><br/>
Por favor, após salvar esta configuração, reveja as configurações do NAT de Saída e verifique se o novo valor da máscara é adequado
<br/><br/>
Em caso de dúvidas, cancele a operação.');
define("NETWORK_IF_WARN_NAT_TITLE", 'Atenção');
define("NETWORK_IF_HELP", '
De tempos em tempos o Winconnection realiza testes de conectividade com a interface para verificar se ela esta funcionando corretamente.

Em determinadas situações, o teste pode resultar em falso-positivo e acusar que existe uma falha na interface erroneamente.

Nessas situações, é possível desabilitar a execução dos testes. Porém, fazendo isso você não será alertado sobre eventuais problemas que a interface venha a apresentar.
');
define("NETWORK_IF_DISABLE_TEST", 'Desabilitar');
define("NETWORK_IF_SELECT_IP", "Especificar um endereço IP");
define("NETWORK_IF_WARN", "* Preencha conforme informado pelo seu provedor de acesso");
define("NETWORK_IF_LINK_TEXT_TITLE", 'Teste Periódico de Conectividade');
define("NETWORK_IF_DIAL_UP", 'Conexão Dial-Up');
define("NETWORK_IF_ENABLE", "Ativar automaticamente esta conexão");

// POPMAP
define("POPMAP_MSG_ACC_LIST", 'Lista de contas');
define("POPMAP_MSG_LOGIN", "Login");
define("POPMAP_MSG_POP_SERVER", "Servidor pop");
define("POPMAP_MSG_LOCAL_USER", "Usuário local");
define("POPMAP_MSG_SIMULTANEOS_PROC", "Número de processos simultâneos:");
define("POPMAP_MSG_CHECK_MSG", "Checar mensagens a cada [minutos]:");
define("POPMAP_MSG_MIN", 'minuto(s)');
define("POPMAP_MSG_READ", 'Ler e-mail');
define("POPMAP_ERR_READ", 'Erro lendo mensagens');

// POPMAP_account
define("POPMAP_ACCOUNT_MSG_MBX_INFO", 'Informações da Mailbox');
define("POPMAP_ACCOUNT_MSG_LOGIN", "Login");
define("POPMAP_ACCOUNT_MSG_PASSW", 'Senha');
define("POPMAP_ACCOUNT_MSG_POP_SRV", "Servidor pop");
define("POPMAP_ACCOUNT_MSG_PORT", "Porta");
define("POPMAP_ACCOUNT_MSG_LOCAL_USER", 'Usuário local');
define("POPMAP_ACCOUNT_MSG_CPY_TO", 'Copiar para');
define("POPMAP_ACCOUNT_MSG_ENABLED", "Conta ativada");
define("POPMAP_ACCOUNT_MSG_SSL", "Utilizar conexão segura (SSL)");
define("POPMAP_ACCOUNT_MSG_DISTR_LOCAL", "Distribuir localmente baseado em username");
define("POPMAP_ACCOUNT_MSG_KEEP", "Manter mensagens no servidor");
define("POPMAP_ACCOUNT_MSG_DELETE", "Apagar mensagem após [dias]:");
define("POPMAP_ACCOUNT_MSG_DAYS", "dia(s)");
define("POPMAP_ACCOUNT_USE_ON_SMTP", "Usar estas credenciais para mensagens cujo o remetente seja o cadastrado no campo 'Remetente da mensagem'.");
define("POPMAP_ACCOUNT_SENDER", 'Remetente da mensagem');
define("POPMAP_ACCOUNT_TITLE", 'Conta de E-mail');

// POPSRV
define("POPSRV_MSG_ACT_AS_PROXY", "Atuar como proxy quando for encontrado o caracter separador");
define("POPSRV_MSG_SEPARATOR", "Caracter separador");
define("POPSRV_MSG_ACCESS_CONTROL", "Controle de Acesso");
define("POPSRV_MSG_TEXT1", "Os grupos listados abaixo são os grupos que tem permissão de recebimento de e-mail. Caso queira adicionar um novo grupo, habilite o grupo desejado na configuração de algum domínio do SMTP.");

// PORTMAP
define("PORTMAP_DESTINATION_HOST", "Host ou IP de destino:");
define("PORTMAP_DESTINATION_PORT", "Porta destino:");
define("PORTMAP_REDIR_TYPE", "Tipo de Redirecionamento:");
define("PORTMAP_REDIR_TYPE_DEFAULT", "Padrão");
define("PORTMAP_REDIR_TYPE_RNAT", "NAT Reverso");
define("PORTMAP_REDIR_TYPE_FTP", "Conexão FTP");
define("PORTMAP_REDIR_TYPE_VPNPPTP", "VPN PPTP");

// SMTPSRV
define("SMTPSRV_ERR_GETTING_GROUP_LIST", 'Erro ao tentar receber a lista de Redes.');
define("SMTPSRV_MSG_EXT_NET", "Rede externa");
define("SMTPSRV_MSG_OTHER_DOMAIN", "&ltOutros domínios&gt");
define("SMTPSRV_MSG_SMTPSRV", 'Servidor SMTP');
define("SMTPSRV_MSG_DOMAINS", 'Domínios');
define("SMTPSRV_MSG_SIGN", 'Assinatura');
define("SMTPSRV_MSG_ALLOW_USERS", "Permitir que usuários façam autenticação neste servidor SMTP");
define("SMTPSRV_MSG_RETRANSMISSION", 'Permissões de retransmissão por rede');
define("SMTPSRV_MSG_DOMAINS_SRV", 'Abaixo estão listados os Domínios tratados neste servidor.');
define("SMTPSRV_MSG_DOMAIN_LIST", 'Lista de Domínios');
define("SMTPSRV_MSG_USE_SIGN", 'O Winconnection permite que você utilize uma assinatura padrão de e-mail que será incluída em todos os e-mails enviados.');
define("SMTPSRV_ERR_DEL_DOMAIN", "Este domínio não pode ser apagado.");
define("SMTPSRV_WARN", '<span class="warning">Não é possível instalar o <strong>Servidor SMTP</strong> porque ele depende do serviço <strong>Filtro de E-mail</strong>. <br /><br />Instale o serviço <strong>Filtro de E-mail</strong> primeiro e em seguida instale o <strong>Servidor SMTP</strong>.</span>');

// SMTPSRV_domain
define("SMTP_DOMAIN_ERR_GETTING_GROUP", "Erro obtendo lista de grupos.");
define("SMTP_DOMAIN_ERR_GETTING_MD_CONF", "Erro obtendo configuração do Mail Dispatcher.");
define("SMTP_DOMAIN_MSG_OTHER_DOMAIN", "&ltOutros domínios&gt");
define("SMTP_DOMAIN_MSG_OUT_PARAM", 'Parâmetros de saída');
define("SMTP_DOMAIN_MSG_BASIC_INFO", 'Informações básicas');
define("SMTP_DOMAIN_MSG_NAME", 'Domínio');
define("SMTP_DOMAIN_MSG_ALIAS", 'Aliases (sep. virgulas)');
define("SMTP_DOMAIN_MSG_POSTMASTER", 'E-mail do postmaster');
define("SMTP_DOMAIN_MSG_ADVANCED_INFO", 'Opções avançadas');
define("SMTP_DOMAIN_MSG_VALID_USER", "Validar nome de usuário nas mensagens recebidas");
define("SMTP_DOMAIN_MSG_APPLY_FILTER", "Aplicar regras baseadas em grupo e filtros para este dominio");
define("SMTP_DOMAIN_MSG_SELECT_GROUPS", 'Grupos com permissão para receber e-mail deste domínio');
define("SMTP_DOMAIN_MSG_CMP_MAIL", 'Comparar o e-mail com o e-mail cadastrado na base de dados');
define("SMTP_DOMAIN_MSG_CMP_USER", "Comparar a parte de usuário do e-mail com o nome de usuário da base de dados");
define("SMTP_DOMAIN_MSG_CMP_ALIAS", "Comparar com todos os alias do domínio");
define("SMTP_DOMAIN_MSG_HOST", '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Host');
define("SMTP_DOMAIN_MSG_PORT", '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Porta');
define("SMTP_DOMAIN_MSG_AUTH", "Autenticar usando as credenciais definidas abaixo");
define("SMTP_DOMAIN_MSG_POPMAP_AUTH", "Autenticar usando as credenciais do POPMAP");
define("SMTP_DOMAIN_MSG_LOGIN", '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Login');
define("SMTP_DOMAIN_MSG_PASSW", '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Senha');
define("SMTP_DOMAIN_MSG_SSL", 'Este servidor requer uma conexão segura (SSL)');
define("SMTP_DOMAIN_MSG_DELIVERY_TO", 'Entregar para o seguinte servidor SMTP:');
define("SMTP_DOMAIN_MSG_FORWARD", 'Encaminhar mensagens para o servidor externo se o usuário não existir');
define("SMTP_DOMAIN_MSG_DIRECT_DLIVERY", 'Entregar mensagens diretamente ao destinatário');
define("SMTP_DOMAIN_MSG_DELIVERY_HOST", 'Entregar todas as mensagens ao servidor SMTP abaixo');
define("SMTP_DOMAIN_MSG_NO_AUTH", "Não autenticar");
define("SMTP_DOMAIN_MSG_DELIVERY", 'Entrega');
define("SMTP_DOMAIN_MSG_AUTHENTICATION", 'Autenticação');
define("SMTP_DOMAIN_MSG_POSTMASTER2", 'Postmaster');
define("SMTP_DOMAIN_MSG_MAIL", 'E-mail');
define("SMTP_DOMAIN_MSG_ADVANCED", 'Avançado');
define("SMTP_DOMAIN_MSG_MAIL_VALIDATION", 'Validação dos e-mails');
define("SMTP_DOMAIN_MSG_TTITLE", 'Domínio');
define("SMTP_SEND_TO_USERHOST", "Entregar para o host definido na base de usuário");
define("SMTP_DOMAIN_MSG_NAMEOF", 'Nome do ');
define("SMTP_DOMAIN_MSG_ISINTERNAL", "Considerar este domínio como Domínio Interno");
define("SMTP_DOMAIN_MSG_TITLE_DOMAIN", "Domínio");

// TPROXY
define("TPROXY_MSG_ALL_PROTO", "Todos");
define("TPROXY_MSG_ALL_PORT", "Todas");
define("TPROXY_MSG_ALL_NET", "Toda internet");
define("TPROXY_MSG_BLOCK_DIFF", "diferente");
define("TPROXY_MSG_BLOCK_EQUAL", "igual");
define("TPROXY_MSG_TPROXY", 'Regras de Saída');
define("TPROXY_MSG_PKT_INSPECTION", 'Inspetor de Pacotes');
define("TPROXY_MSG_INT_INTERFACE", 'Interface interna');
define("TPROXY_MSG_IP", "IP");
define("TPROXY_MSG_MASK", "Máscara de rede do compartilhamento de Internet");
define("TPROXY_MSG_ACCESS_CONTROL", 'Controle de Acesso');
define("TPROXY_MSG_ENABLE_AC", "Habilitar Controle de Acesso");
define("TPROXY_MSG_ALLOW_ONLY", 'Permitir apenas os casos abaixo');
define("TPROXY_MSG_DENY", 'Proibir os casos abaixo');
define("TPROXY_MSG_IP_DEST", "Destino");
define("TPROXY_MSG_PROTO", "Protocolo");
define("TPROXY_MSG_PORT", 'Porta');
define("TPROXY_MSG_RULE_VALID", "Origem");
define("TPROXY_MSG_PKT_TEXT1", "O Inspetor de Pacotes analisa as conexões capturadas e tenta identificar o protocolo.<br/><br/>É possível criar regras para bloquear uma conexão de acordo com o protocolo que ela utiliza.");
define("TPROXY_MSG_ENABLE_PKT_INSP", 'Habilitar Inspetor de Pacotes');
define("TPROXY_MSG_DROP", "Derrubar se");
define("TPROXY_FTP_OPTIONS", "Opções FTP");
define("TPROXY_CAPTURE_FTP_CHECK", "Interceptar conexões FTP (porta 21) para que transferências ativas funcionem");
define("TPROXY_CAPTURE_POP_CHECK", 'Interceptar conexões POP (porta 110) para aplicar anti-vírus');
define("TPROXY_MSG_LOG_LEVEL", 'Nível de detalhamento de Log');
define("TPROXY_MSG_ENABLE_TPROXY", 'Habilitar');
define("TPROXY_MSG_RULES", 'Regras de Controle de Acesso');
define("TPROXY_MSG_ACCESS_NOT_LISTED", "Acessos não listados");
define("TPROXY_MSG_OTHERS_ALLOW", "Permitir");
define("TPROXY_MSG_OTHERS_DENNY", "Bloquear");

// TPROXY_rule e TPROXY_rule_pkt
define("TPROXY_RULE_MSG_PROTO_ALL", "Todos");
define("TPROXY_RULE_MSG_PORT_ANY", "Qualquer porta");
define("TPROXY_RULE_MSG_PORT_ONE", "A porta especificada abaixo");
define("TPROXY_RULE_MSG_PORT_RANGE", "A faixa de portas abaixo");
define("TPROXY_RULE_ERR_GET_NET", "Erro obtendo lista de redes.");
define("TPROXY_RULE_MSG_OTHER_NET", 'Outras redes');
define("TPROXY_RULE_MSG_ALL_NET", "Toda internet");
define("TPROXY_RULE_MSG_BELOW_NET", "Definir uma rede");
define("TPROXY_RULE_MSG_ACCESS_RULES", 'Regras de Acesso');
define("TPROXY_RULE_MSG_PROTO", 'Protocolo');
define("TPROXY_RULE_MSG_DEST_PORT", 'Porta destino');
define("TPROXY_RULE_MSG_PORT_FROM", 'Porta / de');
define("TPROXY_RULE_MSG_PORT_TO", 'até');
define("TPROXY_RULE_MSG_RULE_VALID", 'Regra válida para');
define("TPROXY_RULE_MSG_DEST_ADDRESS", 'Endereço destino');
define("TPROXY_RULE_MSG_IP_MASK", 'Endereço IP / Máscara de subrede');
define("TPROXY_RULE_MSG_IP_RANGE", 'Faixa de IPs (endereço 1 até endereço 2)');
define("TPROXY_RULE_MSG_ONE_HOST", 'Um único host');
define("TPROXY_RULE_MSG_IP_START", 'IP inicial');
define("TPROXY_RULE_MSG_IP_END", 'IP final / Máscara');
define("TPROXY_RULE_MSG_SELECT_NET", "Selecione pelo menos uma rede." );
define("TPROXY_RULE_MSG_APP_PROTO", 'Protocolo da aplicação');
define("TPROXY_RULE_MSG_BLOCK_EQUAL", "igual");
define("TPROXY_RULE_MSG_BLOCK_DIF", "diferente");
define("TPROXY_RULE_MSG_ACCESS_CONTROL", "Controle de Acesso");
define("TPROXY_RULE_MSG_NET_FROM_SYS", '- Redes definidas no sistema -');
define("TPROXY_RULE_MSG_ORIGIN", "Origem");
define("TPROXY_RULE_MSG_DEST", "Destino");
define("TPROXY_RULE_MSG_PROTO", "Protocolo");
define("TPROXY_RULE_MSG_UNKNOWN", "desconhecido");
define("TPROXY_RULE_MSG_ACTION", "Ação");
define("TPROXY_RULE_MSG_STEP1", "Passo 1 de ");
define("TPROXY_RULE_MSG_STEP1_TXT1", ": Origem do Acesso");
define("TPROXY_RULE_MSG_STEP1_TXT2", "Selecione abaixo a origem do acesso. Você pode selecionar mais de uma rede.");
define("TPROXY_RULE_MSG_NETS", "Redes de origem");
define("TPROXY_RULE_MSG_STEP2", "Passo 2 de ");
define("TPROXY_RULE_MSG_STEP2_TXT1", ": Destino do acesso");
define("TPROXY_RULE_MSG_STEP2_TXT2", "Selecione abaixo o endereço e a porta destino.");
define("TPROXY_RULE_MSG_ADDRESS", "Endereço");
define("TPROXY_RULE_MSG_PORT", "Porta");
define("TPROXY_RULE_MSG_START_PORT", "Porta inicial");
define("TPROXY_RULE_MSG_END_PORT", "Porta final");
define("TPROXY_RULE_MSG_STEP3", "Passo 3 de ");
define("TPROXY_RULE_MSG_STEP3_TXT1", ": Protocolo");
define("TPROXY_RULE_MSG_STEP3_TXT2", "Selecione abaixo o protocolo.");
define("TPROXY_RULE_MSG_OBS1", '<strong>OBS:</strong> se o protocolo escolhido for <strong>"');
define("TPROXY_RULE_MSG_OBS2", '"</strong>, a porta de destino escolhida não será levada em consideração.');
define("TPROXY_RULE_MSG_STEP4", "Passo 4 de ");
define("TPROXY_RULE_MSG_STEP4_TXT1",  ": Ação");
define("TPROXY_RULE_MSG_STEP4_TT2", "Selecione abaixo a ação a ser tomada pelo Inspetor de Pacotes.");
define("TPROXY_RULE_ERR_PROTO", "O protocolo deve ser informado");
define("TPROXY_RULE_ERR_ORIGIN", "A origem deve ser informada");
define("TPROXY_RULE_MSG_DPI_TXT1", 'Derrubar conexão se protocolo for');
define("TPROXY_RULE_MSG_DPI_TXT2", 'ao protocolo selecionado');
define("TPROXY_RULE_MSG_STEP4_TT3","Selecione abaixo a ação a ser tomada.");
define("TPROXY_RULE_MSG_STEP3_TXT3", "Autenticação de cliente");
define("TPROXY_RULE_MSG_STEP3_TXT4", "(somente para computadores com Agente de Desktop instalado)");
define("TPROXY_RULE_MSG_PATH_OR_EXEC", "path e/ou executável");
define("TPROXY_RULE_MSG_DESC", "descrição");
define("TPROXY_RULE_MSG_ALLOWED_PROGS", 'Programas permitidos');
define("TPROXY_RULE_MSG_ALLOWED_PROGS_ALL", "Qualquer programa");
define("TPROXY_RULE_MSG_ALLOWED_PROGS_SKP", "Skype, desde que monitorado pelo SkypeController");
define("TPROXY_RULE_MSG_ALLOWED_PROGS_STATED", "Programa especificado");
define("TPROXY_RULE_MSG_REMOTE_USER", 'Usuário remoto (opcional)');
define("TPROXY_RULE_ERR_PROG", "Descrição / path do programa");
define("TPROXY_RULE_MSG_THE_ACCESS", " o acesso");
define("TPROXY_RULE_MSG_AUTH_USER", "Usuário");
define("TPROXY_RULE_MSG_AUTH_GRP", "Grupo");

// USER
define("USER_MSG_LOGIN", 'Login');
define("USER_MSG_SKYPE", 'Login(s) Skype');
define("USER_MSG_PASSW", 'Senha');
define("USER_MSG_PASSW_AGAIN", 'Senha (novamente)');
define("USER_ERR_SELECT_GROUP", "Selecione pelo menos um grupo.");
define("USER_ERR_PASSW_DIF", "As senhas são diferentes. ");
define("USER_MSG_VACATION", 'Aviso de férias');
define("USER_MSG_BASIC_INFO", 'Informações básicas');
define("USER_MSG_DESC", 'Nome / Descrição');
define("USER_MSG_USER_ID", 'ID do Usuário');
define("USER_MSG_MAIL", 'E-mail');
define("USER_MSG_AUTH", 'Autenticação');
define("USER_MSG_USE_WIN_PASSW", 'Usar mesma senha do Windows');
define("USER_MSG_USE_PASS_BELOW", 'Usar senha abaixo:');
define("USER_MSG_GROUPS", 'Grupos deste Usuário');
define("USER_MSG_IP_AUTH", 'Autenticação por IP');
define("USER_MSG_ENABLE_IP_AUTH", 'Habilitar autenticação por IP');
define("USER_MSG_HOST_IP", 'IP ou host');
define("USER_MSG_AUTO_REPLY", "Ativar");
define("USER_MSG_ADM", "Administradores");
define("USER_GLOBAL_CFG", "Replicar este usuário para as filiais");
define("USER_MSG_WARNINGAD", '<span class="warning">Este usuário pertence ao AD. Apenas a configuração de <b>Aviso de Férias</b> pode ser editada pelo Winconnection. As demais configurações devem ser editadas diretamente pelo AD.</span>');
define("USER_MSG_WARNINGAD2", '<span class="warning">Este usuário pertence ao AD. Suas configurações devem ser editadas diretamente pelo AD.</span>');
define("USER_MSG_AWAY_DEFAULT", 'Usuário está ausente por alguns dias e responderá a sua mensagem depois que retornar');
define("USER_ERR_DT_INIT", "Data inicial do Aviso de Férias");
define("USER_ERR_DT_END", "Data final do Aviso de Férias");
define("USER_ERR_AWAY_MSG", "Mensagem de Aviso de Férias");
define("USER_MSG_PERIOD", 'Período');
define("USER_MSG_INIT_DT", "Início:");
define("USER_MSG_END_DT", "Fim:");
define("USER_MSG_INVALID_CHAR", 'O nome de usuário contém caracteres inválidos.');
define("USER_MSG_OTHER_AUTH", 'Parâmetros de autenticação');
define("USER_MSG_AUTH_RULE", 'Forma de autenticação');
define("USER_MSG_AUTH_BY", 'Autenticar por');
define("USER_MSG_CRITERION", 'Critério');
define("USER_MSG_CRITERIA", 'Critérios');
define("USER_MSG_ADVANCED_AUTH", 'Modo Avançado de Autenticação');
define("USER_MSG_ADVANCED_AUTH_ABOUT", '(Saiba mais)');
define("USER_MSG_ADVANCED_AUTH_TEXT", 'No Modo Avançado de autenticação, é possível criar uma lista com os tipos de autenticação que serão aceitos para determinado usuário.<br><br>A lista é lida linha a linha, de cima para baixo, e a primeira que for validada corretamente é utilizada para autenticar o usuário.');
define("USER_MSG_NO_RULE", 'Adicione pelo menos 1 (um) tipo de autenticação.');
define("USER_MSG_AUTH_BY_PASSW", 'Senha');
define("USER_MSG_AUTH_BY_IP", 'Endereço IP/Host');
define("USER_MSG_AUTH_BY_MAC", 'Endereço MAC');
define("USER_MSG_AUTH_BY_P_I", 'Senha e Endereço IP/Host');
define("USER_MSG_AUTH_BY_P_M", 'Senha e Endereço MAC');
define("USER_MSG_AUTH_BY_I_M", 'Endereço IP/Host e Endereço MAC');
define("USER_MSG_AUTH_BY_P_I_M", 'Senha e Endereço IP/Host e Endereço MAC');
define("USER_MSG_AUTH_BY_P_OR_I", "Senha ou IP/Host");
define("USER_MSG_AUTH_BY_P_OR_M", "Senha ou MAC");
define("USER_MSG_AUTH_BY_P_OR_I_OR_M", "Senha ou IP/Host ou MAC");
define("USER_MSG_AUTH_BY_M_OR_I", "MAC ou IP/Host");
define("USER_MSG_AUTH_BY_P_AND_I_OR_M", "Senha e (IP/Host ou MAC)");
define("USER_MSG_AUTH_BY_ADVANVED_MODE", "-- Modo Avançado --");
define("USER_AUTH_MSG_AND", ' e ');
define("USER_AUTH_MSG_OR", 'ou ');
define("USER_MSG_AUTH_BY_PASSW_TEXT", 'Se a senha digitada for a correta');
define("USER_MSG_AUTH_BY_IP_TEXT", 'Se o Endereço IP/Host for igual ao especificado acima');
define("USER_MSG_AUTH_BY_MAC_TEXT", 'Se o Endereço MAC for igual ao especificado acima');
define("USER_MSG_AUTH_BY_P_I_TEXT", 'Se a senha digitada for a correta e o Endereço IP/Host for igual ao especificado acima');
define("USER_MSG_AUTH_BY_P_M_TEXT", 'Se a senha digitada for a correta e o Endereço MAC for igual ao especificado acima');
define("USER_MSG_AUTH_BY_I_M_TEXT", 'Se o Endereço IP/Host e o Endereço MAC forem iguais aos especificados acima');
define("USER_MSG_AUTH_BY_P_I_M_TEXT", 'Se a senha digitada for a correta e se o Endereço IP/Host e o Endereço MAC forem iguais aos especificados acima');
define("USER_MSG_AUTH_TITLE", "Autenticação");
define("USER_MSG_ADITIONAL_CONFIG", 'Configurações Adicionais');
define("USER_MSG_IM_FILTER", 'Filtro de Skype e MSN');
define("USER_MSG_IM_FILTER2", 'Filtro de MSN');
define("USER_MSG_MAIL_FILTER", 'Filtro de E-mail');
define("USER_MSG_USER_HOST", 'Informe o host para entrega de mensagens destinadas a este usuário');
define("USER_MSG_NEW", "<strong>Cadastre nesta tela somente usuários locais, que não estejam em domínio Active Directory (AD).<br />Para visualizar usuários do domínio AD, cadastre seus respectivos grupos na seção <i>Grupos</i></strong>.");
define("USER_MSG_TITLE", "Cadastro de Usuário");
define("USER_MSG_VACATION_TITLE", "Resposta Automática de E-mail");
define("USER_MSG_VACATION_NOTICE", "Por motivo de férias estarei ausente a partir de XX/XX/XX, retornando em YY/YY/YY.
				
Sua mensagem foi recebida e será respondida posteriormente.

Atenciosamente,
Sr(a). Xxxxxxx Xxxxxxx");
define("USER_MSG_IM_TEXT", "Informe a seguir a identificação deste usuário para os serviços de mensagens instantâneas abaixo.<br />É possível informar vários logins diferentes por serviço de IM, separando-os por <i>vírgulas</i>.");
define("USER_MSG_IPRANGE_EXAMPLE", "<br /><strong><u>Dica</u></strong><br /><br />No campo <strong>'Endereço IP/Host'</strong> é possível cadastrar um range de IPs como nos exemplos abaixo:<br /><br /><strong>1) IP inicial - IP final:</strong> 192.168.2.1-192.168.2.50<br /><strong>2) IP/Máscara de rede:</strong> 192.168.2.0/255.255.255.0");
define("USER_MSG_ALERT1", '<br />Obs.:  Informe o login do Skype na aba ´Configurações Adicionais´.<br /><br />');
define("USER_MSG_ALERT2", 'Informe neste campo o login do usuário, que poderá ser o próprio login de sua rede ou qualquer outro login.<br /><br />O login do Skype deverá ser informado na aba ´Configurações Adicionais´.');
define("USER_MSG_LINK_DESC", 'Nome completo do usuário.');
define("USER_MSG_LINK_LOGIN_SKYPE", 'Para entrar com mais de um login, separe-os por vírgulas.');
define("USER_MSG_LINK_WTM_NAME", 'Identificador do usuário no WTM (não pode conter espaços).');
define("USER_MSG_LINK_EMAIL", 'Campo opcional.');
define("USER_MSG_ALERT_TITLE", 'Dica');
define("USER_MSG_WRONG_LOGIN_SKYPE", "O campo Skype deve ser preenchido com o nome mostrado no perfil do usuário (Nome Skype), e não com o e-mail utilizado para efetuar o login do Skype. Por exemplo, <i>live:user</i> está correto, mas <i>user@hotmail.com</i> está incorreto.");
define("USER_MSG_WRONG_EMAIL", "E-mail inválido");
define("USER_PHOLDER_DESC", "Nome&nbsp;do&nbsp;Usuário");
define("USER_PHOLDER_LOGIN_SKYPE", " login.usuario.skype,&nbsp;live:usuario.exemplo");
define("USER_PHOLDER_USER_ID", "id.usuario");
define("USER_PHOLDER_EMAIL", "usuario@meudominio.com");

// USERDB
define("USERDB_MSG_TEXT1", "<p><strong>É possível bloquear um IP sempre que ele atinge um número de tentativas consecutivas de autenticação sem sucesso. Isto ajuda a prevenir eventuais ataques de força bruta.</strong></p><br />");
define("USERDB_MSG_NUMBER_ATTEMPTS", 'Após tentativa número');
define("USERDB_MSG_BLOCK_TIME", 'Tempo de permanência do bloqueio (minutos)');
define("USERDB_MSG_WAIT", 'Tentativas sem sucesso são lembradas por (minutos)');
define("USERDB_MSG_ACTIVE_DOMAIN_AUTH",  "Ativar autenticação no domínio");
define("USERDB_MSG_DOMAIN_CONTROL", 'Domínio:');
define("USERDB_MSG_LOGIN", 'Login:');
define("USERDB_MSG_PASSW", 'Senha:');
define("USERDB_MSG_TEXT2", "<b>Configuração para Autenticação no AD</b>");
define("USERDB_MSG_WARNING_TEXT", "<b>Alguns eventos, informando falhas ou ações a serem tomadas pelo administrador, são notificados por intermédio de e-mails. O campo abaixo determina qual é o endereço de destino destes e-mails.</b>");
define("USERDB_MSG_ADMIN_EMAIL_FIELD", "E-Mail:");
define("USERDB_MSG_WARNINGS", "Avisos do Sistema");
define("USERDB_MSG_TITLE", "Active Directory");
define("USERDB_MSG_AD_TITLE", 'Autenticação no Active Directory (AD)');
define("USERDB_MSG_OBS", "Sobre a integração do Winconnection com o AD");
define("USERDB_MSG_OBS1", "- Quando esta opção estiver ativada, os grupos e usuários do AD poderão ser gerenciados pelo Winconnection.<br />&nbsp;&nbsp;Os grupos do AD a serem controlados deverão ser adicionados em \"Cadastros -> Grupos\".");
define("USERDB_MSG_OBS2", '- Este servidor <u>não está configurado</u> para autenticação em AD.<br />&nbsp;&nbsp;Caso você deseje que o Winconnection integre-se a seu AD, clique <a href="http://winconnection.winco.com.br/suporte/suporte-winconnection-7/faq-winconnection-7/configuracao-do-winconnection-usando-ad/" target="_blank">aqui</a> e veja como proceder.');
define("USERDB_MSG_WTM_PRO", " (função disponível no WTM PRO)");
define("USERDB_MSG_UNAVAIBLE_VERSION", " <i>(indisponível nesta versão do WTM)</i>");

// VPNSSL
define("VPNSSL_MSG_CONFIG_CLI", 'Configurações do Cliente VPN');
define("VPNSSL_MSG_HOST", 'Servidor VPN');
define("VPNSSL_MSG_USER", 'Usuário');
define("VPNSSL_MSG_PASSW", 'Senha');
define("VPNSSL_MSG_PORT", 'Porta');
define("VPNSSL_MSG_CONFIG_SRV", 'Configurações do Servidor VPN');
define("VPNSSL_MSG_ACCESS_PERMISSION", 'Permissões de acesso');
define("VPNSSL_MSG_CERT_NAME", 'Nome no certificado SSL');
define("VPNSSL_MSG_IP_LOCAL", 'IP da interface local');
define("VPNSSL_MSG_MASK_LOCAL", 'Máscara da interface local');
define("VPNSSL_MSG_FIRST_IP", 'Primeiro IP para alocar');
define("VPNSSL_MSG_NUM_IP", 'Número de IPs a alocar');
define("VPNSSL_MSG_MASK_THIS_IP", 'Mascarar o acesso com o IP deste servidor');
define("VPNSSL_MSG_SSL", 'Certificado SSL');
define("VPNSSL_MSG_TEXT1", "ATENÇÃO: O Winconnection não encontrou nenhum certificado instalado nesta máquina. Para utilizar a VPN instale um certificado.");
define("VPNSSL_MSG_CONNECT_GW", 'Conectar como cliente gateway');
define("VPNSSL_MSG_GW_IP", 'IP do gateway');
define("VPNSSL_MSG_MASK", 'Máscara de rede');
define("VPNSSL_ERR_SERVER_FREE", '<strong>ATENÇÃO:</strong> O <strong>Servidor VPN</strong> não pode ser ativado na versão gratuita do Winconnection.');
define("VPNSSL_ERR_GW_FREE", '<strong>ATENÇÃO:</strong> O <strong>modo Gateway</strong> não pode ser ativado na versão gratuita do Winconnection.');
define("VPNSSL_MSG_ABOUT_VERSIONS", 'Para saber mais sobre as versões acesse <a href="http://winconnection.winco.com.br/compare-versoes/" target="_blanq">http://winconnection.winco.com.br/compare-versoes/</a>');

// WEBMAIL
define("WEBMAIL_INSTANCE", "Instância do Webserver");
define("WEBMAIL_INSTANCE_PORT", "Webserver na porta ");

// SYSTEM_MONITOR
define("SYSTEM_MONITOR_SMTP_SETTINGS", "Envio de alarmes por e-mail");
define("SYSTEM_MONITOR_CMD_SETTINGS", "Outras formas de envio de alarme");
define("SYSTEM_MONITOR_SETTINGS", "Emitir alarmes nas seguintes situações");
define("SYSTEM_MONITOR_SVC_MSG_TAB", "Entrega");
define("SYSTEM_MONITOR_SVC_DATA_TAB", "Mensagem");
define("SYSTEM_MONITOR_SMTP_ENABLE", "Habilitar envio de e-mails");
define("SYSTEM_MONITOR_SMTP_SERVER", "Servidor");
define("SYSTEM_MONITOR_SMTP_PORT", "Porta");
define("SYSTEM_MONITOR_SMTP_USER", "Usuário");
define("SYSTEM_MONITOR_SMTP_PWD", "Senha");
define("SYSTEM_MONITOR_SMTP_USESSL", "Usar SSL");
define("SYSTEM_MONITOR_SMTP_RECIPIENT", "Destinatário");
define("SYSTEM_MONITOR_SMTP_SENDER", "Remetente");
define("SYSTEM_MONITOR_NET_INTERFACE_ON", "Ativa Monitoração de Links");
define("SYSTEM_MONITOR_SUBJECT", "Assunto da mensagem de alarme ");
define("SYSTEM_MONITOR_TEXT", "Texto da mensagem de alarme ");
define("SYSTEM_MONITOR_FAILURE_CMD", "Em caso de falhas");
define("SYSTEM_MONITOR_RECOVER_CMD", "Na recuperaçao do Serviço");
define("SYSTEM_MONITOR_SVC_SUBJECT", "Assunto");
define("SYSTEM_MONITOR_SVC_TEXT", "Texto");
define("SYSTEM_MONITOR_SVC_MSG_SETTINGS", "Configurações das mensagens");
define("SYSTEM_MONITOR_LINKS_FLAG", "Interrupção de link internet");
define("SYSTEM_MONITOR_FAILED_LOGINS_FLAG", "Ataques detectados pelo IPS (Sistema de Prevenção de Intrusão) com bloqueio de IP");
define("SYSTEM_MONITOR_MAIL_QUEUE_THRESHOLD", "Alarmar se a Fila de e-mail ultrapassar ");
define("SYSTEM_MONITOR_MAIL_QUEUE_THRESHOLD_OBS", "entradas");
define("SYSTEM_MONITOR_INPUT_RATE", "Download excessivo, com consumo de banda superior a");
define("SYSTEM_MONITOR_OUTPUT_RATE", "Upload excessivo, com consumo de banda superior a");
define("SYSTEM_MONITOR_RATE_UNIT", "KBytes/s");
define("SYSTEM_MONITOR_INPUT_RATE_EVAL_TIME", "&nbsp;KBytes/s durante ");
define("SYSTEM_MONITOR_OUTPUT_RATE_EVAL_TIME", "&nbsp;KBytes/s durante ");
define("SYSTEM_MONITOR_EVAL_TIME", "&nbsp;segundos");
define("SYSTEM_MONITOR_SERVICES", 'Serviços em estado de erro');
define("SYSTEM_MONITOR_TITLE", "Configuração dos Alarmes");
define("SYSTEM_MONITOR_ERR_GETTING_SVCS", "Erro obtendo lista de serviços.");
define("SYSTEM_MONITOR_MSG_SMTPSRV_ON" , "Servidor SMTP na porta ");
define("SYSTEM_MONITOR_LINKS_TITLE", 'Disponibilidade dos links');
define("SYSTEM_MONITOR_MAILSRV", 'Servidor de E-mail');
define("SYSTEM_MONITOR_VIRUS", 'Virus encontrado em e-mail da rede interna');
define("SYSTEM_MONITOR_MQUEUE_SIZE", 'Fila de e-mail com mais de');
define("SYSTEM_MONITOR_MQUEUE_TIME", 'E-mail retido na fila há mais de');
define("SYSTEM_MONITOR_MQUEUE_TIME_OBS", "horas");
define("SYSTEM_MONITOR_SMTPSRV_TYPE1", "Utilizar servidor SMTP do Winconnection");
define("SYSTEM_MONITOR_SMTPSRV_TYPE2", "Utilizar outro servidor SMTP");
define("SYSTEM_MONITOR_TEST", 'Testar');
define("SYSTEM_MONITOR_SEND_OTHER", "Envio de alarme por outros meios");
define("SYSTEM_MONITOR_ENABLE_SEND_OTHER", "Habilitar sinalização por &nbsp;&nbsp;&nbsp;");
define("SYSTEM_MONITOR_SEND_SMS", "envio de SMS");
define("SYSTEM_MONITOR_DO_CMD", "execução de comando");
define("SYSTEM_MONITOR_CONFIGURE", 'Configurar');
define("SYSTEM_MONITOR_MSG_TITLE", 'Configuração da Mensagem');
define("SYSTEM_MONITOR_MSG_TEXT", "Informe a seguir o assunto e o texto da mensagem a ser enviada por e-mail em caso de alarme.<br />O sistema completará a mensagem automaticamente com informações específicas sobre o incidente reportado.");
define("SYSTEM_MONITOR_MSG_SMTP_TEST1", "Subject: Winconnection informa: Teste de Alarme\r\nTo: ");
define("SYSTEM_MONITOR_MSG_SMTP_TEST2", "\r\n\r\nMensagem de teste enviada pelo Sistema de Alarmes do Winconnection.\r\n\r\n.\r\n");
define("SYSTEM_MONITOR_MSG_MAIL_SENT_TO", "E-mail enviado para ");
define("SYSTEM_MONITOR_MSG_SMTP_TEST_TITLE", "Teste de Servidor SMTP");
define("SYSTEM_MONITOR_ERR_SMTP_TEST", "Erro enviando e-mail de teste. Verifique as configurações do servidor.");
define("SYSTEM_MONITOR_MSG_SMS_ALERT1", "O serviço de envio de SMS é terceirizado, devendo ser contratado diretamente pelo cliente.<br /><br />O Winconnection integra o serviço de SMS das seguintes empresas:<br /><br />- <a href=\"http://www.mobilepronto.info\" target=\"_blank\">Mobile Pronto</a><br /><br />Obs.: O envio SMS é feito através da internet, portanto ao menos um link precisa estar funcionando.");
define("SYSTEM_MONITOR_MSG_SMS_TITLE", "Alerta por SMS");
define("SYSTEM_MONITOR_MSG_IPS_ALERT1", "O IPS (Sistema de Prevenção de Intrusão) detecta ataques e bloqueia os endereços IP de origem conforme configurado em <strong>Conectividade -> Firewall -> IDS/IPS</strong>.");
define("SYSTEM_MONITOR_MSG_VIRUS_ALERT", "Um alarme será emitido se um vírus for detectado em e-mail originado da rede interna.
		
Esta opção será válida somente se o escaneamento de vírus estiver habilitado, conforme configurado em Filtro de E-mail.");
define("SYSTEM_MONITOR_MSG_VIRUS_TITLE", "Notificação de vírus");
define("SYSTEM_MONITOR_ERR_DOWNLOAD", "Limite de consumo de banda de download");
define("SYSTEM_MONITOR_ERR_DOWNLOAD2", "Tempo do download excessivo");
define("SYSTEM_MONITOR_ERR_UPLOAD", "Limite de consumo de banda de upload");
define("SYSTEM_MONITOR_ERR_UPLOAD2", "Tempo do upload excessivo");
define("SYSTEM_MONITOR_ERR_MQUEUE", "Número de entradas na fila de e-mail");
define("SYSTEM_MONITOR_ERR_MQUEUE2", "Tempo de e-mail preso na fila");
define("SYSTEM_MONITOR_SMS_TXT", "Preencha os campos abaixo com as informações de sua conta no");
define("SYSTEM_MONITOR_SMS_CREDENCIAL", "Credencial");
define("SYSTEM_MONITOR_SMS_MASTER_USER", "Usuário master");
define("SYSTEM_MONITOR_SMS_CELPHONE", "Celular");
define("SYSTEM_MONITOR_SMS_SEND_ON_FAILURE", "Enviar SMS em caso de falhas");
define("SYSTEM_MONITOR_SMS_SEND_ON_RECOVER", "Enviar SMS na recuperação do serviço");
define("SYSTEM_MONITOR_SMS_BT_TEST", "Testar");
define("SYSTEM_MONITOR_SMS_BT_SAVE", "Salvar");
define("SYSTEM_MONITOR_SMS_BT_CANCEL", "Cancelar");
define("SYSTEM_MONITOR_SMS_TXT2", "O(s) campo(s) abaixo deve(m) ser preenchido(s):\n\n");
define("SYSTEM_MONITOR_SMS_CHOOSE_ALERT", "Marque pelo menos uma opção de alerta.");
define("SYSTEM_MONITOR_SMS_TYPE", "O(s) campo(s) abaixo deve(m) ser preenchido(s):");
define("SYSTEM_MONITOR_SMS_MSG_TEST", "Mensagem de teste enviada pelo Sistema de Alarmes do Winconnection.");
define("SYSTEM_MONITOR_EHLO_STRING", "Cadeia de EHLO");
define("SYSTEM_MONITOR_EHLO_TEXT", 'O serviço de Alerta por e-mail simula um Servidor de correio eletrônico (SMTP).

Um dos parâmetros necessários ao protocolo SMTP é a mensagem de apresentação do servidor (usado pelo comando HELO ou EHLO). Este parâmetro (opcional) especifica a cadeia de caracteres a ser usada pelo serviço de Alerta.

Para melhores resultados, este parâmetro deveria ser especificado com o nome completo (FQDN - Fully Qualified Domain Name) da máquina que está enviando o e-mail, por exemplo: <strong>maquina1.winco.com.br</strong>".

Caso não seja especificado será utilizado o nome completo da máquina.');

// service_panel_base
define("SRV_PANEL_BASE_MSG_OTHER_NET", 'Outras redes');
define("SRV_PANEL_BASE_MSG_EXT_NET", 'Rede externa');
define("SRV_PANEL_BASE_ERR_RECV_GROUP", "Erro obtendo lista de grupos.");

// svc_config
define("SRV_CONFIG_MSG_FILE_TREAT", "Arquivo de tratamento para");
define("SRV_CONFIG_MSG_FILE_NOT_EXIST", "não existe");
define("SRV_CONFIG_MSG_BAD_PARAM", "parametros incorretos");

// template
define("TEMPLATE_ERR_CONFIG", "Por favor reveja as suas configura&ccedil;&otilde;es");
define("TEMPLATE_MSG_SHOW_CONN", "Ver conexões");
define("TEMPLATE_MSG_SHOW_ALARM", "Ver alarmes");
define("TEMPLATE_MSG_SHOW_IPS", "Ver IPs alocados");
define("TEMPLATE_MSG_SHOW_STORAGE_REP", "Ver relatório de utilização do Armazenamento");
define("TEMPLATE_MSG_START", "Iniciar serviço");
define("TEMPLATE_MSG_STOP", "Parar serviço");

// categorias_netfilter
define("NETFILTER_CAT_ALL", '-- Todas as categorias --');
define("NETFILTER_CAT_XXX", 'Pornografia');
define("NETFILTER_CAT_MUSIC", 'Músicas');
define("NETFILTER_CAT_VIDEO", 'Vídeos');
define("NETFILTER_CAT_BOOK", 'Livros');
define("NETFILTER_CAT_JOB", 'Empregos');
define("NETFILTER_CAT_SPORT", 'Esportes');
define("NETFILTER_CAT_GAME", 'Jogos');
define("NETFILTER_CAT_HUMOR", 'Humor');
define("NETFILTER_CAT_DISTANCE_LEARN", 'Ensino à distância');
define("NETFILTER_CAT_CHAT", 'Bate-papo');
define("NETFILTER_CAT_NEWSPAPER", 'Jornais');
define("NETFILTER_CAT_MAGAZINE", 'Revistas');
define("NETFILTER_CAT_ANIMATION", 'Animações');
define("NETFILTER_CAT_TUTORIAL", 'Tutoriais');
define("NETFILTER_CAT_CLASSIFIEDS", 'Classificados');
define("NETFILTER_CAT_LOVE_ONLINE", 'Namoro online');
define("NETFILTER_CAT_CURIOSITY", 'Curiosidades');
define("NETFILTER_CAT_SHOPPING", 'Compras');
define("NETFILTER_CAT_NEWS", 'Notícias');
define("NETFILTER_CAT_VIRTUAL_CARD", 'Cartões Virtuais');
define("NETFILTER_CAT_ESOTERIC", 'Esoterismo');
define("NETFILTER_CAT_WEBMAIL", 'Webmail');
define("NETFILTER_CAT_COMICS", 'Quadrinhos');
define("NETFILTER_CAT_TV", 'Televisão');
define("NETFILTER_CAT_CULINARY", 'Culinária');
define("NETFILTER_CAT_WEAPONS", 'Armas');
define("NETFILTER_CAT_PUBLIC_SALE", 'Leilões');
define("NETFILTER_CAT_TRAVEL", 'Viagens');
define("NETFILTER_CAT_ANIMALS", 'Animais');
define("NETFILTER_CAT_HACKER", 'Hackers');
define("NETFILTER_CAT_MOVIE", 'Filmes');
define("NETFILTER_CAT_PHOTO", 'Fotografia');
define("NETFILTER_CAT_AIRLINE", 'Companhias aéreas');
define("NETFILTER_CAT_ART", 'Artes');
define("NETFILTER_CAT_AUTO", 'Autos');
define("NETFILTER_CAT_BANK", 'Bancos');
define("NETFILTER_CAT_BLOG_FLOG", 'Blogs/Fotologs');
define("NETFILTER_CAT_DRUG", 'Drogas');
define("NETFILTER_CAT_RELATIONSHIP", 'Relacionamentos');
define("NETFILTER_CAT_HEALTH", 'Saúde');

// New netfilter version
define("NETFILTER_CAT_PAGANISM", 'Rituais pagãos');
define("NETFILTER_CAT_BANNERS",  'Banners de propaganda');
define("NETFILTER_CAT_PROXIES", 'Proxies');
define("NETFILTER_CAT_SERACH_ENGINE", 'Sites de Busca');
define("NETFILTER_CAT_VIOLENCE", 'Violência');
define("NETFILTER_CAT_PORTALS", 'Portais' );
define("NETFILTER_CAT_RACIAL_CRIMES", 'Neo-nazismo e crimes raciais');
define("NETFILTER_CAT_DOWNLOAD", 'Sites de download');

// New WincoClasses
define("NETFILTER_CAT_SCAM", 'Phishing Scam');

// dias_da_semana
define("WEEKDAY_SUN", 'Dom');
define("WEEKDAY_MON", 'Seg');
define("WEEKDAY_TUE", 'Ter');
define("WEEKDAY_WED", 'Qua');
define("WEEKDAY_THU", 'Qui');
define("WEEKDAY_FRI", 'Sex');
define("WEEKDAY_SAT", 'Sab');
define("WEEKDAY_SUNDAY", 'Domingo');
define("WEEKDAY_MODAY", 'Segunda');
define("WEEKDAY_TUESDAY", 'Terça');
define("WEEKDAY_WEDNESDAY", 'Quarta');
define("WEEKDAY_THURSDAY", 'Quinta');
define("WEEKDAY_FRIDAY", 'Sexta');
define("WEEKDAY_SATURDAY", 'Sábado');
		
// mail_shell
define("MSHELL_OPTIONS_DOM_BLKLIST", "Blacklist de domínios/e-mails");
define("MSHELL_OPTIONS_BLOCKED_CHARSET", "Charset's bloqueados");
define("MSHELL_OPTIONS_LANG_ORIG", "Língua de origem");
define("MSHELL_OPTIONS_DOM_IGNORED", "Lista de domínios ignorados");
define("MSHELL_OPTIONS_LBL", "Lista de exceção de LBL(Last Blackhole List)");
define("MSHELL_OPTIONS_IP_BLOCK", "Lista de IPs bloqueados");
define("MSHELL_OPTIONS_IP_IGNORED", "Lista de IPs ignorados");
define("MSHELL_OPTIONS_SPOOFED", "Lista de remetentes spoofed");
define("MSHELL_OPTIONS_NONEXISTANT", "Lista de usuários não existentes");
define("MSHELL_OPTIONS_SPAMBAIT", "Lista de usuários SPAMBAIT");
define("MSHELL_OPTIONS_BLOCK_COUNTRIES", "Países bloqueados");
define("MSHELL_OPTIONS_CONTRY_ORIG", "Países de origem");
define("MSHELL_OPTIONS_CUSTOM", "Regras customizadas");
define("MSHELL_OPTIONS_DOM_WHITELIST", "Whitelist de domínios/e-mails");
define("MSHELL_OPTIONS_IP_WHITELIST", "Whitelist de IPs");
define("MSHELL_OPTIONS_SPF", "Habilitar SPF");
define("MSHELL_OPTIONS_LIVEFEED", "Servidor Livefeed");

// wizard
define("WIZ_FORM_BASE_BT_PREV", '&lt; Voltar');
define("WIZ_FORM_BASE_BT_CANCEL", 'Cancelar');
define("WIZ_FORM_BASE_BT_NEXT", 'Avançar &gt;');
define("WIZ_FORM_BASE_BT_END", 'Finalizar');

define("WIZ_AUTH_LABEL1", "Foi verificado que já existe uma conta de Administrador configurada no Winconnection.");
define("WIZ_AUTH_LABEL2", "Para prosseguir, é necessário digitar o Usuário e Senha de administrador do Winconnection.");
define("WIZ_AUTH_TITLE", "Credenciais do Winconnection");

define("WIZ_STEP1_MSG_TITLE", "Instalando driver do Winconnection");
define("WIZ_STEP1_MSG_TEXT1", "Clique em 'Avançar' para instalar o driver.");
define("WIZ_STEP1_MSG_TEXT2", "Foi encontrada uma versão antiga do driver instalado nesta máquina.");
define("WIZ_STEP1_MSG_TEXT3", "Clique em 'Avançar' para atualizá-lo agora.");
define("WIZ_STEP1_MSG_TEXT4", "Não instalar/atualizar o driver agora");
define("WIZ_STEP1_MSG_TEXT5", "(Algumas funções podem ficar indisponíveis)");
define("WIZ_STEP1_ERR1", "Erro obtendo informações do SO");
define("WIZ_STEP1_ERR2", "Erro desinstalando driver");
define("WIZ_STEP1_ERR3", "Erro instalando driver");
define("WIZ_STEP1_WAIT_TEXT1", '&nbsp;&nbsp;Aguarde enquanto o driver do Winconnection é instalado/desinstalado ...');

define("WIZ_STEP2_TITLE", "Migrando as configurações");
define("WIZ_STEP2_MIGRATE_OPTION1", "Migrar Usuários, Grupos e Redes da versão 4 para a versão atual (recomendado)");
define("WIZ_STEP2_MIGRATE_OPTION2", "Criar uma nova configuração do Winconnection 7 (Esta opção apagará todas as configurações anteriores)");
define("WIZ_STEP2_MIGRATE_OPTION3", "Sair deste assistente sem alterar a configuração.");
define("WIZ_STEP2_MSG_PREVIOUS", "Foi encontrada uma instalação anterior do Winconnection");
define("WIZ_STEP2_QST_PREVIOUS", "O que você deseja fazer?");
define("WIZ_STEP2_CHOOSE_OPTION", "Por favor escolha uma opção");

define("WIZ_STEP2_MSG_TITLE", "Configuração da interface interna");
define("WIZ_STEP2_ERR1", 'Erro obtendo lista de interfaces');
define("WIZ_STEP2_MSG_TEXT1", "Esta configuração irá garantir que o Winconnection funcione corretamente e que sua rede esteja protegida de acessos não autorizados.");
define("WIZ_STEP2_MSG_TEXT2", "Selecione a interface interna de sua rede:");
define("WIZ_STEP2_MSG_TEXT3", 'Interface:');
define("WIZ_STEP2_MSG_IP", 'Endereço IP:');
define("WIZ_STEP2_MSG_MASK", 'Máscara de subrede:');
define("WIZ_STEP2_MSG_TEXT4", 'Informe o Endereço IP e a Máscara de rede da sua interface interna:');
define("WIZ_STEP2_ERR_2", 'Os campos Endereço IP e Máscara de rede devem ser preenchidos');

define("WIZ_STEP3_MSG_TITLE", "Senha#Por favor, digite a senha para o Administrador.");
define("WIZ_STEP3_MSG_ADM", 'administrador');
define("WIZ_STEP3_MSG_TEXT1", "Escolha uma senha para ser usada no Administrador do Winconnection:");
define("WIZ_STEP3_MSG_USER", "Usuário:");
define("WIZ_STEP3_MSG_PASSW", "Senha:");
define("WIZ_STEP3_MSG_CONFIRM_PASSW", "Confirmar Senha:");
define("WIZ_STEP3_ERR1", 'Os campos Senha e Confirmar Senha não conferem.');
define("WIZ_STEP3_ERR2", 'Os campos Senha e Confirmar Senha devem ser preenchidos');

define("WIZ_STEP4_MSG_TITLE", "Concluindo o Assistente#Pronto! O Winconnection está pronto para ser usado.");
define("WIZ_STEP4_MSG_TEXT1", "<b>O que você deseja fazer?</b>");
define("WIZ_STEP4_MSG_EXEC_NOW", "Executar o Winconnection agora");
define("WIZ_STEP4_MSG_EXEC_ON_START", "Executar o Winconnection sempre que o computador for iniciado");
define("WIZ_STEP4_ERR1", "Erro criando rede interna.");
define("WIZ_STEP4_ERR2", "Erro obtendo configuração do TPROXY.");
define("WIZ_STEP4_ERR3", "Erro alterando configuração do TPROXY.");
define("WIZ_STEP4_ERR4", "Erro obtendo informação do usuário adminsitrador.");
define("WIZ_STEP4_ERR5", 'Erro salvando informações do administrador no servidor.');
define("WIZ_STEP4_MSG_NET", 'Rede interna');
define("WIZ_STEP4_ERR6", 'Erro obtendo configuração da interface interna.');
define("WIZ_STEP4_ERR7", 'Erro salvando configuração da interface interna.');
define("WIZ_STEP4_ERR8", "Erro obtendo configuração da DMZ.");
define("WIZ_STEP4_ERR9", "Erro alterando configuração da DMZ.");

define("WIZ_STEP5_ERR1", "Erro criando grupo ");
define("WIZ_STEP5_MSG1", 'Usuários comuns');
define("WIZ_STEP5_DESC1", 'Usuários da rede');
define("WIZ_STEP5_MSG2", 'Usuários restritos');
define("WIZ_STEP5_DESC2", 'Usuários que tem menos acesso');
define("WIZ_STEP5_REPORT", 'relatorio');
define("WIZ_STEP5_ERR2", "Erro obtendo configuração padrão do serviço HTTPSRV.");
define("WIZ_STEP5_ERR3", "Erro criando serviço HTTPSRV.");
define("WIZ_STEP5_ERR4", "Erro criando alias para relatório.");
define("WIZ_STEP5_DESC_ADMIN", "Administrador do Winconnection");

define("WIZ_STEP_ERR_TITLE", "Erro na instalação/desinstalação do driver");
define("WIZ_STEP_ERR_TEXT1", "Ocorreu um erro durante a instalação/desinstalação do driver.");
define("WIZ_STEP_ERR_TEXT2", "Não é possível continuar o processo de configuração do Winconnection.");

define("WIZ_CONFIG_SERVICE", "Configurando serviços#Selecione os serviços que deseja configurar agora.");
define("WIZ_SRV_WEB", 'Controle de Navegação - Filtro Web');
define("WIZ_SRV_MAIL", 'Servidor de E-mails');
define("WIZ_SRV_FW", 'Firewall e Filtro de Pacotes');
define("WIZ_SRV_DHCP_DNS", 'Servidor DHCP e Proxy DNS');
define("WIZ_SRV_DHCP", 'Servidor DHCP');
define("WIZ_SRV_DNS", 'Proxy DNS');
define("WIZ_CONFIG_MAIL", "Configuração de E-mail#Configure os parâmetros de saída do servidor SMTP.");
define("WIZ_CONFIG_DHCP", "Configuração do servidor DHCP#Configure os parâmetros do servidor DHCP.");
define("WIZ_ERR_HTTP1", "Erro obtendo configuração do HTTP");
define("WIZ_ERR_HTTP2", "Erro criando serviço HTTP");
define("WIZ_ERR_FW1", "Erro obtendo configuração do Firewall");
define("WIZ_ERR_FW2", "Erro salvando configuração do Firewall");
define("WIZ_ERR_SMTP1", "Erro obtendo configuração do Servidor SMTP");
define("WIZ_ERR_SMTP2", "Erro criando serviço Servidor SMTP");
define("WIZ_ERR_IMAP1", "Erro obtendo configuração do Servidor IMAP");
define("WIZ_ERR_IMAP2", "Erro criando serviço Servidor IMAP");
define("WIZ_ERR_POP1", "Erro obtendo configuração do Servidor POP");
define("WIZ_ERR_POP2", "Erro criando serviço Servidor POP");
define("WIZ_ERR_MD1", "Erro obtendo configuração do Filtro de E-mail");
define("WIZ_ERR_MD2", "Erro criando serviço de Filtro de E-mail");
define("WIZ_ERR_DNS1", "Erro obtendo configuração do DNS");
define("WIZ_ERR_DNS2", "Erro criando serviço DNS");
define("WIZ_ERR_DHCP1", "Erro obtendo configuração do DHCP");
define("WIZ_ERR_DHCP2", "Erro criando serviço DHCP");
define("WIZ_ERR_IMFILTER1", "Erro obtendo configuração do IMFILTER");
define("WIZ_ERR_IMFILTER2", "Erro criando serviço IMFILTER");
define("WIZ_MSG_CONFIGURING", 'Configurando os serviços');
define("WIZ_MSG_WAIT_CONFIGURING", '&nbsp;&nbsp;Aguarde enquanto os serviços são instalados e configurados...');
define("WIZ_ERR_DEL_USER", 'Erro deletando usuário: ');
define("WIZ_ERR_GET_USER", 'Erro obtendo lista de usuários');
define("WIZ_ERR_DEL_GROUP", 'Erro deletando grupo: ');
define("WIZ_ERR_GET_GROUP", 'Erro obtendo lista de grupos');
define("WIZ_ADMIN_GROUP", 'Administradores');
define("WIZ_ERR_DEL_SRV", 'Erro deletando serviço ');
define("WIZ_ERR_GETTING_NET_CONFIG", 'Erro obtendo configurações de rede');
define("WIZ_ERR_SETTING_NET_CONFIG", 'Erro setando configurações de rede');
define("WIZ_ERR_FILL_ALL", 'Preencha todos os campos.');
define("WIZ_ERR_INVALID_USER_PASS", 'Usuário ou senha inválidos');
define("WIZ_MSG_MTU", 'Para que o balanceamento de links funcione corretamente, o Assistente de Configuração irá alterar a configuração do Serviço TCP/IP desta máquina. Para maiores informações, veja <a href="http://www.winco.com.br/suporte_faq_respostas.phtml?ctx_cod=1.5.6.1&name=56" target="_blank">http://www.winco.com.br/suporte_faq_respostas.phtml?ctx_cod=1.5.6.1&name=56</a>');

// OPENDPI
define("ODPI_MSG_UNKNOWN", "desconhecido");
define("ODPI_MSG_DEFAULT", "Protocolos Padrões");
define("ODPI_MSG_GAMES", "Jogos");
define("ODPI_MSG_REMOTE_ACCESS", "Acesso Remoto");
define("ODPI_MSG_DATA_BASE", "Banco de Dados");
define("ODPI_MSG_OTHER", "Outros");

// CPANEL
define("CPANEL_MSG_TITLE", "Painel de Controle do Usuário");
define("CPANEL_MSG_USER", "Usuário:");
define("CPANEL_MSG_PASSW", "Senha:");
define("CPANEL_MSG_LOGOUT", "Sair");
define("CPANEL_MSG_QUARANTINE", 'Quarentena');
define("CPANEL_MSG_VACATION", "Aviso de Férias");
define("CPANEL_MSG_WEB_ACCESS_RULES", 'Regras de Acesso Web');
define("CPANEL_MSG_WEB_ACCESS_REPORT", 'Relatório de Acesso Web');
define("CPANEL_MSG_CHANGE_PASSW", 'Alterar Senha');
define("CPANEL_MSG_WELCOME", 'Bem-vindo');
define("CPANEL_MSG_PASSW_OK", 'Senha alterada com sucesso!');
define("CPANEL_MSG_PASSW_NOT_EQUAL", 'Senhas diferentes!');
define("CPANEL_ERR_PASSW_ERR", 'Troca de senha não foi possível!');
define("CPANEL_MSG_CURRENT_PASSW", 'Senha  Atual:');
define("CPANEL_MSG_NEW_PASSW", 'Nova Senha:');
define("CPANEL_MSG_NEW_PASSW_AGAIN", 'Repetir Nova Senha:');
define("CPANEL_MSG_NEW_PASSW_CHANGE", 'Alterar');
define("CPANEL_MSG_ENTER", 'Entrar');
define("CPANEL_MSG_FILTER_MAIL_BY", 'Filtrar e-mail por:');
define("CPANEL_MSG_QUA_RCPT1", 'destinatário');
define("CPANEL_MSG_QUA_RCPT2", 'Destinatário');
define("CPANEL_MSG_QUA_SENDER1", 'remetente');
define("CPANEL_MSG_QUA_SENDER2", 'Remetente');
define("CPANEL_MSG_QUA_SUBJECT1", 'assunto');
define("CPANEL_MSG_QUA_SUBJECT2", 'Assunto');
define("CPANEL_MSG_QUA_WITH_FILTER", 'sem filtro');
define("CPANEL_MSG_DT_FROM", 'De:');
define("CPANEL_MSG_DT_TO", 'até:');
define("CPANEL_MSG_QUA_SEARCH", 'Pesquisar');
define("CPANEL_MSG_QUA_RECEIVE_REPORT", 'Receber o relatório diário dos e-mails em quarentena?');
define("CPANEL_MSG_QUA_REPORT_YES", 'Sim');
define("CPANEL_MSG_QUA_REPORT_NO", 'Não');
define("CPANEL_MSG_QUA_MANAGER", '[Gerenciar]');
define("CPANEL_MSG_QUA_ADD_IN_WL", 'Adicionar e-mail:');
define("CPANEL_MSG_QUA_ADD", 'Adicionar');
define("CPANEL_MSG_QUA_NOTE", 'Nota: A listagem será limitada a 2.000 registros. Se não encontrar o que procura, tente filtrar mais.');
define("CPANEL_ERR_QUA_RECEIVE", 'Erro ao retirar alguma(s) mensagem(ns) da Quarentena!');
define("CPANEL_ERR_QUA_DELETE", 'Erro ao excluir mensagem(ns) da Quarentena!');
define("CPANEL_MSG_QUA_RECEIVE", 'Mensagem(ns) enviada(s) com sucesso!');
define("CPANEL_MSG_QUA_DELETE", 'Mensagem(ns) excluida(s) com sucesso!');
define("CPANEL_MSG_QUA_RECV", 'Receber Mensagem(ns)');
define("CPANEL_MSG_QUA_DEL", 'Excluir Mensagem(ns)');
define("CPANEL_MSG_QUA_DATE", "Data");
define("CPANEL_MSG_QUA_LOADING", 'Carregando dados...');
define("CPANEL_ERR_QUA_READING_DATA", 'Erro ao recuperar os dados!');
define("CPANEL_MSG_QUA_NO_DATA", 'A busca não gerou resultados. Redefina seus filtros e tente novamente.');
define("CPANEL_MSG_QUA_PAGINATOR_FIRST", '&lt;&lt; Primeira');
define("CPANEL_MSG_QUA_PAGINATOR_LAST", 'Última &gt;&gt;');
define("CPANEL_MSG_QUA_PAGINATOR_PREV", '&lt; Anterior');
define("CPANEL_MSG_QUA_PAGINATOR_NEXT", 'Próxima &gt;');
define("CPANEL_MSG_QUA_CLEAN_FILTERS", 'Limpar filtros');
define("CPANEL_MSG_QUA_STATUS_OK", 'Status alterado com sucesso!');
define("CPANEL_ERR_QUA_STATUS_ERR", 'Ocorreu um erro na tentativa de troca de status.');
define("CPANEL_MSG_QUA_TYPE_MAIL", 'É necessário digitar um endereço de e-mail para cadastrar na Whitelist.');
define("CPANEL_MSG_WL_ADD_OK", 'O e-mail foi cadastrado com sucesso!');
define("CPANEL_ERR_WL_ADD_ERR", 'Erro ao cadastrar o e-mail na Whitelist.');
define("CPANEL_MSG_WL_ADD_MAIL_EXISTS", 'E-mail já cadastrado na Whitelist');
define("CPANEL_MSG_WL_ADD_MAIL_INVALID", 'E-mail inválido.');
define("CPANEL_ERR_QUA_ERROR_OPENNING_DATABASE", "Erro abrindo banco de dados da quarentena!");
define("CPANEL_ERR_WL_DELETING", 'Erro deletando e-mail(s) da Whitelist!');
define("CPANEL_MSG_WL_DELETE_OK", 'E-mail(s) deletado(s) com sucesso!');
define("CPANEL_MSG_WL_EMPTY_LIST", 'Lista vazia.');
define("CPANEL_MSG_TITLE_DATE", 'Clique para escolher uma data');
define("CPANEL_MSG_ALL_CATEGORIES", 'Todas as categorias do Netfilter');
define("CPANEL_MSG_CATEGORY", 'Categoria: ');
define("CPANEL_MSG_ALL_SITES", "Todos os sites");
define("CPANEL_MSG_SITES_BY_IP", "Sites acessados por IP");
define("CPANEL_MSG_UNLIMITED", 'Ilimitado');
define("CPANEL_MSG_TIME_MINUTES", 'min');
define("CPANEL_MSG_TIMECONTROL_RULE", 'Regra');
define("CPANEL_MSG_TIMECONTROL_TIME", "Tempo de navegação");
define("CPANEL_MSG_TIMECONTROL_ALLOWED", 'Permitido');
define("CPANEL_MSG_TIMECONTROL_USED", 'Utilizado');
define("CPANEL_MSG_TIMECONTROL_BYTES", 'Transferência de bytes');
define("CPANEL_MSG_TIMECONTROL_NO_DATA", 'O usuário não possui regra de acesso web.');
define("CPANEL_MSG_SAVE_OK", 'Informações salvas com sucesso!');
define("CPANEL_MSG_VACATION_ENABLE", 'Ativar aviso de Férias');
define("CPANEL_MSG_VACATION_START", 'Início:');
define("CPANEL_MSG_VACATION_END", 'Término:');
define("CPANEL_MSG_VACATION_MSG", 'Mensagem:');
define("CPANEL_MSG_SAVE", 'Salvar');
define("CPANEL_MSG_WEBREPORT_SELECT", '- selecione -');
define("CPANEL_MSG_WEBREPORT_DOMAINS", 'Domínios acessados');
define("CPANEL_MSG_WEBREPORT_DOMAIN", 'Domínio');
define("CPANEL_MSG_WEBREPORT_HOUR", 'Acessos por hora');
define("CPANEL_MSG_WEBREPORT_DAY", 'Total de acessos por dia');
define("CPANEL_MSG_WEBREPORT_EXPORT", 'Exportar para');
define("CPANEL_MSG_WEBREPORT_PAGES", 'Páginas');
define("CPANEL_MSG_WEBREPORT_FILES", 'Arquivos');
define("CPANEL_MSG_WEBREPORT_SIZE", 'Tamanho');
define("CPANEL_MSG_WEBREPORT_TIME", 'Tempo');
define("CPANEL_MSG_NO_ACCESS_DATA", 'Usuário não possui dados de acesso.');
define("CPANEL_MSG_WELCOME", "Bem-vindo");
define("CPANEL_MSG_WELCOME_TEXT", "
No Painel de Controle do Usuário você é capaz de realizar algumas operações sobre a sua conta sem a necessidade da intervenção do administrador da rede.


<strong>&diams; <u>Quarentena:</u></strong> visualize, recupere ou exclua suas mensagens movidas para quarentena.

<strong>&diams; <u>Aviso de Férias:</u></strong> programe uma resposta automática de e-mail quando estiver de férias.

<strong>&diams; <u>Regras de Acesso Web:</u></strong> visualize as Regras de Acesso Web que controlam o seu acesso a internet.

<strong>&diams; <u>Relatório de Acesso Web:</u></strong> visualize detalhes sobre os sites que você acessa, tais como número de páginas, tempo de navegação, etc.

<strong>&diams; <u>Regras de E-mail:</u></strong> crie regras de e-mail para serem aplicadas nos e-mails que chegam para você.

<strong>&diams; <u>Alterar Senha:</u></strong> altere a sua senha de acesso aos serviços (internet, e-mail, etc).


OBS: algumas opções ficam ativas somente se o serviço associado a elas estiver em execução. Em caso de dúvidas entre em contato com o administrador da rede.");
define("CPANEL_MSG_MAIL_RULES", "Regras de E-mail");
define("CPANEL_MSG_MAIL_RULES_OK", '<strong style="center" class="info">Informações salvas com sucesso!</strong><br /><br />');
define("CPANEL_MSG_MAIL_RULES_ERR", '<strong style="center" class="info">Erro salvando informações.</strong><br /><br />');
define("CPANEL_MSG_LOGOUT1", "Foi detectado que você está logado no sistema como o usuário");
define("CPANEL_MSG_LOGOUT2", ". Se quiser fazer logout,");
define("CPANEL_MSG_LOGOUT3", "Clique aqui");
define("CPANEL_MSG_LOGOUT4", "OBS: o seu navegador deverá ser fechado.");

?>