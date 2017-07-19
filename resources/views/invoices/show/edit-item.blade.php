<div class="modal-card">
	<header class="modal-card-head is-primary">
		<p class="modal-card-title">Edit Invoice item</p>
	</header>
	<section class="modal-card-body">

		<form role="form" method="POST" action="{{ route('invoices.update-item', $item->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

			@include('invoices.partials.item-form')

			<button type="submit" class="button is-outline">
				Update
			</button>
		</form>

	</section>
</div>