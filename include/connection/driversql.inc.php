<?php
/*******************************************
 *
 *include/driversql.inc.php -
 *
 *Auteur : Renaud GUEZENNEC
 *
 *******************************************/

require_once "settings.php";
/*
if settings.php does not exist:
Please create it like this:
 **
<?php
$dbData=array(
'connectionString'=>'mysql:host=localhost;dbname=DataBaseName',
'username'=>'mysqlLogin',
'password'=>'mysqlPassword',
);
?>
 **
And change the settings to adapt to your sever.
 */
class driversql {
	protected $db;
	protected $res;

	public function init() {
//        phpinfo();
		try {
			global $dbData;

			$this->db = new PDO($dbData["connectionString"], $dbData["username"], $dbData["password"]);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$this->db->exec("SET NAMES 'UTF8';");

		} catch (PDOException $e) {
			echo 'Connexion échouée : ' . $e->getMessage();
		}

	}
	public function sendRequest($requetesql) {

		try {

			$this->res = $this->db->query($requetesql);

		} catch (PDOException $e) {
			echo $requetesql . ' : ' . $e->getMessage();
		}
	}
	public function nextId() {

		$id = $this->db->query('SELECT LAST_INSERT_ID()');

		$seq = $id->fetch(PDO::FETCH_NUM);

		return $seq[0];
	}
	public function sendRequest2($sql) {
		try {

			$result = $this->db->query($sql);
			return $result;
		} catch (PDOException $e) {
			die($e->getMessage());
		}

//$result= 'system:'.$line['name_os'].'version:'.$line['version_os'];
	}
	public function res_tab_assoc(&$ligne) {
		try {
			$ligne = $this->res->fetch(PDO::FETCH_ASSOC);

			return $ligne;
		} catch (PDOException $e) {
			return false;
		}

	}

	public function nb_lignes() {
		return $this->res->rowCount();
	}
	public function getCount() {
		return $this->res->rowCount();
	}
	public function next_id($sequence, $id) {

		$id = $this->db->query('SELECT LAST_INSERT_ID()');

		$seq = $id->fetch(PDO::FETCH_NUM);

		return $seq[0];
	}
	public function getValue() {
		$this->res_tab_rows($id);

		return $id[0];
	}

	public function matrice_resultat(&$table) {
		while ($this->res_tab_assoc($ligne)) {
			$table[] = $ligne;
		}

	}
	public function res_tab_rows(&$ligne) {

		try {
			$ligne = $this->res->fetch(PDO::FETCH_NUM);
			return $ligne;
		} catch (PDOException $e) {
			return false;
		}
//	return $this->res->fetchInto($ligne, DB_FETCHMODE_ROW);

	}
	//mode avec resultat passer en paramètre
	public function result(&$result) {
		$result = $this->res;

	}
	public function res_tab_rows2(&$ligne, &$result) {

		try {
			$ligne = $result->fetch(PDO::FETCH_NUM);
			return $ligne;
		} catch (PDOException $e) {
			return false;
		}
		//  	return $result->fetchInto($ligne, DB_FETCHMODE_ROW);

	}
	public function getCount2(&$result) {
		return $result->rowCount();
	}
	public function res_tab_assoc2(&$ligne, $result) {
		try {
			$ligne = $result->fetch(PDO::FETCH_ASSOC);
			return $ligne;
		} catch (PDOException $e) {
			return false;
		}

//		return $result->fetchInto($ligne, DB_FETCHMODE_ASSOC);
	}
	public function changdb() {
		try {
			$this->db = new PDO($dbSecondData["connectionString"], $dbSecondData["username"], $dbSecondData["password"]);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$this->db->exec("SET NAMES 'UTF8';");

		} catch (PDOException $e) {
			echo 'Connexion échouée : ' . $e->getMessage();
		}

	}

}

?>
