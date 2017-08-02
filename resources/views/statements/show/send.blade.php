@extends('statements.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			{{ isset($statement->sent_at) ? 'Re-Send' : 'Send' }} Statement to Landlord
		@endcomponent

		<div class="content">

			@if ($statement->sent_at)
				<p>
					<b>Statement was sent to the landlord {{ date_formatted($statement->sent_at) }}</b>
				</p>
			@endif

			<p>
				You can send an email to the landlords with the rental statement, invoices and any expense invoices attached by clicking the button below.
			</p>

		</div>

		<hr />

		<form role="form" method="POST" action="{{ route('statements.send') }}">
			{{ csrf_field() }}
			<input type="hidden" name="statement_id[]" value="{{ $statement->id }}" />

			@component('partials.forms.buttons.primary')
				{{ $statement->sent_at ? 'Re-Send' : 'Send' }} Statement
			@endcomponent

		</form>

	@endcomponent

@endsection