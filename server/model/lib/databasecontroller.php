<?php
require_once 'databaseentity.php';
require_once 'config.php';

//this class manipulate database with DatabaseEntity child
class DatabaseController {
	private static $databasehostname = "localhost";
	private static $databasename = "projetstage";
	private static $databaseusername = "www-data";
	private static $databasepassword = "";

	//instance of pdo
	private static $database = null;

	//init and connect database
	public static function init() {
		if (!isset($database)) {
			try {
				self::$database = new PDO(sprintf('mysql:host=%s;dbname=%s', self::$databasehostname, self::$databasename), self::$databaseusername, self::$databasepassword) or die;
				//self::$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				print "Erreur vous êtes non connecté ! erreur en cours : " . $e->getMessage() . "";
				die();
			}
		}
	}

	//check if type of value was database entity
	//if not throw an exception
	private static function checkType($value) {
		if (!$value instanceof DatabaseEntity) {
			throw new InvalidArgumentException(sprintf('impossible to insert value in database, it is not instance of database entity, %s', get_class($databaseentity)));
		}
	}

	//insert a class of type database entity in the database
	//databaseentity : the value to be inserted
	//return the id of the inserted line
	public static function insert($databaseentity) {
		//check argument type
		self::checkType($databaseentity);

		//init variables
		$queryformat = 'INSERT INTO %s (%s) VALUES(%s)';

		$tablename = $databaseentity->getTableName();
		$values = $databaseentity->serialize();
		$keys = array_keys($values);

		$serializedkeys = "";
		$serializedvalues = "";

		//serialize keys and values
		for ($i = 0; $i < count($keys) - 1; $i++) {
			$serializedkeys = sprintf("%s%s, ", $serializedkeys, $keys[$i]);
			$serializedvalues = sprintf("%s'%s', ", $serializedvalues, $values[$keys[$i]]);
		}

		//insert last key and value without coma
		$serializedkeys = sprintf("%s%s", $serializedkeys, $keys[count($keys) - 1]);
		$serializedvalues = sprintf("%s'%s'", $serializedvalues, $values[$keys[count($keys) - 1]]);

		$query = sprintf($queryformat, $tablename, $serializedkeys, $serializedvalues);

		file_put_contents(LOG_FILE_PATH, $query);

		//execute query
		self::$database->query($query);

		return self::$database->lastInsertId();
	}

	//update a line of database
	//databaseentity : the database entity corresponding to line wich will be updated
	//return true if update success, false if not
	public static function update($databaseentity) {
		file_put_contents(LOG_FILE_PATH, 'database controller update' . PHP_EOL, FILE_APPEND);

		//check argument type
		self::checkType($databaseentity);

		//init variables
		$queryformat = 'UPDATE %s SET %s WHERE id = %d';

		$tablename = $databaseentity->getTableName();
		$id = $databaseentity->getId();
		$values = $databaseentity->serialize();
		$keys = array_keys($values);
		$data = DatabaseController::select($databaseentity);
		$changedkeys = 0;

		$serializeddata = "";

		ob_start();
		print_r($data);
		$serializeddataforprint = ob_get_contents();
		ob_end_clean();

		ob_start();
		print_r($data);
		$serializedvaluesforprint = ob_get_contents();
		ob_end_clean();

		file_put_contents(LOG_FILE_PATH, sprintf('serializing from table %s' . PHP_EOL, $databaseentity->getTableName()), FILE_APPEND);
		file_put_contents(LOG_FILE_PATH, sprintf('original data %s' . PHP_EOL, $serializeddataforprint), FILE_APPEND);
		file_put_contents(LOG_FILE_PATH, sprintf('new data %s' . PHP_EOL, $serializedvaluesforprint), FILE_APPEND);

		for ($i = 0; $i < count($keys); $i++) {
			if ($values[$keys[$i]] !== $data[$keys[$i]]) {
				$changedkeys++;
			}
		}

		file_put_contents(LOG_FILE_PATH, sprintf('changed keys %s' . PHP_EOL, $changedkeys), FILE_APPEND);

		if ($i > 0) {
			$i = 0;

			while ($i < $changedkeys) {
				for ($j = $i; $j < count($keys); $j++) {
					if ($keys[$j] != 'id') {
						if ($values[$keys[$j]] != $data[$keys[$j]]) {
							if ($i != $changedkeys - 1) {
								$serializeddata = sprintf("%s%s = ", $serializeddata, $keys[$j]);
								$serializeddata = sprintf("%s'%s' and ", $serializeddata, $values[$keys[$j]]);
							} else {
								$serializeddata = sprintf("%s%s = ", $serializeddata, $keys[$j]);
								$serializeddata = sprintf("%s'%s'", $serializeddata, $values[$keys[$j]]);
							}

							file_put_contents(LOG_FILE_PATH, sprintf('updating %s from %s to %s' . PHP_EOL, $keys[$j], $data[$keys[$j]], $values[$keys[$j]]), FILE_APPEND);

							$i++;
						}
					}
				}
			}

			$query = sprintf($queryformat, $tablename, $serializeddata, $id);

			file_put_contents(LOG_FILE_PATH, $query . PHP_EOL, FILE_APPEND);

			//excecute query
			return self::$database->prepare($query)->execute() === true;
		}

		return false;
	}

	//select all line from a table
	//tablename : name from table where data are loaded
	//return an array where row corresponde to database row and column to database column
	public static function selectAll($tablename) {
		if (!isset($tablename) or empty($tablename)) {
			throw new InvalidArgumentException(sprintf('impossible to select data from table, argument is null or empty : %s', $tablename));
		}

		$queryformat = 'SELECT * FROM %s';

		return self::selectQuery(sprintf($queryformat, $tablename));
	}

	//load an entity from it id
	//databaseentity : class inherited from DatabaseEntity
	//return array values of data  loaded from database
	public static function select($databaseentity) {
		//check argument type
		self::checkType($databaseentity);

		$queryformat = 'SELECT * FROM %s WHERE id = %d';

		$tablename = $databaseentity->getTableName();
		$id = $databaseentity->getId();

		$data = self::$database->query(sprintf($queryformat, $tablename, $id))->fetch();

		return $data;
	}

	//delete an entity from it id
	//databaseentity : class inherited from DatabaseEntity
	//return array values of data  loaded from database
	public static function delete($databaseentity) {
		//check argument type
		self::checkType($databaseentity);

		$queryformat = 'DELETE FROM %s WHERE id = %d';

		$tablename = $databaseentity->getTableName();
		$id = $databaseentity->getId();

		return self::$database->prepare(sprintf($queryformat, $tablename, $id))->execute() === true;
	}

	//personalized select query
	//query : personalized query
	//return result of query
	public static function selectQuery($query) {
		$result = null;
		$queryresult = self::$database->query($query);

		if ($queryresult) {
			$numberofline = $queryresult->rowCount();

			switch ($numberofline) {
				case 1:
					$result = $queryresult->fetch();
					break;
				default:
					$result = $queryresult->fetchAll();
			}
		}

		return $result;
	}
}DatabaseController::init(); //initialize class
?>
