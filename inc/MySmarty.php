<?php

define('ACCESS','1');
include('inc/config.php');

require('Smarty.class.php');

class MySmarty extends Smarty {

	function __construct() {
		 parent::__construct();
		 
                 global $config;
		 $this->setTemplateDir($config['smarty']['templatedir']);
		 $this->setCompileDir($config['smarty']['compiledir']);
		 $this->setConfigDir($config['smarty']['configdir']);
		 $this->setCacheDir($config['smarty']['cachedir']);
	}		
}
	
?>