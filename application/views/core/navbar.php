<div class="navbar">
	<div>
		<div class="nav_title"><?echo $navbar->get_title();?></div>
		<div class="nav_user"><?echo $navbar->get_user()." (".strtolower($navbar->get_priv()).")";?></div>
	</div>
	<br>
	<? foreach ($navbar->get_navOptions() as $menuOption) {

		if(strcasecmp($menuOption['title'],$navbar->get_active_page()) == 0) {?>
			<a href="<?echo $menuOption['link'];?>"><div class="nav_item_left nav_item_left_active"><span><?echo $menuOption['title'];?></span></div></a>
		<?} else {?>
			<a href="<?echo $menuOption['link'];?>"><div class="nav_item_left"><span><?echo $menuOption['title'];?></span></div></a>
		<?}
	}
	if($navbar->get_cancel() == true) {
		echo "<a href=\"".$navbar->get_cancel_link()."\"><div class=\"nav_item_right\"><span>Cancel</span></div></a>";
	}
	if($navbar->get_delete() == true) {
		echo "<a href=\"".$navbar->get_delete_link()."\"><div class=\"nav_item_right\"><span>Delete</span></div></a>";
	}
	if($navbar->get_edit() == true) {
		echo "<a href=\"".$navbar->get_edit_link()."\"><div class=\"nav_item_right\"><span>Edit</span></div></a>";
	}
	if($navbar->get_create() == true) {
		echo "<a href=\"".$navbar->get_create_link()."\"><div class=\"nav_item_right\"><span>Create</span></div></a>";
	} ?>
</div>