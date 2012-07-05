<div class="alert alert-error imp-modalalert">
	<h1>Fatal error(s):</h1>
	<?php
	if(is_array($exception)) {
		foreach($exception as $e) {
			print htmlentities($e->getMessage());
		}
	}
	else {
		print htmlentities($exception->getMessage());
	}
	?>
</div>
