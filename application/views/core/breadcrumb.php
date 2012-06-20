<ul class="breadcrumb">
	<li><a href="/">Home</a> 
	<span class="divider">/</span></li>
	<?php
	$tempUrl = "/";
	foreach($segments as $segment) {
		echo "<li><a href=\"$tempUrl$segment\">".ucfirst($segment)."</a></li>";
		echo "<span class=\"divider\">/</span></li>";
		$tempUrl .= "$segment/";
	}
	?>
</ul>
