
$( document ).ready(function() {
   //alert('ready');
   VDebugLoadVarsList();
   
   $( "#VDebugFilterVarsSelector" ).click(function() {
		VDebugLoadVarData();
	});
});



function VDebugLoadVarsList()
{
	$.ajax({
	  dataType: "json",
	  url: '/vdebug/index.php?mode=ajax&action=getvarlist',
	  success: function( data, value ){
		  //alert(data);
		   $.each( data, function( key, val ) {
			   var v_name = '';
			   var v_type = '';
			   var v_file = '';
			   var v_line = '';
			   $.each( val, function( k, v ) {
				   //alert(v);
				   if(k=='NAME')
				   {
						v_name = v;
				   }
				   if(k=='FILE')
				   {
						v_file = v;
				   }
				   if(k=='LINE')
				   {
						v_line = v;
				   }
					if(k=='TYPE'&&v=='object')
					{
						v_type = 'obj';
					}
					if(k=='TYPE'&&v=='boolean')
					{
						v_type = 'bool';
					}
					if(k=='TYPE'&&v=='string')
					{
						v_type = 'str';
					}
					if(k=='TYPE'&&v=='array')
					{
						v_type = 'arr';
					}
					if(k=='TYPE'&&v=='integer')
					{
						v_type = 'int';
					}
					if(k=='TYPE'&&v=='float')
					{
						v_type = 'float';
					}
			   });
			   $("#VDebugFilterVarsSelector").append( $('<option value="'+key+'">'+v_name+ ' ['+v_file+':'+v_line+' '+v_type+']</option>') );
		   });
		  
	  }
	});
}



function VDebugLoadVarData()
{
	var var_index = $( "#VDebugFilterVarsSelector :selected" ).val();
	//alert(var_index);
	if(var_index==undefined)
		return;
	
	$.ajax({
	  dataType: "html",
	  url: '/vdebug/index.php?mode=ajax&action=showvar',
	  data: {"var_index":var_index},
	  success: function( data ){
		  //alert(data);
		   $('#VDebugPanelScene').html(data);
	  }
	});
	
	
}


function VDebugFilterArray(var_index)
{
	$('.vdebug_arraykey').css('background-color', ' rgb(220,220,220)');
	$('.vdebug_arrayvalue').css('background-color', ' rgb(220,220,220)');

	var text = $('#VDebugArrayFilter').val();
	if(text.length==0)
		return;
	$('.vdebug_arrayvalue:contains('+text+')').css('background-color', 'yellow');	
	$('.vdebug_arraykey:contains('+text+')').css('background-color', 'yellow');

}

