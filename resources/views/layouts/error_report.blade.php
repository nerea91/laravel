@extends('layouts.base')

@section('body')

	{{-- TOP BAR --}}
	<div class="fixed contain-to-grid-DISABLED">@include('reports.top-bar')</div>
    <div class="flash-alert radius alert callout" data-closable >
        {{ $message }}
        <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@stop
