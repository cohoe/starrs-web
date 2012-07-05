	<dl class="dl-horizontal">
		<dt>Zone</dt>
		<dd><?=htmlentities($rec->get_zone());?></dd>
		<dt>Nameserver</dt>
		<dd><?=htmlentities($rec->get_nameserver());?></dd>
		<dt>Address</dt>
		<dd><?=htmlentities($rec->get_address());?></dd>
		<dt>TTL</dt>
		<dd><?=htmlentities($rec->get_ttl());?></dd>
		<dt>Date Created</dt>
		<dd><?=htmlentities($rec->get_date_created());?></dd>
		<dt>Date Modified</dt>
		<dd><?=htmlentities($rec->get_date_modified());?></dd>
		<dt>Last Modifier</dt>
		<dd><?=htmlentities($rec->get_last_modifier());?></dd>
	</dl>
