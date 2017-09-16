<?php
class baseModel extends model{
     protected $prefix='';

     public function __construct( $database,$force = false ){
		parent::__construct($database,$force = false);
		$this->prefix=config('DB_PREFIX');
	}
}