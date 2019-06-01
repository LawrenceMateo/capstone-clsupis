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
                    Researchers
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
                                <input id="search-researcher" class="form-control" type="text" name="search_researcher" placeholder="Search">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>                
        <div class="row">
            <div class="container-fluid">
                <div class="col-11 offset-1">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Project Name</th>
                                <th>Researcher Name</th>
                                <th>Researcher Role</th>
                                <th>Gender</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="researcher-data">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        
        <!-- EDIT RESEARCHER MODAL -->
        <div id="mod" class="modal fade bd-example-modal-lg edit-researcher-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <span>Edit Researcher</span>
                    </div>
                    <div class="modal-body">
                        <form class="form-container" onsubmit="return updateResearcher()">                                                        
                            <div class="form-group">
                                <label class="label" for="edit-researcher-name">
                                    <span><strong>Researcher Name</strong></span>
                                </label>
                                <input id="edit-researcher-id" type="hidden" name="project_id">
                                <input id="edit-researcher-name" class="form-control" type="text" name="researcher_name" placeholder="Researcher Name"> 
                            </div>
                            <div class="form-group">
                                <div class="row">                                    
                                    <div class="col-6">
                                        <label class="label">
                                            <span><strong>Researcher Role</strong></span>
                                        </label>
                                        <div class="row"></div>
                                            <input id="edit-h-type" type="hidden" name="h_type">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input id="edit-proj-leader" class="custom-control-input" type="radio" name="member_type" value="leader">
                                            <label class="custom-control-label" for="edit-proj-leader">Leader</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input id="edit-proj-member" class="custom-control-input" type="radio" name="member_type" value="member">
                                            <label class="custom-control-label" for="edit-proj-member">Member</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="label">
                                            <span><strong>Gender</strong></span>
                                        </label>
                                        <div class="row"></div>
                                        <input id="edit-h-gen" type="hidden" name="h_gen">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input id="edit-male" class="custom-control-input" type="radio" name="gender" value="Male">
                                            <label class="custom-control-label" for="edit-male">Male</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input id="edit-female" class="custom-control-input" type="radio" name="gender" value="Female">
                                            <label class="custom-control-label" for="edit-female">Female</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="label" for="bachelors-degree">
                                            <span><strong>Bachelor's Degree</strong></span>
                                        </label>
                                        <input id="edit-bachelors-degree" class="form-control" type="text" name="bachelors_degree" placeholder="Bachelor's Degee">
                                    </div>
                                    <div class="col-6">
                                        <label class="label" for="bachelors-grad">
                                            <span><strong>Graduated At</strong></span>
                                        </label>
                                        <input id="edit-bachelors-grad" class="form-control" type="text" name="bachelors_grad" placeholder="Graduated At">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="label" for=""masters-degree">
                                            <span><strong>Master's Degree</strong></span>
                                        </label>
                                        <input id="edit-masters-degree" class="form-control" type="text" name="masters_degree" placeholder="Master's Degree">
                                    </div>
                                    <div class="col-6">
                                        <label class="label" for="masters-grad">
                                            <span><strong>Graduated At</strong></span>
                                        </label>
                                        <input id="edit-masters-grad" class="form-control" type="text" name="masters_grad" placeholder="Graduated At">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="label" for="doctorate">
                                            <span><strong>PhD</strong></span>
                                        </label>
                                        <input id="edit-doctorate" class="form-control" type="text" name="doctorate" placeholder="Doctorate">
                                    </div>
                                    <div class="col-6">
                                        <label class="label" for="doctorate-grad">
                                            <span><strong>Graduated At</strong></span>
                                        </label>
                                        <input id="edit-doctorate-grad" class="form-control" type="text" name="doctorate_grad" placeholder="Graduated At">
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

        <!-- VIEW RESEARCHER MODAL -->
        <div class="modal fade bd-example-modal-lg view-researcher-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <span><strong>View Researcher</strong></span>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>Project Name</th>
                                    <td id="view-project"></td>
                                </tr>
                                <tr>
                                    <th>Researcher Name</th>
                                    <td id="view-name"></td>
                                </tr>
                                <tr>
                                    <th>Researcher Role</th>
                                    <td id="view-role"></td>
                                </tr>
                                <tr>
                                    <th>Gender</th>
                                    <td id="view-gender"></td>
                                </tr>
                                <tr>
                                    <th>Bachelor's Degree</th>
                                    <td id="view-bachelors-degree"></td>
                                </tr>
                                <tr>
                                    <th>Master's Degree</th>
                                    <td id="view-masters-degree"></td>
                                </tr>
                                <tr>
                                    <th>Phd</th>
                                    <td id="view-phd"></td>
                                </tr>
                                <tr>
                                    <th>Bachelor's Degree</th>
                                    <td id="view-bachelors-grad"></td>
                                </tr>
                                <tr>
                                    <th>Master's Degree</th>
                                    <td id="view-masters-grad"></td>
                                </tr>
                                <tr>
                                    <th>Phd</th>
                                    <td id="view-phd-grad"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> 

        <!-- DELETE RESEARCHER MODAL -->
        <div class="modal fade bd-example-modal-lg delete-researcher-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <span><strong>Delete Researcher</strong></span>
                    </div>
                    <div class="modal-body">
                        <form class="form-container" onsubmit="return deleteResearcher()">
                            <div class="form-group">
                                <input id="delete-researcher-id" type="hidden" name="delete_researcher_id">
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
<script src="../../assets/js/researcher.js"></script>

</html>