<div class="span7 well">
	<h2><?=htmlentities($c->get_class());?></h2>
	<dl class="dl-horizontal">
		<dt>Date Created</dt>
		<dd><?=htmlentities($c->get_date_created());?></dd>
		<dt>Date Modified</dt>
		<dd><?=htmlentities($c->get_date_modified());?></dd>
		<dt>Last Modifier</dt>
		<dd><?=htmlentities($c->get_last_modifier());?></dd>
		<dt>Comment</dt>
		<dd><?=htmlentities($c->get_comment());?>&nbsp;</dd>
	</dl>
</div>
