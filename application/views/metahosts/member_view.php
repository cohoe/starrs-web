<div class="item_container">
	<div class="interface_box">
		<div class="interface_box_nav">
			<? echo $membr->get_address();?>
			<a href="/firewall/metahost_members/delete/<?echo $membr->get_name()."/".$membr->get_address();?>"><div class="nav_item_right"><span>Delete</span></div></a>
		</div>
		<div class="infobar">
			<span class="infobar_text">Created on <?echo $membr->get_date_created();?> - Modified by <?echo $membr->get_last_modifier();?> on <?echo $membr->get_date_modified();?></span>
		</div>
	</div>
</div>