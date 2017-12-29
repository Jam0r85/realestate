<button type="submit" class="btn btn-secondary @if (isset($disabled)) btn-danger @endif" @if (isset($disabled)) disabled @endif>
	{{ isset($disabled) ? $disabled : $slot }}
</button>