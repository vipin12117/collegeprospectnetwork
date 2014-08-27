<?php

/*Admin Plugin*/
Router::connect('/admin', array('controller' => 'Login', 'action' => 'login','plugin'=>'Admin'));
Router::connect('/admin/login.php', array('controller' => 'Login', 'action' => 'login','plugin'=>'Admin'));
Router::connect('/admin/forgot-password.php', array('controller' => 'Login', 'action' => 'forgetpassword','plugin'=>'Admin'));
Router::connect('/admin/logout.php', array('controller' => 'Login', 'action' => 'logout','plugin'=>'Admin'));
