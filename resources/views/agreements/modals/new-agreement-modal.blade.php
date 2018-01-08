<div class="modal fade" id="newAgreementModal" tabindex="-1" role="dialog" aria-labelledby="newAgreementModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form method="POST" action="{{ route('agreements.store', $tenancy->id) }}">
			{{ csrf_field() }}
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="newAgreementModalLabel">New Tenancy Agreement</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

                    @if (count($tenancy->pendingAgreements))
                        @component('partials.alerts.warning')
                            Tenancy has the following pending agreements:-
                            <ul>
                                @foreach ($tenancy->pendingAgreements as $agreement)
                                    <li>
                                        {{ date_formatted($agreement->starts_at) }} ({{ $agreement->present()->lengthFormatted }})
                                    </li>
                                @endforeach
                            </ul>
                        @endcomponent
                    @endif

                    @if ($tenancy->currentAgreement)
                        @component('partials.alerts.info')
                            Current agreement ends <b>{{ $tenancy->currentAgreement->present()->endDateFormatted }}</b>
                        @endcomponent
                    @endif

                    @component('partials.form-group')
                        @slot('label')
                            Date From
                        @endslot
                        <input type="date" name="starts_at" id="starts_at" class="form-control" value="{{ $tenancy->currentAgreement ? $tenancy->currentAgreement->ends_at->addDay()->format('Y-m-d') : old('starts_at') }}" />
                    @endcomponent
                    
                    @component('partials.form-group')
                        @slot('label')
                            Length
                        @endslot
                        <select name="length" id="length" class="form-control">
                            <option value="3-months">3 Months</option>
                            <option value="6-months">6 Months</option>
                            <option value="12-months">12 Months</option>
                            <option value="0-months">SPT (Rollover)</option>
                        </select>
                    @endcomponent

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					@component('partials.save-button')
						Create Agreement
					@endcomponent
				</div>
			</div>
		</form>
	</div>
</div>