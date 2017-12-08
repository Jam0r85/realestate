@php
	$emails->appends(['section' => 'email-history']);
@endphp

<div class="tab-pane fade @if (request('section') == 'email-history') show active @endif" id="v-pills-email-history" role="tabpanel">

	@include('emails.partials.emails-table', ['emails' => $emails])

	@include('partials.pagination', ['collection' => $emails])
	
</div>