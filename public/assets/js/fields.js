const addField = () => {

    var field_name = $('#field-name').val();

    $.ajax({
        type : 'POST',
        url : '../../views/php/addField.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'field_name':field_name},
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
                notifyUser( `fa fa-check`, `Research field added successfully.`, `success` );
                $('.field-name').val('');
                $('#modal').hide();
                $('#modal-backdrop').hide();

                getAllFields();
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

const getAllFields = () => {

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
                    <tr>
                        <td>${response.data[i].name}</td>
                        <td><button type="button" class="btn" data-toggle="modal" data-target=".edit-field-modal" onclick="getFieldById(${response.data[i].id})"><i class="fa fa-edit"></button></i><button class="btn" data-toggle="modal" data-target=".delete-field-modal" onclick="getId(${response.data[i].id})"><i class="fa fa-trash"></button></i></td>    
                    </tr>
                `;
            }
            $('#field-data').html(html);
        }
    });

}

const getFieldById = (id) => {
    $.ajax({
        type : 'POST',
        url : '../../views/php/getFieldById.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'field_id':id},
        success : function(response) {
            var fieldNameVal = '';
            var fieldIdVal = '';
            for(i=0; i<response.data.length; i++){
                fieldNameVal = `${response.data[i].name}`;
                fieldIdVal = `${response.data[i].id}`;
            }
            $('#edit-field-id').val(fieldIdVal);
            $('#edit-field-name').val(fieldNameVal);
        }
    });
}

const getId = (id) => {

    $('#delete-field-id').val(id);
    console.log($('#delete-field-id').val());

}

const updateField = () => {
    var field_id = $('#edit-field-id').val();
    var field_name = $('#edit-field-name').val();

    $.ajax({
        type : 'POST',
        url : '../../views/php/updateField.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'edit_field_id':field_id, 'edit_field_name':field_name},
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
                $('#edit-field-id').val('');
                $('.edit-field-name').val('');
                $('.modal').hide();
                $('.modal-backdrop').hide();
                getAllFields();
            }
        }
    });

    return false;

}

const deleteField = () => {
    var field_id = $('#delete-field-id').val();
    console.log(field_id);

    $.ajax({
        type : 'POST',
        url : '../../views/php/deleteField.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'delete_field_id':field_id},
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
                $('#modal').hide();
                $('#modal-backdrop').hide();
                
                getAllFields();
            }
        }
    });

    return false;

}

jQuery(document).ready(function($){
    getAllFields();

    $('#search-field').on('keyup', function(){
        var query = $('#search-field').val();

        $.ajax({
            type : 'POST',
            url : '../../views/php/searchField.php',
            async : true,
            crossDomain : true,
            dataType : 'JSON',
            data : {'search_field':query},
            success : function(response) {
                var html = '';

                if(response.data.length == 0){
                    
                    $('#field-data').html("No results found.");

                } else {

                    for(i=0; i<response.data.length; i++){
                        html += `
                            <tr>
                                <td>${response.data[i].name}</td>
                                <td><button type="button" class="btn" data-toggle="modal" data-target=".edit-sector-modal" data-toggle="tooltip" title="Edit Field" onclick="getSectorById(${response.data[i].sector_id})"><i class="fa fa-edit"></button></i><button class="btn" data-toggle="modal" data-target=".delete-sector-modal" data-toggle="tooltip" title="Delete Field" onclick="getId(${response.data[i].sector_id})"><i class="fa fa-trash"></button></i></td>    
                            </tr>
                        `;
                    }
                    $('#field-data').html(html);
                }
            }
        })
    });
});