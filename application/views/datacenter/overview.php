<div class="span7">
	<div class="row-fluid well span12" style="text-align: center">
		<h2><?=htmlentities($dc->get_datacenter());?></h2>
	</div>
	<div class="row-fluid">
		<div class="span6 well">
			<h3>Datacenter</h3>
			<dl class="dl-horizontal">
				<dt>Date Created</dt>
				<dd><?=htmlentities($dc->get_date_created());?></dd>
				<dt>Date Modified</dt>
				<dd><?=htmlentities($dc->get_date_modified());?></dd>
				<dt>Last Modifier</dt>
				<dd><?=htmlentities($dc->get_last_modifier());?></dd>
				<dt>Comment</dt>
				<dd><?=htmlentities($dc->get_comment());?>&nbsp;</dd>
			</dl>
		</div>
		<div class="span6 well">
			<h3>Availability Zones</h3>
			<br />
			<ul>
				<?php
				foreach($azs as $az) {
					if($az->get_comment()) {
						print "<li><a href=\"/availabilityzone/view/".rawurlencode($az->get_datacenter())."/".rawurlencode($az->get_zone())."\">".htmlentities($az->get_zone())."</a> (".htmlentities($az->get_comment()).")</li>";
					}
					else {					
						print "<li><a href=\"/availabilityzone/view/".rawurlencode($az->get_datacenter())."/".rawurlencode($az->get_zone())."\">".htmlentities($az->get_zone())."</a></li>";
					}
				}
				?>
			</ul>
		</div>
	</div>
</div>
