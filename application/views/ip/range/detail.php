<div class="row-fluid">
	<div class="well span5">
		<h2><?=htmlentities($r->get_name());?></h2>
		<dl class="dl-horizontal">
			<dt>First IP</dt>
			<dd><?=htmlentities($r->get_first_ip());?></dd>
			<dt>Last IP</dt>
			<dd><?=htmlentities($r->get_last_ip());?></dd>
			<dt>Subnet</dt>
			<dd><a href="/ip/subnet/view/<?=rawurlencode($r->get_subnet());?>"><?=htmlentities($r->get_subnet());?></a></dd>
			<dt>Use</dt>
			<dd><?=htmlentities($r->get_use());?></dd>
			<dt>Class</dt>
			<dd><?=htmlentities($r->get_class());?>&nbsp;</dd>
			<dt>Availability Zone</dt>
			<dd><a href="/availabilityzone/view/<?=rawurlencode($r->get_datacenter())?>/<?=rawurlencode($r->get_zone())?>"><?=htmlentities($r->get_zone())?></a>
			 (<a href="/datacenter/view/<?=rawurlencode($r->get_datacenter());?>"><?=htmlentities($r->get_datacenter());?></a>)</dd>
			<dt>Date Created</dt>
			<dd><?=htmlentities($r->get_date_created());?></dd>
			<dt>Date Modified</dt>
			<dd><?=htmlentities($r->get_date_modified());?></dd>
			<dt>Last Modifier</dt>
			<dd><?=htmlentities($r->get_last_modifier());?></dd>
			<dt>Comment</dt>
			<dd><?=htmlentities($r->get_comment());?>&nbsp;</dd>
		</dl>
	</div>
	<div class="well span3">
		<h2>Top Users</h2>
		<ol>
		<? foreach($r->get_top_users() as $user) {
			print "<li><a href=\"/users/view/".rawurlencode($user['user'])."\">".$user['user']."</a> (".$user['count'].")</li>";
		}?>
		</ol>
	</div>
	<div class="well span4">
		<h2>Utilization</h2>
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script type="text/javascript">
			google.load("visualization", "1", {packages:["corechart"]});
			google.setOnLoadCallback(drawChart);
	 		function drawChart() {
				var data = google.visualization.arrayToDataTable([
					['Category', 'Quantity'],
					['In Use',	<?=$stat->inuse;?>],
					['Free',		<?=$stat->free;?>]
				]);

				var options = {
					backgroundColor: '#f5f5f5',
					colors:['#49AFCD','#DA4F49']
				};

				var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
				chart.draw(data, options);
			}
		</script>
		<div id="chart_div" style="width: 100%"></div>
	</div>
</div>
<div class="row-fluid">
	<div class="well">
		<h2>Groups</h2>
        <ul>
        <? foreach ($gs as $g) {
            print "<li><a href=\"/group/view/".rawurlencode($g->get_group())."\">".htmlentities($g->get_group())."</a></li>";
        }?>
        </ul>
    </div>
</div>
