<div class="span6 well">
	<h2><a href="/address/view/<?=rawurlencode($intAddr->get_address());?>"><?=$intAddr->get_address();?></a></h2>
	<dl class="dl-horizontal">
		<dt>Primary</dt>
		<dd><?=($intAddr->get_isprimary()=='t')?"Yes":"No";?></dd>
		<dt>MAC</dt>
		<dd><?=$intAddr->get_mac();?></dd>
		<dt>Config</dt>
		<dd><?=$intAddr->get_config();?></dd>
		<dt>DHCP Class</dt>
		<dd><?=$intAddr->get_class();?></dd>
		<dt>Date Created</dt>
		<dd><?=$intAddr->get_date_created();?></dd>
		<dt>Date Modified</dt>
		<dd><?=$intAddr->get_date_modified();?></dd>
		<dt>Last Modifier</dt>
		<dd><?=$intAddr->get_last_modifier();?></dd>
		<dt>Comment</dt>
		<dd><?=$intAddr->get_comment();?>&nbsp;</dd>
	</dl>
</div>
