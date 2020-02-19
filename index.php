<?php
require_once 'vendor/autoload.php';

$mainRouter = new Router($_GET['uri']);

$mainRouter->addRouteGET('/', 'Movies.index');
$mainRouter->addRouteGET('/movies/show/:id', "Movies.showMovie");

$mainRouter->addRouteGET('/movies/add', "Movies.addMovie");
$mainRouter->addRoutePOST('/movies/add', "Movies.insertNewMovie");

// A list of all the movies with the update option
$mainRouter->addRouteGET('/admin/updatemovies', "Movies.getAllMovies");

// Updating each movie separately
$mainRouter->addRouteGET('/movies/updatemovies/:id', "Movies.getMovie");
$mainRouter->addRoutePOST('/movies/updatemovies/:id', "Movies.updateMovie");

$mainRouter->addRouteGET('/artists', 'Artists.index');

// Administration
$mainRouter->addRouteGET('/admin', 'Admin.index');

try {
    $mainRouter->startRouter();
} catch (RouterException $e) {
}