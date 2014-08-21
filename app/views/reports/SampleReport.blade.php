@section('form')
{{
	Form::label($f = 'date1', $labels->$f),
	Form::text($f, null, ['placeholder' => _('YYYY-MM-DD')]),

	Form::label($f = 'date2', $labels->$f),
	Form::text($f, null, ['placeholder' => _('YYYY-MM-DD')]),

	Form::label($f = 'group_by', $labels->$f),
	Form::radios($f, $group_by, [], ['small' => 2, 'medium' => 3, 'large' => 3])
}}
@stop

@if (isset($results))
@section('results')

	@if ($subtitle)
		<h5 class="text-center">{{ $subtitle }}</h5>
	@endif

	<table class="hover responsive" summary="">

		<thead>
			<tr>
				<th>Col 1</th>
				<th>Col 2</th>
			</tr>
		</thead>

		<tbody class="nowrap">
			@foreach ($results->rows as $row)
			<tr>
				<td>{{ $row->col1 }}</td>
				<td>{{ $row->col2 }}</td>
			</tr>
			@endforeach
		</tbody>

		<tfoot class="nowrap">
			<tr>
				<td>{{ $results->totals->col1 }}</td>
				<td>{{ $results->totals->col2 }}</td>
			</tr>
		</tfoot>

	</table>

@stop
@endif
