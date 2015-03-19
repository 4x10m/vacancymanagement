<?php
require_once 'lib/databaseentity.php';
require_once 'user.php';

//this class represent a stage
class EnterpriseRegistration extends DatabaseEntity {
	protected $values = array('username' => '', 'password' => '', 'mail' => '', 'website' => '', 'validationcode' => '', 'validationlevel' => '');

	public function getTableName() {
		return 'enterpriseregistration';
	}

	public function getValues() {
		return $this->values;
	}

	public static function loadAll() {
		return parent::loadAll(get_class());
	}

	public static function register($username, $password, $mail, $website) {
		$enterpriseregistration = new EnterpriseRegistration($username, $password, $mail, $website, self::generateRandomValidationCode(), 'REGISTERED');

		$enterpriseregistration->save();
		$enterpriseregistration->sendValidationMail();
	}

	public static function getUnvalidatedEnterpriseRegistration() {
		$sqlquery = "select id, username, mail, website from enterpriseregistration where validationlevel = 'COMPLETE'";

		return DatabaseEntity::query($sqlquery);
	}

	public function validate($code) {
		$result = false;

		if ($code == $this->get("validationcode")) {
			$this->set("validationlevel", 'COMPLETE');

			$result = $this->save();
		}

		return $result;
	}

	public function manualValidation() {
		$result = false;

		$result = User::register($this->get('username'), $this->get('password'), 'ENTERPRISE');

		if ($result != null) {
			$result = $this->delete();
		}

		return $result;
	}

	public function manualRefuse() {
		$result = false;

		$this->set("validationlevel", "REFUSED");

		$result = $this->save();

		return $result;
	}

	private function sendValidationMail() {
		$validationcode = $this->get("validationcode");

		$subject = "Validation de votre inscription a notre site de gestion de stage";
		//TODO complete message
		$messageformat = "Bonjour, vous vous êtes inscrit en tant qu'entreprise a notre site de gestion. <a href=\"http://localhost/projetstage/website/validateenterpriseregistration.html?id=%s&code=%s\">Le lien de validation</a>. Le code: %s";

		$message = sprintf($messageformat, $this->getId(), $validationcode, $validationcode);

		mail($this->get("mail"), $subject, $message);
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