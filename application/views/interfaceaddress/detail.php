<div class="span7 well">
<?if($intAddr->get_dynamic() == 'f') {?>
<h2><?=htmlentities($intAddr->get_address());?> <img id="addr_state" title="Host is <?=($state==false)?"NOT ":""?>pingable from the STARRS server." src="/img/<?=($state==true)?"up":"down";?>.png" /></h2>
<?} else {?>
<h2>Dynamic</h2>
<?}?>
	<dl class="dl-horizontal">
		<dt>Primary</dt>
		<dd><?=($intAddr->get_isprimary()=='t')?"Yes":"No";?></dd>
		<dt>MAC</dt>
		<dd><?=htmlentities($intAddr->get_mac());?></dd>
		<dt>Config</dt>
		<dd><?=htmlentities($intAddr->get_config());?></dd>
		<dt>DHCP Class</dt>
		<dd><?=htmlentities($intAddr->get_class());?></dd>
		<dt>Date Created</dt>
		<dd><?=htmlentities($intAddr->get_date_created());?></dd>
		<dt>Date Modified</dt>
		<dd><?=htmlentities($intAddr->get_date_modified());?></dd>
		<dt>Last Modifier</dt>
		<dd><?=htmlentities($intAddr->get_last_modifier());?></dd>
		<dt>Comment</dt>
		<dd><?=htmlentities($intAddr->get_comment());?>&nbsp;</dd>
		<dt>Renew Date</dt>
		<dd><?=htmlentities($intAddr->get_renew_date());?></dd>
	</dl>
</div>
