@component('partials.card-header')
	@if (!$notification->read_at)
		<span class="badge badge-danger float-right">
			Unread!
		</span>
	@endif
	{{ $header }}
@endcomponent

	{{ $slot }}

<div class="card-footer">
	{{ datetime_formatted($notification->created_at) }}
</div>