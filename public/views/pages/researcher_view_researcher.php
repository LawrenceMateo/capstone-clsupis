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
                    Funding Agencies
                </h4>   
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-10 offset-1">
                <div class="row">
                    <div class="col-lg-12 col-md-8">
                        <div class="d-inline-flex w-30">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target=".add-agency-modal">Add Funding Agency</button>                     
                        </div>                    
                        <div class="form-group d-inline-flex w-70 float-right">
                            <form class="form-inline">        
                                <input id="search-agency" class="form-control" type="text" name="search_agency" placeholder="Search">
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
                                <th>Researcher ID Number</th>
                                <th>Researcher Name</th>
                                <th>Bachelor's Degree</th>
                                <th>Bachelor's Degree</th>
                                <th>PhD</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="agency-data">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ADD MODAL -->
        <div id="mod" class="modal fade bd-example-modal-lg add-agency-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <span>Add Agency</span>
                    </div>
                    <div class="modal-body">
                        <form class="form-container" onsubmit="return addAgency()">                            
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <input id="bachelors-degree" class="form-control" type="text" name="bachelors_degree" placeholder="Bachelor's Degree">
                                    </div>
                                    <div class="col-6">
                                        <input id="bachelors-grad" class="form-control" type="text" name="bachelors_grad" placeholder="Graduated At" disabled="true">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <input id="masters-degree" class="form-control" type="text" name="masters_degree" placeholder="Master's Degree" disabled="true">
                                    </div>
                                    <div class="col-6">
                                        <input id="masters-grad" class="form-control" type="text" name="masters_grad" placeholder="Graduated At" disabled="true">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <input id="doctorate" class="form-control" type="text" name="doctorate" placeholder="Doctorate" disabled="true">
                                    </div>
                                    <div class="col-6">
                                        <input id="doctorate-grad" class="form-control" type="text" name="doctorate_grad" placeholder="Graduated At" disabled="true">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
        
        <!-- EDIT MODAL -->
        <div class="modal fade bd-example-modal-lg edit-agency-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <span><strong>Update Agency</strong></span>
                    </div>
                    <div class="modal-body">
                        <form class="form-container" onsubmit="return updateAgency()">
                            <div class="form-group">
                                <input id="edit-agency-id" type="hidden" name="edit_agency_id">
                                <input id="edit-agency-name" class="form-control" type="text" name="edit_agency_name" placeholder="Agency Name">
                            </div>
                            <div class="form-group">
                                <input id="edit-agency-address" class="form-control" type="text" name="edit_agency_address" placeholder="Agency Address">
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 

        <!-- DELETE MODAL -->
        <div class="modal fade bd-example-modal-lg delete-agency-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <span><strong>Delete Agency</strong></span>
                    </div>
                    <div class="modal-body">
                        <form class="form-container" onsubmit="return deleteAgency()">
                            <div class="form-group">
                                <input id="delete-agency-id" type="hidden" name="delete_agency_id">
                                <p>Are you sure you want to delete this record?</p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
    </div> <!-- END CONTAINER-FLUID -->
</body>
<?php include '../../includes/scripts.php'; ?>
<script src="../../assets/js/agencies.js"></script>

</html>