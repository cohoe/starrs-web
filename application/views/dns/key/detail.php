<div class="row-fluid span7 well">
	<h2><?=htmlentities($key->get_keyname());?></h2>
	<dl class="dl-horizontal">
		<dt>Key</dt>
		<dd><?=htmlentities($key->get_key());?></dd>
		<dt>Owner</dt>
		<dd><?=htmlentities($key->get_owner());?></dd>
		<dt>Date Created</dt>
		<dd><?=htmlentities($key->get_date_created());?></dd>
		<dt>Date Modified</dt>
		<dd><?=htmlentities($key->get_date_modified());?></dd>
		<dt>Last Modifier</dt>
		<dd><?=htmlentities($key->get_last_modifier());?></dd>
		<dt>Comment</dt>
		<dd><?=htmlentities($key->get_comment());?>&nbsp;</dd>
	</dl>
</div>
