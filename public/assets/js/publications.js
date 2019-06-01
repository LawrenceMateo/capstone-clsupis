const addPublication = () => {

    var projectId = $('#publication-project-id').val();
    var title = $('#publication-title').val();
    var isbn = $('#isbn').val();
    var datePublished = $('#date-published').val();
    var publisher = $('#publisher').val();

    $.ajax({
        type : 'POST',
        url : '../../views/php/addPublication.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'publication_project_id':projectId, 'publication_title':title, 'isbn':isbn, 'date_published':datePublished, 'publisher':publisher},
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
                notifyUser( `fa fa-check`, `Publication record added successfully.`, `success` );
                $('#publication-project-id').val('');
                $('#publication-title').val('');
                $('#isbn').val('');
                $('#date-published').val('');
                $('#publisher').val('');
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

const getAllPublications = () => {
    $.ajax({
        type : 'GET',
        url : '../../views/php/getPublications.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        success : function(response) {
            var html = '';
            var editBtn = '';

            for(i=0; i<response.data.length; i++){
                editBtn = `<button type="button" class="btn" data-toggle="modal" data-target=".edit-publication-modal" data-toggle="tooltip" title="Edit Publication" onclick="getPublicationById(${response.data[i].publish_id})"><i class="fa fa-edit"></i></button>`;
                html += `
                    <tr>
                        <td>${response.data[i].project_title}</td>
                        <td>${response.data[i].ISBN}</td>
                        <td>${response.data[i].date_published}</td>
                        <td>${response.data[i].publisher}</td>
                        <td>${editBtn}</td>    
                    </tr>
                `;
            }
            $('#published-data').html(html);
        }
    });
}

const getPublicationById = (id) => {
    $.ajax({
        type : 'POST',
        url : '../../views/php/getPublicationById.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'publish_id':id},
        success : function(response) {
            var publisher = '';
            var isbn = '';
            var datePublished = '';
            var pId = '';

            for(i=0; i<response.data.length; i++){
                pId = `${response.data[i].publish_id}`;
                publisher = `${response.data[i].publisher}`;
                isbn = `${response.data[i].ISBN}`;
                datePublished = `${response.data[i].date_published}`;
            }
            $('#edit-publication-id').val(pId);
            $('#edit-publisher').val(publisher);
            $('#edit-isbn').val(isbn);
            $('#edit-date-published').val(datePublished);
        }
    });
}

const updatePublication = () => {
    var publisher = $('#edit-publisher').val();
    var isbn = $('#edit-isbn').val();
    var datePublished = $('#edit-date-published').val();
    var pId = $('#edit-publication-id').val();

    console.log(datePublished);

    $.ajax({
        type : 'POST',
        url : '../../views/php/updatePublication.php',
        async : true,
        crossDomain : true,
        dataType : 'JSON',
        data : {'edit_publication_id':pId, 'edit_isbn':isbn, 'edit_publisher':publisher, 'edit_date_published':datePublished},
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
                $('#publication-project-id').val('');
                $('#publication-title').val('');
                $('#isbn').val('');
                $('#date-published').val('');
                $('#publisher').val('');
                $('.modal').hide();
                $('.modal-backdrop').hide();
                
                getAllPublications();
            }
        }
    });

    return false;

}

jQuery(document).ready(function($){
    getAllPublications();

    $('#search-publication').on('keyup', function(){
        var query = $('#search-publication').val();
        if( query.length === 0 ){
            getAllPublications();
        }
        $.ajax({
            type : 'POST',
            url : '../../views/php/searchPublication.php',
            async : true,
            crossDomain : true,
            dataType : 'JSON',
            data : {'search_publication':query},
            success : function(response) {
                var html = '';
                var editBtn = '';

                if(response.data.length == 0){
                    $('#published-data').html("No results found.");
                } else {

                    for(i=0; i<response.data.length; i++){
                        editBtn = `<button type="button" class="btn" data-toggle="modal" data-target=".edit-publication-modal" data-toggle="tooltip" title="Edit Publication" onclick="getPublicationById(${response.data[i].publish_id})"><i class="fa fa-edit"></i></button>`;

                        html += `
                            <tr>
                                <td>${response.data[i].project_title}</td>
                                <td>${response.data[i].ISBN}</td>
                                <td>${response.data[i].date_published}</td>
                                <td>${response.data[i].publisher}</td>
                                <td>${editBtn}</td>    
                            </tr>
                        `;
                    }
                    $('#published-data').html(html);
                }
            }
        })
    });

});