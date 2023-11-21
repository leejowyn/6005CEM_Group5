<?php

$roles = [
        'Admin' => [
            'view_dashboard',
            'view_recent_activities',
            'view_consultation', 'update_consultation', 'delete_consultation', 
            'view_project', 'update_project', 'delete_project', 
            'update_general_settings', 
            'view_portfolio', 'update_portfolio', 
            'view_user', 'update_user'
        ],
        'Project Leader' => [
            'view_dashboard',
            'view_consultation', 'update_consultation', 
            'view_project', 'update_project',
            'view_portfolio', 'update_portfolio', 
        ],
        'Customer Service' => ['livechat'],
        'Normal User' => [],
    ];

?>