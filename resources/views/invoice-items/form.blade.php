<div class="row">
	<div class="col-sm-12 col-md-5">

		<div class="card mb-3">

			@component('partials.card-header')
				Invoice Item Details
			@endcomponent

			<div class="card-body">

				@include('invoices.partials.item-form')

			</div>
		</div>

	</div>
	<div class="col-sm-12 col-md-7">

		<div class="card mb-3">

			@component('partials.card-header')
				Current Invoice Items
			@endcomponent

			@component('partials.table')
				@slot('header')
					<th>Name</th>
					<th>Amount</th>
					<th>#</th>
					<th class="text-right">Total</th>
				@endslot
				@slot('body')
					@foreach ($invoice->items as $item)
						<tr>
							<td>
								<a href="{{ route('invoices.edit-item', $item->id) }}" name="Edit Item">
									{{ $item->name }}
								</a>
							</td>
							<td>{{ currency($item->amount) }}</td>
							<td>{{ $item->quantity }}</td>
							<td class="text-right">{{ currency($item->total) }}</td>
						</tr>
					@endforeach
				@endslot
			@endcomponent

		</div>

	</div>
</div>