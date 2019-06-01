const addResearcher = () => {

    var projectId = $('#research-project-id').val();
    var name = $('#researcher-name').val();
    var role = $('#h-type').val();
    var gender = $('#h-gen').val();
    var bDegree = $('#bachelors-degree').val();
    var bGrad = $('#bachelors-grad').val();
    var mDegree = $('#masters-degree').val();
    var mGrad = $('#masters-grad').val();
    var doctorate = $('#doctorate').val();
    var dGrad = $('#doctorate-grad').val();

    $.ajax({
        type : 'POST',
        url : '../../views/php/addResearcher.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'project_id':projectId, 'name':name, 'role':role, 'gender':gender,'bachelor_degree':bDegree, 'bachelor_grad':bGrad,'master_degree':mDegree, 'master_grad':mGrad, 'doctorate':doctorate, 'doctorate_grad':dGrad},
        success : function(response){

            if(response.error){
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
                notifyUser( `fa fa-check`, `Researcher added successfully.`, `success` );
                $('#sector-name').val('');
                $('.modal').hide();
                $('.modal-backdrop').hide();

                getAllResearchers();
            }
        },
        fail : function(response){

            if( response.error ) {
                notifyUser( `fa fa-window-close`, `${response.data.message}`, `danger` );
            } else {
                notifyUser( `fa fa-window-close`, `Something went wrong. Please try again later.`, `danger` );
            }
        }
    });

    return false;
}

const getAllResearchers = () => {

    $.ajax({
        type : 'GET',
        url : '../../views/php/getResearchers.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        success : function(response) {
            var html = '';
            var editBtn = '';
            var delBtn = '';

            for(i=0; i<response.data.length; i++){
                editBtn = `<button type="button" class="btn" data-toggle="modal" data-target=".edit-researcher-modal" data-toggle="tooltip" title="Edit Researcher" onclick="getResearcherById(${response.data[i].researcher_id})"><i class="fa fa-edit"></i></button>`;
                delBtn = `<button class="btn" data-toggle="modal" data-target=".delete-researcher-modal" data-toggle="tooltip" title="Delete Researcher" onclick="getResearcherById(${response.data[i].researcher_id})"><i class="fa fa-trash"></i></button>`;
                viewBtn = `<button class="btn" data-toggle="modal" data-target=".view-researcher-modal" data-toggle="tooltip" title="View Researcher" onclick="getResearcherById(${response.data[i].researcher_id})"><i class="fa fa-eye"></i></button>`
                html += `
                    <tr>
                        <td>${response.data[i].project}</td>
                        <td>${response.data[i].fullname}</td>
                        <td>${response.data[i].researcher_role}</td>
                        <td>${response.data[i].gender}</td>
                        <td>${editBtn}${viewBtn}${delBtn}</td>    
                    </tr>
                `;
            }
            $('#researcher-data').html(html);
        }
    });

}

const getResearcherById = (id) => {
    
    var researcherId = '';
    var projectId = '';
    var projectName = '';
    var name = '';
    var role = '';
    var gender = '';
    var bDegree = '';
    var bGrad = '';
    var mDegree = '';
    var mGrad = '';
    var doctorate = '';
    var dGrad = '';

    $.ajax({
        type : 'POST',
        url : '../../views/php/getResearcherById.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'id':id},
        success : function(response) {

            for(i=0; i<response.data.length; i++){
                
                researcherId = `${response.data[i].researcher_id}`;
                projectId = `${response.data[i].project_id}`;
                name = `${response.data[i].fullname}`;
                projectName = `${response.data[i].project}`;
                role = `${response.data[i].researcher_role}`;
                gender = `${response.data[i].gender}`;
                bDegree = `${response.data[i].bachelor_degree}`;
                bGrad = `${response.data[i].bachelor_university}`;
                mDegree = `${response.data[i].master_degree}`;
                mGrad = `${response.data[i].master_university}`;
                doctorate = `${response.data[i].doctorate}`;
                dGrad = `${response.data[i].doctorate_university}`;
            }

            $('#edit-researcher-id').val(researcherId);
            $('#edit-researcher-name').val(name);
            $('#edit-h-type').val(role);
            $('#edit-h-gen').val(gender);
            $('#edit-bachelors-degree').val(bDegree);
            $('#edit-bachelors-grad').val(bGrad);
            $('#edit-masters-degree').val(mDegree);
            $('#edit-masters-grad').val(mGrad);
            $('#edit-doctorate').val(doctorate);
            $('#edit-doctorate-grad').val(dGrad);

            $('#view-project').html(projectName);
            $('#view-name').html(name);
            $('#view-role').html(role);
            $('#view-gender').html(gender);
            $('#view-bachelors-degree').html(bDegree);
            $('#view-bachelors-grad').html(bGrad);
            $('#view-masters-degree').html(mDegree);
            $('#view-masters-grad').html(mGrad);
            $('#view-phd').html(doctorate);
            $('#view-phd-grad').html(dGrad);

            $('#delete-researcher-id').val(id);
        
            if(gender === 'Male'){
                $('#edit-male').prop('checked', true);
                $('#edit-h-gen').val('Male');
            } else {
                $('#edit-female').prop('checked', true);
                $('#edit-h-gen').val('Female');
            }

            if(role === 'leader'){
                $('#edit-proj-leader').prop('checked', true);
                $('#edit-h-type').val('leader');
            } else {
                $('#edit-proj-member').prop('checked', true);
                $('#edit-h-type').val('member');
            }
        }
    });
}

const updateResearcher = () => {
    var id = $('#edit-researcher-id').val();
    var role = $('#edit-h-type').val();
    var gender = $('#edit-h-gen').val();
    var name = $('#edit-researcher-name').val();
    var bachelorDegree = $('#edit-bachelors-degree').val();
    var bachelorGrad = $('#edit-bachelors-grad').val();
    var masterDegree = $('#edit-masters-degree').val();
    var masterGrad = $('#edit-masters-grad').val();
    var doctorate = $('#edit-doctorate').val();
    var doctorateGrad = $('#edit-doctorate-grad').val();

    $.ajax({
        type : 'POST',
        url : '../../views/php/updateResearcher.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'researcher_id':id, 'researcher_name':name, 'role':role, 'gender':gender, 'bachelor_degree':bachelorDegree, 'bachelor_grad':bachelorGrad, 'master_degree':masterDegree, 'master_grad':masterGrad, 'doctorate':doctorate, 'doctorate_grad':doctorateGrad},
        success : function(response) {

            if(response.error){
                if( Array.isArray( (response.data.message) ) ) {
                    var messagesHTML = ``;

                    messagesHTML += `<ul>`;
                    (responseData.data.message).forEach( ( message ) => {
                        messagesHTML += `<li>${message}</li>`;
                    } );
                    messagesHTML += `</ul>`;
                    
                    notifyUser( `fa fa-window-close`, `${messagesHTML}`, `danger` );
                } else {
                    notifyUser( `fa fa-window-close`, `${response.data.message}`, `danger` );
                }
            } else {
                notifyUser( `fa fa-check`, `Record updated successfully.`, `success` );
                $('#edit-researcher-id').val('');
                $('#edit-h-gen').val('');
                $('#edit-h-role').val('');
                $('#edit-researcher-name').val('');
                $('#edit-researcher-name').val('');
                $('#edit-bachelor-degree').val('');
                $('#edit-bachelor-grad').val('');
                $('#edit-master-degree').val('');
                $('#edit-master-grad').val('');
                $('#edit-doctorate').val('');
                $('#edit-doctorate-grad').val('');
                $('.modal').hide();
                $('.modal-backdrop').hide();
                
                getAllResearchers();
            }
        }
    });

    return false;

}

const deleteResearcher = () => {
    var researcher_id = $('#delete-researcher-id').val();

    $.ajax({
        type : 'POST',
        url : '../../views/php/deleteResearcher.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'delete_researcher_id':researcher_id},
        success : function(response) {

            if(response.error){
                if( Array.isArray( (response.data.message) ) ) {
                    var messagesHTML = ``;

                    messagesHTML += `<ul>`;
                    (responseData.data.message).forEach( ( message ) => {
                        messagesHTML += `<li>${message}</li>`;
                    } );
                    messagesHTML += `</ul>`;
                    
                    notifyUser( `fa fa-window-close`, `${messagesHTML}`, `danger` );
                } else {
                    notifyUser( `fa fa-window-close`, `${response.data.message}`, `danger` );
                }
            } else {
                notifyUser( `fa fa-check`, `Record deleted successfully.`, `success` );
                $('.modal').hide();
                $('.modal-backdrop').hide();
                
                getAllResearchers();
            }
        }
    });

    return false;
}

jQuery(document).ready(function($){
    getAllResearchers();

    // $('#search-agency').on('keyup', function(){
    //     var query = $('#search-agency').val();

    //     $.ajax({
    //         type : 'POST',
    //         url : '../../views/php/searchAgency.php',
    //         async : true,
    //         crossDomain : true,
    //         dataType : 'JSON',
    //         data : {'search_agency':query},
    //         success : function(response) {
    //             var html = '';
    //             var editBtn = '';
    //             var delBtn = '';

    //             if(response.data.length == 0){
                    
    //                 $('#agency-data').html("No results found.");

    //             } else {

    //                 for(i=0; i<response.data.length; i++){
    //                     editBtn = `<button type="button" class="btn" data-toggle="modal" data-target=".edit-agency-modal" onclick="getAgencyById(${response.data[i].agency_id})"><i class="fa fa-edit"></i></button>`;
    //                     delBtn = `<button class="btn" data-toggle="modal" data-target=".delete-agency-modal" onclick="getId(${response.data[i].agency_id})"><i class="fa fa-trash"></i></button>`;

    //                     html += `
    //                         <tr>
    //                             <td>${response.data[i].agency_name}</td>
    //                             <td>${response.data[i].address}</td>
    //                             <td>${editBtn}${delBtn}</td>    
    //                         </tr>
    //                     `;
    //                 }
    //                 $('#agency-data').html(html);
    //             }
    //         }
    //     })
    // });

    $('#bachelors-degree').on('keyup', function(){
        if($('#bachelors-degree').val().length != 0){
            $("#bachelors-grad").prop('disabled', false);
        } else {
            $("#bachelors-grad").prop('disabled', true);
            $("#bachelors-grad").val('');
        }
    });

    $('#bachelors-grad').on('keyup', function(){
        if($('#bachelors-grad').val().length != 0){
            $("#masters-degree").prop('disabled', false);
        } else {
            $("#masters-degree").prop('disabled', true);
            $("#masters-degree").val('');
        }
    });

    $('#masters-degree').on('keyup', function(){
        if($('#masters-degree').val().length != 0){
            $("#masters-grad").prop('disabled', false);
        } else {
            $("#masters-grad").prop('disabled', true);
            $("#masters-grad").val('');
        }
    });

    $('#masters-grad').on('keyup', function(){
        if($('#masters-grad').val().length != 0){
            $("#doctorate").prop('disabled', false);
        } else {
            $("#doctorate").prop('disabled', true);
            $("#doctorate").val('');
        }
    });

    $('#doctorate').on('keyup', function(){
        if($('#doctorate').val().length != 0){
            $("#doctorate-grad").prop('disabled', false);
        } else {
            $("#doctorate-grad").prop('disabled', true);
            $('#doctorate-grad').val('');
        }
    });

    $('#proj-leader').on('click', function(){
        $('#h-type').val('leader');
    });

    $('#proj-member').on('click', function(){
        $('#h-type').val('member');
    });

    $('#male').on('click', function(){
        $('#h-gen').val('Male');
    });

    $('#female').on('click', function(){
        $('#h-gen').val('Female');
    });

    $('#edit-proj-leader').on('click', function(){
        $('#edit-h-type').val('leader');
    });

    $('#edit-proj-member').on('click', function(){
        $('#edit-h-type').val('member');
    });

    $('#edit-male').on('click', function(){
        $('#edit-h-gen').val('Male');
    });

    $('#edit-female').on('click', function(){
        $('#edit-h-gen').val('Female');
    });

});