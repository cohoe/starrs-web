<div class="span10 well">
	<h2><?=$sys->get_system_name();?></h2>
	<dl class="dl-horizontal">
		<dt>Type</dt>
		<dd><?=$sys->get_type();?></dd>
		<dt>Operating System</dt>
		<dd><?=$sys->get_os_name();?></dd>
		<dt>Owner</dt>
		<dd><?=$sys->get_owner();?></dd>
		<dt>Date Created</dt>
		<dd><?=$sys->get_date_created();?></dd>
		<dt>Date Modified</dt>
		<dd><?=$sys->get_date_modified();?></dd>
		<dt>Last Modifier</dt>
		<dd><?=$sys->get_last_modifier();?></dd>
		<dt>Comment</dt>
		<dd><?=$sys->get_comment();?>&nbsp;</dd>
		<dt>Renew Date</dt>
		<dd><?=$sys->get_renew_date();?></dd>
	</dl>
</div>
