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
	
    public function __construct() {
		$this->addTable('auth_events');	

		$this->addColumn('auth_events.ae_seq', 'ae_seq', BZC_INTEGER | BZC_TABLEKEY);
		$this->addColumn('auth_events.usu_seq', 'usu_seq', BZC_INTEGER | BZC_NOTNULL);
		$this->addColumn('auth_events.ae_event', 'ae_event', BZC_STRING | BZC_NOTNULL);
		$this->addColumn('auth_events.ae_datetime', 'ae_datetime', BZC_DATE | BZC_NOTNULL);
		$this->addColumn('auth_events.ae_reason', 'ae_reason', BZC_STRING);
	}
	
	static function registerEvent($sql, $event, $usu_id, $reason = '') {
		$this = new AuthEvents;
		$this->ae_event = $event;
		$this->insert($sql);
		$this->usu_seq = $usu_id;
		$this->ae_reason = $reason;
		return $this->insert($sql);
	}

	public function countBadLogins(PDO $sql) {
		$count = 0;

		$sth = $sql->prepare("SELECT ae_event as total FROM auth_events WHERE usu_seq = :user ORDER BY ae_seq DESC LIMIT 40");
		$sth->execute([':user' => $this->usu_seq]);
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

	/*
	private maxAttempt = 0;

	public function addBadLogin($sql) {
				
		if (empty($this->usu_seq)) {
			throw new Exception('O parametro usu_seq não pode ser vazio.');
			// $this->error = 'O parametro usu_seq não pode ser vazio.';
			// return false;
		}

		if ($this->maxAttempt === 0)
			return;

		if ($this->isBlocked($sql)) 
			return self::BLOCK_LOGIN_EVENT;
		
		$total_attemps = $this->checkBadLoginAttempts($sql->con);
		$this->ae_event = self::BAD_LOGIN_EVENT;

		if ($total_attemps >= $this->maxAttempt) {
			$this->ae_event = self::BLOCK_LOGIN_EVENT;
			$this->ae_reason = 'BAD_LOGIN';
			
			$clone = new AuthEvents;
			$clone->usu_seq = $this->usu_seq;
			$clone->clearEvents($sql, self::BAD_LOGIN_EVENT);
		}

		$this->insert($sql);
		return $this->ae_event;
	}


	public function isBlocked($sql) {

		if (empty($this->usu_seq))
			throw new Exception('O parametro usu_seq não pode ser vazio.');

		$clone = new AuthEvents;
		$clone->usu_seq = $this->usu_seq;
		$clone->ae_event = self::BLOCK_LOGIN_EVENT;
		$clone->select($sql);
		return $clone->valid;

	}	

	// Função nova (Rafael)
	public function blockedReason($sql) {
		if (empty($this->usu_seq))
			throw new Exception('O parametro usu_seq não pode ser vazio.');

		$clone = new AuthEvents;
		$clone->usu_seq = $this->usu_seq;
		$clone->ae_event = self::BLOCK_LOGIN_EVENT;
		$clone->select($sql);

		if (!$clone->fetch()) return 'Not blocked';
		if ($clone->ae_reason) return $clone->ae_reason;
		return false;
	}

	public function isPasswordChange($sql) {

		if (empty($this->usu_seq))
			throw new Exception('O parametro usu_seq não pode ser vazio.');

		$clone = new AuthEvents;
		$clone->usu_seq = $this->usu_seq;
		$clone->ae_event = self::CHANGE_PASSWD_NEXT_LOGIN;
		$clone->select($sql);
		return $clone->valid;	
	}
	*/
	/**
	 * Clear events for an user on auth_events table.
	 *
	 * @param Sql $sql
	 * @param string $evt
	 * @return void
	 */
	/*
	public function clearEvents($sql, $evt = null) {

		if (empty($this->usu_seq))
			throw new Exception('A propriedade usu_seq não pode ser nula.');

		if (!is_null($evt))
			$this->ae_event = $evt;
		if (!$this->select($sql))
			return true;
		
		//the delete method requires primary key
		//let's walk into results and call delete method one by one
		while ($this->fetch()) {
			$clone = clone $this;
			$clone->delete($sql);
		}
		return true;

	}

	public function addEvent($sql, $evt, $reason = NULL) {
		
		if ($evt == self::BAD_LOGIN_EVENT)
			return $this->addBadLogin($sql);

		if ($evt == self::BLOCK_LOGIN_EVENT || $evt == self::CHANGE_PASSWD_NEXT_LOGIN) {
			//theses events should occour alone
			$ae = new AuthEvents;
			$ae->usu_seq = $this->usu_seq;
			$ae->clearEvents($sql);
		}

		$clone = new AuthEvents;
		$clone->usu_seq = $this->usu_seq;
		$clone->ae_event = $evt;
		$clone->ae_datetime = $this->ae_datetime;
		if (!is_null($reason))
			$clone->ae_reason = $reason;
		return $clone->insert($sql);
	}
	*/
}
