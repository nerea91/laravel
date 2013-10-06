@extends('layouts.scaffold')

@section('main')

<h1>Show Language</h1>

<p>{{ link_to_route('languages.index', 'Return to all languages') }}</p>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Code</th>
				<th>Name</th>
				<th>English_name</th>
				<th>Locale</th>
				<th>Default</th>
				<th>Priority</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $language->code }}}</td>
					<td>{{{ $language->name }}}</td>
					<td>{{{ $language->english_name }}}</td>
					<td>{{{ $language->locale }}}</td>
					<td>{{{ $language->default }}}</td>
					<td>{{{ $language->priority }}}</td>
                    <td>{{ link_to_route('languages.edit', 'Edit', array($language->id), array('class' => 'btn btn-info')) }}</td>
                    <td>
                        {{ Form::open(array('method' => 'DELETE', 'route' => array('languages.destroy', $language->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                    </td>
		</tr>
	</tbody>
</table>

@stop
