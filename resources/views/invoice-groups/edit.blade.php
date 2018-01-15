@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				Return
				@slot('url')
					{{ route('invoice-groups.show', $group->id) }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			{{ $group->name }}
		@endcomponent

		@component('partials.sub-header')
			Edit Invoice Group
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-6">

				<form method="POST" action="{{ route('invoice-groups.update', $group->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					@component('partials.card')
						@slot('header')
							Invoice Group Details
						@endslot

						@slot('body')

							@include('invoice-groups.partials.form')

						@endslot

						@slot('footer')
							@component('partials.save-button')
								Save Changes
							@endcomponent
						@endslot

					@endcomponent

				</form>

			</div>
			<div class="col-12 col-lg-6">

				@if ($group->deleted_at)

					<form method="POST" action="{{ route('invoice-groups.restore', $group->id) }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}

						@component('partials.card')
							@slot('header')
								Restore Invoice Group
							@endslot
							@slot('footer')
								@include('partials.forms.restore-button')
							@endslot
						@endcomponent

					</form>

					<form method="POST" action="{{ route('invoice-groups.forceDelete', $group->id) }}">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}

						@component('partials.card')
							@slot('header')
								Destroy Invoice Group
							@endslot
							@slot('body')

								@component('partials.alerts.danger')
									@icon('warning') Destroying this invoice group will delete it permanently.
								@endcomponent

								@component('partials.form-group')
									@slot('label')
										Related Invoices
									@endslot
									@slot('help')
										Choose what to do with the invoices assigned to this invoice group.
									@endslot
									<select name="related_invoices" id="related_invoices" class="form-control">
										<option value="delete">Delete invoices assigned to this group</option>
										@foreach (common('invoice-groups') as $group)
											<option value="{{ $group->id}}">
												Move to {{ $group->name }}
											</option>
										@endforeach
									</select>
								@endcomponent

							@endslot
							@slot('footer')
								@include('partials.forms.destroy-button')
							@endslot
						@endcomponent

					</form>

				@else

					<form method="POST" action="{{ route('invoice-groups.delete', $group->id) }}">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}

						@component('partials.card')
							@slot('header')
								Delete Invoice Group
							@endslot
							@slot('footer')
								@include('partials.forms.delete-button')
							@endslot
						@endcomponent

					</form>

				@endif

			</div>
		</div>

	@endcomponent

@endsection