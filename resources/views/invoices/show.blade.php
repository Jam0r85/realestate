@extends('layouts.app')

@section('breadcrumbs')
	<li><a href="{{ route('invoices.index') }}">Invoices</a></li>
	<li class="is-active"><a>Invoice #{{ $invoice->number }}</a></li>
@endsection

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			Invoice #{{ $invoice->number }}
		@endslot
		@slot('subTitle')
			{{ $invoice->property->name }}
		@endslot
	@endcomponent

	@component('partials.sections.section')

		<div class="columns is-flex is-column-mobile">
			<div class="column is-3">
				<aside class="menu">
					<p class="menu-label">
						Invoice Items
					</p>
					<ul class="menu-list">
						<li>
							<a href="{{ route('invoices.show', $invoice->id) }}" class="">
								Items List
							</a>
							<a href="{{ route('invoices.show', $invoice->id) }}" class="">
								Add Item
							</a>
						</li>
					</ul>
					<p class="menu-label">
						Settings
					</p>
					<ul class="menu-list">
						<li>
							<a href="{{ route('invoices.show', $invoice->id) }}" class="">
								Archive
							</a>
						</li>
					</ul>
				</aside>
			</div>
			<div class="column is-9">

				<h2 class="title is-3">Invoice Items</h2>

				@component('partials.table')
					@slot('head')
						<th>Name</th>
						<th>Amount</th>
						<th>Quantity</th>
						<th>Tax</th>
						<th>Total</th>
						<th>Options</th>
					@endslot
					@foreach ($invoice->items as $item)
						<tr>
							<td>{{ $item->name }}</td>
							<td>{{ $item->amount }}</td>
							<td>{{ $item->quantity }}</td>
							<td>{{ $item->tax }}</td>
							<td>{{ $item->total }}</td>
							<td>
								<a href="#">
									Edit
								</a>
							</td>
						</tr>
					@endforeach
				@endcomponent

			</div>
		</div>

		<div class="tile is-ancestor">
			<div class="tile is-vertical is-parent is-3">

				<article class="tile is-child notification is-light">
					<p class="title">Archive Invoice</p>
					<div class="content">
						<p>
							You can archive this invoice and prevent it from being seen by the users.
						</p>
					</div>

					<form role="form" method="POST" action="{{ route('invoices.archive', $invoice->id) }}">
						{{ csrf_field() }}

						<button type="submit" class="button">
							Archive
						</button>
					</form>

				</article>

			</div>
			<div class="tile is-vertical is-parent is-9">

				<article class="tile is-child">

					

				</article>

			</div>
		</div>

	@endcomponent

@endsection