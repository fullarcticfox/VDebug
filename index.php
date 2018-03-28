<?php
include_once 'vdebug_interface.php';

session_start();

if(isset($_GET['mode'])&&$_GET['mode']=='ajax')
{
	$debug = new VDebugInterface; 
	if(isset($_GET['action']))
	{
		$methods = get_class_methods('VDebugInterface');
		if(in_array($_GET['action'], $methods))
		{
			$f = $_GET['action'];
			if(strlen($f)==0)
				die;
			try
			{
				$debug->$f($_GET);
			}
			catch(Exception $e){
				echo $e->getMessage();
				die;
			}
		}
	}
	die;
}
	

?>



<!DOCTYPE html>

<head>

  <meta charset="utf-8">
  <title>VDebug Test</title>
   <script type="text/javascript" src="/vdebug/js/jquery-3.3.1.min.js"></script>
   <script type="text/javascript" src="/vdebug/js/vdebug.js"></script>
   <link rel="stylesheet" type="text/css" href="/vdebug/css/vdebug.css" >
  </head>
<body>

<div id="VDebugPanel" class="VDebugPanel">
<div class="VDebugPanelLeftSideBar">
<input type="text" id="VDebugFilterVarsSearch" class="VDebugFilterVarsSearch" value="" />
<div>Список переменных:</div>
<select id="VDebugFilterVarsSelector" class="VDebugFilterVarsSelector" size="30" >

</select>

</div>

<div class="VDebugPanelScene" id="VDebugPanelScene">

</div>

</div>

<?php
include_once("vdebug.php");


$obj = new A;



class A
{
	public $debug;
	public static $static_var;
	
	
	public function __construct()
	{
		$this->debug = new VDebug();
		$this->foo();
	}
	
	private function foo()
	{
		
		$this->bar();
		
		
	}
	
	
	private function bar()
	{
		//unset($_SESSION['VDebug']);
		$arr=array(1,2,array('ffdfd'=>'fdfd', 'pole'=>'tupol'));
		//$this->debug->wv1($arr, 'arr');
		
		$this->debug->wv1($arr, 'arr2');

		
		$arr = array('volga', 'jkjkj');
		
		$this->debug->epilog();
	}
	
	
	public static function s()
	{
		
		
	}
	
	
}

?>


</body>
</html>








