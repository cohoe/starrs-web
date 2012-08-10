<div class="span7 well">
	<h3><a href="/system/view/<?=rawurlencode($h->get_system_name())?>"><?=htmlentities($h->get_system_name());?></a></h3>
	<dl class="dl-horizontal">
		<dt>URI</dt>
		<dd><?=htmlentities($h->get_uri());?></dd>
		<dt>Password</dt>
		<dd><?=htmlentities($h->get_password());?></dd>
		<dt>Date Created</dt>
		<dd><?=htmlentities($h->get_date_created());?></dd>
		<dt>Date Modified</dt>
		<dd><?=htmlentities($h->get_date_modified());?></dd>
		<dt>Last Modifier</dt>
		<dd><?=htmlentities($h->get_last_modifier());?></dd>
	</dl>
</div>
