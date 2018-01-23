<div class="modal fade" id="quickNoteModal" tabindex="-1" role="dialog" aria-labelledby="quickNoteModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form role="form" method="POST" action="{{ $route }}">
			{{ csrf_field() }}
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="quickNoteModalLabel">Quick Note</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					@component('partials.form-group')
						@slot('label')
							Note
						@endslot
						<textarea name="body" id="body" class="form-control" rows="6">{{ old('body') }}</textarea>
					@endcomponent

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					@component('partials.save-button')
						Record Note
					@endcomponent
				</div>
			</div>
		</form>
	</div>
</div>