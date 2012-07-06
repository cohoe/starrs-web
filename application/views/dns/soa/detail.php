<div class="span6 well">
	<h3>SOA</h3>
	<dl class="dl-horizontal">
		<dt>Nameserver</dt>
		<dd><?=htmlentities($soaRec->get_nameserver());?></dd>
		<dt>TTL</dt>
		<dd><?=htmlentities($soaRec->get_ttl());?></dd>
		<dt>Contact</dt>
		<dd><?=htmlentities($soaRec->get_contact());?></dd>
		<dt>Serial</dt>
		<dd><?=htmlentities($soaRec->get_serial());?></dd>
		<dt>Refresh</dt>
		<dd><?=htmlentities($soaRec->get_refresh());?></dd>
		<dt>Retry</dt>
		<dd><?=htmlentities($soaRec->get_retry());?></dd>
		<dt>Expire</dt>
		<dd><?=htmlentities($soaRec->get_expire());?></dd>
		<dt>Minimum</dt>
		<dd><?=htmlentities($soaRec->get_minimum());?></dd>
		<dt>Date Created</dt>
		<dd><?=htmlentities($soaRec->get_date_created());?></dd>
		<dt>Date Modified</dt>
		<dd><?=htmlentities($soaRec->get_date_modified());?></dd>
		<dt>Last Modifier</dt>
		<dd><?=htmlentities($soaRec->get_last_modifier());?></dd>
	</dl>
</div>
