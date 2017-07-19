<textarea 
	id="{{ $name }}"
	name="{{ $name }}"
	class="textarea"
	@if (isset($placeholder))
		placeholder="{{ $placeholder }}"
	@endif
>{{ isset($value) ? $value : null }}</textarea>