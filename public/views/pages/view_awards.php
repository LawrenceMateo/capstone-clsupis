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
    <title>Document</title>
    <?php include '../partials/head.php'; ?>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <?php include '../../includes/header.php'; ?>    
        </div>
        <div class="row">                  
            <?php 
                if( $_SESSION['userType'] == 'researcher' )
                    include '../partials/researcher_sidebar.php'; 
                else
                    include '../partials/sidebar.php'; 
            ?> 
        </div>
        <div class="row">
            <div class="col-9 offset-1 mt-3">
                <h4> 
                    Awarded Projects
                </h4>   
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-10 offset-1">
                <div class="row">
                    <div class="col-lg-12 col-md-8">
                        <div class="d-inline-flex w-30">                    
                        </div>                    
                        <div class="form-group d-inline-flex w-70 float-right">
                            <form class="form-inline">        
                                <input id="search-award" class="form-control" type="text" name="search_award" placeholder="Search">
                                <!-- <button class="btn btn-outline-success" type="submit">Search</button>                             -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>                
        <div class="row">
            <div class="container-fluid">
                <div class="col-10 offset-1">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Project Title</th>
                                <th>Award Received</th>
                                <th>Award Giving Body</th>
                                <th>Date Awarded</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="award-data">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- EDIT AWARD MODAL -->
        <div class="modal fade bd-example-modal-lg edit-award-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="center"><strong>Edit Award</strong></span>
                    </div>
                    <div class="modal-body">
                        <form class="form-container" onsubmit="return updateAward()">
                            <div class="form-group">                                                                                
                                <label for="award-name" class="label">
                                    <span><b>Award Received</b></span>
                                </label>
                                <input id="edit-award-id" type="hidden" name="edit_award_id">
                                <input id="edit-award-name" class="form-control" type="text" name="edit_award_name" placeholder="Award received">                                
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">                                                 
                                        <label for="edit-given-by" class="label">
                                            <span><b>Awarded Giving Body</b></span>
                                        </label>
                                        <input id="edit-given-by"class="form-control" type="text" name="edit_given_by" placeholder="Enter award giving body">
                                    </div>
                                    <div class="col-6">                                                 
                                        <label for="edit-date-awarded" class="label">
                                            <span><b>Date Awarded</b></span>
                                        </label>
                                        <input id="edit-date-awarded"class="form-control" name="edit_date_awarded" type="date">                                        
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">                                                 
                                        <label for="edit-venue" class="label">
                                            <span><b>Venue of Awarding</b></span>
                                        </label>
                                        <input id="edit-venue"class="form-control" type="text" name="edit_venue" placeholder="Venue">
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 

    </div> <!-- END CONTAINER-FLUID -->
</body>
<?php include '../../includes/scripts.php'; ?>
<script src="../../assets/js/awards.js"></script>

</html>