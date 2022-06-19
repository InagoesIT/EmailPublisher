<?php use app\core\App; ?>
<?php use app\controllers\StatsController; ?>
<?php use app\models\Publication; ?>
<?php use app\models\Stats; ?>
<?php
$count = Publication::count();
$languageArray = array();
$countArray = array();

$arrayCountries = Stats::getCountries(1);

var_dump($arrayCountries);
echo "<br>";
foreach ($arrayCountries as $k => $v) {
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
            console.log("1");
            google.load('visualization', '1', {packages: ['corechart'], callback: drawChart});
            console.log("2");

            google.setOnLoadCallback(drawChart);
            console.log("3");

            function drawChart(callback) {
                console.log("4");

                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Topping');
                data.addColumn('number', 'Slices');
                let count = '<?= $count ?>';
                let array =<?php echo json_encode($arrayCountries); ?>;
                for (let key = 0; key < array.length; key += 2) {
                    data.addRows([
                        [array[key], array[key + 1]],
                    ]);
                }
                console.log("5");

                var options = {
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
<div class="firstRow">
    <p class="text1">Select how the chart should be grouped:</p>
    <form class="form2">
        <label for="groups" class="text1">Group by: </label>
        <select name="groups" id="groups" class="exportOptions">
            <option value="day">Day</option>
            <option value="week">Week</option>
            <option value="month">Month</option>
        </select>
    </form>
    <button type="submit" class="GenerateButton">Save Changes</button>
</div>
<hr>
<div class="SecondStatsPlace">
    <p class="Text5">The visitors diagram:</p>
    <div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript">
            console.log("1");
            google.load('visualization', '1', {packages: ['corechart'], callback: drawChart});
            console.log("2");

            google.setOnLoadCallback(drawChart);
            console.log("3");

            function drawChart() {
                console.log("4");

                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Topping');
                data.addColumn('number', 'Slices');

                let data1;
                $.ajax({
                    type: 'POST',
                    dataType: "json",
                    url: 'test.php',
                    data:
                    success
            :

                function (data1) {
                    try {
                        data1 = JSON.parse(data1);
                        console.log(data1);
                        document.write(1000);
                    } catch (e) {
                        window.alert(5 + 6);
                    }
                    console.log(data1);
                    document.write(2000);
                }
            })


                //for(let i=0;i<)
                data.addRows([
                    ['Mushrooms', 3],
                    ['Onions', 1],
                    ['Olives', 1],
                    ['Zucchini', 1],
                    ['Pepperoni', 2]
                ]);
                console.log("5");

                var options = {
                    'title': 'How Much Pizza I Ate Last Night ana',
                    'width': 400,
                    'height': 300
                };

                var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
                chart.draw(data, options);
                console.log("6");

            }

            console.log("7");

        </script>
        <div id="content">
            <div id="chart_div"></div>
        </div>
    </div>
    <div class="ExportRow">
        <p class="Text4">Export as:</p>
        <form>
            <label for="types"></label>
            <select name="types" id="types" class="exportOptions">
                <option value="pdf">PDF</option>
                <option value="html">HTML</option>
                <option value="xml">XML</option>
            </select>
        </form>
    </div>
</div>

