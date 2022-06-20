<?php use app\core\App; ?>
<?php use app\controllers\StatsController; ?>
<?php use app\models\Publication; ?>
<?php use app\models\Stats; ?>
<?php
$count = Publication::count();
$languageArray = array();
$countArray = array();

$arrayCountries = Stats::getCountries(1);

$startDate=StatsController::$startDate;
$endDate=StatsController::$endDate;

$hourArray=Stats::generateTimeStats();

$nrDays=Stats::$nrDays;

echo "nr days =" . $nrDays;


$startHour=\date('h', strtotime($startDate));
$startDay=date('d', strtotime($startDate));
echo " \n $startHour \n";

echo " HOUR ARRAY LENGTH = " . count($hourArray) ;

foreach ($hourArray as $k => $v) {
    echo "\$a[$k] => $v.\n";
}

?>
<div class="appBar" id="appBar">
    <div class="logoPlace" id="logoPlace">
        <img src="images/logo.png" alt="Logo" width="150px">
    </div>
    <p class="title" id="title"> Statistics for your email</p>

</div>
<div class="firstRow">
    <p class="text1">Choose the start and end date for the statistics</p>
    <form method="post" class="firstRow">
        <div class="column1">
            <label for="startDate" class="selecting1">Select start date:</label>
            <input type="datetime-local" id="startDate" name="startDate" class="date" value="startDate">
        </div>
        <div class="column2">
            <label for="endDate" class="selecting2">Select end date:</label>
            <input type="datetime-local" id="endDate" name="endDate" class="date">
        </div>
        <input type="submit" value="Submit" class="GenerateButton">
    </form>
</div>
<hr>
<div class="FirstStatsPlace">
    <p class="Text2">Number of views: <?php echo StatsController::$nrViews ?> </p>
    <p class="Text3"> The origin country for the visitors:</p>
    <p class="Text5">The visitors diagram:</p>

    <div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript">

            google.load('visualization', '1', {packages: ['corechart'], callback: drawChart});

            google.setOnLoadCallback(drawChart);

            function drawChart(callback) {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Topping');
                data.addColumn('number', 'Slices');
                let count = '<?= $count ?>';
                let array =<?php echo json_encode($arrayCountries); ?>;

                let keyArray=new Array();
                for (let key = 0; key < array.length; key += 2) {
                    keyArray.push(array[key]);
                }
                Array.prototype.contains = function(v) {
                    for (let i = 0; i < this.length; i++) {
                        if (this[i] === v) return true;
                    }
                    return false;
                };

                Array.prototype.unique = function() {
                    let arr = [];
                    for (let i = 0; i < this.length; i++) {
                        if (!arr.contains(this[i])) {
                            arr.push(this[i]);
                        }
                    }
                    return arr;
                }

                keyArray=keyArray.unique();

                // alert(keyArray.length);

                // for(let j=0;j<keyArray.length;j++){
                //
                //     data.addRows([
                //         [keyArray[key], array.valueOf( keyArray[key]) ) ],
                //     ]);
                // }

                for (let key = 0; key < array.length; key += 2) {

                    data.addRows([
                        [array[key], array[key + 1]],
                    ]);
                }

                let startDate='<?= $startDate ?>';
                let endDate='<?= $endDate ?>';
                var options = {
                    'title' : '  Diagram from ' + startDate + ' to ' + endDate,
                    'width': 400,
                    'height': 400
                };

                var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
                chart.draw(data, options);
            }

        </script>

        <div id="content">
            <div id="chart_div"></div>
        </div>
    </div>


    <div class="ExportRow">
        <p class="Text4">Export as:</p>
        <form method="post">
            <label for="types"></label>
            <select name="types" id="types" class="exportOptions">
                <option value="pdf">PDF</option>
                <option value="html">HTML</option>
                <option value="xml">XML</option>
            </select>
            <input type="submit" value="Submit" class="GenerateButton" id="save-pdf">
        </form>
    </div>
</div>
<hr>
<!--<div class="firstRow">-->
<!--    <p class="text1">Select how the chart should be grouped:</p>-->
<!--    <form class="form2" method="post">-->
<!--        <label for="groups" class="text1">Group by: </label>-->
<!--        <select name="groups" id="groups" class="exportOptions">-->
<!--            <option value="day" id="day" name="day">Day</option>-->
<!--            <option value="week" id="week" name="week">Week</option>-->
<!--            <option value="month" id="month" name="month">Month</option>-->
<!--        </select>-->
<!--    </form>-->
<!--    <button type="submit" class="GenerateButton">Save Changes</button>-->
<!--</div>-->
<!--<hr>-->
<div class="SecondStatsPlace">
    <p class="Text5">The visitors diagram:</p>
    <div>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.load('visualization', '1', {packages: ['bar'], callback: drawStuff});
            google.charts.setOnLoadCallback(drawStuff);

            function drawStuff(callback) {

                let data = new google.visualization.DataTable();
                data.addColumn('timeofday', 'Time of Day');
                data.addColumn('number', 'Nr views');



                // in dreapta adaug nr de views , in stanga adaug ora
                let hourArray =<?php echo json_encode($hourArray); ?>;


                let startHour = '<?= $startHour ?>';

                let startDay = '<?= $startDay ?>';

                let indexStart;
                alert(parseInt(startHour));

                let nrDays = '<?= $nrDays ?>';

                let generalArray;
                if(parseInt(nrDays)===0){
                    indexStart=startHour;
                }else{
                    indexStart=startDay;
                }

                for(let i=parseInt(indexStart);i<24; i++){

                    // alert(hourArray[i]);

                    data.addRows([
                        [ {v: [i, 0, 0], f: i + " am"} , hourArray[i] ],
                    ]);
                }


                let options = {
                    title: 'Diagram group by hours/day',
                    width: 1000,
                    height: 400,
                    hAxis: {
                        title: 'Time of Day',
                        format: 'h:mm a',
                        viewWindow: {
                            min: [0, 30, 0],
                            max: [23, 30, 0]
                        }
                    },
                    vAxis: {
                        title: 'Nr views'
                    }
                };

                let chart = new google.charts.Bar(document.getElementById('top_x_div'));
                // Convert the Classic options to Material options.
                chart.draw(data, google.charts.Bar.convertOptions(options));
            }
        </script>


        <div id="content">
            <div id="top_x_div"></div>
        </div>

    </div>
    <div class="ExportRow">
        <p class="Text4">Export as:</p>
        <form method="post">
            <label for="types"></label>
            <select name="types" id="types" class="exportOptions">
                <option value="pdf">PDF</option>
                <option value="html">HTML</option>
                <option value="xml">XML</option>
            </select>
        </form>
    </div>
</div>

