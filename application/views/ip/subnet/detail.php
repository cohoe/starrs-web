<div class="span6 well">
	<a href="/ip/subnet/view/<?=rawurlencode($snet->get_subnet());?>"><h2><?=htmlentities($snet->get_subnet());?></h2></a>
	<dl class="dl-horizontal">
		<dt>Name</dt>
		<dd><?=htmlentities($snet->get_name());?>&nbsp;</dd>
		<dt>DNS Zone</dt>
		<dd><?=htmlentities($snet->get_zone());?>&nbsp;</dd>
		<dt>DHCP Enable</dt>
		<dd><?=htmlentities($snet->get_dhcp_enable());?></dd>
		<dt>Autogen</dt>
		<dd><?=htmlentities($snet->get_autogen());?></dd>
		<dt>Owner</dt>
		<dd><?=htmlentities($snet->get_owner());?></dd>
		<dt>Date Created</dt>
		<dd><?=htmlentities($snet->get_date_created());?></dd>
		<dt>Date Modified</dt>
		<dd><?=htmlentities($snet->get_date_modified());?></dd>
		<dt>Last Modifier</dt>
		<dd><?=htmlentities($snet->get_last_modifier());?></dd>
		<dt>Comment</dt>
		<dd><?=htmlentities($snet->get_comment());?>&nbsp;</dd>
	</dl>
</div>
