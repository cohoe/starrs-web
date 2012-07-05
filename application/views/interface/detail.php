<div class="span7 well">
	<h2><?=htmlentities($int->get_name());?></h2>
	<dl class="dl-horizontal">
		<dt>MAC</dt>
		<dd><?=htmlentities($int->get_mac());?></dd>
		<dt>Date Created</dt>
		<dd><?=htmlentities($int->get_date_created());?></dd>
		<dt>Date Modified</dt>
		<dd><?=htmlentities($int->get_date_modified());?></dd>
		<dt>Last Modifier</dt>
		<dd><?=htmlentities($int->get_last_modifier());?></dd>
		<dt>Comment</dt>
		<dd><?=htmlentities($int->get_comment());?>&nbsp;</dd>
	</dl>
</div>
