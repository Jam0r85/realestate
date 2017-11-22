<div class="tab-pane fade @if (request('section') == 'agreements') show active @endif" id="v-pills-agreements" role="tabpanel">

	@include('agreements.partials.agreements-table', ['agreements' => $tenancy->agreements])

</div>