<ul class="medium-block-grid-2 large-block-grid-3">
	@foreach ($types as $key => $type)
		<li>
			<div class="alert-box {{ $round = $roundness[$key % 3] }} {{ $type }}" data-alert>
				{{$round}} {{$type}} alert-box
				<a href="#" class="close">&times;</a>
			</div>
		</li>
	@endforeach
</ul>
