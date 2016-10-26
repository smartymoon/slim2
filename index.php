<?php
//common, models autoload defined in composer.json
  require 'vendor/autoload.php';
//create application
  $app = new \Slim\Slim(
      array(
          'templates.path' => './templates',
          'view'           => new \Slim\Views\Twig(),
          'debug'          => true,
      )
  );

//deal view
 $view = $app->view();
 $view->parserExtensions =  array(
     new \Slim\Views\TwigExtension(),
 );
//take a config into function or class ?yes a class
  \lib\Config::init();

 //foreach 加载
  $user = new \models\User();

  foreach(glob('routes/*.php') as $filename)
  {
      require $filename;
  }

  $app->run();
