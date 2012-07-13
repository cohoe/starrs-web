<div class="well">
	<h2><?=htmlentities($r->get_name());?></h2>
	<dl class="dl-horizontal">
		<dt>First IP</dt>
		<dd><?=htmlentities($r->get_first_ip());?></dd>
		<dt>Last IP</dt>
		<dd><?=htmlentities($r->get_last_ip());?></dd>
		<dt>Subnet</dt>
		<dd><a href="/ip/subnet/view/<?=rawurlencode($r->get_subnet());?>"><?=htmlentities($r->get_subnet());?></a></dd>
		<dt>Use</dt>
		<dd><?=htmlentities($r->get_use());?></dd>
		<dt>Class</dt>
		<dd><?=htmlentities($r->get_class());?>&nbsp;</dd>
		<dt>Availability Zone</dt>
		<dd><a href="/availabilityzone/view/<?=rawurlencode($r->get_datacenter())?>/<?=rawurlencode($r->get_zone())?>"><?=htmlentities($r->get_zone())?></a>
		 (<a href="/datacenter/view/<?=rawurlencode($r->get_datacenter());?>"><?=htmlentities($r->get_datacenter());?></a>)</dd>
		<dt>Date Created</dt>
		<dd><?=htmlentities($r->get_date_created());?></dd>
		<dt>Date Modified</dt>
		<dd><?=htmlentities($r->get_date_modified());?></dd>
		<dt>Last Modifier</dt>
		<dd><?=htmlentities($r->get_last_modifier());?></dd>
		<dt>Comment</dt>
		<dd><?=htmlentities($r->get_comment());?>&nbsp;</dd>
	</dl>
</div>
