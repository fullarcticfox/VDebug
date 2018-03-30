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
	}
	
	
	private function showarray($arr, $var_index, $level=1 )
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
									<details open><summary>['.$k.'] =>  array</summary>'.$this->showarray($v, $var_index, $level).'</details></div>';
					$level--;
					
				}
				else
				{
					$html .= '<div class="VDebugArrayTree" style="padding-left: '.$padding_left.'px">['.$k.'] => ['.$v.']</div>';
				}
				$html .= '';
			}
		}
		
		return $html;
	}
	
	
}