<?php

$roles = [
        'Admin' => [
            'view_dashboard',
            'view_recent_activities',
            'update_consultation', 'delete_consultation', 
            'update_project', 'delete_project', 
            'update_general_settings', 
            'create_portfolio', 'view_portfolio', 'update_portfolio', 'delete_portfolio', 
            'create_user', 'view_user', 'update_user', 'delete_user'
        ],
        'Project Leader' => [
            'view_dashboard',
            'update_consultation', 
            'update_project',
            'create_portfolio', 'view_portfolio', 'update_portfolio', 'delete_portfolio', 
        ],
        'Customer Service' => ['livechat'],
        'Normal User' => [],
    ];

?>