
<br>
<br>
<br>

<?php 

    $id = $_SESSION['farmerid'];

    $weather = 'SELECT * FROM Farmers
     INNER JOIN City ON City.cityid = Farmers.cityid
     WHERE Farmers.farmerid = :id';

    $selectweather =  $conn->prepare($weather);
    $selectweather->bindParam('id', $id);
    $selectweather->execute();
    $farmer = $selectweather->fetch(); 
?>

    <a class="weatherwidget-io"
        href="https://forecast7.com/en/<?php echo $farmer['weatherid'];?>/"
        data-label_1="<?php echo $farmer['cityname'];?>" data-label_2="WEATHER"
        data-theme="original" ><?php echo $farmer['cityname'];?> WEATHER</a>

<script>
!function(d,s,id){
    var js, fjs=d.getElementsByTagName(s)[0];
    if(!d.getElementById(id)){
        js=d.createElement(s);
        js.id=id;
        js.src='https://weatherwidget.io/js/widget.min.js';
        fjs.parentNode.insertBefore(js,fjs);
        }
    }
    (document,'script','weatherwidget-io-js');
</script>