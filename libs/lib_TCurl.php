<?php
class TCurl {
	protected static $_instance;

	public function __construct() {
		self::$_instance = $this;
	}

	public static function getInstance()
    {
        return self::$_instance;
    }

    
}