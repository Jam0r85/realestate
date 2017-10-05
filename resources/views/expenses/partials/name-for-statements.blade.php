<b>{{ $expense->name }}</b>

@if (count($expense->contractors))
	<br />
	@foreach ($expense->contractors as $user)
		{{ $user->name }}
	@endforeach
@endif

@if ($expense->pivot->amount != $expense->cost)
	<small>(Part Payment)</small>
@endif