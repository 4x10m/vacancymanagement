<?php
require_once 'lib/databaseentity.php';
require_once 'gcmuser.php';

//this class represent a stage
class Stage extends DatabaseEntity {
	public static $tablename = 'stage';
	protected $values = array('title' => '', 'description' => '', 'enterprise' => '', 'online' => '', 'placenumber' => '');

	public function getTableName() {
		return self::$tablename;
	}

	public function getValues() {
		return $this->values;
	}

	public static function loadAll() {
		return parent::loadAll(get_class());
	}

	public static function loadAllStageFromEnterprise($id) {
		$queryformat = 'SELECT stage.id, stage.title, stage.description FROM stage WHERE enterprise = %s';

		return parent::query(sprintf($queryformat, $id));
	}

	public static function loadAllStageFromEnterpriseWithCandidatures($id) {
		$queryformat = 'SELECT stage.id, stage.title, stage.description, count(*) as nbcandidature FROM stage JOIN candidature ON stage.id = candidature.stage WHERE enterprise = %s GROUP BY stage.id';

		return parent::query(sprintf($queryformat, $id));
	}

	public function publication() {
		$this->set('online', 1);
		$this->save();

		GCMUser::sendNotificationToAllGCMUser('Un nouveau stage est en ligne');

		return true;
	}
}
?>