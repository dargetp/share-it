<?php
/**
 * This file is the Front Controller
 * HTTP traffic must be redirected to this file
 *
 * @var App $app
 */

use App\Controller\HomeController;
use Slim\App;

// App configuration
require_once __DIR__ . '/../config/bootstrap.php';


// Application routes
$app
    ->map(['GET', 'POST'], '/', [HomeController::class, 'homepage'])
    ->setName('homepage')
;

//On peut indiquer des parametres dans les routes entre accolades: {param}
//On peut indiquer leur format avec des RegEx: \d+ (constitué d'un ou plusieurs chiffres)

//Les paramètres seront envoyés en argument de la méthode du controleur
$app
    ->get('/download/{id:\d+}', [HomeController::class, 'download'])
    ->setName('download')

;



// Start the application
$app->run();