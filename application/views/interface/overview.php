<div class="span6 well">
	<h2><a href="/interface/view/<?=rawurlencode($int->get_mac());?>"><?=$int->get_name();?></a></h2>
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
