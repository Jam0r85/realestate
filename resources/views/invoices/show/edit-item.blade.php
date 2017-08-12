<div class="modal-card">
	<header class="modal-card-head is-primary">
		<p class="modal-card-title">Edit Invoice item</p>
	</header>
	<section class="modal-card-body">

		<form role="form" method="POST" action="{{ route('invoices.update-item', $item->id) }}">
			{{ csrf_field() }}
			{{ method_field('PUT') }}

			@include('invoices.partials.item-form')

			<button type="submit" class="button is-danger is-pulled-right" name="remove_item" value="true">
				<span class="icon is-small">
					<i class="fa fa-trash"></i>
				</span>
				<span>
					Remove Item
				</span>
			</button>

			<button type="submit" class="button is-primary">
				<span class="icon is-small">
					<i class="fa fa-save"></i>
				</span>
				<span>
					Save Changes
				</span>
			</button>
		</form>

	</section>
</div>