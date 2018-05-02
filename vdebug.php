<?php

class VDebug
{
	private $vars;
	
	
	/*
	*    0 - Debug off;
	*/
	public function __construct()
	{
		if(isset($_SESSION['VDebug']['vars']) && sizeof($_SESSION['VDebug']['vars'])!=0)
		{
			$this->vars = $_SESSION['VDebug']['vars'];
		}
		
		//print_r($_SESSION['VDebug']['vars']);

		//Register end script event
		register_shutdown_function(array($this, 'shutdown'));
		//unset($_SESSION['VDebug']);
		
	}
	
	
	public function shutdown()
	{
		if(isset($_GET['mode'])&&$_GET['mode']=="ajax")
			return;
		$names = $this->get_vars_names();
		
		
		//print_r($names);
	}
	
	
	private function get_vars_names()
	{

		
	}
	

	public function get_var($var_index)
	{
		$var = array();
		if(!isset($_SESSION['VDebug']['vars'][$var_index]))
			return $var;
		$var = $_SESSION['VDebug']['vars'][$var_index];
		return $var;
	}
	

	//Watch var level 1
	public function wv1($var, $var_name)
	{	
		$trace = debug_backtrace();
	
		$line = -1;
		$file = '';
		$func = '';
		$class = '';
		
		if(isset($trace[0]))
		{
			$line = $trace[0]['line'];
			$file = $this->get_file_name($trace[0]['file']);
		}
		
		if(isset($trace[1]))
		{
			$func = $trace[1]['function'];
			$class = $trace[1]['class'];
		}
		
		$this->var_add_to_stack($var, $var_name, $line, $file, $func, $class);
	}	
	
	
	public function get_var_list()
	{
		$vars = array();
		if(sizeof($this->vars)==0)
			return $vars;
		foreach($this->vars as $index=>$data)
		{
			$vars[$index]=$data;
		}
		return $vars;
	}
	
	
	private function var_add_to_stack($var, $var_name, $line=-1, $file='', $func='', $class='')
	{
		$index = $file.$line;
		if(!$this->var_index_exists($file, $line))
		{
			$type = gettype($var);
			$this->vars[$index] = array('NAME'=>$var_name, 'VALUE'=>$var, 'LINE'=>$line, 'FILE'=>$file, 'FUNC'=>$func, 'CLASS'=>$class, 'TYPE'=>$type);
			$_SESSION['VDebug']['vars'][$index] = array('NAME'=>$var_name, 'VALUE'=>$var, 'LINE'=>$line, 'FILE'=>$file, 'FUNC'=>$func, 'CLASS'=>$class, 'TYPE'=>$type);
		}
		
		
		//Var exists, updating...
		$this->vars[$index]['NAME'] = $var_name;
		$this->vars[$index]['VALUE'] = $var;
		$this->vars[$index]['LINE'] = $line;
		$this->vars[$index]['FILE'] = $file;
		$this->vars[$index]['FUNC'] = $func;
		$this->vars[$index]['CLASS'] = $class;
		$this->vars[$index]['TYPE'] = $type;
		
		$_SESSION['VDebug']['vars'][$index]['NAME'] = $var_name;
		$_SESSION['VDebug']['vars'][$index]['VALUE'] = $var;
		$_SESSION['VDebug']['vars'][$index]['LINE'] = $line;
		$_SESSION['VDebug']['vars'][$index]['FILE'] = $file;
		$_SESSION['VDebug']['vars'][$index]['FUNC'] = $func;
		$_SESSION['VDebug']['vars'][$index]['CLASS'] = $class;
		$_SESSION['VDebug']['vars'][$index]['TYPE'] = $type;
	}
	
	
	
	private function var_index_exists($file, $line)
	{
		$index = $file.$line;
		if(isset($this->vars[$index]))
			return true;
		return false;
	}
	
	
	private function var_exists($var_name)
	{
		if(sizeof($this->vars)==0)
			return -1;
		
		foreach($this->vars as $index=>$data)
		{
			if($data['NAME']==$var_name)
			{
				return $index;
			}
			
		}
		
		return -1;
	}
	
	

	
	public function epilog()
	{
		
	
	}
	
	
	private function get_file_name($path)
	{
		$arr = explode('/', $path);
		if(strpos($path, '/')===false)
		{
			$arr = explode('\\', $path);
		}
		if(sizeof($arr)<=1)
			return $path;
		
		return array_pop($arr);
	}	

}
?>


