const addType = () => {

    var type_name = $('#type-name').val();

    $.ajax({
        type : 'POST',
        url : '../../views/php/addType.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'type_name':type_name},
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
                notifyUser( `fa fa-check`, `Research type added successfully.`, `success` );
                $('#type-name').val('');
                $('#.modal').hide();
                $('#.modal-backdrop').hide();

                getAllTypes();
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

const getAllTypes = () => {

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
                    <tr>
                        <td>${response.data[i].type_name}</td>
                        <td><button type="button" class="btn" data-toggle="modal" data-target=".edit-type-modal" onclick="getTypeById(${response.data[i].type_id})"><i class="fa fa-edit"></button></i><button class="btn" data-toggle="modal" data-target=".delete-type-modal" onclick="getId(${response.data[i].type_id})"><i class="fa fa-trash"></button></i></td>    
                    </tr>
                `;
            }
            $('#type-data').html(html);
        }
    });

}

const getTypeById = (id) => {
    $.ajax({
        type : 'POST',
        url : '../../views/php/getTypeById.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'type_id':id},
        success : function(response) {
            var typeNameVal = '';
            var typeIdVal = '';
            for(i=0; i<response.data.length; i++){
                typeNameVal = `${response.data[i].type_name}`;
                typeIdVal = `${response.data[i].type_id}`;
            }
            $('#edit-type-id').val(typeIdVal);
            $('#edit-type-name').val(typeNameVal);
        }
    });
}

const getId = (id) => {

    $('#delete-type-id').val(id);
    console.log($('#delete-type-id').val());

}

const updateType = () => {
    var type_id = $('#edit-type-id').val();
    var type_name = $('#edit-type-name').val();

    $.ajax({
        type : 'POST',
        url : '../../views/php/updateType.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'edit_type_id':type_id, 'edit_type_name':type_name},
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
                $('#edit-type-id').val('');
                $('#edit-type-name').val('');         
                $('#.modal').hide();
                $('#.modal-backdrop').hide();
                getAllTypes();
            }
        }
    });

    return false;

}

const deleteType = () => {
    var type_id = $('#delete-type-id').val();

    $.ajax({
        type : 'POST',
        url : '../../views/php/deleteType.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'delete_type_id':type_id},
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
                $('.sector-name').val('');     
                $('#.modal').hide();
                $('#.modal-backdrop').hide();
                
                getAllTypes();
            }
        }
    });

    return false;

}

jQuery(document).ready(function($){
    getAllTypes();

    $('#search-type').on('keyup', function(){
        var query = $('#search-type').val();
        if( query.length === 0 ){
            getAllTypes();
        }
        $.ajax({
            type : 'POST',
            url : '../../views/php/searchType.php',
            async : true,
            crossDomain : true,
            dataType : 'JSON',
            data : {'search_type':query},
            success : function(response) {
                var html = '';

                if(response.data.length == 0){
                    
                    $('#type-data').html("No results found.");

                } else {

                    for(i=0; i<response.data.length; i++){
                        html += `
                            <tr>
                                <td>${response.data[i].type_name}</td>
                                <td><button type="button" class="btn" data-toggle="modal" data-target=".edit-sector-modal" onclick="getSectorById(${response.data[i].type_id})"><i class="fa fa-edit"></button></i><button class="btn" data-toggle="modal" data-target=".delete-sector-modal" onclick="getId(${response.data[i].type_id})"><i class="fa fa-trash"></button></i></td>    
                            </tr>
                        `;
                    }
                    $('#type-data').html(html);
                }
            }
        })
    });
});