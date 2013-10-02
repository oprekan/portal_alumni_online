<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>IAP - Online Voting 2013</title>
    <!-- Le styles -->
    <link href="portal_assets/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="portal_assets/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
	 
	 <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="portal_assets/admin/js/jquery-1.7.2.min.js"></script>
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>-->
    <script src="portal_assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="portal_assets/highcharts-3.0.5/highcharts.js"></script>
	<script type="text/javascript">
	<?php
		$kandidat = "";
		$totalVotePerKandidat = "";
		$persentasePerKandidat = "";
		$isExist = "false";
		if (!empty($voting_result)) {
			$isExist = "true";
			foreach ($voting_result['data'] as $row) {
				$kandidat .= $row['nama_kandidat'].",";
				$totalVotePerKandidat .= $row['vote'].",";
				$persentasePerKandidat .= round(($row['vote']/$total_vote)*100,2).",";
			}
		}
		
		$kandidat = substr($kandidat,0,-1);
		$persentasePerKandidat = substr($persentasePerKandidat,0,-1);
		$totalVotePerKandidat = substr($totalVotePerKandidat,0,-1);
	?>
	var isExist = "<?php echo $isExist;?>";
	
	var kandidat = "<?php echo $kandidat;?>";
	var kandidatSplit = kandidat.split(",");
	
	var persentasePerKandidat = "<?php echo $persentasePerKandidat;?>".split(",");
	for(var i=0; i<persentasePerKandidat.length; i++) { 
		persentasePerKandidat[i] = parseInt(persentasePerKandidat[i], 10); 
	} 
	
	var totalVotePerKandidat = "<?php echo $totalVotePerKandidat;?>".split(",");
	for(var i=0; i<totalVotePerKandidat.length; i++) { 
		totalVotePerKandidat[i] = parseInt(totalVotePerKandidat[i], 10); 
	} 
	
	console.log(totalVotePerKandidat);
	$(document).ready(function(){
		var selectBox = $("select");
		showByPercentage();
		selectBox.change(function()
		{ 
			if ($(this).val() == "percentage") {
				showByPercentage();
			} else if ($(this).val() == "total_value") {
				showByValue();
			}
			//alert("You Choose : "+$(this).val());
		});

		
		function showByPercentage () {
			$(function () {
				if (isExist == "true") {
					//$('#container')[0].innerHTML = "";
					$('#container').highcharts({
						chart: {
							type: 'column'
						},
						title: {
							text: 'Voting Result'
						},
						subtitle: {
							text: 'Ketua IAP 2013 - 2018'
						},
						xAxis: {
							categories: kandidatSplit
						},
						yAxis: {
							min: 0,
							max: 100,
							title: {
								text: 'Total Vote (%)'
							}
						},
						tooltip: {
							headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
							pointFormat: '<tr><td style="color:{series.color};padding:0">Total : </td> ' +
								'<td style="padding:0"> <b>{point.y:.1f} % </b></td></tr>',
							footerFormat: '</table>',
							shared: true,
							useHTML: true
						},
						plotOptions: {
							column: {
								pointPadding: 0.2,
								borderWidth: 0,
								colorByPoint: true
							}
						},
						legend : {
							enabled : false
						},
						series: [{
							name: 'Total Vote',
							data: persentasePerKandidat
						}]
					});
				} else {
					$('#container')[0].innerHTML = "<div align='center'><h4>Belum ada voting yang masuk</h4></div>";
				}
			});
		}
		
		function showByValue () {
			$(function () {
				if (isExist == "true") {
					//$('#container')[0].innerHTML = "";
					$('#container').highcharts({
						chart: {
							type: 'column'
						},
						title: {
							text: 'Voting Result'
						},
						subtitle: {
							text: 'Ketua IAP 2013 - 2018'
						},
						xAxis: {
							categories: kandidatSplit
						},
						yAxis: {
							allowDecimals:false,
							title: {
								text: 'Total Voters'
							}
						},
						tooltip: {
							headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
							pointFormat: '<tr><td style="color:{series.color};padding:0">Total : </td> ' +
								'<td style="padding:0"> <b>{point.y:.1f} voters </b></td></tr>',
							footerFormat: '</table>',
							shared: true,
							useHTML: true
						},
						plotOptions: {
							column: {
								pointPadding: 0.2,
								borderWidth: 0,
								colorByPoint: true
							}
						},
						legend : {
							enabled : false
						},
						series: [{
							name: 'Total Vote',
							data: totalVotePerKandidat
						}]
					});
				} else {
					$('#container')[0].innerHTML = "<div align='center'><h4>Belum ada voting yang masuk</h4></div>";
				}
			});
		}
		
	});
    

	</script>
	</head>
	<body>
		Show result by : 
		<select name="show">
		  <option value="percentage">Percentage</option>
		  <option value="total_value">Total Voters</option>
		</select>
		
		<?php
			$kandidat = "";
			if (!empty($voting_result)) {
				foreach ($voting_result['data'] as $row) {
					//echo "Persentase ".$row['nim_kandidat']." (".$row['vote'].") : ".round(($row['vote']/$total_vote)*100,2)." %<br/>";
				}
			}
			//echo "</br>Total Voters : ".$total_vote."</br>";
		?>
		<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
	</body>
</html>