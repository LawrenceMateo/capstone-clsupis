<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location:login_form.php');
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <?php include '../partials/head.php'; ?>
</head>
<body>
    <div>
        <?php include '../../includes/header.php'; ?>
        <?php 
            if( $_SESSION['userType'] == 'researcher' ){
                include '../partials/researcher_sidebar.php'; 
            } else {
                include '../partials/sidebar.php'; 
            }
        ?>
    </div>
    <div class="container-fluid">
        <div class="row">
            <h2>Dashboard</h2>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-3">
                <div class="card" style="width: 45rem;">
                    <div id="pie" class="card-body">
                        <canvas id="pieChartField"></canvas>
                        <h5 class="card-title">Distribution of Projects by Research Field</h5>
                        <div id="hidden-field-data" class="collapse">
                            <p class="card-text">The set of data in the pie chart is as follows:</p>
                            <table id="pie-field-data" class="table table-striped">

                            </table>
                        </div>
                        <button id="" class="btn btn-primary" type="button"  data-toggle="collapse" data-target="#hidden-field-data">Show Data</button>
                        <button id="printPieField" class="btn btn-primary print">Print</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-3">
                <div class="card" style="width: 45rem;">
                    <div id="pie" class="card-body">
                        <canvas id="pieChart"></canvas>
                        <h5 class="card-title">Distribution of Projects by Sector</h5>
                        <div id="hidden-data" class="collapse">
                            <p class="card-text">The set of data in the pie chart is as follows:</p>
                            <table id="pie-sector-data" class="table table-striped">

                            </table>
                        </div>
                        <button id="" class="btn btn-primary" type="button"  data-toggle="collapse" data-target="#hidden-data">Show Data</button>
                        <button id="printPie" class="btn btn-primary print">Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <canvas id="myChart"></canvas>

</body>
<script src="https://cdn.jsdelivr.net/npm/jspdf@1.5.3/dist/jspdf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script src="../../assets/js/home.js"></script>
<script>
    jQuery(document).ready(function(){
        var user = '<?php echo $_SESSION['userType']; ?>';

        if(user !== 'admin'){
            $('.print').remove();
            $('.hide-from-researcher').remove();
        } else {
            $('.print').show();
            $('.hide-from-researcher').show();
        }
    });
</script>
</html>