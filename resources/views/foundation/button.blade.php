<ul id="buttons" class="small-block-grid-3 medium-block-grid-5 large-block-grid-6">
	@foreach ($types as $key => $type)
		@foreach ($sizes as $size)
			<li>
				<a href="#" class="{{ $size }} {{ $type }} button {{ $round = $roundness[$key % 3] }}">{{ $size }} {{$type}} button {{$round}}</a>
			</li>

		@endforeach
		<li>
			<a href="#" class="{{ $type }} button {{ $round }} disabled">{{$type}} button {{$round}} disabled</a>
		</li>
	@endforeach
</ul>
