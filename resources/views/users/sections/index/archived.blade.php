<div class="tab-pane fade @if (request('section') == 'archived') show active @endif" id="v-pills-archived" role="tabpanel">

	@include('users.partials.users-table', ['users' => $archived_users])

	@include('partials.pagination', ['collection' => $archived_users->appends(['section' => 'archived'])])
	
</div>