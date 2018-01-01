<!DOCTYPE html>
	<head>
		<title>{{ isset($title) ? $title : '' }}</title>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	    <style type="text/css">
	    	@page {
	    		margin: 0;
	    	}
	    	body {
	    		margin: 0;
	    		line-height: 20px;
	    		font-size: 15px;
	    	}
	    	.container {
	    		margin: 2rem 5rem 1rem 5rem;
	    	}
			.header {
				text-align: right;
				height: 80px;
			}
			.header h1 {
				margin: 0;
				font-size: 1.6rem;
				padding-bottom: 1rem;
			}
			.footer {
				font-size: 0.9rem;
				position: fixed;
				bottom:	0px;
				height: 20px;
				border-top: 2px solid #ddd;
				padding-top: 0.5rem;
			}
			.footer ul {
				margin: 0;
				padding: 0;
				list-style-type: none;
			}
			.footer ul li {
				display: inline;
			}
			.footer ul li span.footer-title {
				font-weight: bold;
				padding-right: 0.2rem;
			}
			.page-break {
			    page-break-after: always;
			}
			.footer {
				background-color: #fff;
				position: fixed;
				bottom: 0;
			}
			.footer .title {
				margin: 0;
			}
			.section {
				margin-bottom: 1.8rem;
			}
			h1 {
				font-size: 3rem;
			}
			h2 {
				font-size: 2.6rem;
			}
			h3 {
				font-size: 2.2rem;
			}
			h4 {
				font-size: 1.8rem;
			}
			h5 {
				font-size: 1.4rem;
			}
			h1, h2, h3, h4, h5 {
				margin: 0 0 1rem 0;
			}
			.text-muted {
				color: #aaa !important;
			}
			.lead {
				font-size: 1.2rem;
				line-height: 1.8rem;
			}
			.text-right {
				text-align: right;
			}
			.text-success {
				color: #28a745;
			}
			hr {
			    border: 0;
			    height: 2px;
			    background: #bbb;
			}
			.mb-0 {
				margin-bottom: 0 !important;
			}
			table {
				width: 100%;
			}
			table td {
				vertical-align: top;
			}
			table.table-list {
				border-spacing: 0;
				border-collapse: collapse;
				margin-bottom: 1rem;
			}
			table.table-list th {
				font-weight: bold;
				background-color: #f8f8f8;
			}
			table.table-list th, table.table-list td {
				padding: 0.4rem;
				border: 1px solid #999;
				margin: 0;
				font-size: 14px;
			}
			ul.list-unstyled {
				list-style: none;
				margin: 0;
				padding: 0;
			}
			ul.list-unstyled li {
				margin-bottom: 0.1rem;
			}
			ul.list-inline {
			    list-style-type: none;
			    margin: 0;
			    padding: 0;
			}
			ul.list-inline li {
				color: #999;
				font-size: 15px;
			    float: left;
			    display: block;
			    margin-right: 1rem;
			}
	    </style>
	</head>
	<body>

		<div class="container">

			<div class="header">
				<table>
					<tr>
						<td>

							<ul class="list-inline">

								@if (isset($statement))

									<li>
										<span class="footer-title">Phone</span>
										{{ $statement->property()->branch->phone_number }}
									</li>
									<li>
										<span class="footer-title">E-Mail</span>
										{{ $statement->property()->branch->email }}
									</li>

								@elseif (isset($invoice))

									<li>
										<span class="footer-title">Phone</span>
										{{ $invoice->invoiceGroup->branch->phone_number }}
									</li>
									<li>
										<span class="footer-title">E-Mail</span>
										{{ $invoice->invoiceGroup->branch->email }}
									</li>

								@elseif (isset($payment))

									<li>
										<span class="footer-title">Phone</span>
										{{ $payment->parent->property->branch->phone_number }}
									</li>
									<li>
										<span class="footer-title">E-Mail</span>
										{{ $payment->parent->property->branch->email }}
									</li>

								@endif
							</ul>

						</td>
						<td class="text-right" nowrap>

							@if (get_setting('company_logo'))
								<img src="{{ Storage::url(get_setting('company_logo_small')) }}" />
							@else
								<h1>{{ get_setting('company_name') }}</h1>
							@endif

						</td>
					</tr>
				</table>
			</div>

		</div>