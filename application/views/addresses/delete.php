<title>Testing</title>
<div class="item_container">
	<form method="POST" class="input_form">
		<label for="address">Address: </label><select name="address">
			<? foreach ($addresses as $intAddr) {
				if($intAddr->get_address() == $address) {
					echo "<option value=\"".htmlentities($intAddr->get_address())."\" selected=\"true\" >".htmlentities($intAddr->get_address())."</option>";
				}
				else {
					echo "<option value=\"".htmlentities($intAddr->get_address())."\">".htmlentities($intAddr->get_address())."</option>";
				}
			} ?>
		</select></br>
		<label for="submit">&nbsp;</label><input type="submit" name="submit" value="Delete" class="input_form_submit"/>
	</form>
</div>