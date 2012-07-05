<ul class="breadcrumb">
	<li><a href="/">Home</a> 
	<span class="divider">/</span></li>
	<?php
	if($segments) {
		foreach(array_keys($segments) as $segment) {
			echo "<li><a href=\"$segments[$segment]\">".htmlentities($segment)."</a></li>";
			echo "<span class=\"divider\">/</span></li>";
		}
	}
	?>
</ul>
