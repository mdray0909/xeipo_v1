<?php


/*
#	Session
*/
if (!session_id()){
 	if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')){
 		ob_start("ob_gzhandler");
 	} else {
 		ob_start();
 	}
 	
 	session_save_path(ROOT.DS.'/temp/sessions/');     
 	session_name("user_login");
 	session_cache_limiter ('private, must-revalidate');   
 	$cache_limiter = session_cache_limiter();
 	session_cache_expire(60); // in minutes
 	session_start();
}


/*
#	Autoload function
*/
if(phpversion() > "5.2.0"){
	function autoload($class)
	{
		$controllers_path = ROOT.DS.'app'.DS.'controllers'.DS.strtolower($class).'.class.php';
		$models_path = ROOT.DS.'app'.DS.'models'.DS.strtolower($class).'.class.php';

		if(file_exists($controllers_path)){
			include ($controllers_path);	
		}else if(file_exists($models_path)){
			include ($models_path);			
		}else{
			$massage = "No loading this class $models_path or $controllers_path !";
			die($massage);
			exit();
		}
	}

	spl_autoload_register("autoload");
}else{
	function __autoload($class)
	{
		$controllers_path = ROOT.DS.'app'.DS.'controllers'.DS.strtolower($class).'.class.php';
		$models_path = ROOT.DS.'app'.DS.'models'.DS.strtolower($class).'.class.php';

		if(file_exists($controllers_path)){
			include $controllers_path;	
		}else if(file_exists($models_path)){
			include $models_path;			
		}else{
			$massage = "No loading this class $models_path or $controllers_path !";
			die($massage);
			exit();
		}
	}
}

/*
#	Config
*/
if(file_exists(ROOT.DS.'config'.DS.'config.php')){
	include_once(ROOT.DS.'config'.DS.'config.php');
}

/*
#	Framework
*/
new Framework();


/*
#	WebLink
*/
Framework::web_link_define();  


/*
#	Developer mod
*/
if(DEVELOPER_MOD == 1){
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
}else{
	error_reporting(E_ALL);
	ini_set("display_errors", 0);
}

/*
#	Loading lang
*/
Language::lang_load();

/*
#	Add Views
*/
$views = new Views();
    

/*
#	Ak web nieje s koncovkou https tak ju presmerujeme :)
*/

/*
if(SSL_CERTIFICAT_TRUE == 1){
	if($_SERVER['REQUEST_SCHEME'] == "http"){
		header("location: ".WEB);	 
	}
}*/


?>