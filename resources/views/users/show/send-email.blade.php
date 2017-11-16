@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('users.show', $user->id) }}" class="btn btn-secondary float-right">
			Return
		</a>

		@component('partials.header')
			{{ $user->present()->fullName }}
		@endcomponent

		@component('partials.sub-header')
			Send an E-Mail
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<div class="row">
			<div class="col-xs-12 col-lg-6">

				@if (!$user->email)

					@component('partials.alerts.danger')
						This user does not have a valid e-mail address.
					@endcomponent

				@else

					<form method="POST" action="{{ route('users.send-email', $user->id) }}">
						{{ csrf_field() }}

						@include('partials.errors-block')

						<div class="form-group">
							<label for="email">E-Mail</label>
							<input type="text" name="email" id="email" class="form-control" disabled value="{{ $user->email }}" />
						</div>	

						<div class="form-group">
							<label for="subject">Subject</label>
							<input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject') }}" />
							<small class="form-text text-muted">
								The subject of the e-mail and the e-mail header.
							</small>
						</div>	

						<div class="form-group">
							<label for="message">Message</label>
							<textarea name="message" id="message" rows="12" class="form-control">{{ old('message') }}</textarea>
						</div>

						@component('partials.save-button')
							Send E-Mail
						@endcomponent

					</form>

				@endif

			</div>
			<div class="col-sm-12 col-lg-6">

				<div class="card mb-3">

					@component('partials.card-header')
						E-Mail History
					@endcomponent

					@component('partials.table')
						@slot('header')
							<th>Subject</th>
							<th class="text-right">Date</th>
						@endslot
						@slot('body')
							@foreach ($user->emails(15) as $email)
								<tr>
									<td>
										<a href="{{ route('emails.preview', $email->id) }}">
											{{ $email->subject }}
										</a>
									</td>
									<td class="text-right">{{ date_formatted($email->created_at) }}</td>
								</tr>
							@endforeach
						@endslot
					@endcomponent

				</div>

			</div>
		</div>

	@endcomponent

@endsection