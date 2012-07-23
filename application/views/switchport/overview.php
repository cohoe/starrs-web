<div class="span7">
	<div class="row-fluid">
		<div class="well" style="text-align: center">
			<h2><a href="/system/view/<?=rawurlencode($sys->get_system_name());?>"><?=htmlentities($sys->get_system_name());?></a></h2>
		</div>
	</div>
	<? foreach($blades as $blade) {
		print "<div class=\"row-fluid\"><div class=\"well\">";
		foreach($blade->get_rows() as $rowNum) {
			print $blade->renderRow($rowNum);
		}
		print "</div></div>";
	} ?>
</div>
