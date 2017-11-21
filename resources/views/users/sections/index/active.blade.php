<div class="tab-pane fade @if (request('section') == 'active' || (!request('section') && $loop->first)) show active @endif" id="v-pills-active" role="tabpanel">

	@include('users.partials.users-table', ['users' => $active_users])

	@include('partials.pagination', ['collection' => $active_users->appends(['section' => 'active'])])
	
</div>