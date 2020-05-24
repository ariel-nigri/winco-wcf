<?php
/*

CREATE TABLE auth_events (
	ae_seq INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
	usu_seq INTEGER NOT NULL,
	ae_event VARCHAR(2) NOT NULL,
	ae_datetime DATETIME NOT NULL
);

CREATE INDEX ae_event_usu ON auth_events (usu_seq, ae_event);

*/
class AuthEvents extends SqlToClass {
	const GOOD_LOGIN_EVENT		= 'GL';					/** Good login. */
	const BAD_LOGIN_EVENT		= 'BD';					/** Bad Login. */

	const BLOCK_LOGIN_EVENT 	= 'BL';					/** Blocked. It's not possible to sign in. */
	const USER_UNBLOCKED_EVENT	= 'UL';					/** unblock login event. */

	const CHANGE_PASSWD_NEXT_LOGIN = 'PC';				/** Should change password */
	const NEW_PWD_EVENT 		= 'NP';					/** User changed the password */
	
	const PASSWORD_RECOVERY		= 'PR';					/** User is trying to recover a lost password */

    public function __construct() {
		$this->addTable('auth_events');	

		$this->addColumn('auth_events.ae_seq', 'ae_seq', BZC_INTEGER | BZC_TABLEKEY);
		$this->addColumn('auth_events.usu_seq', 'usu_seq', BZC_INTEGER | BZC_NOTNULL);
		$this->addColumn('auth_events.ae_event', 'ae_event', BZC_STRING | BZC_NOTNULL);
		$this->addColumn('auth_events.ae_datetime', 'ae_datetime', BZC_DATE | BZC_NOTNULL);
		$this->addColumn('auth_events.ae_reason', 'ae_reason', BZC_STRING);
	}
	
	static function registerEvent($sql, $event, $usu_id, $reason = '') {
		$ae = new AuthEvents;
		$ae->ae_event = $event;
		$ae->insert($sql);
		$ae->usu_seq = $usu_id;
		$ae->ae_reason = $reason;
		return $ae->insert($sql);
	}

	static function countBadLogins(Sql $sql, $usu_seq) {
		$count = 0;

		$sth = $sql->con->prepare("SELECT ae_event as total FROM auth_events WHERE usu_seq = :user ORDER BY ae_seq DESC LIMIT 40");
		$sth->execute([':user' => $usu_seq]);
		$array = $sth->fetchAll();
		foreach ($array as $row) {
			switch ($row[0]) {
			case self::BAD_LOGIN_EVENT:
				++$count;
				break;
			case self::USER_UNBLOCKED_EVENT:
			case self::GOOD_LOGIN_EVENT:
				return $count;
			}
		}

		return $count;
	}

	protected function beforeSave($insert) {
		if (!$insert) {
			$this->error = 'Não é permitido alterar eventos de autenticação';
			return false;
		}
		$this->ae_datetime = date('Y-m-d H:i:s');
		return true;
	}
}
