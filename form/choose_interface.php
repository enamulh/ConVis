<?php

session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Untitled Form</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>

</head>
<body id="main_body" >
	
	<img id="top" src="top.png" alt="">
	<div id="form_container">
	
		<h1><a>Exploring blog</a></h1>
		<form id="form_736103" class="appnitro"  method="post" action="save_interface.php">
					
			<ul >
			
					<li id="li_1" >
		<label class="description" for="element_1">Choose an interface </label>
		<span>
			<input  name="interface_option" class="element radio" type="radio" value="1" />
			<label class="choice" for="element_1_1">A</label>
			<input  name="interface_option" class="element radio" type="radio" value="2" />
			<label class="choice" for="element_1_2">B</label>
			<input name="interface_option" class="element radio" type="radio" value="3" />
			<label class="choice" for="element_1_3">C</label>

		</span> 
		</li>
			
					<li class="buttons">
			    <input type="hidden" name="form_id" value="736103" />
			    
				<input id="saveForm" class="button_text" type="submit" name="submit" value="Submit" />
		</li>
			</ul>
		</form>	
	</div>
	<img id="bottom" src="bottom.png" alt="">
	</body>
</html>