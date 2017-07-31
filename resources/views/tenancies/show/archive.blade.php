@extends('tenancies.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			Finish Tenancy
		@endcomponent

		<div class="content">
			<p>
				Are you sure that you want to finish this tenancy? WHat you are saying is that this tenancy is finished, nothing else needs doing, the rent is up to date and the deposit has been returned etc.
			</p>
		</div>

		<hr />

		@include('partials.errors-block')

		<form role="form" method="POST" action="{{ route('tenancies.archive', $tenancy->id) }}">
			{{ csrf_field() }}

			@component('partials.forms.buttons.primary')
				Yes, Finish The Tenancy
			@endcomponent
		</form>

	@endcomponent

@endsection