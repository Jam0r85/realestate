@extends('layouts.pages.branch')

@section('sub-content')

	@component('partials.sections.section')

		<div class="columns">
			<div class="column is-one-third">

				@include('partials.errors-block')

				@component('partials.cards.card')
					@slot('cardHeader')
						Branch Details
					@endslot
					@slot('cardContent')

						<form role="form" method="POST" action="{{ route('branches.update', $branch->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}

							@include('branches.partials.form')

							@component('partials.forms.buttons.save')
								Save Changes
							@endcomponent

						</form>

					@endslot
				@endcomponent

			</div>
			<div class="column">

				<div class="tile is-ancestor">
					<div class="tile is-one-half">

						<div class="tile is-parent is-vertical">

							<div class="tile is-child notification is-success">
								<p class="title">0</p>
								<p class="subtitle">Properties Registered</p>
							</div>

							<div class="tile is-child notification is-warning">
								<p class="title">0</p>
								<p class="subtitle">Tenancies Registered</p>				
							</div>

						</div>	

					</div>
					<div class="tile is-vertical is-one-half">

					</div>
				</div>

			</div>
		</div>

	@endcomponent

@endsection