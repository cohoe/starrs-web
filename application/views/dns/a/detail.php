	<dl class="dl-horizontal">
		<dt>Hostname</dt>
		<dd><?=$rec->get_hostname();?></dd>
		<dt>Zone</dt>
		<dd><?=$rec->get_zone();?></dd>
		<dt>TTL</dt>
		<dd><?=$rec->get_ttl();?></dd>
		<dt>Address</dt>
		<dd><?=$rec->get_address();?></dd>
		<dt>Owner</dt>
		<dd><?=$rec->get_owner();?></dd>
		<dt>Date Created</dt>
		<dd><?=$rec->get_date_created();?></dd>
		<dt>Date Modified</dt>
		<dd><?=$rec->get_date_modified();?></dd>
		<dt>Last Modifier</dt>
		<dd><?=$rec->get_last_modifier();?></dd>
	</dl>
