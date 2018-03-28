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

		//Register end script event
		register_shutdown_function(array($this, 'shutdown'));
		
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
		$this->var_add_to_stack($var, $var_name);
	}	
	
	
	public function get_var_list()
	{
		$vars = array();
		if(sizeof($this->vars)==0)
			return $vars;
		foreach($this->vars as $index=>$data)
		{
			$vars[$index]=$data["NAME"];
		}
		return $vars;
	}
	
	
	private function var_add_to_stack($var, $var_name)
	{
		$var_index = $this->var_exists($var_name);
		if($var_index==-1)
		{
			$this->vars[] = array('NAME'=>$var_name, 'VALUE'=>$var);
			$_SESSION['VDebug']['vars'][] = array('NAME'=>$var_name, 'VALUE'=>$var);
			return sizeof($this->vars)-1;
		}
		
		
		//Var exists, updating...
		$this->vars[$var_index]['VALUE'] = $var;
		return -1;
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
	
}
?>


