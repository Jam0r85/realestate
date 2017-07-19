@php
	if (!isset($type)) { $type = 'text'; }
@endphp

<input 
	type="{{ $type }}"
	id="{{ $name }}"
	name="{{ $name }}"
	@if (in_array($type, ['text','email','password','number','date','datetime-local'])) class="input" @endif
	@if (isset($value))
		value="{{ $value }}"
	@endif
	@if (isset($placeholder))
		placeholder="{{ $placeholder }}"
	@endif
	@if (isset($required))
		required
	@endif
	@if (isset($checked))
		checked
	@endif
/>