@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="row">
				<div class="col-sm-12 col-lg-6">

					@include('dashboard.cards.tenancies')
					@include('dashboard.cards.tenancies-management')

				</div>
			</div>

		</div>
	</section>

@endsection