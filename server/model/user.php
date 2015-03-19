<?php
require_once 'lib/databaseentity.php';

//this class represent a stage
class User extends DatabaseEntity {
	public static $tablename = 'user';
	protected $values = array('username' => '', 'password' => '', 'type' => '');

	public function getTableName() {
		return self::$tablename;
	}

	public function getValues() {
		return $this->values;
	}

	public static function loadAll() {
		return parent::loadAll(get_class());
	}

	public static function login($username, $password) {
		$loginqueryformat = 'SELECT * FROM user WHERE username = \'%s\' and password = \'%s\'';
		$user = null;

		$res = DatabaseEntity::query(sprintf($loginqueryformat, $username, $password));

		if (isset($res)) {
			$user = new User($res);
		}

		return $user;
	}

	public static function register($username, $password, $type) {
		$user = new User($username, $password, $type);

		$user->save();

		return $user;
	}
}
?>