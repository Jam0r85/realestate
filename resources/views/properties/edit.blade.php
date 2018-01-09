@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				Return
				@slot('url')
					{{ route('properties.show', $property->id) }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			{{ $property->present()->shortAddress }}
		@endcomponent

		@component('partials.sub-header')
			Edit Property Details
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-6">

				<form method="POST" action="{{ route('properties.update', $property->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}	

					@component('partials.card')
						@slot('header')
							@icon('branch') Branch
						@endslot

						<div class="card-body">

							<p class="card-text">
								You can change the branch assigned to deal with this property by selecting the a new branch below.
							</p>

							@component('partials.alerts.info')
								Branch assigned is currently <b>{{ $property->branch->name }}</b>
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									New Branch
								@endslot
								<select name="branch_id" id="branch_id" class="form-control">
									<option value="{{ $property->branch_id }}">Please select..</option>
									@foreach (branches() as $branch)
										@if ($branch->id != $property->branch_id)
											<option value="{{ $branch->id }}">
												{{ $branch->name }}
											</option>
										@endif
									@endforeach
								</select>
							@endcomponent

						</div>
						@slot('footer')
							@component('partials.save-button')
								Save Changes
							@endcomponent
						@endslot
					@endcomponent

				</form>

				<form method="POST" action="{{ route('properties.update', $property->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					@component('partials.card')
						@slot('header')
							Property Details
						@endslot

						<div class="card-body">

							@include('properties.partials.form')

						</div>

						@slot('footer')
							@component('partials.save-button')
								Save Changes
							@endcomponent
						@endslot
					@endcomponent

				</form>

			</div>
			<div class="col-12 col-lg-6">

				<form method="POST" action="{{ route('properties.update', $property->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					@component('partials.card')
						@slot('header')
							@icon('tenancy') Tenancy Settings
						@endslot

						<div class="card-body">

							@component('partials.alerts.info')
								The following settings will be applied automatically to new tenancies created for this property.
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Statement Send Method
								@endslot
								<select name="statement_send_method" id="statement_send_method" class="form-control">
									<option @if ($property->getSetting('statement_send_method') == 'email') selected @endif value="email">E-Mail</option>
									<option @if ($property->getSetting('statement_send_method') == 'post') selected @endif value="post">Post</option>
								</select>
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Statement Payment Method
								@endslot
								@slot('help')
									Select the bank account to send the landlords payment to.
								@endslot
								<select name="bank_account_id" id="bank_account_id" class="form-control select2">
									<option value="0">Cheque or Cash</option>
									@foreach (bank_accounts($property->owners->pluck('id')->toArray()) as $account)
										<option @if ($property->bank_account_id == $account->id) selected @endif value="{{ $account->id }}">
											{{ $account->present()->selectName }}
										</option>
									@endforeach
								</select>
							@endcomponent

						</div>

						@slot('footer')
							@component('partials.save-button')
								Save Changes
							@endcomponent
						@endslot

					@endcomponent

				</form>

				<form method="POST" action="{{ route('properties.update', $property->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					@component('partials.card')
						@slot('header')
							@icon('list') Further Information
						@endslot

						<div class="card-body">

							@component('partials.form-group')
								@slot('label')
									Bedrooms
								@endslot
								<select name="bedrooms" id="bedrooms" class="form-control">
									@for($i = 0; $i <= 10; $i++)
										<option @if ($property->getData('bedrooms') == $i) selected @endif value="{{ $i }}">
											@if ($i == 0)
												Studio / None
											@else
												{{ $i }}
											@endif
										</option>
									@endfor
								</select>
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Bathrooms
								@endslot
								<select name="bathrooms" id="bathrooms" class="form-control">
									@for($i = 0; $i <= 10; $i++)
										<option @if ($property->getData('bathrooms') == $i) selected @endif value="{{ $i }}">
											@if ($i == 0)
												None
											@else
												{{ $i }}
											@endif
										</option>
									@endfor
								</select>
							@endcomponent

							@component('partials.form-group')
								@slot('label')
									Reception Rooms
								@endslot
								<select name="reception_rooms" id="reception_rooms" class="form-control">
									@for($i = 0; $i <= 10; $i++)
										<option @if ($property->getData('reception_rooms') == $i) selected @endif value="{{ $i }}">
											@if ($i == 0)
												None
											@else
												{{ $i }}
											@endif
										</option>
									@endfor
								</select>
							@endcomponent

						</div>
						
						@slot('footer')
							@component('partials.save-button')
								Save Changes
							@endcomponent
						@endslot
					@endcomponent

				</form>

				@if ($property->deleted_at)

					<form method="POST" action="{{ route('properties.restore', $property->id) }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}

						@component('partials.card')
							@slot('header')
								@icon('restore') Restore Property
							@endslot

							@slot('footer')
								@component('partials.save-button')
									Restore Property
								@endcomponent
							@endslot
						@endcomponent

					</form>

					<form method="POST" action="{{ route('properties.forceDestroy', $property->id) }}">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}

						@component('partials.card')
							@slot('header')
								@icon('destroy') Destroy Property
							@endslot

							@slot('footer')
								@component('partials.save-button')
									Destroy Property
								@endcomponent
							@endslot
						@endcomponent

					</form>

				@else

					<form method="POST" action="{{ route('properties.destroy', $property->id) }}">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}

						@component('partials.card')
							@slot('header')
								@icon('delete') Delete Property
							@endslot

							@slot('footer')
								@component('partials.save-button')
									Delete Property
								@endcomponent
							@endslot
						@endcomponent

					</form>

				@endif

			</div>
		</div>

	@endcomponent

@endsection