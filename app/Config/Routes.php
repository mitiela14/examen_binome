<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// === Livres Routes ===
// Accueil - Liste des livres (avec recherche/filtrage)
$routes->get('/', 'BookController::index', ['as' => 'home']);

// Afficher le formulaire d'ajout d'un livre
$routes->get('/livre/creer', 'BookController::create', ['as' => 'book.create']);

// Enregistrer un nouveau livre
$routes->post('/livre', 'BookController::store', ['as' => 'book.store']);

// Afficher la fiche détaillée d'un livre
$routes->get('/livre/(:num)', 'BookController::show/$1', ['as' => 'book.show']);

// Supprimer un livre
$routes->post('/livre/(:num)/supprimer', 'BookController::delete/$1', ['as' => 'book.delete']);

// === Emprunts Routes ===
// Emprunter un livre
$routes->post('/livre/(:num)/emprunter', 'LoanController::borrow/$1', ['as' => 'loan.borrow']);

// Retourner un livre
$routes->post('/livre/(:num)/retourner', 'LoanController::return/$1', ['as' => 'loan.return']);

