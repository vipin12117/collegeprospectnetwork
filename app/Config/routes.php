<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
Router::connect('/', array('controller' => 'Home', 'action' => 'index'));
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));


Router::connect('/features', array('controller' => 'Home', 'action' => 'features'));
Router::connect('/about-us', array('controller' => 'Home', 'action' => 'aboutus'));
Router::connect('/contact-us', array('controller' => 'Home', 'action' => 'contactus'));
Router::connect('/privacy-policy', array('controller' => 'Home', 'action' => 'privacyPolicy'));
Router::connect('/terms-conditions', array('controller' => 'Home', 'action' => 'termsConditions'));
Router::connect('/refund-policy', array('controller' => 'Home', 'action' => 'refundPolicy'));
Router::connect('/login.php', array('controller' => 'Home', 'action' => 'login'));
Router::connect('/register.php', array('controller' => 'User', 'action' => 'register'));
Router::connect('/logout.php', array('controller' => 'Home', 'action' => 'logout'));

Router::connect('/register-athlete.php', array('controller' => 'User', 'action' => 'registerAthlete'));
Router::connect('/register-hs-coach.php', array('controller' => 'User', 'action' => 'registerHSCoach'));
Router::connect('/register-college-coach.php', array('controller' => 'User', 'action' => 'registerCollegeCoach'));

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';
