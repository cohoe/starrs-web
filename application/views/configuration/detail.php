	<dl class="dl-horizontal">
		<dt>Option</dt>
		<dd><?=htmlentities($c->get_option());?></dd>
		<dt>Value</dt>
		<dd><?=htmlentities($c->get_value());?></dd>
		<dt>Date Created</dt>
		<dd><?=htmlentities($c->get_date_created());?></dd>
		<dt>Date Modified</dt>
		<dd><?=htmlentities($c->get_date_modified());?></dd>
		<dt>Last Modifier</dt>
		<dd><?=htmlentities($c->get_last_modifier());?></dd>
	</dl>
