<div class="span3">        
	<div class="well sidebar-nav">
		<ul class="nav nav-list">
			<?php
			foreach($items as $item) {
				echo "<li><a href=\"{$item['link']}\">".htmlentities($item['text'])."</a></li>";
			}
			?>
		</ul>
	 </div><!--/.well -->
</div><!--/.span -->
