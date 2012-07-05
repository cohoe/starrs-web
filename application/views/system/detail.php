<div class="span7 well">
	<h2><?=htmlentities($sys->get_system_name());?></h2>
	<dl class="dl-horizontal">
		<dt>Type</dt>
		<dd><?=htmlentities($sys->get_type());?></dd>
		<dt>Operating System</dt>
		<dd><?=htmlentities($sys->get_os_name());?></dd>
		<dt>Owner</dt>
		<dd><?=htmlentities($sys->get_owner());?></dd>
		<dt>Date Created</dt>
		<dd><?=htmlentities($sys->get_date_created());?></dd>
		<dt>Date Modified</dt>
		<dd><?=htmlentities($sys->get_date_modified());?></dd>
		<dt>Last Modifier</dt>
		<dd><?=htmlentities($sys->get_last_modifier());?></dd>
		<dt>Comment</dt>
		<dd><?=htmlentities($sys->get_comment());?>&nbsp;</dd>
		<dt>Renew Date</dt>
		<dd><?=htmlentities($sys->get_renew_date());?></dd>
	</dl>
</div>
