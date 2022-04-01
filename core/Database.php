<?php

    class  Database{

		private $host_name = DB_HOST;
		private $user_name = DB_USER;
		private $passwd = DB_PASSWD;
		private $db_name = DB_NAME;
		private $pdo;
		private $sth;

		function __construct(){
			try{
				$this->pdo = new PDO("mysql:host=$this->host_name;dbname=$this->db_name",$this->user_name,$this->passwd);
			}catch(PDOException $exp){
				die('Ops something went wrong!!!!');
			}
		}

		/**
		 * 
		 * Prepare query and asign it to $sth property
		 * 
		 * @param array
		 * @return void
		 * 
		 */
		
		public function prepareQuery($query){
			$this->sth = $this->pdo->prepare($query);
		}	

		/**
		 * 
		 * Bind given values and execute
		 * 
		 * @param array $values to bind
		 * @return void
		 * 
		 */

		public function bindValues($values = []){
			$num_params = count($values);
			for ($i=0; $i < $num_params; $i++) { 
				$this->sth->bindValue($i+1,$values[$i]);
			}
		}

		/**
		 * Execute 
		 * @param array
		 */

		public function execute($values = []){
			$this->bindValues($values);
			return $this->sth->execute();
		}

		/**
		 * insert method
		 * @param string $table name
		 * @param array $attrs table attributes
		 * @param array $values to be inserted
		 * @return true|false
		 */

		 public function insert($table,$params = []){
			 
			 $values = [];
			 $columns = '';
			 $query = '';
			 $labels = '';

			 // form sql attributes and values
			 foreach ($params as $column => $value) {
				 $values[] = $value;
				 $columns.="$column,";
				 $labels.="?,";
			 }

			 // remove last comma
			 $columns = rtrim($columns,',');
			 $labels = rtrim($labels,',');
			 
			 // form sql query
			 $query = "INSERT INTO $table($columns) VALUES($labels)";

			 // Prepare query
			 $this->prepareQuery($query);
			 // Execute query
			 return $this->execute($values);
		 }

		 /**
		 * Select method
		 * @param string $table name
		 * @param array $attrs table attributes
		 * @param array $values to be selected
		 * @return array|false
		 */

		 public function select($table,$attrs = [],$values = [],$all = true){

			$query = '';
			// form sql attributes and values
			if (!empty($attrs)) {
				foreach ($attrs as $key => $attr) {
					$query.=" $attr LIKE ? AND";
				}
	
				// remove last 'AND' (!rtrim is case sensitive)
				$query = rtrim($query,'AND');	
			}else $query = 1;
			// form sql query
			$query = "SELECT * FROM $table WHERE $query";
			// Prepare query
			$this->prepareQuery($query);
			// Execute query
			if($all) return $this->execute($values) ? $this->getResult() : false;
			return $this->execute($values) ? $this->getRow() : false;
		 }

		 /**
		  * update records
		  */

		 public function update($table,$primaryKey,$keyValue,$params){
			$values = [];
			$statments = '';
			$query = '';
			// form sql attributes and values
			foreach ($params as $column => $value) {
			 $values[] = $value;
			 $statments.="$column = ?,";
			}

			$values[] = $keyValue;
			// remove last comma
			$statments = rtrim($statments,',');
			
			// form sql query
			$query = "UPDATE $table SET $statments WHERE $table.$primaryKey = ?";
			// Prepare query
			$this->prepareQuery($query);
			// Execute query
			return $this->execute($values);	

		 }

		 public function delete($table,$columnId,$valueId){
			$this->prepareQuery("DELETE FROM $table WHERE $table.$columnId = ?");
			return $this->execute([$valueId]);
		 }

		/**
		 * 
		 * Get result 
		 * 
		 * @param integer  PDO::FETCH_ASSOC | PDO::FETCH_OBJ | PDO::FETCH_COLUMN | ...
		 * @return object|array| ... depending on the given param
		 * 
		 */
 
		public function getResult($fetchType = PDO::FETCH_ASSOC){
			return $this->sth->fetchAll($fetchType);
		}

		/**
		 * 
		 * Get one row
		 * @return object
		 * 
		 */

		public function getRow($fetchType = PDO::FETCH_ASSOC){
			return $this->sth->fetch($fetchType);
		}

		/**
		 * get numbre of rows
		 * @return integer
		 */
		
		public function numRows(){
			return $this->sth->rowCount();
		}

		/**
		 * lastInsertId : return the last inserted id
		 * 
		 * @param void
		 * @return integer|string
		 * 
		 */
		public function lastInsertId(){
			return $this->pdo->lastInsertId();
		}

		/**
		 * get table primary key
		 * 
		 * @param string $table : name of the table
		 * @return string 
		 * 
		 */

		public function getPrimaryKey($table){
			$this->prepareQuery("SELECT column_name as PRIMARYKEYCOLUMN FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS AS TC 
				INNER JOIN INFORMATION_SCHEMA.KEY_COLUMN_USAGE AS KU
				ON TC.CONSTRAINT_TYPE = 'PRIMARY KEY' 
				AND TC.CONSTRAINT_NAME = KU.CONSTRAINT_NAME 
				AND KU.table_name = ? 
				ORDER BY KU.TABLE_NAME ,KU.ORDINAL_POSITION");
			 
			$this->execute([$table]);
			return $this->getRow()['PRIMARYKEYCOLUMN'];
		}
		
	}
	
