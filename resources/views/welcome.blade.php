<!doctype html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Laravel test</title>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.css" />
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.css" />
		<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.css" />
		<link rel="stylesheet" href="https://cdn.datatables.net/select/1.1.2/css/select.dataTables.css" />

		<script src="https://code.jquery.com/jquery-1.12.4.js" ></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.js" ></script>
		<script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.js" ></script>
		<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.js" ></script>
		<script src="https://cdn.datatables.net/select/1.1.2/js/dataTables.select.js" ></script>
		<script type="text/javascript" charset="utf8" src="./js/dataTables.altEditor.free.js"></script>

		<style>
		body, .dataTables_wrapper {
			margin: 20px;
		}
		</style>
	</head>
	<body>
		<div id="container">
			<table id="users" class="table table-striped cell-border compact"></table>
			<table id="transactions" class="table table-striped cell-border compact"></table>
		</div>
		<script>
		$(document).ready(function() {
			var countryOptions = {!! json_encode($countries) !!};
			$('#users').DataTable({
				dom: 'Bfrtip',
				select: 'single',
				altEditor: true,
				ajax: { url: './api/user/search', dataSrc: '' },
				columns: [
					{ data: "user_id", title: "User ID", type: "readonly" },
					{
						data: "citizenship_country_id",
						title: "Citizenship",
						type : "select",
						options : countryOptions,
						render: function (data, type, row, meta) {
							if (data == null || !(data in countryOptions)) return null;
							return countryOptions[data];
						}
					},
					{ data: "first_name", title: "First Name" },
					{ data: "last_name", title: "Last Name" },
					{ data: "phone_number", title: "Phone Number" }
				],
				buttons: [
					{ extend: 'selected', text: 'Edit selected row', name: 'edit' }
				],
				onEditRow: function(datatable, rowdata, success, error) {
					$.ajax({
						url: './api/user/'+ rowdata.user_id,
						type: 'PUT',
						data: rowdata,
						error: error
					}).success( function() {
						success(rowdata);
					});
				}
			});
			$('#transactions').DataTable( {
				ajax: { url: './api/transaction', dataSrc: '' },
				columns: [
					{ data: 'id', title: 'ID' },
					{ data: 'code', title: 'Code' },
					{ data: 'amount', title: 'Amount' },
					{ data: 'user_id', title: 'User ID' },
					{ data: 'created_at', title: 'Created At' },
					{ data: 'updated_at', title: 'Updated At' }
				]
			});
		});
		</script>
	</body>
</html>
