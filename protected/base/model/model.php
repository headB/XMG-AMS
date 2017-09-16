<?php
class model{
	public $model = NULL;
	public $db = NULL;
	protected $table = "";
	protected $ignoreTablePrefix = false;
	
	public function __construct( $database, $force = false){


		$this->model = self::connect(config($database), $force);

		$this->db = $this->model->db;
	}
	
	static public function connect($config, $force=false){
		static $model = NULL;
		static $configDBName = NULL;
		if(empty($model)){$configDBName = $config['DB_NAME']; }
		else{
				if($configDBName!=$config['DB_NAME']){
					$force = true;
					$configDBName = $config['DB_NAME'];
				}
			}
		

		if( $force==true || empty($model) ){

			
			$model = new cpModel($config);
		}
		return $model;
	}
	
	public function query($sql){
		return $this->model->query($sql);
	}
	
	public function find($condition = '', $field = '', $order = ''){
		return $this->model->table($this->table, $this->ignoreTablePrefix)->field($field)->where($condition)->order($order)->find();
	}
	
	public function select($condition = '', $field = '', $order = '', $limit = ''){
		return $this->model->table($this->table, $this->ignoreTablePrefix)->field($field)->where($condition)->order($order)->limit($limit)->select();
	}
	
	public function count($condition = ''){
		return $this->model->table($this->table, $this->ignoreTablePrefix)->where($condition)->count();
	}
	
	public function insert($data = array() ){
		return $this->model->table($this->table, $this->ignoreTablePrefix)->data($data)->insert();
	}
	
	public function update($condition, $data = array() ){
		return $this->model->table($this->table, $this->ignoreTablePrefix)->data($data)->where($condition)->update();
	}
	
	public function delete($condition){
		return $this->model->table($this->table, $this->ignoreTablePrefix)->where($condition)->delete();
	}
	
	public function getSql(){
		return $this->model->getSql();
	}
	
	public function escape($value){
		return $this->model->escape($value);
	}
	
	public function cache($time = 0){
		$this->model->cache($time);
		return $this;
	}

	function conditionToSql($conditionArray){

		$condition = "";
		if(!empty($conditionArray)) {

			if(is_string($conditionArray)) {
				$condition .= $conditionArray;
			} else if(is_array($conditionArray)) {
				foreach($conditionArray as $key => $value) {
					if(empty($value)){continue;}
					$condition .= " `$key` = " . $this->escape($value) . " AND ";
				}

				$condition = substr($condition, 0,-4);
			} else {
				$condition = "";
			}
		}
		return $condition;
	}

	function conditionToSqlWithWhere($conditionArray){

		$condition = "";
		if(!empty($conditionArray)) {
			$condition = " WHERE ";
			if(is_string($conditionArray)) {

				$condition .= $conditionArray;
			} else if(is_array($conditionArray)) {
				foreach($conditionArray as $key => $value) {
					if(empty($value)){continue;}
					$condition .= " `$key` = " . $this->escape($value) . " AND ";
				}

				$condition = substr($condition, 0,-4);
			} else {
				$condition = "";
			}
		}
		return $condition;
	}

	function conditionToSqlWhere($conditionArray){

		$condition = "";
		if(!empty($conditionArray)) {

			if(is_string($conditionArray)) {
				$condition .= $conditionArray;
			} else if(is_array($conditionArray)) {
				foreach($conditionArray as $key => $value) {
					if(empty($value)){continue;}
					$condition .= " $key = " . $this->escape($value) . " AND ";
				}

				$condition = substr($condition, 0,-4);
			} else {
				$condition = "";
			}
		}
		return $condition;
	}

	function conditionLike1($array){

		$sql = '';
		$i=1;
		foreach($array as $key=>$value){

		if(empty($value)){continue;}
			$value.='%';
			$value = $this->escape($value);

			if($i==1){

				$sql = " `$key` like  $value ";
				$i++;
			}elseif($i>1){

				$sql.= " and `$key` like $value ";
			}

		}
		if(!empty($sql)) {$sql.=" and ";}
		return $sql;

	}

	function conditionLike($array){

		$sql = '';
		$i=1;
		foreach($array as $key=>$value){

			if(empty($value)){continue;}
			$value.='%';
			$value = $this->escape($value);

			if($i==1){

				$sql = " `$key` like  $value ";
				$i++;
			}elseif($i>1){

				$sql.= " and `$key` like $value ";
			}

		}

		return $sql;

	}

	public function insertEcho($list,$tableName)
	{

		$count=count($list);
		$sql = "insert into `$tableName` ";
		$i=1;foreach ($list as $k => $v) {
		$k = $this->escape($k);
		$k = trim($k,"'");
		if($i==1 and $count==1)
		{$sql.="(`$k`) ";}
		if($i==1 and $count!=1){$sql.="(`$k`,";}
		if($i>1 and $i < $count){$sql.="`$k`,";}
		if($i>1 and $i==$count){$sql.="`$k`) ";}

		$i++;}


		$i=1;foreach ($list as $k => $v) {
		$v = $this->escape($v);
		$v = trim($v,"'");
		if($i==1 and $count ==1 )
		{$sql.="values('$v')";}
		if($i==1 and $count!=1){$sql.="values('$v',";}
		if($i > 1 and $i < $count){$sql.="'$v',";}
		if($i>1 and $i==$count){$sql.="'$v') ";}

		$i++;}
		return $sql;
	}

	public function updateEcho($list,$tableName,$whereArray)
	{
		$tableName = trim($this->escape($tableName),"'");
		$count = count($list);
		$sql = "UPDATE `$tableName` SET ";
		$i = 1;
		foreach($list as $k => $v)
		{
			$k = trim($this->escape($k),"'");
			$v = trim($this->escape($v),"'");
			if($v=="null"){$sql.="`$k` = '$v'";}
			else
			{$sql.="`$k` = '$v'";}

			if($i<$count)
			{$sql.=",";}
			$i++;}



		$i=1; foreach ($whereArray as $k => $v) {
		$k = trim($this->escape($k),"'");
		$v = trim($this->escape($v),"'");
		if($i==1)
		{$sql.=" WHERE `$k` = '$v' ";}
		if($i>1)
		{$sql.="and `$k` = '$v' ";}
		$i++;

		$i++;}
		return $sql;}
	
}