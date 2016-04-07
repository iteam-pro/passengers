<?php
/**
* Licensed under The MIT License
* For full copyright and license information, please see the LICENSE.txt
* Redistributions of files must retain the above copyright notice.
*
* @copyright     Copyright (c) Mindforce Team (http://mindforce.me)
* @link          http://mindforce.me Platform CakePHP 3 Plugin
* @since         0.0.1
* @license       http://www.opensource.org/licenses/mit-license.php MIT License
*/

$config = [
    [
        'path' => 'App.allow_user_registration',
        'title' => 'User registration enabled',
        'default' => '1',
        'options' => [
            "type" => "radio",
            "options" => [
                "1" => "Yes",
                "0" => "No"
            ]
        ],
    ],
];
