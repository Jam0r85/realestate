<div class="field">
	<p class="control">
		<label class="checkbox" @if (isset($name)) for="{{ $name }}" @endif">
			@component('partials.forms.input')
				{{-- Set the input type as Checkbox --}}
				@slot('type')
					checkbox
				@endslot

				{{-- The name of the checkbox --}}
				@if (isset($name))
					@slot('name')
						{{ $name }}
					@endslot
				@endif

				{{-- The value of the checkbox --}}
				@slot('value')
					{{ $value }}
				@endslot

			@endcomponent
			{{ isset($label) ? $label : '' }}
		</label>
	</p>
</div>