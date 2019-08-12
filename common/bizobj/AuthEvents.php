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
	
	/** Bad Login. */
	const BAD_LOGIN_EVENT = 'BD';

	/** Blocked. It's not possible to sign in. */
	const BLOCK_LOGIN_EVENT = 'BL';

	/** Should change password */
	const CHANGE_PASSWD_NEXT_LOGIN = 'PC';
	
	private $maxAttempt = 0;
	
    public function __construct() {
		
		$this->addTable('auth_events');	

		$this->addColumn('auth_events.ae_seq', 'ae_seq', BZC_INTEGER | BZC_TABLEKEY);
		$this->addColumn('auth_events.usu_seq', 'usu_seq', BZC_INTEGER | BZC_NOTNULL);
		$this->addColumn('auth_events.ae_event', 'ae_event', BZC_STRING | BZC_NOTNULL);
		$this->addColumn('auth_events.ae_datetime', 'ae_datetime', BZC_DATE | BZC_NOTNULL);
		$this->addColumn('auth_events.ae_reason', 'ae_reason', BZC_STRING);
	}
	
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
	
	public function isBlocked($sql) {

		if (empty($this->usu_seq))
			throw new Exception('O parametro usu_seq não pode ser vazio.');

		$clone = new AuthEvents;
		$clone->usu_seq = $this->usu_seq;
		$clone->ae_event = self::BLOCK_LOGIN_EVENT;
		$clone->select($sql);
		return $clone->valid;

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

	/**
	 * Clear events for an user on auth_events table.
	 *
	 * @param Sql $sql
	 * @param string $evt
	 * @return void
	 */
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
	
	private function checkBadLoginAttempts($sql) {
		
		$sth = $sql->prepare("SELECT count(*) as total FROM auth_events WHERE usu_seq = :user AND ae_event = :event");
		$ret = $sth->execute(array(':user' => $this->usu_seq, ':event' => self::BAD_LOGIN_EVENT));
		if ($row = $sth->fetch())
			return $row['total'];

		return 0;

	}

	protected function beforeSave() {
		if (empty($this->ae_datetime))
			$this->ae_datetime = date('Y-m-d H:i:s');

		return true;
	}
}



