const addSector = () => {

    var sector_name = $('#sector-name').val();

    $.ajax({
        type : 'POST',
        url : '../../views/php/addSector.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'sector_name':sector_name},
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
                notifyUser( `fa fa-check`, `Sector added successfully.`, `success` );
                $('#sector-name').val('');
                $('.modal').hide();
                $('.modal-backdrop').hide();

                getAllSectors();
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

const getAllSectors = () => {

    $.ajax({
        type : 'GET',
        url : '../../views/php/getSector.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        success : function(response) {
            var html = '';
            var btnEdit = '';
            var btnDel = '';

            for(i=0; i<response.data.length; i++){
                btnEdit = `<button type="button" class="btn" data-toggle="modal" data-target=".edit-sector-modal" data-toggle="tooltip" title="Edit Sector" onclick="getSectorById(${response.data[i].sector_id})"><i class="fa fa-edit"></i></button>`;
                btnDel = `<button class="btn" data-toggle="modal" data-target=".delete-sector-modal" data-toggle="tooltip" title="Delete Sector" onclick="getId(${response.data[i].sector_id})"><i class="fa fa-trash"></i></button>`;
                html += `
                    <tr>
                        <td>${response.data[i].sector_name}</td>
                        <td>${btnEdit}${btnDel}</td>    
                    </tr>
                `;
            }
            $('#sector-data').html(html);
        }
    });

}

const getSectorById = (id) => {
    $.ajax({
        type : 'POST',
        url : '../../views/php/getSectorById.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'sector_id':id},
        success : function(response) {
            var sectorNameVal = '';
            var sectorIdVal = '';
            for(i=0; i<response.data.length; i++){
                sectorNameVal = `${response.data[i].sector_name}`;
                sectorIdVal = `${response.data[i].sector_id}`;
            }
            $('#edit-sector-id').val(sectorIdVal);
            $('#edit-sector-name').val(sectorNameVal);
        }
    });
}

const getId = (id) => {

    $('#delete-sector-id').val(id);
    console.log($('#delete-sector-id').val());

}

const updateSector = () => {
    var sector_id = $('#edit-sector-id').val();
    var sector_name = $('#edit-sector-name').val();

    $.ajax({
        type : 'POST',
        url : '../../views/php/updateSector.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'edit_sector_id':sector_id, 'edit_sector_name':sector_name},
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
                notifyUser( `fa fa-check`, `Sector updated successfully.`, `success` );
                $('.sector-name').val('');
                $('.modal').hide();
                $('.modal-backdrop').hide();
                
                getAllSectors();
            }
        }
    });

    return false;

}

const deleteSector = () => {
    var sector_id = $('#delete-sector-id').val();
    console.log(sector_id);

    $.ajax({
        type : 'POST',
        url : '../../views/php/deleteSector.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'delete_sector_id':sector_id},
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
                $('#modal').hide();
                
                getAllSectors();
            }
        }
    });

    return false;

}

jQuery(document).ready(function($){
    getAllSectors();

    $('#search-sector').on('keyup', function(){
        var query = $('#search-sector').val();
        if( query.length === 0 ){
            getAllSectors();
        }
        $.ajax({
            type : 'POST',
            url : '../../views/php/searchSector.php',
            async : true,
            crossDomain : true,
            dataType : 'JSON',
            data : {'search_sector':query},
            success : function(response) {
                var html = '';

                if(response.data.length == 0){
                    
                    $('#sector-data').html("No results found.");

                } else {

                    for(i=0; i<response.data.length; i++){
                        html += `
                            <tr>
                                <td>${response.data[i].sector_name}</td>
                                <td><button type="button" class="btn" data-toggle="modal" data-target=".edit-sector-modal" onclick="getSectorById(${response.data[i].sector_id})"><i class="fa fa-edit"></button></i><button class="btn" data-toggle="modal" data-target=".delete-sector-modal" onclick="getId(${response.data[i].sector_id})"><i class="fa fa-trash"></button></i></td>    
                            </tr>
                        `;
                    }
                    $('#sector-data').html(html);
                }
            }
        })
    });
});