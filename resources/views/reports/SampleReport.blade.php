@section('form')
{!!
	Form::label($f = 'date1', $labels->$f),
	Form::text($f, null, ['placeholder' => _('YYYY-MM-DD')]),

	Form::label($f = 'date2', $labels->$f),
	Form::text($f, null, ['placeholder' => _('YYYY-MM-DD')]),

	Form::label($f = 'group_by', $labels->$f),
	Form::radios($f, $group_by, [], ['small' => 2, 'medium' => 3, 'large' => 3])

	/*Form::label($f = 'format', _('Format')),
	Form::radios($f, $formats, [], ['small' => 2, 'medium' => 3, 'large' => 3])*/
!!}
@stop

@if (isset($results))
@section('results')

	@if ($subtitle)
		<h5 class="text-center">{{ $subtitle }}</h5>
	@endif

	<table class="hover responsive" summary="report-results">

		<thead>
			<tr class="zebra">
				<th class="text-center">Number</th>
				<th class="text-center">Currency</th>
				<th class="text-center">Percentage</th>
			</tr>
		</thead>

		<tbody class="nowrap">
			@foreach ($results->rows as $row)
			<tr>
				<td class="text-center">{{ number($row->number, $results->currency) }}</td>
				<td class="text-right">{{ currency($row->currency, $results->currency) }}</td>
				<td class="text-right">{{ percent($row->percentage, $results->currency) }}</td>
			</tr>
			@endforeach
		</tbody>

		<tfoot class="nowrap">
			<tr>
				<td class="text-center">{{ number($results->totals->number, $results->currency) }}</td>
				<td class="text-right">{{ currency($results->totals->currency, $results->currency) }}</td>
				<td class="text-right">{{ percent($results->totals->percentage, $results->currency) }}</td>
			</tr>
		</tfoot>

	</table>

@stop
@endif


@section('js')
@parent
<script>
$(document).ready(function() {

	{{-- JS datepicker --}}
	<?php Assets::add('datepicker'); ?>
	@include('reports.datepicker', ['selector' => '#date1,#date2'])

});
</script>
@stop
