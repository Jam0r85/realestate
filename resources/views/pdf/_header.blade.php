<!DOCTYPE html>
	<base href="{{ url('/') }}">
	<head>
		<title>{{ $statement->property->short_name }}</title>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.4.1/css/bulma.min.css" />

	    <style type="text/css">
	    	@page {
	    		margin: 0px !important;
	    		padding: 0px !important;
	    	}
	    	body {
	    		font-size: 15px;
	    	}
	    	.recipient {
	    		margin-bottom: 1rem;
	    	}
		    .section {
		    	padding: 1rem 2rem;
		    	margin: 0;
		    }
		    .section .container {
		    	padding: 0;
		    	margin: 0 3rem;
		    }
	    	.has-header {
	    		margin-top: 1rem;
	    	}
	    	.header-image {
	    		max-height: 150px;
	    		max-width: 160px;
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