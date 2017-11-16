<!DOCTYPE html>
	<head>
		<base href="{{ url('/') }}">
		<title>{{ isset($title) ? $title : '' }}</title>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.4.1/css/bulma.min.css" />

	    <style type="text/css">
			@page { margin: 100px 25px; }
			header {
				text-align: right;
				position: fixed;
				top: 50px;
				left: 0px;
				right: 0px;
				height: 150px;
				padding: 0 2rem;
			}
			header img {
				padding: 1rem;
				margin-right: 2rem;
			}
			header h1 {
				font-size: 3rem;
			}
			footer {
				font-size: 0.9rem;
				position: fixed;
				bottom: 0px;
				left: 50px;
				right: 50px;
				height: 50px;
				border-top: 2px solid #ddd;
				padding-top: 0.5rem;
			}
			footer ul {
				margin: 0;
				padding: 0;
				list-style-type: none;
			}
			footer ul li {
				display: inline;
			}
			footer ul li span.footer-title {
				font-weight: bold;
				padding-right: 0.2rem;
			}
	    	main { margin-top: 150px; }
	    	body {
	    		line-height: 20px;
	    		font-size: 15px;
	    	}
	    	.recipient {
	    		margin-bottom: 1rem;
	    	}
		    .section {
		    	padding: 0.5rem 2rem;
		    	margin: 0;
		    }
		    .section .container {
		    	padding: 0;
		    	margin: 0 3rem;
		    }
	    	.has-header {
	    		margin-top: 1.5rem;
	    	}
			.page-break {
			    page-break-after: always;
			}
			.footer {
				background-color: #fff;
				position: fixed;
				bottom: 60;
				padding: 1rem;
				margin: 0 2rem;
			}
			.footer .title {
				margin: 0;
			}
			.table tr td {
				font-size: 14px;
			}
	    </style>
	</head>
	<body>

		<header>
			@if (get_setting('company_logo'))
				<img src="{{ get_file(get_setting('company_logo')) }}" />
			@else
				<h1>{{ get_setting('company_name') }}</h1>
			@endif 
		</header>

		<footer>
			<ul>

				{{-- Invoice footer taken from it's group and branch --}}
				@if (isset($statement))

					@if ($statement->tenancy->property->branch)
						<li>
							<span class="footer-title">Phone</span>
							{{ $statement->tenancy->property->branch->phone_number }}
						</li>
						<li>
							<span class="footer-title">E-Mail</span>
							{{ $statement->tenancy->property->branch->email }}
						</li>
					@endif

				@elseif (isset($invoice))

					@if ($invoice->invoiceGroup && $invoice->invoiceGroup->branch)
						<li>
							<span class="footer-title">Phone</span>
							{{ $invoice->invoiceGroup->branch->phone_number }}
						</li>
						<li>
							<span class="footer-title">E-Mail</span>
							{{ $invoice->invoiceGroup->branch->email }}
						</li>
					@endif

				@elseif (isset($payment))

					@if ($payment->parent_type == 'tenancies')

						<li>
							<span class="footer-title">Phone</span>
							{{ $payment->parent->property->branch->phone_number }}
						</li>
						<li>
							<span class="footer-title">E-Mail</span>
							{{ $payment->parent->property->branch->email }}
						</li>

					@endif

				@endif

				{{-- VAT Number taken from settings --}}
				@if (get_setting('vat_number'))
					<li>
						<span class="footer-title">VAT #</span>
						{{ get_setting('vat_number') }}
					</li>
				@endif
			</ul>
		</footer>

		<main>