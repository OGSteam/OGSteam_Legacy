<script type="text/javascript">
<!-- Begin
jQuery(document).ready(function() {
	Highcharts.setOptions({
		lang: {
			months: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 
				'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
			weekdays: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi']
		},
		credits: {
			enabled: false
		}
	});
	var chart_point = new Highcharts.Chart({
	   chart: {
		  renderTo: 'point',
		  zoomType: 'x'
	   },
			title: {
		  text: null
	   },
			subtitle: {
		  text: 'Selectionner pour zoomer'
	   },
	   xAxis: {
		  type: 'datetime',
		  maxZoom: 14 * 24 * 3600000, // fourteen days
		  title: {
			 text: null
		  }
	   },
	   yAxis: {
		  title: {
			 text: 'Points'
		  },
		  startOnTick: true,
		  showFirstLabel: true
	   },
	   tooltip: {
		  formatter: function() {
			 return '<b>'+ (this.point.name || this.series.name) +'</b><br/>'+
				Highcharts.dateFormat('%A %e %B %Y, %H:%M', this.x+3600000) + ':<br/>'+
				Highcharts.numberFormat(this.y, 2) +' Points';
		  }
	   },
	   legend: {
		  enabled: true
	   },
	   plotOptions: {
		  area: {
			 fillOpacity: .1,
			 lineWidth: 1,
			 marker: {
				enabled: false,
				states: {
				   hover: {
					  enabled: true,
					  radius: 3
				   }
				}
			 },
			 shadow: true,
			 states: {
				hover: {
				   lineWidth: 1                  
				}
			 }
		  }
	   },

	   series: [{
			type: 'area',
			  name: '{homestat_General} - {user_stat_name}',
			  data: [
			  <!-- IF is_rank_general -->
				<!-- BEGIN rank_general -->
					[{rank_general.time}, {rank_general.points}],
				<!-- END rank_general -->
			<!-- END IF is_rank_general -->
			  ]
		   },
		   {
			  type: 'area',
			  name: '{homestat_Fleet} - {user_stat_name}',
			  data: [
			  <!-- IF is_rank_fleet -->
				<!-- BEGIN rank_fleet -->
					[{rank_fleet.time}, {rank_fleet.points}],
				<!-- END rank_fleet -->
			<!-- END IF is_rank_fleet -->
			]
		   },
		   {
			  type: 'area',
			  name: '{homestat_Technology} - {user_stat_name}',
			  data: [
			  <!-- IF is_rank_research -->
				<!-- BEGIN rank_research -->
					[{rank_research.time}, {rank_research.points}],
				<!-- END rank_research -->
			<!-- END IF is_rank_research -->
			  ]
		   },
		<!-- IF is_player_comp -->
			{
			  type: 'area',
			  name: '{homestat_General} - {player_comp}',
			  data: [
					<!-- IF is_rank2_general -->
						<!-- BEGIN rank2_general -->
							[{rank2_general.time}, {rank2_general.points}],
						<!-- END rank2_general -->
					<!-- END IF is_rank2_general -->
			  ]
		   },
			{
			  type: 'area',
			  name: '{homestat_Fleet} - {player_comp}',
			  data: [
					<!-- IF is_rank2_fleet -->
						<!-- BEGIN rank2_fleet -->
							[{rank2_fleet.time}, {rank2_fleet.points}],
						<!-- END rank2_fleet -->
					<!-- END IF is_rank2_fleet -->
			  ]
		   },
		   {
			  type: 'area',
			  name: '{homestat_Technology} - {player_comp}',
			  data: [
					<!-- IF is_rank2_research -->
						<!-- BEGIN rank2_research -->
							[{rank2_research.time}, {rank2_research.points}],
						<!-- END rank2_research -->
					<!-- END IF is_rank2_research -->
			  ]
		   }
		<!-- END IF is_player_comp -->
	   ]
   });
   
   var chart_rank = new Highcharts.Chart({
   chart: {
	  renderTo: 'rank',
	  zoomType: 'x'
   },
		title: {
	  text: null
   },
		subtitle: {
	  text: 'Selectionner pour zoomer'
   },
   xAxis: {
	  type: 'datetime',
	  maxZoom: 14 * 24 * 3600000, // fourteen days
	  title: {
		 text: null
	  }
   },
   yAxis: {
	  title: {
		 text: 'Rank'
	  },
	  startOnTick: true,
	  showFirstLabel: true
   },
   tooltip: {
	  formatter: function() {
		 return '<b>'+ (this.point.name || this.series.name) +'</b><br/>'+
			Highcharts.dateFormat('%A %e %B %Y, %H:%M', this.x+3600000) + ':<br/>'+
			Highcharts.numberFormat(this.y, 2) +'&egrave;me';
	  }
   },
   legend: {
	  enabled: true
   },
   plotOptions: {
	  area: {
		 fillOpacity: .1,
		 lineWidth: 1,
		 marker: {
			enabled: false,
			states: {
			   hover: {
				  enabled: true,
				  radius: 3
			   }
			}
		 },
		 shadow: true,
		 states: {
			hover: {
			   lineWidth: 1                  
			}
		 }
	  }
   },

   series: [{
	type: 'area',
	  name: '{homestat_General} - {user_stat_name}',
	  data: [
			<!-- IF is_rank_general -->
				<!-- BEGIN rank_general -->
					[{rank_general.time}, {rank_general.rank}],
				<!-- END rank_general -->
			<!-- END IF is_rank_general -->
	  ]
   },
   {
	  type: 'area',
	  name: '{homestat_Fleet} - {user_stat_name}',
	  data: [
			<!-- IF is_rank_fleet -->
				<!-- BEGIN rank_fleet -->
					[{rank_fleet.time}, {rank_fleet.rank}],
				<!-- END rank_fleet -->
			<!-- END IF is_rank_fleet -->
	  ]
   },
   {
	  type: 'area',
	  name: '{homestat_Technology} - {user_stat_name}',
	  data: [
			<!-- IF is_rank_research -->
				<!-- BEGIN rank_research -->
					[{rank_research.time}, {rank_research.rank}],
				<!-- END rank_research -->
			<!-- END IF is_rank_research -->
	  ]
   },
<!-- IF is_player_comp -->
	{
	  type: 'area',
	  name: '{homestat_General} - {player_comp}',
	  data: [
			<!-- IF is_rank2_general -->
				<!-- BEGIN rank2_general -->
					[{rank2_general.time}, {rank2_general.rank}],
				<!-- END rank2_general -->
			<!-- END IF is_rank2_general -->
	  ]
   },
	{
	  type: 'area',
	  name: '{homestat_Fleet} - {player_comp}',
	  data: [
			<!-- IF is_rank2_fleet -->
				<!-- BEGIN rank2_fleet -->
					[{rank2_fleet.time}, {rank2_fleet.rank}],
				<!-- END rank2_fleet -->
			<!-- END IF is_rank2_fleet -->
	  ]
   },
   {
	  type: 'area',
	  name: '{homestat_Technology} - {player_comp}',
	  data: [
			<!-- IF is_rank2_research -->
				<!-- BEGIN rank2_research -->
					[{rank2_research.time}, {rank2_research.rank}],
				<!-- END rank2_research -->
			<!-- END IF is_rank2_research -->
	  ]
   }
<!-- END IF is_player_comp -->
   ]
   });
<!-- IF is_empire -->  
	   var chart_type = new Highcharts.Chart({
	   chart: {
		  renderTo: 'empire_type',
		  margin: [0, 0, 0, 0]
	   },
	   title: {
		  text: '{homestat_GraphTitleDistributionPlanets}'
	   },
	   tooltip: {
		  formatter: function() {
			 return '<b>'+ this.point.name +'</b>: '+ this.y +' points';
		  }
	   },
	   plotOptions: {
		  pie: {
			 allowPointSelect: true,
			 size: '70%',
			 center: ['37.5%', '50%'],
			 dataLabels: {
				enabled: false
			 }
		  }
	   },
	   legend: {
		  layout: 'vertical',
		  style: {
			 left: 'auto',
			 bottom: 'auto',
			 right: '0px',
			 top: '32.5%'
		  }
	   },
		series: [{
		  type: 'pie',
		  name: 'point share',
		  data: [{implode_planet}]
	   }]
	});
<!-- IF is_repartition -->	
	var chart_repartition = new Highcharts.Chart({
	   chart: {
		  renderTo: 'empire_repartition',
		  margin: [0, 0, 0, 0]
	   },
	   title: {
		  text: '{homestat_GraphTitleDistributionPoints}'
	   },
	   tooltip: {
		  formatter: function() {
			 return '<b>'+ this.point.name +'</b>: '+ this.y +' points';
		  }
	   },
	   plotOptions: {
		  pie: {
			 allowPointSelect: true,
			 size: '70%',
			 center: ['37.5%', '50%'],
			 dataLabels: {
				enabled: false
			 }
		  }
	   },
	   legend: {
		  layout: 'vertical',
		  style: {
			 left: 'auto',
			 bottom: 'auto',
			 right: '0px',
			 top: '32.5%'
		  }
	   },
		series: [{
		  type: 'pie',
		  name: 'point share',
		  data: [{implode_repartition}]
	   }]
	});
<!-- END IF is_repartition -->	
<!-- END IF is_empire -->
});
// End -->
</script>

<form method="post" action="index.php?action=home&amp;subaction=stat">
<table style="text-align:center;margin-left:auto;margin-right:auto;">
	<tr>
		<td class='c'>{homestat_StatisticOf}</td>
	</tr>
	<tr>
		<th>
			<input type="text" name="user_stat_name" value="{user_stat_name}" />
			<input type="submit" value="{homestat_GetStat}" />
		</th>
	</tr>
	<tr>
		<th>
			<input type="text" name="player_comp" value="{player_comp}" />
			<input type="submit" value="{homestat_CompareWith}" />
		</th>
	</tr>
</table>
</form>
<p style="text-align:center;margin-left:auto;margin-right:auto;text-decoration:underline;font-size:14px;font-weight:bold;">
	{homestat_StatisticOf2}
</p>

<table width='800' style="text-align:center;margin-left:auto;margin-right:auto;">
	<tr>
		<td colspan="2">
			<div id="point" style="width: 800px; height: 300px; margin: 0 auto"></div>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<div id="rank" style="width: 800px; height: 300px; margin: 0 auto"></div>
		</td>
	</tr>
	<tr>
<!-- IF is_empire -->
	<!-- IF is_repartition -->
		<td>
			<div id="empire_repartition" style="width: 400px; height: 300px; margin: 0 auto"></div>
		</td>
	<!-- ELSE IF is_repartition -->
		<td align='center'>{homestat_NoDataRanking}</td>
	<!-- END IF is_repartition -->
		<td>
			<div id="empire_type" style="width: 400px; height: 300px; margin: 0 auto"></div>
		</td>
<!-- ELSE IF is_empire -->
		<td align='center'>{homestat_NoDataRanking}</td>
		<td align='center'>{homestat_NoDataEmpire}</td>
<!-- END IF is_empire -->	
	</tr>
</table>
<br />
<table style="text-align:center;margin-left:auto;margin-right:auto;">
	<tr>
		<td class="c" colspan="7">{homestat_RankingOf}</td>
	</tr>
	<tr>
		<td class="c" style="width:175px;">{homestat_Date}</td>
		<td class="c" colspan="2">{homestat_GeneralPoints}</td>
		<td class="c" colspan="2">{homestat_FleetPoints}</td>
		<td class="c" colspan="2">{homestat_FleetResearch}</td>
	</tr>
<!-- IF is_rank -->
<!-- BEGIN rank -->
	<tr>
		<th style="width:180px;">{rank.time}</th>
		<th style="width:70px;">{rank.general_points}</th>
		<th style="width:40px;color:lime;"><i>{rank.general_rank}</i></th>
		<th style="width:70px;">{rank.fleet_points}</th>
		<th style="width:40px;color:lime;"><i>{rank.fleet_rank}</i></th>
		<th style="width:70px;">{rank.research_points}</th>
		<th style="width:40px;color:lime;"><i>{rank.research_rank}</i></th>
	</tr>
<!-- END rank -->
<!-- END IF is_rank -->
	<tr>
		<th style='border-color:#FF0000;width:150px;color:yellow;'>{homestat_AverageProgressionPerDay}</th>
		<th style='border-color:#FF0000;width:70px;'>{general_points}</th>
		<th style='border-color:#FF0000;width:40px;color:lime;'><i>{general_rank}</i></th>
		<th style='border-color:#FF0000;width:70px;'>{fleet_points}</th>
		<th style='border-color:#FF0000;width:40px;color:lime;'><i>{fleet_rank}</i></th>
		<th style='border-color:#FF0000;width:70px;'>{research_points}</th>
		<th style='border-color:#FF0000;width:40px;color:lime;'><i>{research_rank}</i></th>
	</tr>
</table>