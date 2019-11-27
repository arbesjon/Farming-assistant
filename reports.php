<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="css/cropsplant.css" rel="stylesheet">
  <title></title>
</head>
<body>

    <div class="mx-auto" style="width: 18rem;">
    <br>
    <label class="font-weight-bold" for="exampleFormControlSelect1">Reports</label>
    <br>
    <br>
          
        <form method="post" id="reports" onSubmit="ReportsFunction()">
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlSelect1">Action:</label>
                <select class="form-control" id="exampleFormControlSelect1" name="action">
                    <option value="tasks" >Tasks</option>   
                    <option value="alarms" >Alarms</option> 
                    <option value="plants" >Plants</option> 
                    <option value="harvested" >Harvested</option>    
                </select>
            </div>
            <br>
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">Date from:</label>
                <input type="date" class="form-control" id="exampleFormControlInput1" name="datefrom" placeholder="Date from">
            </div>
            <div class="form-group">
                <label class="font-weight-bold" id="formtext" for="exampleFormControlInput1">Date to:</label>
                <input type="date" class="form-control" id="exampleFormControlInput1" name="dateto" placeholder="Date to">
            </div>
            <div class="modal-footer">
                <button type="submit" name="createreport" class="btn btn-info">Create report!</button>
            </div>
        </form>

    </div>

    <script> 
        function ReportsFunction(){
            var action = document.getElementsByName("action")[0].value;
            var datefrom = document.getElementsByName("datefrom")[0].value;
            var dateto = document.getElementsByName("dateto")[0].value;

            //var reports = document.getElementById('reports');
            //reports.action = "generatereport?action="+action+"&datefrom="+datefrom+"&dateto="+dateto;
            window.open("generatereport?action="+action+"&datefrom="+datefrom+"&dateto="+dateto);
        }
    </script>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html> 