<?php

    function isAlpha( $str ) {
        $pattern = "/^[a-zA-Z ]+$/";
        return isValid( $pattern, $str );
    }

    function isNumeric( $str ) {
        $pattern = "/^[0-9]+$/";
        return isValid( $pattern, $str );
    }
    
    function isIsbn( $str ) {
        $pattern = "/\d{3}-\d{4}-\d{4}/";
        return isValid( $pattern, $str );
    }

    function isIdNumber( $str ) {
        $pattern = "/\d{2}-\d{4}/";
        return isValid( $pattern, $str );
    }

    function isAlphaNumeric( $str ) {
        $pattern = "/^[a-zA-Z0-9]+$/";
        return isValid( $pattern, $str );
    }

    function isEmail( $str ) {
        if( filter_var( $str, FILTER_VALIDATE_EMAIL ) )
            return true;
        else
            return false;
    }

    function isValid( $pattern, $str ) {
        $isValid = false;
        if( preg_match( $pattern, $str ) )
            $isValid = true;
        else
            $isValid = false;

        return $isValid;
    }

?>