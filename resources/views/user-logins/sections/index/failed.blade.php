<div class="tab-pane fade @if (request('section') == 'failed') show active @endif" id="v-pills-failed" role="tabpanel">

	@include('user-logins.user-logins-table', ['logins' => $failed, 'request' => true])

	@include('partials.pagination', ['collection' => $failed->appends(['section' => 'failed'])])
	
</div>