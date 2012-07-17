<div class="span7">
	<div class="row-fluid well span12" style="text-align: center">
		<h2><?=htmlentities($sys->get_system_name());?></h2>
	</div>
	<div class="row-fluid">
		<div class="span8 well">
			<h3>System</h3>
			<dl class="dl-horizontal">
				<dt>Datacenter</dt>
				<dd><a href="/datacenter/view/<?=rawurlencode($sys->get_datacenter());?>"><?=htmlentities($sys->get_datacenter());?></a></dd>
				<dt>Type</dt>
				<dd><?=htmlentities($sys->get_type());?></dd>
				<dt>Operating System</dt>
				<dd><?=htmlentities($sys->get_os_name());?></dd>
				<dt>Owner</dt>
				<dd><?=htmlentities($sys->get_owner());?></dd>
				<dt>Group</dt>
				<dd><a href="/group/view/<?=rawurlencode($sys->get_group());?>"><?=htmlentities($sys->get_group());?></a>&nbsp</dd>
				<dt>Asset</dt>
				<dd><?=htmlentities($sys->get_asset());?>&nbsp</dd>
				<dt>Date Created</dt>
				<dd><?=htmlentities($sys->get_date_created());?></dd>
				<dt>Date Modified</dt>
				<dd><?=htmlentities($sys->get_date_modified());?></dd>
				<dt>Last Modifier</dt>
				<dd><?=htmlentities($sys->get_last_modifier());?></dd>
				<dt>Comment</dt>
				<dd><?=htmlentities($sys->get_comment());?>&nbsp;</dd>
			</dl>
		</div>
		<div class="span4 well">
			<h3>Platform</h3>
			<dl class="dl-horizontal">
				<dt>Platform</dt>
				<dd><?=htmlentities($p->get_platform_name());?></dd>
				<dt>Architecture</dt>
				<dd><?=htmlentities($p->get_architecture());?></dd>
				<dt>Disk</dt>
				<dd><?=htmlentities($p->get_disk());?></dd>
				<dt>CPU</dt>
				<dd><?=htmlentities($p->get_cpu());?></dd>
				<dt>Memory</dt>
				<dd><?=htmlentities($p->get_memory());?> GB</dd>
			</dl>
			<br />
			<br />
			<br />
			<br />
			<br />
			<br />
		</div>
	</div>
</div>
