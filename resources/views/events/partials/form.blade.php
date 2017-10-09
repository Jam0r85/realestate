<div class="form-group">
	<label for="title">Title</label>
	<input type="text" name="title" class="form-control" />
</div>


@component('partials.forms.field')
	@slot('label')
		Title
	@endslot
	@slot('name')
		title
	@endslot
	@slot('value')
		{{ isset($event) ? $event->title : null }}
	@endslot
	@slot('required')
	@endslot
@endcomponent

@component('partials.forms.field-textarea')
	@slot('label')
		Message
	@endslot
	@slot('name')
		body
	@endslot
	@slot('value')
		{{ isset($event) ? $event->body : null }}
	@endslot
@endcomponent

@component('partials.forms.field')
	@slot('label')
		Start
	@endslot
	@slot('name')
		start
	@endslot
	@slot('type')
		datetime-local
	@endslot
	@slot('value')
		{{ isset($event) ? $event->start->format('Y-m-d\TH:i:s') : $start }}
	@endslot
@endcomponent

@component('partials.forms.field')
	@slot('label')
		End
	@endslot
	@slot('name')
		end
	@endslot
	@slot('type')
		datetime-local
	@endslot
	@slot('value')
		{{ isset($event) ? $event->end->format('Y-m-d\TH:i:s') : $end }}
	@endslot
@endcomponent

@if (!isset($event))
	@component('partials.forms.field-checkbox')
		@slot('label')
			Is this an all day event?
		@endslot
		@slot('name')
			allDay
		@endslot
		@slot('value')
			1
		@endslot
	@endcomponent
@endif