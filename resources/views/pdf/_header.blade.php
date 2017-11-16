<!DOCTYPE html>
	<head>
		<title>{{ isset($title) ? $title : '' }}</title>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	    <style type="text/css">
			.header {
				text-align: right;
				height: 150px;
			}
			.header img {
				padding: 1rem;
				margin-right: 2rem;
			}
			.header h1 {
				font-size: 1.6rem;
				padding-bottom: 1rem;
				border-bottom: 2px solid #bbb;
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
	    	body {
	    		line-height: 20px;
	    		font-size: 15px;
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
				margin-bottom: 2rem;
			}
			h1 {
				font-size: 3rem;
			}
			.text-muted {
				color: #aaa !important;
			}
			.lead {
				font-size: 1.2rem;
				line-height: 1.8rem;
			}
			hr {
			    border: 0;
			    height: 2px;
			    background: #bbb;
			}
			.mb-0 {
				margin-bottom: 0 !important;
			}
	    </style>
	</head>
	<body>

		<div class="header">
			<div class="logo">
				@if (get_setting('company_logo'))
					<img src="{{ get_file(get_setting('company_logo')) }}" />
				@else
					<h1>{{ get_setting('company_name') }}</h1>
				@endif
			</div>
		</div>

		<div class="content">