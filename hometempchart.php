
<!DOCTYPE html>
<meta charset="utf-8">
<html>
  <head>
    <title>Nile's House</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <!-- Load c3.css -->
    <link href="/css/c3.css" rel="stylesheet" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
    <script src="/c3/c3.js"></script>

<style>

body { font: 12px Arial;}

path { 
    stroke: steelblue;
    stroke-width: 2;
    fill: none;
}

.axis path,
.axis line {
    fill: none;
    stroke: grey;
    stroke-width: 1;
    shape-rendering: crispEdges;
}

</style>
<body>
<div class="col-md-12"> <h1>Home Temp</h1> </div>
<div class="col-md-12" id="home"></div>
<div class="col-md-4" id="current"><h2>Current Temp: 68 F</h2></div>
<div class="col-md-4" id="garagehigh"><h2>24 Hour High: 75
 F</h2></div>
<div class="col-md-4" id="garagelow"><h2>24 Hour Low: 64 F</h2></div>
<div class="col-md-12"><br><br><br> Last open: 2015-02-27 08:56:22 </div>

<script>

var margin = {top: 30, right: 20, bottom: 30, left: 50},
    width = (parseInt(d3.select('#garage').style('width'), 10)*.9) - margin.left - margin.right,
    height = 270 - margin.top - margin.bottom;

var parseDate = d3.time.format("%Y-%m-%d %H:%M:%S").parse;

var x = d3.time.scale().range([0, width]);
var y = d3.scale.linear().range([height, 0]);

var xAxis = d3.svg.axis().scale(x)
    .orient("bottom").ticks(5);

var yAxis = d3.svg.axis().scale(y)
    .orient("left").ticks(5);

var valueline = d3.svg.line()
    .x(function(d) { return x(d.timestamp); })
    .y(function(d) { return y(d.value); });
    
var svg = d3.select("#garage")
    .append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
    .append("g")
        .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

// Get the data
d3.json("queryhometemp.php", function(error, data) {
    data.forEach(function(d) {
        d.timestamp = parseDate(d.timestamp);
        d.value = +d.value;
    });

    // Scale the range of the data
    x.domain(d3.extent(data, function(d) { return d.timestamp; }));
    y.domain([d3.min(data, function(d) { return d.value; })-5, d3.max(data, function(d) { return d.value; })+1]);

    svg.append("path")      // Add the valueline path.
        .attr("d", valueline(data));

    svg.append("g")         // Add the X Axis
        .attr("class", "x axis")
        .attr("transform", "translate(0," + height + ")")
        .call(xAxis);

    svg.append("g")         // Add the Y Axis
        .attr("class", "y axis")
        .call(yAxis);

});

var chart = c3.generate({
bindto: '#current',
data: {
        columns: [
            ['data', 68]
        ],
        type: 'gauge',
        onclick: function (d, i) { console.log("onclick", d, i); },
        onmouseover: function (d, i) { console.log("onmouseover", d, i); },
        onmouseout: function (d, i) { console.log("onmouseout", d, i); }
    },
    gauge: {
        label: {
            format: function(value, ratio) {
                return value;
            },
            show: true // to turn off the min/max labels.
        },
    min: -10, // 0 is default, //can handle negative min e.g. vacuum / voltage / current flow / rate of change
//    max: 100, // 100 is default
    units: ' F',
//    width: 39 // for adjusting arc thickness
    },
    color: {
        pattern: ['#FF0000', '#F97600', '#F6C600', '#60B044'], // the three color levels for the percentage values.
        threshold: {
//            unit: 'value', // percentage is default
//            max: 200, // 100 is default
            values: [30, 60, 90, 100]
        }
    },
    size: {
        height: 100
    }
});

setTimeout(function () {
    chart.load({
        columns: [['data', 68]]
    });
}, 120000);

</script>

    <script src="//code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>