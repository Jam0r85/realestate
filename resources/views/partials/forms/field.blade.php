<div class="field">

	{{-- Label --}}
	@if (isset($label))
		<label class="label" @if (isset($name)) for="{{ $name }}" @endif >{{ $label }}</label>
	@endif

	{{-- Control Class for the Field --}}
	<p class="control 
		@if (isset($iconLeft)) has-icons-left @endif
		@if (isset($iconRight)) has-icons-right @endif
		">
		@component('partials.forms.input')

			{{-- Field Type --}}
			@if (isset($type))
				@slot('type')
					{{ $type }}
				@endslot
			@endif

			{{-- Field Name --}}
			@if (isset($name))
				@slot('name')
					{{ $name }}
				@endslot
			@endif

			{{-- Field Value --}}
			@if (isset($value))
				@slot('value')
					{{ $value }}
				@endslot
			@endif

			{{-- Field Placehlder --}}
			@if (isset($placeholder))
				@slot('placeholder')
					{{ $placeholder }}
				@endslot
			@endif

			{{-- Required --}}
			@if (isset($required))
				@slot('required')
				@endslot
			@endif

		@endcomponent

		{{-- Icon - Left Side --}}
		@if (isset($iconLeft))
			<span class="icon is-small is-left">
				<i class="fa fa-{{$iconLeft}}"></i>
			</span>
		@endif

		{{-- Icon - Right Side --}}
		@if (isset($iconRight))
			<span class="icon is-small is-right">
				<i class="fa fa-{{$iconRight}}"></i>
			</span>
		@endif

	</p>
	
	{{-- Help --}}
	@if (isset($help))
		<p class="help">{{ $help }}</p>
	@endif
</div>