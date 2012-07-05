	<dl class="dl-horizontal">
		<dt>Hostname</dt>
		<dd><?=htmlentities($rec->get_hostname());?></dd>
		<dt>Zone</dt>
		<dd><?=htmlentities($rec->get_zone());?></dd>
		<dt>Preference</dt>
		<dd><?=htmlentities($rec->get_preference());?></dd>
		<dt>TTL</dt>
		<dd><?=htmlentities($rec->get_ttl());?></dd>
		<dt>Address</dt>
		<dd><?=htmlentities($rec->get_address());?></dd>
		<dt>Owner</dt>
		<dd><?=htmlentities($rec->get_owner());?></dd>
		<dt>Date Created</dt>
		<dd><?=htmlentities($rec->get_date_created());?></dd>
		<dt>Date Modified</dt>
		<dd><?=htmlentities($rec->get_date_modified());?></dd>
		<dt>Last Modifier</dt>
		<dd><?=htmlentities($rec->get_last_modifier());?></dd>
	</dl>
