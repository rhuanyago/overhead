<?php

$canal = 8;


?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<style>

.highcharts-figure, .highcharts-data-table table {
  min-width: 800px; 
  max-width: 900px;
  margin: 1em auto;
}

.highcharts-data-table table {
	font-family: Verdana, sans-serif;
	border-collapse: collapse;
	border: 1px solid #EBEBEB;
	margin: 10px auto;
	text-align: center;
	width: 100%;
	max-width: 900px;
}
.highcharts-data-table caption {
  padding: 1em 0;
  font-size: 1.2em;
  color: #555;
}
.highcharts-data-table th {
	font-weight: 600;
  padding: 0.5em;
}
.highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
  padding: 0.5em;
}
.highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
  background: #f8f8f8;
}
.highcharts-data-table tr:hover {
  background: #f1f7ff;
}
</style>

<figure class="highcharts-figure">
  <div id="container"></div>
  <p class="highcharts-description">

  </p>
</figure>




<script>
Highcharts.chart('container', {
  chart: {
    type: 'gauge',
    plotBorderWidth: 1,
    plotBackgroundColor: {
      linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
      stops: [
        [0, '#FFF4C6'],
        [0.3, '#FFFFFF'],
        [1, '#FFF4C6']
      ]
    },
    plotBackgroundImage: null,
    height: 250
  },

  title: {
    text: 'Frequência do Canal'
  },

  pane: [{
    startAngle: -65,
    endAngle: 70,
    background: null,
    center: ['50%', '145%'],
    size: 500
  }],

  exporting: {
    enabled: false
  },

  tooltip: {
    enabled: false
  },

  yAxis: [{
    min: -90,
    max: -20,
    minorTickPosition: 'outside',
    tickPosition: 'outside',
    labels: {
      rotation: 'auto',
      distance: 20
    },
    plotBands: [{
      from: 0,
      to: 6,
      color: '#C02316',
      innerRadius: '100%',
      outerRadius: '105%'
    }],
    pane: 0,
    title: {
      text: '-dBm<br/><span style="font-size:15px">Canal <?php echo $canal ?></span>',
      y: -40
    }
  }],

  plotOptions: {
    gauge: {
      dataLabels: {
        enabled: false
      },
      dial: {
        radius: '100%'
      }
    }
  },

  series: [{
    name: 'Channel A',
    data: [-20],
    yAxis: 0
  }]

},

// Let the music play
function (chart) {
  setInterval(function () {
    if (chart.series) { // the chart may be destroyed
      var left = chart.series[0].points[0],
        right = chart.series[1].points[0],
        leftVal,
        rightVal,
        inc = (Math.random() - 0.5) * 3;

      leftVal = left.y + inc;
      rightVal = leftVal + inc / 3;
      if (leftVal < -20 || leftVal > 6) {
        leftVal = left.y - inc;
      }
      if (rightVal < -20 || rightVal > 6) {
        rightVal = leftVal;
      }

      left.update(leftVal, false);
      right.update(rightVal, false);
      chart.redraw();
    }
  }, 500);

});

</script>