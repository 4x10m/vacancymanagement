<?php
require_once 'user.php';
require_once 'stage.php';
require_once 'lib/databaseentity.php';

//this class represent a stage
class Candidature extends DatabaseEntity {
	public static $tablename = 'candidature';
	protected $values = array('student' => '', 'stage' => '');

	public function getTableName() {
		return self::$tablename;
	}

	public function getValues() {
		return $this->values;
	}

	public static function loadAll() {
		return parent::loadAll(get_class());
	}

	public static function getCandidatures($id) {
		$candidaturearray = array();

		$query = "SELECT * FROM candidature inner join stage on candidature.stage = stage.id inner join user on candidature.student = user.id WHERE candidature.stage = %s";

		return parent::query(sprintf($query, $id));
	}

	public function getCandidatedStage($userid) {
		$stagearray = array();

		$query = "SELECT * FROM stage WHERE id in (SELECT stage FROM candidature where student = %s)";

		return parent::query(sprintf($query, $userid));
	}
}
?>