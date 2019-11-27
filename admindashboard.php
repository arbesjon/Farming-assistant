<?php 

    $idf = $_SESSION['farmerid'];

    $farmertodayq = 'SELECT * FROM Farmers
    WHERE DATE(registerdate) = DATE(NOW())';
    $selectfarmertoday =  $conn->prepare($farmertodayq);
    $selectfarmertoday->execute();

    $farmerq = 'SELECT * FROM Farmers';
    $selectfarmer =  $conn->prepare($farmerq);
    $selectfarmer->execute();

    $salesq = 'SELECT SUM(price) AS price FROM Shop 
    INNER JOIN Harvest on Harvest.harvestid = Shop.harvestid
    WHERE Harvest.shopstatusid = 2';
    $sales =  $conn->prepare($salesq);
    $sales->execute();
    $sa = $sales->fetch();

    $messagesq = 'SELECT * FROM Messages
    WHERE DATE(msgsent) = DATE(NOW())';
    $messages =  $conn->prepare($messagesq);
    $messages->execute();

?>
<br>
<br>
<div class="container">
<div class="row">
    <div class="card text-center" style="width: 16rem;">
        <div class="card-body">
            <h5 class="card-title"><stroong><?php echo $selectfarmertoday->rowCount(); ?></strong></h5>
            <p class="card-text" id="formtext">Farmers today</p>
        </div>
    </div>
    
    <div class="card text-center" style="width: 16rem;">
        <div class="card-body">
            <h5 class="card-title"><stroong><?php echo $selectfarmer->rowCount(); ?></strong></h5>
            <p class="card-text" id="formtext">Total Farmers</p>
        </div>
    </div>
    <div class="card text-center" style="width: 16rem;">
        <div class="card-body">
            <h5 class="card-title"><stroong><?php echo $sa['price']; ?>€</strong></h5>
            <p class="card-text" id="formtext">Sales</p>
        </div>
    </div>
    <div class="card text-center" style="width: 16rem;">
        <div class="card-body">
            <h5 class="card-title"><stroong><?php echo $messages->rowCount(); ?></strong></h5>
            <p class="card-text" id="formtext">Messages today</p>
        </div>
    </div>
</div>

<div class="row">

    <?php
        $maleq = 'SELECT * FROM Details
        WHERE gender = "M"';
        $male =  $conn->prepare($maleq);
        $male->execute();

        $femaleq = 'SELECT * FROM Details
        WHERE gender = "F"';
        $female =  $conn->prepare($femaleq);
        $female->execute();
    ?>
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
        ['Male', <?php echo $male->rowCount(); ?>],
        ['Female', <?php echo $female->rowCount(); ?>]
        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title':'Gender', 'width':400, 'height':350};

        // Display the chart inside the <div> element with id="chart"
        var chart = new google.visualization.PieChart(document.getElementById('chart'));
        chart.draw(data, options);
        }
        </script>
    </div>

    <?php 
        $cityq = 'SELECT *, COUNT(Farmers.cityid) as nrcity FROM Farmers
        INNER JOIN City on City.cityid = Farmers.cityid
        GROUP BY Farmers.cityid';
        $selectcity =  $conn->prepare($cityq);
        $selectcity->execute();
        $city = $selectcity->fetchAll();

        $allrows = $selectcity->rowCount();
        $i = 1;
    ?>
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
        <?php foreach($city as $c){
            if($allrows == $i){?>
                ['<?php echo $c['cityname']?>', <?php echo $c['nrcity'] ?>]
            <?php } else{?>
                ['<?php echo $c['cityname']?>', <?php echo $c['nrcity'] ?>],
            <?php }
            $i++;
         } ?>
        ]);

        // Optional; add a title and set the width and height of the chart
        var options = {'title':'Regions', 'width':400, 'height':350};

        // Display the chart inside the <div> element with id="chart"
        var chart = new google.visualization.PieChart(document.getElementById('chart1'));
        chart.draw(data, options);
        }
        </script>
    </div>

</div>



</div>