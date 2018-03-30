
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
			   $("#VDebugFilterVarsSelector").prepend( $('<option value="'+key+'">'+val+'</option>') );
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
	//alert(var_index);
	$('#VDebugArrayTree').highlight("tupol");

}

