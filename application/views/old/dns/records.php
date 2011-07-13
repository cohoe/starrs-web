<div class="item_container">
	<div class="item_title_style5">
		<span class="item_title_bar_left">DNS Records for <?echo "(".$address.")";?></span>
	</div>
	<div class="item_information_area_style5">
	<? if($address_record){?>
		<div class="item_information_area_container">
		Address Records (A, AAAA)
			<table class="dns_information_area_table">
				<tr><th>DNS Name</th><th>Type</th><th>TTL</th><th>Last Modifier</th></tr>
				<tr><td><?echo $address_record->get_hostname().".".$address_record->get_zone();?></td><td><?echo $address_record->get_type();?></td><td><?echo $address_record->get_ttl();?></td><td><?echo $address_record->get_last_modifier();?></td></tr>
			</table>
		</div>
	<?} if($pointer_records) {?>
		<div class="item_information_area_container">
		Pointer Records (CNAME, SRV)
		<table class="dns_information_area_table">
			<tr><th>Alias</th><th>Target</th><th>Extra</th><th>Type</th><th>TTL</th><th>Last Modifier</th></tr>
			<? foreach ($pointer_records as $pointer) { ?>
			<tr><td><?echo $pointer->get_alias();?></td><td><?echo $pointer->get_hostname().".".$pointer->get_zone();?></td><td><?echo $pointer->get_extra();?></td><td><?echo $pointer->get_type();?></td><td><?echo $pointer->get_ttl();?></td><td><?echo $pointer->get_last_modifier();?></td></tr>
			<?}?>
		</table>
		</div>
	<?} if($text_records) {?>
		<div class="item_information_area_container">
		Text Records (TXT, SPF)
		<table class="dns_information_area_table">
			<tr><th>Text</th><th>TTL</th><th>Last Modifier</th></tr>
			<? foreach ($text_records as $text) { ?>
			<tr><td><?echo $text->get_text();?></td><td><?echo $text->get_ttl();?></td><td><?echo $text->get_last_modifier();?></td></tr>
			<?}?>
		</table>
		</div>
	<?} if($ns_records) {?>
		<div class="item_information_area_container">
		Nameserver Records (NS)
		<table class="dns_information_area_table">
			<tr><th>Zone</th><th>Primary</th><th>TTL</th><th>Last Modifier</th></tr>
			<? foreach ($ns_records as $ns) { ?>
			<tr><td><?echo $ns->get_zone();?></td><td><?echo $ns->get_isprimary();?></td><td><?echo $ns->get_ttl();?></td><td><?echo $ns->get_last_modifier();?></td></tr>
			<?}?>
		</table>
		</div>
	<?} if($mx_records) {?>
		<div class="item_information_area_container">
		Mailserver Records (MX)
		<table class="dns_information_area_table">
			<tr><th>Preference</th><th>TTL</th><th>Last Modifier</th></tr>
			<? foreach ($mx_records as $mx) { ?>
			<tr><td><?echo $mx->get_preference();?></td><td><?echo $mx->get_ttl();?></td><td><?echo $mx->get_last_modifier();?></td></tr>
			<?}?>
		</table>
		</div>
	<?}
    if(!$address_record && !$pointer_records && !$text_records && !$ns_records && !$mx_records) {
        ?>
        <div class="item_information_area_container">
		No DNS records found for this IP address
        </div>
        <?}?>
	</div>
	<div class="item_lower_bar_style5"></div>
</div>