$(document).ready(function(){
	$('#t1').Tabledit({
			deleteButton: false,
			editButton: false,
			columns: {
					identifier: [0, 'id'],
					editable: [[1, 'nome'], [2, 'luogo'], [3, 'data_inizio'], [4, 'data_fine']]
			},
			hideIdentifier: true,
			url: 'live_edit.php'
	});
});