<!DOCTYPE html>
	<head>
		<title>{{ isset($title) ? $title : '' }}</title>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	    <style type="text/css">
	    	body {
	    		line-height: 20px;
	    		font-size: 16px;
	    	}
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
				border: 1px solid #999;
				margin-bottom: 2rem;
			}
			table.table-list th {
				font-weight: bold;
				background-color: #f8f8f8;
			}
			table.table-list th, table.table-list td {
				padding: 0.6rem;
				border: 1px solid #999;
				margin: 0;
			}
			ul.list-unstyled {
				list-style: none;
				margin: 0;
				padding: 0;
			}
			ul.list-unstyled li {
				margin-bottom: 0.2rem;
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