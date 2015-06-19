@extends('layouts.base')

<?php

Assets::add('data-tables');

$labelClass = [
	//level    =>  CSS class
	'debug'    => 'info',
	'info'     => 'info',
	'notice'   => 'info',
	'warning'  => 'warning',
	'error'    => 'alert',
	'critical' => 'alert',
	'alert'    => 'alert',
];

?>

@section('css')
<style>
	.row.fullWidth {
		width: 100%;
		margin-left: auto;
		margin-right: auto;
		max-width: initial;
		margin-top:1em !important;
	}
	.side-nav .active { border-left: 2px solid #008CBA; }
	.no-wrap{ white-space: nowrap; }

	.stack { cursor:pointer; }
	.stack + pre {
		font-size:85%;
		padding:0 1em;
		margin-top: 1em;
	}

	table { width:100%; }
	table tbody:hover > tr {
	 	/*opacity: 0.8; */
	}
	table tbody:hover > tr:hover {
		/*opacity: 1.0; */
		background-color:#BBB !important;
	}

	/* Fix bug with original style*/
	.dataTables_wrapper .dataTables_paginate .paginate_button,
	.dataTables_wrapper .dataTables_paginate .paginate_button:hover,
	.dataTables_wrapper .dataTables_paginate .paginate_button.current,
	.dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
		color: transparent;
		border: none;
		background: none;
	}
</style>
@stop

@section('body')

	<div class="row fullWidth">

		<!--SIDE NAV-->
		<div class="medium-3 large-2 columns">
			<h3 class="text-center">Files</h3>
			<ul class="side-nav">
				@foreach($files as $file)
					<li class="{{ ($current_file == $file) ? 'active' : null }}">
						<a href="/logs?l={{ base64_encode($file) }}">{{$file}}</a>
					</li>
					<li class="divider"></li>
				@endforeach
			</ul>
		</div>

		<!--LOGS-->
		<div class="medium-9 large-10 columns">
			@if ($logs === null)
			<div data-alert class="alert-box alert text-center">
				<br/>
				<p>Log file size is greater than 50M, please download it.</p>
				<a href="#" class="close">&times;</a>
			</div>
			@else

			<table id="logs">
				<thead>
					<tr>
						<th class="text-center">Date</th>
						<th class="text-center">Level</th>
						<th>Content</th>
					</tr>
				</thead>

				<tbody>
					@foreach($logs as $key => $log)
					<tr>
						<td class="text-center no-wrap">
							{{ $log['date'] }}
						</td>

						<td class="text-center no-wrap">
							<span class="{{ $labelClass[$log['level']] }} radius label"><b>{{ $log['level'] }}</b></span>
						</td>

						<td>
							{!! $log['text'] !!}<br/>

							@if (isset($log['in_file']))
								<span class="success radius label">{{ $log['in_file'] }}</span>
							@endif

							@if ($log['stack'])
								<span class="label radius stack">Details</span>
								<pre class="panel hide">{!! $log['stack'] !!}</pre>
							@endif
						</td>
					</tr>
					@endforeach
				</tbody>

				<tfoot>
					<tr>
						<th><input type="text" placeholder="Filter by date" /></th>
						<th><input type="text" placeholder="Filter by level" /></th>
						<th><input type="text" placeholder="Filter by content" /></th>
					</tr>
				</tfoot>
			</table>
			@endif

			<p class="text-center">
				<a href="logs/?dl={{ base64_encode($current_file) }}" class="button">Download file <i>{{ $current_file }}</i></a>
			</p>

		</div>

	</div><!--.row-->

@stop

@section('js')
@parent
<script>
$(document).ready(function() {

	// Toggle stack trace
	$(".stack").click(function() {
		$(this).next().toggleClass('hide');
	});

	// Initialize table plugin
	var table = $('#logs').DataTable({
		order: [0, 'desc'],
	});

	//Filter by column
	table.columns().every( function () {
		var that = this;

		$( 'input', this.footer() ).on( 'keyup change', function () {
			that
			.search( this.value )
			.draw();
		} );
	});


});
</script>
@stop
