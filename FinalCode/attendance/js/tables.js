$(document).ready(function() {
        $('#example').DataTable( {
        dom: 'Bfrtip',
		scrollX: true,
		buttons: [
			{ extend: 'excel', text: 'Download' }
		]
    } );
} );