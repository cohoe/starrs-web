<div class="item_container">
    <table class="tab_table">
        <tr><th>Option</th><th>Value</th></tr>
        <? foreach ($options as $option) {
            echo '<tr><td class="tab_table_left">'.$option->get_option().'</td><td class="tab_table_right">'.$option->get_value().'</tr>';
        } ?>
    </table>
</div>