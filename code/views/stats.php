<?php use app\core\App; ?>
<?php use app\controllers\StatsController; ?>
<?php
if( isset($_POST['endDate']) & isset($_POST['startDate'])){
    echo "acum setez ";
    StatsController::$startDate=$_POST['startDate'];
    StatsController::$endDate=$_POST['endDate'];
    $session = App::$app->session;
    $session->set("startDate", $_POST['startDate']);
    $session->set("endDate", $_POST['endDate']);
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
            <input type="datetime-local" id="startDate" name="startDate" class="date"  value="startDate" >
        </div>
        <div class="column2">
            <label for="endDate" class="selecting2">Select end date:</label>
            <input type="datetime-local" id="endDate" name="endDate" class="date" >
        </div>
        <input type="submit" value="Submit" class="GenerateButton"  >
    </form>
</div>
<hr>
<div class="FirstStatsPlace">
    <p class="Text2">Number of views: <?php echo StatsController::$nrViews?> </p>
    <p class="Text3"> The origin country for the visitors:</p>
    <img src="images/diagram.png" alt="diagram1" class="image1">
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
    <img src="images/diagram.png" alt="diagram2" class="image1">
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
