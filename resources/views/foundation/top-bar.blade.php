<!-- Remove the class "contain-to-grid" to make the top-bar sections use full page width -->
<!-- Remove the class "fixed" to make the top-bar move when you scroll -->
<!-- Replace the class "fixed" with "sticky" to allow content above the top-bar -->
<div id="top-bar" class="contain-to-grid fixed">
	<nav class="top-bar" data-topbar>

		<!-- Site name and mobile icon -->
		<ul class="title-area">
			<li class="name">
				<h1><a href="#">My Site</a></h1><!-- Remove this line if to omit site name -->
			</li>
			<li class="toggle-topbar menu-icon"><!-- Remove the class "menu-icon" to get rid of the "hamburger" icon -->
				<a href="#"><span>Menu</span></a><!-- Remove the "Menu" word to just have the icon alone -->
			</li>
		</ul>

		<section class="top-bar-section">

			<!-- Left section -->
			<ul class="left">
				<li><a href="#">Left 1</a></li>
				<li class="active"><a href="#">Left 2</a></li>
				<li class="has-dropdown">
					<a href="#">Left 3 dropdown</a>
					<ul class="dropdown">
						<li><label>Some label</label></li>
						<li><a href="#">Link 1</a></li>
						<li class="active"><a href="#">Link 2</a></li>
						<li><label>Another label</label></li>
						<li class="has-dropdown">
							<a href="#">Link 3 dropdown</a>
							<ul class="dropdown">
								<li><a href="#">Link 4</a></li>
								<li><a href="#">Link 5</a></li>
							</ul>
						</li>
					</ul>
				</li>
			</ul>

			<!-- Right section -->
			<ul class="right">
				<li><a href="#">Right 1</a></li>
				<li><a href="#">Right 2</a></li>
				<li class="has-form">
					<div class="row collapse">
						<div class="small-7 columns">
							<input type="text" placeholder="Find Stuff">
						</div>
						<div class="small-5 columns">
							<button class="secondary expand">Search</button> <!--"expand" class is important for mobile -->
						</div>
					</div>
				</li>
				<li class="has-form">
					<a href="#" class="button">Login</a>
				</li>
			</ul>

		</section>
	</nav>
</div>

<br>


@section('js')
@parent
<script>
$(document).ready(function() {

	// Disable links for demo purposes
	$('#top-bar a').click(function (e) {e.preventDefault();});

});
</script>
@stop
