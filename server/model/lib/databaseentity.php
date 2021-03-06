<?php
require_once 'databasecontroller.php';

//this class can be herited from model
//wich must be stored in database
//it contains an idé and multiple methods
//to store or load child in database
abstract class DatabaseEntity {
	//id attributes
	private $id;

	public function getId() {
		return $this->id;
	}

	public function set($key, $value) {
		$this->values[$key] = $value;
	}
	public function get($key) {
		return $this->getValues()[$key];
	}

	//constructor
	//if id is set, load attributes from database and deserialize them
	public function __construct() {
		$args = func_get_args();
		$argsnb = func_num_args();
			
		switch($argsnb) {
			case 1:
			if (is_array($args[0])) {
				if (is_array($args[0][0])) {
					$this->deserialize($args[0][0]);
				}
				else $this->deserialize($args[0]);
			}
			else {
				$this->id = $args[0];
				$this->load();
			}
			break;
			default:
				$this->deserialize($args);
		}
	}

	//abstracts methods
	public abstract function getTableName();
	protected abstract function getValues();

	public function serialize() {
		$values = $this->getValues();
		$result = array();

		if ($this->getId() > 0) {
			$result = array('id' => $this->getId());
		}

		foreach ($values as $key => $value) {
			$result[$key] = $value;
		}

		return $result;
	}

	protected function deserialize($data) {
		$keyset = false;

		if (is_array($data)) {
			//set id
			if (array_key_exists("id", $data)) {
				$this->id = $data["id"];

				unset($data["id"]);
			}

			//deseralize with key
			foreach ($data as $key => $value) {
				if (array_key_exists($key, $this->getValues())) {
					$this->set($key, $value);

					$keyset = true;
				}
			}

			//deserialize if index are number
			if (!$keyset) {
				$i = 0;
				$keys = array_keys($this->getValues());

				foreach ($keys as $key) {
					$this->set($key, $data[$i]);
					$i++;
				}
			}
		} else {
			//var_dump($data);
		}
	}

	protected function delete() {
		return DatabaseController::delete($this);
	}

	//insert or update row in database following if id is set or not
	public function save() {
		$result = false;

		if (isset($this->id) and $this->id > 0) {
			$result = DatabaseController::update($this);
		} else {
			$this->id = DatabaseController::insert($this);
			
			if($this->id > 0) $result = true;
		}

		return $result;
	}

	//load child value with id
	private function load() {
		$this->deserialize(DatabaseController::select($this));
	}

	protected static function loadAll($class) {
		$rc = new ReflectionClass($class);
		$class = $rc->newInstance();
		$classes = null;

		$data = DatabaseController::selectAll($class::$tablename);

		if ($data != null) {
			$classes = array();

			foreach ($data as $row) {
				array_push($classes, $rc->newInstance($row));
			}
		}

		return $classes;
	}

	protected static function query($query) {
		return DatabaseController::selectQuery($query);
	}
}
?>