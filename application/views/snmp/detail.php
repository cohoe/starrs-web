<div class="well span7">
	<h2><?=htmlentities($sys->get_system_name());?></h2>
	<dl class="dl-horizontal">
		<dt>Address</dt>
		<dd><?=htmlentities($snmp->get_address());?></dd>
		<dt>RO Community</dt>
		<dd><?=htmlentities($snmp->get_ro_community());?>&nbsp;</dd>
		<dt>RW Community</dt>
		<dd><?=htmlentities($snmp->get_rw_community());?>&nbsp;</dd>
		<dt>Date Created</dt>
		<dd><?=htmlentities($snmp->get_date_created());?></dd>
		<dt>Date Modified</dt>
		<dd><?=htmlentities($snmp->get_date_modified());?></dd>
		<dt>Last Modifier</dt>
		<dd><?=htmlentities($snmp->get_last_modifier());?></dd>
	</dl>
</div>
