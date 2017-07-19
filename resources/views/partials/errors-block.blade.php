@if ($errors->any())
	@component('partials.notifications.primary')
		@if (count($errors->all()) > 1)
			<p class="is-errors-title">
				<span class="icon">
					<i class="fa fa-exclamation-triangle"></i>
				</span>
				<strong>
					The following errors occured:-
				</strong>
			</p>
		@endif
		<ul>
			@foreach ($errors->all() as $error)
				<li>
					@if (count($errors->all()) == 1)
						<span class="icon">
							<i class="fa fa-exclamation-triangle"></i>
						</span>
					@endif
					{{ $error }}
				</li>
			@endforeach
		</ul>
	@endcomponent
@endif