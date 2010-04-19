<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{LANG_LOWERCASE}">
	<head>
		<title>{SERVER_NAME}</title>
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="language" content="{LANG_LOWERCASE}" />
		
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
		
		<!-- Main CSS and custum CSS (for mods and other pages) -->
		<link rel="stylesheet" href="{LINK_CSS}formate.css" type="text/css" />
		<link rel="stylesheet" href="{CUSTOM_CSS}" type="text/css" />
	</head>
	
	<body>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/highcharts.js"></script>
		<script type="text/javascript" src="js/prototype.js"></script>
		<script type="text/javascript" src="js/wz_tooltip.js"></script>
		
		<!-- IF show_menu -->
		
		<div id="menu">
			{MENU}
		</div>
		
		<!-- END IF show_menu -->
		
		<div id="{HEADER_ID}">
			<img src="images/{BANNER}" alt="banner" />
		</div>
		
		<div id="{CONTENT_ID}">
			<!-- IF DEBUG_ON_TOP -->
			
			<div id="debug">
				{DEBUG}
			</div>
			
			<!-- END IF DEBUG_ON_TOP -->
			
			{CONTENT}
			
			<!-- IF DEBUG_ON_TOP -->
			<!-- ELSE IF DEBUG_ON_TOP -->
			
			<div id="debug">
				{DEBUG}
			</div>
			
			<!-- END IF DEBUG_ON_TOP -->
			
			<!-- IF phperror -->
			
			<div id="php-error">
				<div id="main">
					{ERROR_PHP}
				</div>
				
				<!-- BEGIN phperror -->
				
				<div id="line">
					{phperror.line}
				</div>
				
				<!-- END phperror -->
			</div>
			
			<!-- END IF phperror -->
		</div>
		
		<div id="{FOOTER_ID}">
			<span class="copyright"><a href="{COPYRIGHT_LINK}" class="strong">{pagetail_OGSpy}</a> {pagetail_Copyright}</span><br />
			<span class="version">{VERSION}</span><br />
			<span class="time">{TIME}</span>
		</div>
	</body>
</html>