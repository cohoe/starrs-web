<div class="span7">
	<div class="row-fluid">
		<div class="row-fluid">
			<div class="span12 well">
				<h2><a href="/system/view/<?=rawurlencode($dom->get_system_name())?>"><?=$dom->get_system_name();?></a> <small><?=$dom->get_state();?> on <a href="/system/view/<?=rawurlencode($dom->get_host_name())?>"><?=$dom->get_host_name();?></a></small></h2>
			</div>
		</div>
		<div class="row-fluid">
			<div class="well">
				<h2>Definition</h2>
				<pre>
<?=htmlentities($dom->get_definition());?>
				</pre>
			</div>
		</div>
	</div>
</div>
