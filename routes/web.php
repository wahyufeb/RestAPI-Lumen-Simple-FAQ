<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(["prefix" => "list-faq"], function() use ($router){
  // general routes
  $router->get("/", "FaqController@showAll");
  $router->get("/{id}/find-one", "FaqController@findOne");
  $router->post("/user/save", "FaqController@save");
  // admin routes
  $router->post("/admin/save", "AdminController@save");
  $router->delete("/{id}/delete", "AdminController@delete");
  $router->post("/{id}/answering", "AdminController@answeringQuestion");
});

$router->group(["prefix" => "auth"], function() use ($router){
  $router->post("/login", "AdminController@login");
  $router->post("/registration", "AdminController@registration");
  $router->get("/admin/data", "AdminCOntroller@adminData");
});
