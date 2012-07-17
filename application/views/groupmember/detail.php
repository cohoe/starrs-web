	<dl class="dl-horizontal">
		<dt>Group</dt>
		<dd><?=htmlentities($gm->get_group());?></dd>
		<dt>User</dt>
		<dd><?=htmlentities($gm->get_user());?></dd>
		<dt>Privilege</dt>
		<dd><?=htmlentities($gm->get_privilege());?></dd>
		<dt>Date Created</dt>
		<dd><?=htmlentities($gm->get_date_created());?></dd>
		<dt>Date Modified</dt>
		<dd><?=htmlentities($gm->get_date_modified());?></dd>
		<dt>Last Modifier</dt>
		<dd><?=htmlentities($gm->get_last_modifier());?></dd>
	</dl>
