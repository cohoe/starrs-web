<div class="span6 well">
	<a name="zone"></a><h3>Zone</h3>
	<dl class="dl-horizontal">
		<dt>Keyname</dt>
		<dd><?=htmlentities($zone->get_keyname());?></dd>
		<dt>Forward</dt>
		<dd><?=htmlentities($zone->get_forward());?></dd>
		<dt>Shared</dt>
		<dd><?=htmlentities($zone->get_shared());?></dd>
		<dt>Owner</dt>
		<dd><?=htmlentities($zone->get_owner());?></dd>
		<dt>Date Created</dt>
		<dd><?=htmlentities($zone->get_date_created());?></dd>
		<dt>Date Modified</dt>
		<dd><?=htmlentities($zone->get_date_modified());?></dd>
		<dt>Last Modifier</dt>
		<dd><?=htmlentities($zone->get_last_modifier());?></dd>
		<dt>Comment</dt>
		<dd><?=htmlentities($zone->get_comment());?>&nbsp;</dd>
	</dl>
</div>
