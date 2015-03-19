<?php
require_once 'user.php';
require_once 'lib/databaseentity.php';

//this class represent a stage
class StudentSession extends DatabaseEntity {
	public static $tablename = 'studentsession';
	protected $values = array('name' => '', 'contact' => '', 'type' => '', 'validationcode' => '');

	public function getTableName() {
		return self::$tablename;
	}

	public function getValues() {
		return $this->values;
	}

	public static function loadAll() {
		return parent::loadAll(get_class());
	}

	public static function add($value) {
		$session = new StudentSession(array('name' => $value[0], 'contact' => $value[1], 'type' => 'EMAIL', 'validationcode' => StudentSession::generateRandomValidationCode()));

		$session->save();

		$session->sendValidationMail();
	}

	public function validate($code, $password) {
		if ($code == $this->get('validationcode')) {
			$this->delete();

			User::register($this->get('name'), $password, 'STUDENT');

			return true;
		}

		return false;
	}

	private function sendValidationMail() {
		$validationcode = $this->get("validationcode");

		$subject = "Validation de votre inscription a notre site de gestion de stage";
		//TODO complete message
		$messageformat = "Bonjour, vous vous êtes inscrit en tant qu'entreprise a notre site de gestion. <a href=\"http://localhost/projetstage/website/validatestudentsession.html?id=%s&code=%s\">Le lien de validation</a>. Le code: %s";

		$message = sprintf($messageformat, $this->getId(), $validationcode, $validationcode);

		mail($this->get("contact"), $subject, $message);
	}

	//création d'un fonction qui calcule une puissance
	private static function pow($nb, $exposant) {
		$result = 1;

		for ($n = 1; $n <= $exposant; $n++) {
			$result = $result * $nb;
		}

		return $result;
	}

	//création de la fonction qui génère le code
	private static function generateRandomValidationCode() {
		srand((double) microtime() * 1000000);

		//intialisation du générateur de nombres aléatoires
		$min = 5; //nombre minimum de chiffres
		$max = 10; //nombre maximum de chiffres
		$nb_chiffres = rand($min, $max);

		// choix du nombre de chiffres entre $min et $max
		$nb_max = self::pow(10, $nb_chiffres) - 1; //nombre maximum possible (999...9)
		$nb_min = self::pow(10, $nb_chiffres - 1); //nombre minimum possible (10...0)

		$code = rand($nb_min, $nb_max);

		return $code;
	}
}
?>