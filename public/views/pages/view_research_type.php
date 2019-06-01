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
                    Project Types
                </h4>   
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-10 offset-1">
                <div class="row">
                    <div class="col-lg-12 col-md-8">
                        <div class="d-inline-flex w-30">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target=".add-type-modal">Add Project Type</button>                     
                        </div>                    
                        <div class="form-group d-inline-flex w-70 float-right">
                            <form class="form-inline">        
                                <input id="search-type" class="form-control" type="text" name="search_type" placeholder="Search">
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
                                <th>Project Type Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="type-data">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ADD MODAL -->
        <div id="mod" class="modal fade bd-example-modal-lg add-type-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <span>Add Project Type</span>
                    </div>
                    <div class="modal-body">
                        <form class="form-container" onsubmit="return addType()">
                            <div class="form-group">
                                <input id="type-name" class="form-control" type="text" name="type_name" placeholder="Project Type Name">
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
        <div class="modal fade bd-example-modal-lg edit-type-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <span><strong>Update Project Type</strong></span>
                    </div>
                    <div class="modal-body">
                        <form class="form-container" onsubmit="return updateType()">
                            <div class="form-group">
                                <input id="edit-type-id" type="hidden" name="edit_type_id">
                                <input id="edit-type-name" class="form-control" type="text" name="edit_type_name" placeholder="Project Type Name">
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
        <div class="modal fade bd-example-modal-lg delete-type-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <span><strong>Delete Project Type</strong></span>
                    </div>
                    <div class="modal-body">
                        <form class="form-container" onsubmit="return deleteType()">
                            <div class="form-group">
                                <input id="delete-type-id" type="hidden" name="delete_type_id">
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
<script src="../../assets/js/project_type.js"></script>

</html>