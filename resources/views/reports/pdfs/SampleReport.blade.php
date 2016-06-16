@extends('layouts.pdf')
@if (isset($results))
@section('body')

	<h1 class="text-center">{{ $title }}</h1>
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
