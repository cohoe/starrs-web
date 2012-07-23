	<dl class="dl-horizontal">
		<dt>System Name</dt>
		<dd><?=htmlentities($sp->get_system_name());?></dd>
		<dt>Interface Name</dt>
		<dd><?=htmlentities($sp->get_name());?></dd>
		<dt>Description</dt>
		<dd><?=htmlentities($sp->get_description());?></dd>
		<dt>Alias</dt>
		<dd><?=htmlentities($sp->get_alias());?>&nbsp;</dd>
		<dt>Index</dt>
		<dd><?=htmlentities($sp->get_index());?></dd>
		<dt>State</dt>
		<dd><?
		if($sp->get_admin_state()=='t') { 
			if($sp->get_oper_state()=='t') { 
				print $ifState['up'];
			} else { 
				print $ifState['down'];
			} 
		} else {
			print $ifState['disabled']; 
		}?></dd>
		<dt>VLAN</dt>
		<dd><?=htmlentities($sp->get_vlan());?>&nbsp;</dd>
		<dt>Date Created</dt>
		<dd><?=htmlentities($sp->get_date_created());?></dd>
		<dt>Date Modified</dt>
		<dd><?=htmlentities($sp->get_date_modified());?></dd>
		<dt>Last Modifier</dt>
		<dd><?=htmlentities($sp->get_last_modifier());?></dd>
	</dl>
