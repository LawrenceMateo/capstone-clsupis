const addAgency = () => {

    var agency_name = $('#agency-name').val();
    var agency_address = $('#agency-address').val();

    $.ajax({
        type : 'POST',
        url : '../../views/php/addAgency.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'agency_name':agency_name, 'agency_address':agency_address},
        success : function(response){

            if(response.error == true){
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
                notifyUser( `fa fa-check`, `Funding Agency added successfully.`, `success` );
                $('#agency-name').val('');
                $('#agency-address').val('');
                $('.modal').hide();
                $('.modal-backdrop').hide();

                getAllAgencies();
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

const getAllAgencies = () => {

    $.ajax({
        type : 'GET',
        url : '../../views/php/getAgency.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        success : function(response) {
            var html = '';
            var editBtn = '';
            var delBtn = '';

            for(i=0; i<response.data.length; i++){
                editBtn = `<button type="button" class="btn" data-toggle="modal" data-target=".edit-agency-modal" onclick="getAgencyById(${response.data[i].agency_id})"><i class="fa fa-edit"></i></button>`;
                delBtn = `<button class="btn" data-toggle="modal" data-target=".delete-agency-modal" onclick="getId(${response.data[i].agency_id})"><i class="fa fa-trash"></i></button>`;

                html += `
                    <tr>
                        <td>${response.data[i].agency_name}</td>
                        <td>${response.data[i].address}</td>
                        <td>${editBtn}${delBtn}</td>    
                    </tr>
                `;
            }
            $('#agency-data').html(html);
        }
    });

}

const getAgencyById = (id) => {
    $.ajax({
        type : 'POST',
        url : '../../views/php/getAgencyById.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'agency_id':id},
        success : function(response) {
            var agencyNameVal = '';
            var agencyAddressVal = '';
            var agencyIdVal = '';
            for(i=0; i<response.data.length; i++){
                agencyNameVal = `${response.data[i].agency_name}`;
                agencyAddressVal = `${response.data[i].address}`;
                agencyIdVal = `${response.data[i].agency_id}`;
            }
            $('#edit-agency-id').val(agencyIdVal);
            $('#edit-agency-name').val(agencyNameVal);
            $('#edit-agency-address').val(agencyAddressVal);
        }
    });
}

const getId = (id) => {

    $('#delete-agency-id').val(id);
    console.log($('#delete-agency-id').val());

}

const updateAgency = () => {
    var agency_id = $('#edit-agency-id').val();
    var agency_name = $('#edit-agency-name').val();
    var agency_address = $('#edit-agency-address').val();

    $.ajax({
        type : 'POST',
        url : '../../views/php/updateAgency.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'edit_agency_id':agency_id, 'edit_agency_name':agency_name, 'edit_agency_address':agency_address},
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
                $('#edit-agency-name').val('');
                $('#edit-agency-address').val('');
                $('.modal').hide();
                $('.modal-backdrop').hide();
                
                getAllAgencies();
            }
        }
    });

    return false;

}

const deleteAgency = () => {
    var agency_id = $('#delete-agency-id').val();
    console.log(agency_id);

    $.ajax({
        type : 'POST',
        url : '../../views/php/deleteAgency.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'delete_agency_id':agency_id},
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
                
                getAllAgencies();
            }
        }
    });

    return false;

}

jQuery(document).ready(function($){
    getAllAgencies();

    $('#search-agency').on('keyup', function(){
        var query = $('#search-agency').val();

        $.ajax({
            type : 'POST',
            url : '../../views/php/searchAgency.php',
            async : true,
            crossDomain : true,
            dataType : 'JSON',
            data : {'search_agency':query},
            success : function(response) {
                var html = '';
                var editBtn = '';
                var delBtn = '';

                if(response.data.length == 0){
                    
                    $('#agency-data').html("No results found.");

                } else {

                    for(i=0; i<response.data.length; i++){
                        editBtn = `<button type="button" class="btn" data-toggle="modal" data-target=".edit-agency-modal" onclick="getAgencyById(${response.data[i].agency_id})"><i class="fa fa-edit"></i></button>`;
                        delBtn = `<button class="btn" data-toggle="modal" data-target=".delete-agency-modal" onclick="getId(${response.data[i].agency_id})"><i class="fa fa-trash"></i></button>`;

                        html += `
                            <tr>
                                <td>${response.data[i].agency_name}</td>
                                <td>${response.data[i].address}</td>
                                <td>${editBtn}${delBtn}</td>    
                            </tr>
                        `;
                    }
                    $('#agency-data').html(html);
                }
            }
        })
    });
});