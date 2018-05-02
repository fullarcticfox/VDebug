<?php

include_once 'vdebug.php';


class VDebugInterface extends VDebug
{
	
	
	public function getvarlist($params=array())
	{
		//echo 'Get Var List Called';
		$vars = $this->get_var_list();
		echo json_encode($vars);
	}
	
	
	public function showvar($params=array())
	{
		if(!isset($params['var_index']))
			return;
		
		$var_data = $this->get_var($params['var_index']);
		//print_r($params);
		
		if(is_array($var_data['VALUE']))
		{
			echo $this->showarray($var_data['VALUE'], $params['var_index']);
		}
		elseif(is_object($var_data['VALUE']))
		{
			echo $this->showobject($var_data['VALUE'], $params['var_index']);
		}
		elseif(is_bool($var_data['VALUE']))
		{
			echo $this->showbool($var_data['VALUE'], $params['var_index']);
		}elseif(is_null($var_data['VALUE']))
		{
			echo $this->shownull();
		}elseif(is_resource($var_data['VALUE']))
		{
			echo $this->showres();
		}elseif(is_string($var_data['VALUE']))
		{
			echo $this->showstring($var_data['VALUE'], $params['var_index']);
		}
		
	}
	
	
	private function showarray($arr, $var_index, $level=1)
	{
		$html = '';
		if(sizeof($arr)!=0)
		{
			if($level==1)//before level array we show caption contol
			{
				$html .= '
					<div class="VDebugFilterArray">
						<input type="text" placeholder="Key or value" id="VDebugArrayFilter" onkeyup="VDebugFilterArray('.$var_index.')">
					</div>
					';
			}
			$padding_left = 10*$level;
			foreach($arr as $k=>$v)
			{
				$html .= '';
				
				if(is_array($v))
				{
					$level++;
					$html .= '<div class="VDebugArrayTree" style="padding-left: '.$padding_left.'px" >
									<details open><summary>[<span class="vdebug_arraykey">'.$k.'</span>] =>  array</summary>'.$this->showarray($v, $var_index, $level).'</details></div>';
					$level--;
					
				}
				else
				{
					$html .= '<div class="VDebugArrayTree" style="padding-left: '.$padding_left.'px">[<span class="vdebug_arraykey">'.$k.'</span>] => [<span class="vdebug_arrayvalue">'.$v.'</span>]</div>';
				}
				$html .= '';
			}
		}
		
		return $html;
	}
	
	
	private function showobject($obj, $var_index)
	{
		$html = '<pre>';
		foreach($obj as $key=>$value)
		{
			//echo $key.' '.$value;
			ob_start();
			var_dump($value);
			$html .= ob_get_clean();
			//print $key;
			
			if(is_object($value))
			{
				$html .= $this->showobject($value, $var_index);
			}elseif(is_array($value))
			{
				$html .= $this->showarray($value, $var_index);
			}
			
		}
		
		$html .= '</pre>';
		
		return $html;
	}
	
	
	private function showbool($bool, $var_index)
	{
		$v = 'true';
		if(!$bool)
			$v = 'false';
		$html = '<div class="VDebugArrayTree" style="padding-left: 20px">'.$v.'</div>';
		return $html;
	}
	
	
	private function shownull()
	{
		$html = '<div class="VDebugArrayTree" style="padding-left: 20px">NULL</div>';
		return $html;
	}
	
	
	private function showres()
	{
		$html = '<div class="VDebugArrayTree" style="padding-left: 20px">Resource</div>';
		return $html;
	}
	
	
	private function showstring($string, $var_index)
	{
		$html = '<div class="VDebugArrayTree" style="padding-left: 20px">'.$string.'</div>';
		return $html;
	}
	
}