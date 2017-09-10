<ul class="nav nav-pills mb-3" id="" role="tablist">
	<li class="nav-item">
		<a class="nav-link active" id="recordRentAmount-Tab" data-toggle="tab" href="#recordRentAmount" role="tab" aria-controls="recordRentAmount" aria-expanded="true">
			Record Rent
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" id="recordNewStatement-Tab" data-toggle="tab" href="#recordNewStatement" role="tab" aria-controls="recordNewStatement" aria-expanded="false">
			Record Statement
		</a>
	</li>
</ul>
<div class="tab-content mb-3" id="tenanciesTabContent">
	<div class="tab-pane fade show active" id="recordRentAmount" role="tabpanel" aria-labelledby="recordRentAmount-Tab">
		<div class="card">
			<div class="card-body">
				@include('tenancies.partials.record-rent-payment-form')
			</div>
		</div>
	</div>
	<div class="tab-pane fade show active" id="recordNewStatement" role="tabpanel" aria-labelledby="recordNewStatement-Tab">
		<div class="card">
			<div class="card-body">
				@include('tenancies.partials.record-statement-form')
			</div>
		</div>
	</div>
</div>