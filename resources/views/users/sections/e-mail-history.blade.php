@php
	$emails->appends(['section' => 'email-history']);
@endphp

<div class="tab-pane fade @if (request('section') == 'e-mail-history') show active @endif" id="v-pills-e-mail-history" role="tabpanel">

	@include('emails.partials.emails-table', ['emails' => $emails])

	@include('partials.pagination', ['collection' => $emails])
	
</div>