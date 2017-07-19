<div class="modal-card">
	<header class="modal-card-head">
		<p class="modal-card-title">
			Edit User's Details
		</p>
	</header>

	<form role="form" method="POST" action="{{ route('users.update', $user->id) }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}

		<section class="modal-card-body">

			@include('users.partials.form')

		</section>
		<section class="modal-card-foot">
		
			<button type="submit" class="button is-success">
				Save Changes
			</button>

		</section>

	</form>
</div>