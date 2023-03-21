<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Employee Management API Documentation</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/swagger-ui.css" >
	<style>
		html
		{
			box-sizing: border-box;
			overflow: -moz-scrollbars-vertical;
			overflow-y: scroll;
		}
		*,
		*:before,
		*:after
		{
			box-sizing: inherit;
		}

		body
		{
			margin:0;
			background: #fafafa;
		}

		.swagger-ui .topbar
		{
			display: none;
		}

		.swagger-ui .scheme-container
		{
			display: none;
		}

		.swagger-ui .information-container
		{
			display: none;
		}

		.swagger-ui .api-sections-container
		{
			margin: 0;
			padding: 0;
		}
	</style>
</head>
<body>
<div id="swagger-ui"></div>
<script src="<?php echo base_url(); ?>js/swagger-ui-bundle.js"></script>
<script src="<?php echo base_url(); ?>js/swagger-ui-standalone-preset.js"></script>
<script>
	window.onload = function() {
		const ui = SwaggerUIBundle({
			url: "<?php echo base_url('docs/openapi.yml'); ?>",
			dom_id: '#swagger-ui',
			presets: [
				SwaggerUIBundle.presets.apis,
				SwaggerUIStandalonePreset
			],
			layout: "BaseLayout"
		});
	};
</script>
</body>
</html>
