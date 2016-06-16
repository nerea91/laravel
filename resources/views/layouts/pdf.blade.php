<!DOCTYPE html>
<html>
	<head>
		{{-- CSS  --}}
		<style>
			.text-center {
			    text-align: center !important;
			}
			.text-right {
			    text-align: right !important;
			}
			.text-left {
			    text-align: left !important;
			}
			table tbody tr td, table tbody tr th, table tfoot tr td, table tfoot tr th, table thead tr th, table tr td {
			    display: table-cell;
			    line-height: 1.125rem;
			}
			table thead tr td, table thead tr th {
			    font-size: 0.875rem;
			    font-weight: 700;
			    padding: 0.5rem 0.625rem 0.625rem;
			}
			table tr td, table tr th {
			    font-size: 0.875rem;
			    padding: 0.5625rem 0.625rem;
			    text-align: left;
			}
			table tfoot, table tbody tr:nth-child(even) {
			    background: #f5f5f5 none repeat scroll 0 0;
			}
			table tfoot tr td, table tfoot tr th {
			    color: #222;
			    font-size: 0.875rem;
			    font-weight: 700;
			    padding: 0.5rem 0.625rem 0.625rem;
			}
			table, tr, td, th, tbody, thead, tfoot {
			    page-break-inside: avoid !important;
			}
		</style>
		@yield('css')
	</head>
	<body>
		<span style="float:right">{{ \Carbon\Carbon::now() }}</span>
		@yield('body')
	</body>
</html>
