<div class="card mb-3">
	<div class="card-header">
		<i class="fa fa-user"></i> Contractor
	</div>

	@if ($expense->contractor)

		<ul class="list-group list-group-flush">
			<li class="list-group-item">
				<p class="lead mb-0">
					<a href="{{ route('users.show', $expense->contractor->id) }}" title="{{ $expense->contractor->name }}">
						{{ $expense->contractor->name }}
					</a>
				</p>
				{!! $expense->contractor->email ? $expense->contractor->email . '<br />' : '' !!}
				{!! $expense->contractor->phone_number ? $expense->contractor->phone_number . '<br />' : '' !!}
			</li>
		</ul>

	@else

		<div class="card-body">
			<p class="card-text">
				No user has been added as a contractor to this expense.
			</p>
		</div>

	@endif

</div>