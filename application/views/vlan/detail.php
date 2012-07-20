<div class="span7 well">
	<h2><?=htmlentities($v->get_vlan());?></h2>
	<dl class="dl-horizontal">
		<dt>Name</dt>
		<dd><?=htmlentities($v->get_name());?></dd>
		<dt>Datacenter</dt>
		<dd><?=htmlentities($v->get_datacenter());?></dd>
		<dt>Date Created</dt>
		<dd><?=htmlentities($v->get_date_created());?></dd>
		<dt>Date Modified</dt>
		<dd><?=htmlentities($v->get_date_modified());?></dd>
		<dt>Last Modifier</dt>
		<dd><?=htmlentities($v->get_last_modifier());?></dd>
		<dt>Comment</dt>
		<dd><?=htmlentities($v->get_comment());?>&nbsp;</dd>
	</dl>
</div>
