<?php

include 'roles.php';

function hasPermission($user_role, $required_permission, $staff_id = "") {
    global $roles;

    // check if user has specific permission
    if (isset($roles[$user_role]) && in_array($required_permission, $roles[$user_role])) {
        // check if this project leader is accessing those consultation or project page that is not assigned to them
        if ($_SESSION['admin_position'] == "Project Leader" && !empty($staff_id) && $staff_id != $_SESSION['admin_id'])
            return false;
        else 
            return true;
    }

    return false;
}

function redirect403() {
    header("Location: error_403.php");
}

?>
