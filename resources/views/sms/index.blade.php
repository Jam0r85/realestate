@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			SMS History
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@foreach ($messages as $message)

			<div class="card mb-3 border-{{ $message->status('class') }}">

				@component('partials.card-header')
					<span class="float-right text-muted">
						<small></small>
					</span>

					{{ $message->phone_number }}

					@if ($message->user)
						({{ $message->user->present()->fullName }})
					@endif

					@slot('small')
						{{ datetime_formatted($message->created_at) }}
					@endslot
				@endcomponent

				<div class="card-body">

					<p class="card-text">
						{{ $message->body }}
					</p>

					@if ($message->owner)
						<p class="card-text text-muted">
							<small>
								<b>{{ $message->status() }}</b> by {{ $message->owner->present()->fullName }}
							</small>
						</p>
					@endif
					
				</div>

			</div>

		@endforeach

		@include('partials.pagination', ['collection' => $messages])

	@endcomponent

@endsection