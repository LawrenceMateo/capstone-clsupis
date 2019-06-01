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
                    Sectors
                </h4>   
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-10 offset-1">
                <div class="row">
                    <div class="col-lg-12 col-md-8">
                        <div class="d-inline-flex w-30">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target=".add-sector-modal">Add Sector</button>                     
                        </div>                    
                        <div class="form-group d-inline-flex w-70 float-right">
                            <form class="form-inline">        
                                <input id="search-sector" class="form-control" type="text" name="search_sector" placeholder="Search">
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
                                <th>Sector Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="sector-data">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ADD MODAL -->
        <div class="modal fade bd-example-modal-lg add-sector-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <span>Add Sector</span>
                    </div>
                    <div class="modal-body">
                        <form class="form-container" onsubmit="return addSector()">
                            <div class="form-group">
                                <input id="sector-name" class="form-control" type="text" name="sector_name" placeholder="Sector Name">
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
        <div class="modal fade bd-example-modal-lg edit-sector-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <span><strong>Update Sector</strong></span>
                    </div>
                    <div class="modal-body">
                        <form class="form-container" onsubmit="return updateSector()">
                            <div class="form-group">
                                <input id="edit-sector-id" type="hidden" name="edit_sector_id">
                                <input id="edit-sector-name" class="form-control" type="text" name="edit_sector_name" placeholder="Sector Name">
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
        <div class="modal fade bd-example-modal-lg delete-sector-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <span><strong>Delete Sector</strong></span>
                    </div>
                    <div class="modal-body">
                        <form class="form-container" onsubmit="return deleteSector()">
                            <div class="form-group">
                                <input id="delete-sector-id" type="hidden" name="delete_sector_id">
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
<script src="../../assets/js/sectors.js"></script>

</html>