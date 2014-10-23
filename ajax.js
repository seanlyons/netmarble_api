var frm = $('#dyno');

$('select').on('change', function() {
	var functionality = $('select option:selected')[0].text;
	var lc = functionality.toLowerCase();
	var data = $('#'+lc).attr("data-json");
	getDataAttribute( data, lc );
});

function getDataAttribute( data, lc ) {
	console.log( 'data=' );
	console.log( data );
	$('#dyno').empty();
	if (data === '[]') {
		console.log( 'nil' );
		$( "#dyno" ).append( "This call accepts no inputs.");
	}
	var parsed = $.parseJSON(data);
	$("#dyno").append( '<br/><input type="hidden" name="request_type" value="'+lc+'">' );
	
	$.each( parsed , function( key, value ) {
		var gkey = key;
		
		new_input = '<span class="wrapper"><span class="col1">' + key + '</span><input class="col2" type="text" name="'+key+'" placeholder="'+ value.vartype +': '+value.example +'"></span><br/>';
		$( "#dyno" ).append( new_input );
	});
	$("#dyno").append( '<br/><input type="submit" value="Submit">' );

	return;
}

frm.submit(function (ev) {
	var jqxhr = $.ajax({
			type: 'get',
			url: 'nway.php',
			//async: TRUE,
			dataType: 'json',
			data: frm.serialize(),				
		})
		.done(function(data) {
			console.log(data);
			$( "#dyno" ).append( '<pre>' + data.command + '</pre>');
			$( "#dyno" ).append( '<pre>' + JSON.stringify(JSON.parse(data.response), undefined, 2) + '</pre>');
		})
		.fail(function() {
			//console.log( "errorrrrrr" );
		})
		.always(function() {
			//console.log( "completeeeee" );
		});

	ev.preventDefault();
});	