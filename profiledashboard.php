<?php 

    $idf = $_SESSION['farmerid'];
    $sold = "2";

    $queryprofits = 'SELECT * FROM Shop
    INNER JOIN Harvest ON Harvest.harvestid = Shop.harvestid
    INNER JOIN Plant ON Plant.plantid = Harvest.plantid
    WHERE Plant.farmerid = :id AND Harvest.shopstatusid = :statusid';

    $selectprofits =  $conn->prepare($queryprofits);
    $selectprofits->bindParam('id', $idf);
    $selectprofits->bindParam('statusid', $sold);
    $selectprofits->execute();
    $profits = $selectprofits->fetchAll();

    $profit = 0;
    foreach($profits as $crop){
        $profit = $profit + $crop['price'];
    }

    $queryinvp = 'SELECT * FROM Plant
    WHERE farmerid = :id';

    $selectinvp =  $conn->prepare($queryinvp);
    $selectinvp->bindParam('id', $idf);
    $selectinvp->execute();
    $investmentsp = $selectinvp->fetchAll();

    $investment = 0;
    foreach($investmentsp as $crop){
        $investment = $investment + $crop['plantcosts'];
    }
    

    $queryinv = 'SELECT * FROM Harvest
    INNER JOIN Plant ON Plant.plantid = Harvest.plantid
    WHERE Plant.farmerid = :id';

    $selectinv =  $conn->prepare($queryinv);
    $selectinv->bindParam('id', $idf);
    $selectinv->execute();
    $investments = $selectinv->fetchAll();

    foreach($investments as $crop){
        $investment = $investment + $crop['harvestcosts'];
    }


?>

<div class="container">
<div class="row">
    <div>
        <div id="chart"></div>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

        <script type="text/javascript">
        // Load google charts
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        // Draw the chart and set the chart values
        function drawChart() {
        var data = google.visualization.arrayToDataTable([
        ['Farmers', 'Number of Activity'],
        ['Investments', <?php echo $investment; ?>],
        ['Profits', <?php echo $profit; ?>]
        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title':'Investments vs Profits', 'width':400, 'height':350};

        // Display the chart inside the <div> element with id="chart"
        var chart = new google.visualization.PieChart(document.getElementById('chart'));
        chart.draw(data, options);
        }
        </script>
    </div>
    <div>
        <div id="chart1"></div>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

        <script type="text/javascript">
        // Load google charts
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        // Draw the chart and set the chart values
        function drawChart() {
        var data = google.visualization.arrayToDataTable([
        ['Farmers', 'Number of Activity'],
        ['example', 23],
        ['example', 40]
        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title':'example vs example', 'width':400, 'height':350};

        // Display the chart inside the <div> element with id="chart"
        var chart = new google.visualization.PieChart(document.getElementById('chart1'));
        chart.draw(data, options);
        }
        </script>
    </div>
</div>

<?php
    $queryplant = 'SELECT * FROM Plant
    WHERE farmerid = :id';

    $selectplant =  $conn->prepare($queryplant);
    $selectplant->bindParam('id', $idf);
    $selectplant->execute();


    $queryharvest = 'SELECT * FROM Harvest
    INNER JOIN Plant ON Plant.plantid = Harvest.plantid
    WHERE Plant.farmerid = :id';

    $selectharvest =  $conn->prepare($queryharvest);
    $selectharvest->bindParam('id', $idf);
    $selectharvest->execute();


    $plant = $selectplant->rowCount();
    $harvest = $selectharvest->rowCount();

    $result = ($harvest / $plant) * 100;
?>

<label>Harvested plants in %</label>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo (int) $result ?>%;" aria-valuenow="<?php echo (int) $result ?>" aria-valuemin="0" aria-valuemax="100"><?php echo (int) $result ?>%</div>
</div>


<?php
    $queryshopall = 'SELECT * FROM Shop
    INNER JOIN Harvest ON Harvest.harvestid = Shop.harvestid
    INNER JOIN Plant ON Plant.plantid = Harvest.plantid
    WHERE Plant.farmerid = :id';

    $selectshopall =  $conn->prepare($queryshopall);
    $selectshopall->bindParam('id', $idf);
    $selectshopall->execute();

    $shid = "2";
    $querysold = 'SELECT * FROM Shop
    INNER JOIN Harvest ON Harvest.harvestid = Shop.harvestid
    INNER JOIN Plant ON Plant.plantid = Harvest.plantid
    WHERE Plant.farmerid = :id AND Harvest.shopstatusid = :shid';

    $selectsold =  $conn->prepare($querysold);
    $selectsold->bindParam('id', $idf);
    $selectsold->bindParam('shid', $shid);
    $selectsold->execute();


    $shopall = $selectshopall->rowCount();
    $sold = $selectsold->rowCount();

    $resultshop = ($sold / $shopall) * 100;
?>
<br>
<br>
<br>
<label>Products sold in %</label>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo (int) $resultshop ?>%;" aria-valuenow="<?php echo (int) $resultshop ?>" aria-valuemin="0" aria-valuemax="100"><?php echo (int) $resultshop ?>%</div>
</div>


<?php
    $querytasksall = 'SELECT * FROM Tasks
    WHERE farmerid = :id';

    $selecttasksall =  $conn->prepare($querytasksall);
    $selecttasksall->bindParam('id', $idf);
    $selecttasksall->execute();

    $taskstatusid = "2";
    $querycompl = 'SELECT * FROM Tasks
    WHERE farmerid = :id AND taskstatusid = :tid';

    $selectcompl =  $conn->prepare($querycompl);
    $selectcompl->bindParam('id', $idf);
    $selectcompl->bindParam('tid', $taskstatusid);
    $selectcompl->execute();


    $tasksall = $selecttasksall->rowCount();
    $compl = $selectcompl->rowCount();

    $resulttasks = ($compl / $tasksall) * 100;
?>
<br>
<br>
<br>
<label>Completed tasks in %</label>
<div class="progress">
  <div class="progress-bar" role="progressbar" style="width: <?php echo (int) $resulttasks ?>%;" aria-valuenow="<?php echo (int) $resulttasks ?>" aria-valuemin="0" aria-valuemax="100"><?php echo (int) $resulttasks ?>%</div>
</div>

</div>