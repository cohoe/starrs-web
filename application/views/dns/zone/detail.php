<div class="well">
	<a name="zone"></a><h3>Zone</h3>
	<dl class="dl-horizontal">
		<dt>Keyname</dt>
		<dd><?=htmlentities($zone->get_keyname());?></dd>
		<dt>Forward</dt>
		<dd><?=($zone->get_forward()=='t')?"Yes":"No";?></dd>
		<dt>Shared</dt>
		<dd><?=($zone->get_shared()=='t')?"Yes":"No";?></dd>
		<dt>DDNS</dt>
		<dd><?=($zone->get_ddns()=='t')?"Enabled":"Disabled";?></dd>
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
