
    const toTitleCase = (phrase) => {
        return phrase
            .toLowerCase()
            .split(' ')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
            .join(' ');
        };

    const empty = (this_val, error) => {
        var error_id = '#'+error;
        if( this_val == "" ) {
            $(error_id).show();
        } else {
            $(error_id).hide();
        }
    }

    const notifyUser = ( icon, message, type ) => {
        $.notify( {
            icon: icon,
            message: message
        }, {
            type: type
        } );
    };
