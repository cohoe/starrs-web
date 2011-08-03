<div class="item_container">
	<table class="item_information_area_table">
		<tr><td><em>CIDR Subnet:</em></td><td><?echo htmlentities($sNet->get_subnet());?></td></tr>
		<tr><td><em>Name:</em></td><td><?echo htmlentities($sNet->get_name());?></td></tr>
		<tr><td><em>DNS Zone:</em></td><td><?echo htmlentities($sNet->get_zone());?></td></tr>
		<tr><td><em>Owner:</em></td><td><?echo htmlentities($sNet->get_owner());?></td></tr>
		<tr><td><em>Autogenerated?:</em></td><td><?echo ($sNet->get_autogen() == 't')?"Yes":"No";?></td></tr>
		<tr><td><em>DHCPable?:</em></td><td><?echo ($sNet->get_dhcp_enable() == 't')?"Yes":"No";?></td></tr>
		<tr><td><em>Comment:</em></td><td><?echo htmlentities($sNet->get_comment());?></td></tr>
		<tr></tr>
		<tr><td><em>Firewall Primary:</em></td><td><?echo htmlentities($sNet->get_firewall_primary());?></td></tr>
		<tr><td><em>Firewall Secondary:</em></td><td><?echo htmlentities($sNet->get_firewall_secondary());?></td></tr>
	</table>
</div>
<div class="infobar">
	<span class="infobar_text">Created on <?echo $sNet->get_date_created();?> - Modified by <?echo $sNet->get_last_modifier();?> on <?echo $sNet->get_date_modified();?></span>
</div>