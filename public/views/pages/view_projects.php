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
                else if( $_SESSION['userType'] == 'admin' )
                    include '../partials/sidebar.php'; 
                else 
                    header('location:view_projects.php');
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
                            <button type="button" class="btn btn-success hide-from-researcher" data-toggle="modal" data-target=".add-project-modal">Add Project</button>                     
                        </div>                    
                        <div class="form-group d-inline-flex w-70 float-right">
                            <form class="form-inline">        
                                <input id="search-project" class="form-control" type="text" name="search_project" placeholder="Search">
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
        
        <!-- EDIT PROJECT MODAL -->
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

        <!-- ADD RESEARCHER MODAL -->
        <div id="mod" class="modal fade bd-example-modal-lg add-researcher-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <span>Add Researcher</span>
                    </div>
                    <div class="modal-body">
                        <form class="form-container" onsubmit="return addResearcher()">                                                        
                            <div class="form-group">
                                <label class="label" for="researcher-name">
                                    <span><strong>Researcher Name</strong></span>
                                </label>
                                <input id="research-project-id" type="hidden" name="project_id">
                                <input id="researcher-name" class="form-control" type="text" name="researcher_name" placeholder="Researcher Name"> 
                            </div>
                            <div class="form-group">
                                <div class="row">                                    
                                    <div class="col-6">
                                        <label class="label">
                                            <span><strong>Researcher Role</strong></span>
                                        </label>
                                        <div class="row"></div>
                                            <input id="h-type" type="hidden" name="h_type">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input id="proj-leader" class="custom-control-input" type="radio" name="member_type" value="leader" checked="true">
                                            <label class="custom-control-label" for="proj-leader">Leader</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input id="proj-member" class="custom-control-input" type="radio" name="member_type" value="member">
                                            <label class="custom-control-label" for="proj-member">Member</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="label">
                                            <span><strong>Gender</strong></span>
                                        </label>
                                        <div class="row"></div>
                                        <input id="h-gen" type="hidden" name="h_gen">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input id="male" class="custom-control-input" type="radio" name="gender" value="Male" checked="true">
                                            <label class="custom-control-label" for="male">Male</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input id="female" class="custom-control-input" type="radio" name="gender" value="Female">
                                            <label class="custom-control-label" for="female">Female</label>
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
                                        <input id="bachelors-degree" class="form-control" type="text" name="bachelors_degree" placeholder="Bachelor's Degee">
                                    </div>
                                    <div class="col-6">
                                        <label class="label" for="bachelors-grad">
                                            <span><strong>Graduated At</strong></span>
                                        </label>
                                        <input id="bachelors-grad" class="form-control" type="text" name="bachelors_grad" placeholder="Graduated At" disabled="true">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="label" for=""masters-degree">
                                            <span><strong>Master's Degree</strong></span>
                                        </label>
                                        <input id="masters-degree" class="form-control" type="text" name="masters_degree" placeholder="Master's Degree (optional)" disabled="true">
                                    </div>
                                    <div class="col-6">
                                        <label class="label" for="masters-grad">
                                            <span><strong>Graduated At</strong></span>
                                        </label>
                                        <input id="masters-grad" class="form-control" type="text" name="masters_grad" placeholder="Graduated At" disabled="true">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="label" for="doctorate">
                                            <span><strong>PhD</strong></span>
                                        </label>
                                        <input id="doctorate" class="form-control" type="text" name="doctorate" placeholder="Doctorate (optional)" disabled="true">
                                    </div>
                                    <div class="col-6">
                                        <label class="label" for="doctorate-grad">
                                            <span><strong>Graduated At</strong></span>
                                        </label>
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

        <!-- VIEW PROJECTS MODAL -->
        <div class="modal fade bd-example-modal-lg profile-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="center"><strong>Project Profile</strong></span>
                    </div>
                    <div class="modal-body">
                    <table class="table table-striped">
                        <tbody id="project-profile">
                        <table class="table">
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
                        </table>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div> 

    </div> <!-- END CONTAINER-FLUID -->
</body>
<?php include '../../includes/scripts.php'; ?>
<script src="../../assets/js/projects.js"></script>
<script src="../../assets/js/publications.js"></script>
<script src="../../assets/js/awards.js"></script>
<script src="../../assets/js/researcher.js"></script>
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

