<?php $palette = [
	'white',
	'ghost',
	'snow',
	'vapor',
	'white-smoke',
	'silver',
	'smoke',
	'gainsboro',
	'iron',
	'base',
	'aluminum',
	'jumbo',
	'monsoon',
	'steel',
	'charcoal',
	'tuatara',
	'oil',
	'jet',
	'black',
	'primary-color',
	'secondary-color',
	'alert-color',
	'success-color',
	'warning-color',
	'info-color'
];
?>

@foreach ($palette as $key => $color)
	<div class="palette palette-{{$key+1}}">{{$color}}</div>
@endforeach



