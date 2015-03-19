<?php
include_once '../lib/config.php';
require_once 'lib/databaseentity.php';

//this class represent a stage
class GCMUser extends DatabaseEntity {
	public static $tablename = 'gcmuser';
	protected $values = array('name' => '', 'registrationid' => '');

	public function getTableName() {
		return self::$tablename;
	}

	public function getValues() {
		return $this->values;
	}

	public static function loadAll() {
		return parent::loadAll(get_class());
	}

	public static function storeUser($name, $registrationid) {
		$id = parent::query(sprintf('SELECT id FROM %s WHERE name = %s', self::$tablename, $name));

		if ($id > 0) {
			$gcmuser = new GCMUser($id);
			$gcmuser->set('registrationid', $id);
			$gcmuser->save();

			return true;
		} else {
			$gcmuser = new GCMUser(array('name' => $name, 'registrationid' => $registrationid));
			$id = $gcmuser->save();

			if ($id > 0) {
				return true;
			} else {
				return false;
			}
		}

		return false;
	}

	public static function sendNotificationToAllGCMUser($message) {
		file_put_contents(LOG_FILE_PATH, sprintf('gcm user send message to all %s' . PHP_EOL, $message), FILE_APPEND);

		$ids = parent::query('SELECT registrationid FROM gcmuser');

		ob_start();
		print_r($ids);
		$serializedidsforprint = ob_get_contents();
		ob_end_clean();

		file_put_contents(LOG_FILE_PATH, sprintf('to ids %s' . PHP_EOL, $serializedidsforprint), FILE_APPEND);

		foreach ($ids as $id) {
			GCMUser::send_notification($id, $message);
		}
	}

	public static function send_notification($registatoin_ids, $message) {
		$url = 'https://android.googleapis.com/gcm/send';

		$fields = array(
			'registration_ids' => array($registatoin_ids),
			'data' => array('message' => $message),
		);

		$headers = array(
			'Authorization: key=' . GOOGLE_API_KEY,
			'Content-Type: application/json',
		);
		// Open connection
		$ch = curl_init();

		// Set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Disabling SSL Certificate support temporarly
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

		// Execute post
		$result = curl_exec($ch);

		file_put_contents(LOG_FILE_PATH, sprintf('send notification %s' . PHP_EOL, $result), FILE_APPEND);

		if ($result === FALSE) {
			die('Curl failed: ' . curl_error($ch));
		}

		// Close connection
		curl_close($ch);
	}
}
?>