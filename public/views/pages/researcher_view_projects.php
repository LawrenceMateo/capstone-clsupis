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
                else if( $_SESSION['userType'] == 'leader' )
                    include '../partials/sidebar.php'; 
                else   
                    header('location:researcher_view_projects.php');
            ?> 
        </div>
        <div class="row">
            <div class="col-9 offset-1 mt-3">
                <h4> 
                    Projects
                </h4>   
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-10 offset-1">
                <div class="row">
                    <div class="col-lg-12 col-md-8">
                        <div class="d-inline-flex w-30">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target=".add-project-modal">Add Project</button>                     
                        </div>                    
                        <div class="form-group d-inline-flex w-70 float-right">
                            <form class="form-inline">        
                                <input id="search-project" class="form-control" type="text" name="search_project" placeholder="Search">
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
                                <th>Sector</th>
                                <th>Field</th>
                                <th>Date Conducted</th>
                                <th>Duration</th>
                                <th>Project Leader</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="project-data">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ADD MODAL -->
        <div class="modal fade bd-example-modal-lg add-project-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <span>Add Project</span>
                    </div>
                    <div class="modal-body">
                        <form class="form-container" onsubmit="return addProject()">
                            <div class="form-group">
                                <input id="project-title" class="form-control" type="text" name="project_title" placeholder="Project Title">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="select-sector" class="label">
                                            <span><b>Select Research Sector</b></span>
                                        </label>
                                        <select id="select-sector" class="form-control">
                                            <option value="0">Select Sector</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="date-added" class="label">
                                            <span><b>Date Recorded</b></span>
                                        </label>
                                        <input id="date-added" class="form-control" type="date" name="date_added"> 
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="select-type" class="label">
                                            <span><b>Select Project Type</b></span>
                                        </label>
                                        <select id="select-type" class="form-control">
                                            <option value="0">Select Project Type</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="select-field" class="label">
                                            <span><b>Select Field of Research</b></span>
                                        </label>
                                        <select id="select-field" class="form-control">
                                            <option value="0">Select Research Field</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="date-started" class="label">
                                            <span><b>Date Started</b></span>
                                        </label>
                                        <input id="date-started" class="form-control" type="date" name="date_started">
                                    </div>
                                    <div class="col-6">
                                        <label for="date-ended" class="label">
                                            <span><b>Date Ended</b></span>
                                        </label>
                                        <input id="date-ended" class="form-control" type="date" name="date_ended">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="commodities" class="label">
                                            <span><b>Commodities</b></span>
                                        </label>
                                        <input id="commodities" class="form-control" type="text" name="commedities">
                                    </div>
                                    <div class="col-6">
                                        <label for="description" class="label">
                                            <span><b>Description</b></span>
                                        </label>
                                        <textarea id="description" class="form-control" type="date" name="description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <h6>Project Leader</h6>
                                    </div>                                
                                </div>                            
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="fname" class="label">
                                            <span><b>First Name</b></span>
                                        </label>
                                        <input id="fname" class="form-control" type="text" name="fname">
                                    </div>                                                 
                                    <div class="col-6">                                                   
                                        <label for="lname" class="label">
                                            <span><b>Last Name</b></span>
                                        </label>
                                        <input id="lname" class="form-control" type="text" name="lname">
                                    </div>
                                </div>  
                                <div class="row">
                                    <div class="col-6">
                                        <label for="id-number" class="label">
                                            <span><b>ID Number</b></span>
                                        </label>
                                        <input id="id-number" class="form-control" type="text" name="id_number">
                                    </div>
                                    <div class="col-6">
                                        <label for="gender" class="label">
                                            <span><b>Gender</b></span>
                                        </label>
                                        <select id="gender" class="form-control">
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <h6>Funding Agency</h6>
                                    </div>                                
                                </div>                            
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="select-agency" class="label">
                                            <span><b>Agency Name</b></span>
                                        </label>
                                        <select id="select-agency" class="form-control">
                                            <option value="0">Select Agency Name</option>
                                        </select>
                                    </div>                                                 
                                    <div class="col-6">                                                   
                                        <label for="funding" class="label">
                                            <span><b>Approved Funding</b></span>
                                        </label>
                                        <input id="funding" class="form-control" type="text" name="funding"  placeholder="In Php">
                                    </div>
                                </div>  
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div> <!-- END MODAL-BODY -->
                </div>
            </div>
        </div>  
        
        <!-- EDIT MODAL -->
        <div class="modal fade bd-example-modal-lg edit-project-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <span><strong>Update Project</strong></span>
                    </div>
                    <div class="modal-body">
                        <form class="form-container" onsubmit="return updateProject()">
                            <div class="form-group">
                                <input id="edit-project-id" type="hidden" name="edit_project_id">
                                <input id="edit-project-title" class="form-control" type="text" name="edit_project_title" placeholder="Project Title">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="edit-select-sector" class="label">
                                            <span><b>Select Research Sector</b></span>
                                        </label>
                                        <select id="edit-select-sector" class="form-control">
                                            <option value="0">Select Sector</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="edit-date-added" class="label">
                                            <span><b>Date Recorded</b></span>
                                        </label>
                                        <input id="edit-date-added" class="form-control" type="date" name="edit_date_added"> 
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="edit-select-type" class="label">
                                            <span><b>Select Project Type</b></span>
                                        </label>
                                        <select id="edit-select-type" class="form-control">
                                            <option value="0">Select Project Type</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="edit-select-field" class="label">
                                            <span><b>Select Field of Research</b></span>
                                        </label>
                                        <select id="edit-select-field" class="form-control">
                                            <option value="0">Select Research Field</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="edit-date-started" class="label">
                                            <span><b>Date Started</b></span>
                                        </label>
                                        <input id="edit-date-started" class="form-control" type="date" name="edit_date_started">
                                    </div>
                                    <div class="col-6">
                                        <label for="edit-date-ended" class="label">
                                            <span><b>Date Ended</b></span>
                                        </label>
                                        <input id="edit-date-ended" class="form-control" type="date" name="edit_date_ended">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="edit-commodities" class="label">
                                            <span><b>Commodities</b></span>
                                        </label>
                                        <input id="edit-commodities" class="form-control" type="text" name="edit_commodities">
                                    </div>
                                    <div class="col-6">
                                        <label for="edit-description" class="label">
                                            <span><b>Description</b></span>
                                        </label>
                                        <textarea id="edit-description" class="form-control" type="date" name="edit_description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <h6>Project Leader</h6>
                                    </div>                                
                                </div>                            
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="edit-fname" class="label">
                                            <span><b>First Name</b></span>
                                        </label>
                                        <input id="edit-fname" class="form-control" type="text" name="edit_fname">
                                    </div>                                                 
                                    <div class="col-6">                                                   
                                        <label for="edit-lname" class="label">
                                            <span><b>Last Name</b></span>
                                        </label>
                                        <input id="edit-lname" class="form-control" type="text" name="edit_lname">
                                    </div>
                                </div>  
                                <div class="row">
                                    <div class="col-6">
                                        <label for="edit-id-number" class="label">
                                            <span><b>ID Number</b></span>
                                        </label>
                                        <input id="edit-id-number" class="form-control" type="text" name="edit_id_number">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <h6>Funding Agency</h6>
                                    </div>                                
                                </div>                            
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="edit-select-agency" class="label">
                                            <span><b>Agency Name</b></span>
                                        </label>
                                        <select id="edit-select-agency" class="form-control">
                                            <option value="0">Select Agency Name</option>
                                        </select>
                                    </div>                                                 
                                    <div class="col-6">                                                   
                                        <label for="edit-funding" class="label">
                                            <span><b>Approved Funding</b></span>
                                        </label>
                                        <input id="edit-funding" class="form-control" type="text" name="edit_funding" placeholder="In Php">
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

        <!-- ADD PUBLICATION MODAL -->
        <div class="modal fade bd-example-modal-lg publication-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="center"><strong>Add Publication</strong></span>
                    </div>
                    <div class="modal-body">
                        <form class="form-container" onsubmit="return addPublication()">
                            <div class="form-group">                                                                                
                                <label for="publication-title" class="label">
                                    <span><b>Project Title</b></span>
                                </label>
                                <input id="publication-project-id" type="hidden" name="publication_project_id">
                                <input id="publication-title" class="form-control" type="text" name="publication_title" readonly="true">                                
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">                                                 
                                        <label for="isbn" class="label">
                                            <span><b>ISBN</b></span>
                                        </label>
                                        <input id="isbn"class="form-control" type="text" name="isbn" placeholder="eg. xxx-xxxx-xxxx">
                                    </div>
                                    <div class="col-6">                                                 
                                        <label for="date-published" class="label">
                                            <span><b>Date Published</b></span>
                                        </label>
                                        <input id="date-published"class="form-control" name="date_published" type="date">                                        
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">                                                 
                                        <label for="publisher" class="label">
                                            <span><b>Publisher</b></span>
                                        </label>
                                        <input id="publisher"class="form-control" type="text" name="publisher" placeholder="Publisher">
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

        <!-- ADD AWARDS MODAL -->
        <div class="modal fade bd-example-modal-lg award-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="center"><strong>Add Award</strong></span>
                    </div>
                    <div class="modal-body">
                        <form class="form-container" onsubmit="return addAward()">
                            <div class="form-group">                                                                                
                                <label for="award-name" class="label">
                                    <span><b>Award Received</b></span>
                                </label>
                                <input id="award-project-id" type="hidden" name="award_project_id">
                                <input id="award-name" class="form-control" type="text" name="award_name" placeholder="Award received">                                
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">                                                 
                                        <label for="given-by" class="label">
                                            <span><b>Awarded Giving Body</b></span>
                                        </label>
                                        <input id="given-by"class="form-control" type="text" name="given_by" placeholder="Enter award giving body">
                                    </div>
                                    <div class="col-6">                                                 
                                        <label for="date-awarded" class="label">
                                            <span><b>Date Awarded</b></span>
                                        </label>
                                        <input id="date-awarded"class="form-control" name="date_awarded" type="date">                                        
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">                                                 
                                        <label for="venue" class="label">
                                            <span><b>Venue of Awarding</b></span>
                                        </label>
                                        <input id="venue"class="form-control" type="text" name="venue" placeholder="Venue">
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

        <!-- VIEW PROJECTS MODAL -->
        <!-- <div class="modal fade bd-example-modal-lg award-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="center"><strong>Project Profile</strong></span>
                    </div>
                    <div class="modal-body">
                        <form class="form-container" onsubmit="return addAward()">
                            <div class="form-group">                                                                                
                                <label for="award-name" class="label">
                                    <span><b>Award Received</b></span>
                                </label>
                                <input id="award-project-id" type="hidden" name="award_project_id">
                                <input id="award-name" class="form-control" type="text" name="award_name" placeholder="Award received">                                
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">                                                 
                                        <label for="given-by" class="label">
                                            <span><b>Awarded Giving Body</b></span>
                                        </label>
                                        <input id="given-by"class="form-control" type="text" name="given_by" placeholder="Enter award giving body">
                                    </div>
                                    <div class="col-6">                                                 
                                        <label for="date-awarded" class="label">
                                            <span><b>Date Awarded</b></span>
                                        </label>
                                        <input id="date-awarded"class="form-control" name="date_awarded" type="date">                                        
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">                                                 
                                        <label for="venue" class="label">
                                            <span><b>Venue of Awarding</b></span>
                                        </label>
                                        <input id="venue"class="form-control" type="text" name="venue" placeholder="Venue">
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
        </div>  -->

    </div> <!-- END CONTAINER-FLUID -->
</body>
<?php include '../../includes/scripts.php'; ?>
<script src="../../assets/js/projects.js"></script>
<script src="../../assets/js/publications.js"></script>
<script src="../../assets/js/awards.js"></script>

</html>

