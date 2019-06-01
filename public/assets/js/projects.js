const addProject = () => {

    var projectTitle = $('#project-title').val();
    var sectorId = $('#select-sector').val();
    var dateAdded = $('#date-added').val();
    var typeId = $('#select-type').val();
    var fieldId = $('#select-field').val();
    var dateStarted = $('#date-started').val();
    var dateEnded = $('#date-ended').val();
    var commodities = $('#commodities').val();
    var description = $('#description').val();
    var agencyId = $('#select-agency').val();
    var funding = $('#funding').val();

    $.ajax({
        type : 'POST',
        url : '../../views/php/addProjects.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'project_title':toTitleCase(projectTitle), 'sector_id':sectorId, 'date_added':dateAdded, 'type_id':typeId, 'field_id':fieldId, 'date_started':dateStarted, 'date_ended':dateEnded, 'commodities':toTitleCase(commodities), 'description':toTitleCase(description), 'agency_id':agencyId, 'funding':funding},
        success : function(response){

            if(response.error === true){
                if( Array.isArray( (response.data.message) ) ) {
                    var messagesHTML = ``;

                    messagesHTML += `<ul>`;
                    (response.data.message).forEach( ( message ) => {
                        messagesHTML += `<li>${message}</li>`;
                    } );
                    messagesHTML += `</ul>`;
                    
                    notifyUser( `fa fa-window-close`, `${messagesHTML}`, `danger` );
                } else {
                    notifyUser( `fa fa-window-close`, `${response.data.message}`, `danger` );
                }
            } else {
                notifyUser( `fa fa-check`, `Project profile added successfully.`, `success` );
                console.log(response);
                $('#project-title').val('');
                $('#select-sector').val('');
                $('#date-added').val('');
                $('#select-type').val('');
                $('#select-field').val('');
                $('#date-started').val('');
                $('#date-ended').val('');
                $('#commodities').val('');
                $('#description').val('');
                $('#select-agency').val('');
                $('#funding').val('');
                $('#modal').hide();

                getAllProjects();
            }
        },
        fail : function(response){
            var response = JSON.parse( response );

            if( response.error ) {
                notifyUser( `fa fa-window-close`, `${response.data.message}`, `danger` );
            } else {
                notifyUser( `fa fa-window-close`, `Something went wrong. Please try again later.`, `danger` );
            }
        }
    });

    return false;

}

const getAllProjects = () => {

    $.ajax({
        type : 'GET',
        url : '../../views/php/getProjects.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        success : function(response) {
            var html = '';
            var sDate = '';
            var eDate = '';
            var startDate = '';
            var endDate = '';
            var duration = '';
            var editButton = '';
            var addButton = '';
            var viewButton = '';
            var pubButton = '';
            var awardButton = '';

            for(i=0; i<response.data.length; i++){

                sDate = new Date(response.data[i].date_started);
                eDate = new Date(response.data[i].date_ended);
                startDate = sDate.getFullYear();
                endDate = eDate.getFullYear();
                duration = startDate+"-"+endDate;

                editButton = `<button type="button" class="btn" data-toggle="modal" data-toggle="tooltip" title="Update Project" data-target=".edit-project-modal" onclick="getProjectById(${response.data[i].project_id})"><i class="fa fa-edit"></i></button>`;

                addButton = `<button type="button" class="btn" data-toggle="modal" data-toggle="tooltip" title="Add Researchers to this project" data-target=".add-researcher-modal" onclick="getProjectById(${response.data[i].project_id})"><i class="fa fa-users"></i></button>`;

                viewButton = `<button type="button" class="btn" data-toggle="modal" data-toggle="tooltip" title="View project profile" data-target=".profile-modal" onclick="getProjectById(${response.data[i].project_id})"><i class="fa fa-eye"></i></button>`;

                pubButton = `<button type="button" class="btn" data-toggle="modal" data-toggle="tooltip" title="Add publication" data-target=".publication-modal" onclick="getId(${response.data[i].project_id}, '${response.data[i].title}')"><i class="fa fa-book"></i></button>`;

                awardButton = `<button type="button" class="btn" data-toggle="modal" data-toggle="tooltip" title="Add award" data-target=".award-modal" onclick="getProjectById(${response.data[i].project_id})"><i class="fa fa-star"></i></button>`;

                html += `
                    <tr>
                        <td>${response.data[i].title}</td>
                        <td>${response.data[i].sectorName}</td>
                        <td>${response.data[i].fieldName}</td>
                        <td>${response.data[i].date_started}</td>
                        <td>${duration}</td>
                        <td>${editButton}${viewButton}${pubButton}${awardButton}</td>    
                    </tr>
                `;
            }
            $('#project-data').html(html);
        }
    });

}

const getProjectById = (id) => {

    // var projectId = '';
    // var projectTitleVal = '';
    // var fieldIdVal = '';
    // var sectorIdVal = '';
    // var typeIdVal = '';
    // var fieldNameVal = '';
    // var sectorNameVal = '';
    // var typeNameVal = '';
    // var dateAddedVal = '';
    // var dateStartedVal = '';
    // var dateEndedVal = '';
    // var commoditiesVal = '';
    // var descriptionVal = '';
    var fNameVal = '';
    var lNameVal = '';
    // var fullNameVal = '';
    // var idNmberVal = '';
    // var agencyIdVal = '';
    // var agencyNameVal = '';
    // var fundingVal = '';
    // var sectorOpt = '';
    // var fieldOpt = '';
    // var typeOpt = '';
    // var agencyOpt = '';

    $.ajax({
        type : 'POST',
        url : '../../views/php/getProjectById.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'project_id':id},
        success : function(response) {

            for(i=0; i<response.data.length; i++){
                var projectId = `${response.data[i].project_id}`;
                var projectTitleVal = `${response.data[i].title}`;
                var sectorIdVal = `${response.data[i].sector_id}`;
                var fieldIdVal = `${response.data[i].field_id}`;
                var typeIdVal = `${response.data[i].type_id}`;
                var fieldNameVal = `${response.data[i].fieldName}`;
                var sectorNameVal = `${response.data[i].sectorName}`;
                var typeNameVal = `${response.data[i].typeName}`;
                var dateAddedVal = `${response.data[i].date_added}`;
                var dateStartedVal = `${response.data[i].date_started}`;
                var dateEndedVal = `${response.data[i].date_ended}`;
                var commoditiesVal = `${response.data[i].commodities}`;
                var descriptionVal = `${response.data[i].project_description}`;
                var fullNameVal = `${response.data[i].project_leader_name}`;
                var idNmberVal = `${response.data[i].id_number}`;
                var agencyIdVal = `${response.data[i].agency_id}`;
                var agencyNameVal = `${response.data[i].agencyName}`;
                var fundingVal = `${response.data[i].approved_funding}`;
            }

            var temp = fullNameVal.split(' ');
            var max = Math.max(temp.length)-1;
            for(i=0; i<temp.length; i++){
                if(i !== max){
                    fNameVal = fNameVal+temp[i]+" ";
                } else {
                    lNameVal = temp[max];
                }
            }

            sectorOpt = `
                <option value="${sectorIdVal}">${sectorNameVal}</option>
            `;

            fieldOpt = `
                <option value="${fieldIdVal}">${fieldNameVal}</option>
            `;

            typeOpt = `
                <option value="${typeIdVal}">${typeNameVal}</option>
            `;
            
            agencyOpt = `
                <option value="${agencyIdVal}">${agencyNameVal}</option>
            `;

            $('#view-project').html(projectTitleVal);
            $('#view-role').html(projectTitleVal);
            $('#view-gender').html(projectTitleVal);
            $('#view-bachelors-degree').html(projectTitleVal);
            $('#view-bachelors-grad').html(projectTitleVal);
            $('#view-masters-degree').html(projectTitleVal);
            $('#view-masters-grad').html(projectTitleVal);
            $('#view-phd').html(projectTitleVal);
            $('#view-phd-grad').html(projectTitleVal);

            $('#edit-project-id').val(projectId);
            $('#edit-project-title').val(projectTitleVal);
            $('#edit-date-added').val(dateAddedVal);
            $('#edit-date-started').val(dateStartedVal);
            $('#edit-date-ended').val(dateEndedVal);
            $('#edit-commodities').val(commoditiesVal);
            $('#edit-description').val(descriptionVal);
            $('#edit-id-number').val(idNmberVal);
            $('#edit-fname').val(fNameVal);
            $('#edit-lname').val(lNameVal);
            $('#edit-funding').val(fundingVal);
            $('#edit-select-sector').html(sectorOpt);
            $('#edit-select-field').html(fieldOpt);
            $('#edit-select-type').html(typeOpt);
            $('#edit-select-agency').html(agencyOpt);
            $('#award-project-id').val(projectId);
            $('#research-project-id').val(projectId);

        }
    });
}

const getId = (id, title) => {

    $('#publication-project-id').val(id);
    $('#publication-title').val(title);

}

const updateProject = () => {

    var projectId = $('#edit-project-id').val();
    var projectTitleVal = $('#edit-project-title').val();
    var fieldIdVal = $('#edit-select-field').val();
    var sectorIdVal = $('#edit-select-sector').val();
    var typeIdVal = $('#edit-select-type').val();
    var dateAddedVal = $('#edit-date-added').val();
    var dateStartedVal = $('#edit-date-started').val();
    var dateEndedVal = $('#edit-date-ended').val();
    var commoditiesVal = $('#edit-commodities').val();
    var descriptionVal = $('#edit-description').val();
    var agencyIdVal = $('#edit-select-agency').val();
    var fundingVal = $('#edit-funding').val();

    $.ajax({
        type : 'POST',
        url : '../../views/php/updateProject.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'edit_project_id':projectId, 'edit_project_title':toTitleCase(projectTitleVal), 'edit_sector_id':sectorIdVal, 'edit_field_id':fieldIdVal, 'edit_type_id':typeIdVal, 'edit_date_added':dateAddedVal, 'edit_date_started':dateStartedVal, 'edit_date_ended':dateEndedVal, 'edit_commodities':commoditiesVal, 'edit_description':descriptionVal, 'edit_agency_id':agencyIdVal, 'edit_funding':fundingVal},
        success : function(response) {

            if(response.error === true){
                if( Array.isArray( (response.data.message) ) ) {
                    var messagesHTML = ``;
                    
            
            console.log(response);
                    messagesHTML += `<ul>`;
                    (response.data.message).forEach( ( message ) => {
                        messagesHTML += `<li>${message}</li>`;
                    } );
                    messagesHTML += `</ul>`;
                    
                    notifyUser( `fa fa-window-close`, `${messagesHTML}`, `danger` );
                } else {
                    notifyUser( `fa fa-window-close`, `${response.data.message}`, `danger` );
                }

            } else {
                notifyUser( `fa fa-check`, `Record updated successfully.`, `success` );
                $('#edit-project-id').val('');
                $('#edit-project-title').val('');
                $('#edit-select-field').val('');
                $('#edit-select-sector').val('');
                $('#edit-select-type').val('');
                $('#edit-date-added').val('');
                $('#edit-date-started').val('');
                $('#edit-date-ended').val('');
                $('#edit-commodites').val('');
                $('#edit-description').val('');
                $('#edit-fname').val('');
                $('#edit-lname').val('');
                $('#edit-id-number').val('');
                $('#edit-select-agency').val('');
                $('#edit-funding').val('');
                $('.modal').hide();
                $('.modal-backdrop').hide();
                getAllProjects();
            }

        }, fail : function(response){

            if( response.error ) {
                notifyUser( `fa fa-window-close`, `${response.data.message}`, `danger` );
            } else {
                notifyUser( `fa fa-window-close`, `Something went wrong. Please try again later.`, `danger` );
            }
        }
    });

    return false;

}

const viewProfile = (id) => {

}

jQuery(document).ready(function($){
    getAllProjects();
    

    $('#search-project').on('keyup', function(){
        var query = $('#search-project').val();
        if( query.length === 0 ){
            getAllProjects();
        }
        $.ajax({
            type : 'POST',
            url : '../../views/php/searchProject.php',
            async : true,
            crossDomain : true,
            dataType : 'JSON',
            data : {'search_project':query},
            success : function(response) {
                var html = '';
                var editButton = '';
                var addButton = '';
                var viewButton = '';
                var awardButton = '';

                if(response.data.length == 0){
                    
                    $('#project-data').html("No results found.");

                } else {

                    for(i=0; i<response.data.length; i++){
                        sDate = new Date(response.data[i].date_started);
                        eDate = new Date(response.data[i].date_ended);
                        startDate = sDate.getFullYear();
                        endDate = eDate.getFullYear();
                        duration = endDate - startDate;

                        editButton = `<button type="button" class="btn" data-toggle="modal" data-toggle="tooltip" title="Update Project" data-target=".edit-project-modal" onclick="getProjectById(${response.data[i].project_id})"><i class="fa fa-edit"></i></button>`;

                        addButton = `<button type="button" class="btn" data-toggle="modal" data-toggle="tooltip" title="Add Researchers to this project" data-target=".edit-project-modal" onclick="getProjectById(${response.data[i].project_id})"><i class="fa fa-users"></i></button>`;

                        viewButton = `<button type="button" class="btn" data-toggle="modal" data-toggle="tooltip" title="View project profile" data-target=".profile-modal" onclick="getProjectById(${response.data[i].project_id})"><i class="fa fa-eye"></i></button>`;

                        pubButton = `<button type="button" class="btn" data-toggle="modal" data-toggle="tooltip" title="Add publication" data-target=".publication-modal" onclick="getId(${response.data[i].project_id}, '${response.data[i].title}')"><i class="fa fa-book"></i></button>`;

                        awardButton = `<button type="button" class="btn" data-toggle="modal" data-toggle="tooltip" title="Add award" data-target=".award-modal" onclick="getProjectById(${response.data[i].project_id})"><i class="fa fa-star"></i></button>`;

                        html += `
                            <tr>
                                <td>${response.data[i].title}</td>
                                <td>${response.data[i].sectorName}</td>
                                <td>${response.data[i].fieldName}</td>
                                <td>${response.data[i].date_started}</td>
                                <td>${duration}</td>
                                <td>${editButton}${viewButton}${pubButton}${awardButton}</td>    
                            </tr>
                        `;
                    }
                    $('#project-data').html(html);
                }
            }
        })
    });


    $('#select-sector').on('focus', () =>{
        $.ajax({
            type : 'GET',
            url : '../../views/php/getSector.php',
            async : true,
            crossDomain : true,
            dataType : 'JSON',
            success : function(response) {
                var html = '';

                for(i=0; i<response.data.length; i++){
                    html += `
                        <option value="${response.data[i].sector_id}">${response.data[i].sector_name}</option>
                    `;        
                }
                $('#select-sector').html(html);
            }
        });
    });

    $('#select-type').on('focus', () =>{
        $.ajax({
            type : 'GET',
            url : '../../views/php/getTypes.php',
            async : true,
            crossDomain : true,
            dataType : 'JSON',
            success : function(response) {
                var html = '';

                for(i=0; i<response.data.length; i++){
                    html += `
                        <option value="${response.data[i].type_id}">${response.data[i].type_name}</option>
                    `;        
                }
                $('#select-type').html(html);
            }
        });
    });

    $('#select-field').on('focus', () =>{
        $.ajax({
            type : 'GET',
            url : '../../views/php/getFields.php',
            async : true,
            crossDomain : true,
            dataType : 'JSON',
            success : function(response) {
                var html = '';

                for(i=0; i<response.data.length; i++){
                    html += `
                        <option value="${response.data[i].id}">${response.data[i].name}</option>
                    `;        
                }
                $('#select-field').html(html);
            }
        });
    });

    $('#select-agency').on('focus', () =>{
        $.ajax({
            type : 'GET',
            url : '../../views/php/getAgency.php',
            async : true,
            crossDomain : true,
            dataType : 'JSON',
            success : function(response) {
                var html = '';

                for(i=0; i<response.data.length; i++){
                    html += `
                        <option value="${response.data[i].agency_id}">${response.data[i].agency_name}</option>
                    `;        
                }
                $('#select-agency').html(html);
            }
        });
    });

    $('#edit-select-sector').on('focus', () =>{
        $.ajax({
            type : 'GET',
            url : '../../views/php/getSector.php',
            async : true,
            crossDomain : true,
            dataType : 'JSON',
            success : function(response) {
                var html = '';

                for(i=0; i<response.data.length; i++){
                    html += `
                        <option value="${response.data[i].sector_id}">${response.data[i].sector_name}</option>
                    `;        
                }
                $('#edit-select-sector').html(html);
            }
        });
    });

    $('#edit-select-type').on('focus', () =>{
        $.ajax({
            type : 'GET',
            url : '../../views/php/getTypes.php',
            async : true,
            crossDomain : true,
            dataType : 'JSON',
            success : function(response) {
                var html = '';

                for(i=0; i<response.data.length; i++){
                    html += `
                        <option value="${response.data[i].type_id}">${response.data[i].type_name}</option>
                    `;        
                }
                $('#edit-select-type').html(html);
            }
        });
    });

    $('#edit-select-field').on('focus', () =>{
        $.ajax({
            type : 'GET',
            url : '../../views/php/getFields.php',
            async : true,
            crossDomain : true,
            dataType : 'JSON',
            success : function(response) {
                var html = '';

                for(i=0; i<response.data.length; i++){
                    html += `
                        <option value="${response.data[i].id}">${response.data[i].name}</option>
                    `;        
                }
                $('#edit-select-field').html(html);
            }
        });
    });

    $('#edit-select-agency').on('focus', () =>{
        $.ajax({
            type : 'GET',
            url : '../../views/php/getAgency.php',
            async : true,
            crossDomain : true,
            dataType : 'JSON',
            success : function(response) {
                var html = '';

                for(i=0; i<response.data.length; i++){
                    html += `
                        <option value="${response.data[i].agency_id}">${response.data[i].agency_name}</option>
                    `;        
                }
                $('#edit-select-agency').html(html);
            }
        });
    });

});