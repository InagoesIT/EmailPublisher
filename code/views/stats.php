<style>
    body {
        background-color: #005226;
        margin: 0px;
    }
    .appBar{
        height: 150px;
        width: 100%;
        background-color: #BCCE98;
        margin:0;
        padding:0;
        display: flex;

    }
    .logoPlace{
        width: 160px;
        /*background-color: #C4C4C4;*/

    }
    .title{
        font-size: 35px;
        font-weight: bold;
        font-family: 'Roboto Mono Light', monospace;
        text-align: center;
        float: left;
        margin-left: 20px;
    }
    .button{
        font-family: 'Roboto Mono Light', monospace;
        font-size: 21px;
        font-weight: bold;
        color: #005226;
        background-color: #fff;
        height: 60px;
        width: 200px;
        border-radius: 15px;
        border-color: #005226;
        margin-top: 40px;
        margin-left: 10%;

    }

    .firstRow{
        height: 180px;
        width: 100%;
        display: flex;
        align-items: center;
    }
    .text1{
        font-family: 'Roboto Mono Light', monospace;
        font-size: 30px;
        color: #fff;
    }
    .selecting1{
        font-family: 'Roboto Mono Light', monospace;
        font-size: 23px;
        color: #fff;
        margin-left: 1%;
    }
    .selecting2{
        font-family: 'Roboto Mono Light', monospace;
        font-size: 23px;
        color: #fff;
        margin-left: 1%;
    }

    .GenerateButton{
        font-family: 'Roboto Mono Light', monospace;
        font-size: 25px;
        color: black;
        background-color: #BCCE98;
        margin-left: 6%;
        height: 65px;
        border-radius: 10px;
        border-color: yellow;
    }
    hr {
        display: block;
        border: 1px solid #BCCE98;
    }
    .FirstStatsPlace{
        height: 900px;
        background-color: #C4C4C4;
        margin: 50px;
        border-top-left-radius: 40px;
        border-top-right-radius: 40px;
        align-content: center;
        vertical-align: middle;
        text-align: center;


    }
    .SecondStatsPlace{
        height: 900px;
        background-color: #C4C4C4;
        margin: 50px;
        border-bottom-left-radius: 40px;
        border-bottom-right-radius: 40px;
        text-align: center;
        padding-top: 30px;
    }
    .Text2{
        font-family: 'Roboto Mono Light', monospace;
        font-size: 30px;
        color: #042212;
        padding-top: 50px;
        padding-left: 50px;
    }
    .Text3{
        font-family: 'Roboto Mono Light', monospace;
        font-size: 30px;
        color: #042212;
        padding-top: 20px;
        padding-left: 50px;
        padding-bottom: 20px;
    }
    .image1{
        width: 750px;
        padding-left: 50px;
    }

    .ExportRow{
        display: flexbox;
        margin-left: 50px;
    }

    .Text4{
        font-family: 'Roboto Mono Light', monospace;
        font-size: 30px;
        color: #042212;
    }
    .form2{
        margin-left: 10%;
    }

    .SecondStatsPlace{
        height: 900px;
        background-color: #C4C4C4;
        margin: 60px;
        border-bottom-left-radius: 40px;
        border-bottom-right-radius: 40px;
    }
    .column1{
        padding-left: 6%;
    }
    .column2{
        padding-left: 6%;
    }
    .date{
        height: 50px;
        border-radius: 15px;
        font-size: 17px;
        font-weight: bold;

    }
    .exportOptions{
        width: 100px;
        height: 50px;
        font-size: 20px;
        font-family: 'Roboto Mono Light', monospace;
        color: #042212;
        border-radius: 10px;
        border-color: yellow;
        font-weight: bold;
    }
    .Text5{
        font-family: 'Roboto Mono Light', monospace;
        font-size: 30px;
        color: #042212;
        padding-top: 50px;
        padding-left: 50px;

    }

    @media screen and (max-width: 1100px) {
        .image1{
            width: 500px;
        }
        .text1{
            font-size: 22px;
        }
        .title{
            font-size: 30px;
        }
        .SecondStatsPlace{
            height: 800px;
        }
        .FirstStatsPlace{
            padding-top: 10px;
            height: 800px;
        }
        .Text2{
            padding-top: 30px;
        }
        .Text5{
            padding-top: 80px;
        }
        .selecting1{
            font-size: 20px ;
        }
        .selecting2{
            font-size: 20px ;
        }
        .date{
            width: 150px;
        }
        .column1{
            padding-left: 4%;
        }
        .column2{
            padding-left: 4%;
        }
    }

    @media screen and (max-width: 800px) {
        .image1{
            width: 400px;
        }
    }
</style>
<?php use app\core\App; ?>
<?php use app\controllers\StatsController; ?>
<?php use app\models\Publication; ?>
<?php use app\models\Stats; ?>
<?php
$count = Publication::count();
$languageArray = array();
$countArray = array();

$link = $_SERVER['REQUEST_URI'];
$pub = preg_split("[/]", $link);
$pub = $pub[2];
$id = Publication::getPublicationProprietyByLink('id', $pub);

$arrayCountries = Stats::getCountries($id);

$startDate=StatsController::$startDate;
$endDate=StatsController::$endDate;

$hourArray=Stats::generateTimeStats();

$nrDays=3;

//echo "nr days =" . $nrDays;


$startHour=\date('h', strtotime($startDate));
$startDay=date('d', strtotime($startDate));
//echo " \n $startHour \n";

//echo " HOUR ARRAY LENGTH = " . count($hourArray) ;
//
//foreach ($hourArray as $k => $v) {
//    echo "\$a[$k] => $v.\n";
//}

?>
<div class="appBar" id="appBar">
    <p class="title" id="title" style="margin-left: 40%"> Statistics for your email</p>

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
                // alert(parseInt(startHour));

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

