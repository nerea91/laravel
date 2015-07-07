{!! Form::model(new App\User, ['route' => 'home']) !!}
	<div class="row">
		<div class="large-4 columns">
			{!!
				Form::label($f = 'user', _('User')),
				Form::text($f, null, ['placeholder' => _('Required')])
			!!}
		</div>

		<div class="large-4 columns">
			{!!
				Form::label($f = 'password', _('Password')),
				Form::password($f, null)
			!!}
		</div>

		<div class="large-4 columns">
			{!!
				Form::label($f = 'country', _('Country')),
				Form::select($f, App\Country::dropdown())
			!!}
		</div>
	</div>

	<div class="row">
		<div class="large-3 columns">
			{!! Form::label($f = 'inputPrefixPostfix', 'Prefix and/or Postfix') !!}
			<div class="row collapse">
				<div class="small-3 columns">
					<span class="prefix">http://</span>
				</div>
				<div class="small-6 columns">
					{!! Form::text($f, null, ['placeholder' => 'URL']) !!}
				</div>
				<div class="small-3 columns">
					<span class="postfix">.com</span>
				</div>
			</div>
		</div>

		<div class="large-3 columns">
			{!! Form::label($f = 'inputRadius', 'Radius') !!}
			<div class="row collapse prefix-radius"><!-- NOTE prefix-radius|postfix-radius class here -->
				<div class="small-3 columns">
					<span class="prefix">http://</span>
				</div>
				<div class="small-9 columns">
					{!! Form::text($f, null, ['placeholder' => 'URL']) !!}
				</div>
			</div>
		</div>

		<div class="large-3 columns">
			{!! Form::label($f = 'inputRound', 'Round') !!}
			<div class="row collapse postfix-round"><!-- NOTE prefix-round|postfix-round class here -->
				<div class="small-9 columns">
					{!! Form::text($f, null, ['placeholder' => 'Price']) !!}
				</div>
				<div class="small-3 columns">
					<span class="postfix">€</span>
				</div>
			</div>
		</div>

		<div class="large-3 columns">
			{!! Form::label($f = 'inputButton', 'With button') !!}
			<div class="row collapse">
				<div class="small-9 columns">
					{!! Form::text($f, null, ['placeholder' => 'URL']) !!}
				</div>
				<div class="small-3 columns">
					<a href="#" class="button postfix">Go</a>
				</div>
			</div>
		</div>
	</div>


	<div class="row">
		<div class="large-4 columns error">
			{!!
				Form::label($f = 'error', 'Error'),
				Form::text($f, null, ['placeholder' => _('Required')])
			!!}
			<small class="error">Error class attached to container</small>
		</div>

		<div class="large-4 columns">
			{!!
				Form::label($f = 'inlineerror', 'Inline error', ['class' => 'error']),
				Form::text($f, null, ['placeholder' => _('Required'), 'class' => 'error'])
			!!}
			<small class="error">Error class attached to inline elements</small>
		</div>

		<div class="large-4 columns">
			<label>Textarea
				<textarea placeholder="small-12.columns"></textarea>
			</label>
		</div>
	</div>


	<div class="row">
		<div class="large-4 columns">
			{!!
				Form::label($f = 'language', _('Language')),
				Form::radios($f, App\Language::dropdown(), [7], ['large' => 3]),

				Form::label($f = 'profile', _('Profile')),
				Form::checkboxes($f, App\Profile::dropdown(), [1], ['large' => 3])
			!!}
		</div>

		<div class="large-6 columns">
			<fieldset>
				<legend>Fieldset</legend>

				<div class="row">
					<div class="small-3 columns">
						<label for="inline-label" class="right inline">Inline label</label>
						<label for="inline-label" class="right inline">Another inline label</label>
					</div>
					<div class="small-9 columns">
						<input type="text" id="inline-label" placeholder="foo">
						<input type="text" id="right-label2" placeholder="bar" class="error">
						<small class="error">Some error</small>
					</div>
				</div>
			</fieldset>
		</div>
		<div class="large-2 columns">
			{!! Form::submit(_('Submit'), ['class' => 'button expand']) !!}
		</div>
	</div>

{!! Form::close() !!}
