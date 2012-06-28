	<dl class="dl-horizontal">
		<dt>Zone</dt>
		<dd><?=$rec->get_zone();?></dd>
		<dt>Nameserver</dt>
		<dd><?=$rec->get_nameserver();?></dd>
		<dt>Address</dt>
		<dd><?=$rec->get_address();?></dd>
		<dt>TTL</dt>
		<dd><?=$rec->get_ttl();?></dd>
		<dt>Date Created</dt>
		<dd><?=$rec->get_date_created();?></dd>
		<dt>Date Modified</dt>
		<dd><?=$rec->get_date_modified();?></dd>
		<dt>Last Modifier</dt>
		<dd><?=$rec->get_last_modifier();?></dd>
	</dl>
