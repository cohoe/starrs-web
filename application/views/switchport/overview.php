<div class="span7">
	<? foreach($blades as $blade) {
		print "<div class=\"row-fluid\"><div class=\"well\">";
		foreach($blade->get_rows() as $rowNum) {
			print $blade->renderRow($rowNum);
		}
		print "</div></div>";
	} ?>
</div>
