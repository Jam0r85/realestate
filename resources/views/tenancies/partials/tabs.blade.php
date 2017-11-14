<ul class="nav nav-pills mb-3" id="" role="tablist">
	<li class="nav-item">
		<a class="nav-link" id="recordNewStatement-Tab" data-toggle="tab" href="#recordNewStatement" role="tab" aria-controls="recordNewStatement" aria-expanded="false">
			Record Statement
		</a>
	</li>
</ul>
<div class="tab-content mb-3" id="tenanciesTabContent">
	<div class="tab-pane fade" id="recordNewStatement" role="tabpanel" aria-labelledby="recordNewStatement-Tab">
		<div class="card">
			<div class="card-body">
				@include('tenancies.partials.record-statement-form')
			</div>
		</div>
	</div>
</div>