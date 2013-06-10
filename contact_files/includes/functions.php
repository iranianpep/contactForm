<?php

    function required_field_check($field) {
        $field_errors = array();
        if (!isset($_POST[$field]) || (empty($_POST[$field]) && $_POST[$field] != 0) || $_POST[$field] == "") {
            $field_errors[] = $field;
        }
        return $field_errors;
    }

?>