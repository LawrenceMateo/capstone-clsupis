const addAward = () => {

    var projectId = $('#award-project-id').val();
    var name = $('#award-name').val();
    var givenBy = $('#given-by').val();
    var dateAwarded = $('#date-awarded').val();
    var venue = $('#venue').val();

    $.ajax({
        type : 'POST',
        url : '../../views/php/addAward.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'award_project_id':projectId, 'award_name':name, 'venue':venue, 'date_awarded':dateAwarded, 'given_by':givenBy},
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
                notifyUser( `fa fa-check`, `Project award added successfully.`, `success` );
                $('#sector-name').val('');
                $('#modal').hide();

                getAllAwards();
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

const getAllAwards = () => {
    $.ajax({
        type : 'GET',
        url : '../../views/php/getAwards.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        success : function(response) {
            var html = '';
            var editBtn = '';

            for(i=0; i<response.data.length; i++){
                editBtn = `<button type="button" class="btn" data-toggle="modal" data-target=".edit-award-modal" data-toggle="tooltip" title="Update Award" onclick="getAwardById(${response.data[i].award_id})"><i class="fa fa-edit"></i></button>`;
                html += `
                    <tr>
                        <td>${response.data[i].title}</td>
                        <td>${response.data[i].award_title}</td>
                        <td>${response.data[i].given_by}</td>
                        <td>${response.data[i].date_awarded}</td>
                        <td>${editBtn}</td>    
                    </tr>
                `;
            }
            $('#award-data').html(html);
        }
    });
}

const getAwardById = (id) => {
    $.ajax({
        type : 'POST',
        url : '../../views/php/getAwardsById.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'award_id':id},
        success : function(response) {
            var pId = '';
            var name = '';
            var givenBy = '';
            var dateAwarded = '';
            var venue = '';

            for(i=0; i<response.data.length; i++){
                pId = `${response.data[i].award_id}`;;
                name = `${response.data[i].award_title}`;;
                givenBy = `${response.data[i].given_by}`;;
                dateAwarded = `${response.data[i].date_awarded}`;;
                venue = `${response.data[i].venue}`;;
            }
            $('#edit-award-id').val(pId);
            $('#edit-award-name').val(name);
            $('#edit-given-by').val(givenBy);
            $('#edit-date-awarded').val(dateAwarded);
            $('#edit-venue').val(venue);
        }
    });
}

const updateAward = () => {
    var projectId = $('#edit-award-id').val();
    var name = $('#edit-award-name').val();
    var givenBy = $('#edit-given-by').val();
    var dateAwarded = $('#edit-date-awarded').val();
    var venue = $('#edit-venue').val();

    $.ajax({
        type : 'POST',
        url : '../../views/php/updateAward.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'edit_award_id':projectId, 'edit_award_name':name, 'edit_given_by':givenBy, 'edit_date_awarded':dateAwarded, 'edit_venue':venue},
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
                $('#edit-award-id').val('');
                $('#edit-award-name').val('');
                $('#edit-given-by').val('');
                $('#edit-date-awarded').val('');
                $('#edit-venue').val('');
                $('.modal').hide();
                $('.modal-backdrop').hide();
                
                getAllAwards();
            }
        }
    });

    return false;

}

jQuery(document).ready(function($){
    getAllAwards();

    $('#search-award').on('keyup', function(){
        var query = $('#search-award').val();
        if( query.length === 0 ){
            getAllAwards();
        }
        $.ajax({
            type : 'POST',
            url : '../../views/php/searchAwards.php',
            async : true,
            crossDomain : true,
            dataType : 'JSON',
            data : {'search_award':query},
            success : function(response) {
                var html = '';
                var editBtn = '';

                for(i=0; i<response.data.length; i++){
                    editBtn = `<button type="button" class="btn" data-toggle="modal" data-target=".edit-award-modal" data-toggle="tooltip" title="Update Award" onclick="getAwardById(${response.data[i].award_id})"><i class="fa fa-edit"></i></button>`;
                    html += `
                        <tr>
                            <td>${response.data[i].title}</td>
                            <td>${response.data[i].award_title}</td>
                            <td>${response.data[i].given_by}</td>
                            <td>${response.data[i].date_awarded}</td>
                            <td>${editBtn}</td>    
                        </tr>
                    `;
                }
                $('#award-data').html(html);
            }
        });
    });
});