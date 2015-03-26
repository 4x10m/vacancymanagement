<?php
require_once 'lib/databaseentity.php';

//this class represent a stage
class User extends DatabaseEntity {
	public static $tablename = 'user';
	protected $values = array('name' => '', 'email' => '', 'password' => '', 'type' => '', 'graduate' => '', 'skill' => '');

	public function getTableName() {
		return self::$tablename;
	}

	public function getValues() {
		return $this->values;
	}

	public function setSkills($skills) {
		$this->set("skill", implode($skills, ","));

		$this->save();

		return ;
	}

	public function getSkills() {
		$getskillsquery = 'SELECT skill FROM user WHERE id = %s';

		$result = DatabaseEntity::query(sprintf($getskillsquery, $this->getId()));

		return explode(",", $result[0]['skill']);
	}

	public static function loadAll() {
		return parent::loadAll(get_class());
	}

	public static function login($username, $password) {
		$loginqueryformat = 'SELECT * FROM user WHERE email = \'%s\' and password = \'%s\'';
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

	public static function search($graduate, $skills) {
		$loginqueryformat = 'SELECT * FROM user WHERE type="STUDENT" and graduate like "%%" and skill like "%%%s';

		$loginqueryformat = sprintf($loginqueryformat, implode('%" or skill ilike "%', $skills));
		$loginqueryformat = $loginqueryformat.'%"';

		$students = DatabaseEntity::query($loginqueryformat);

		return $students;
	}

	public static function searchGraduate($graduate) {
		$loginqueryformat = 'SELECT * FROM user WHERE type="STUDENT" and graduate like "%' .$graduate. '%"';

		$students = DatabaseEntity::query($loginqueryformat);

		return $students;
	}

	public static function searchSkills($skills) {
		$loginqueryformat = 'SELECT * FROM user WHERE type="STUDENT" and skill like "%%%s';

		$loginqueryformat = sprintf($loginqueryformat, implode('%" or skill ilike "%', $skills));
		$loginqueryformat = $loginqueryformat.'%"';

		$students = DatabaseEntity::query($loginqueryformat);

		return $students;
	}
}
?>