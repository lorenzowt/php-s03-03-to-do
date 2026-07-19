<?php 

/**
 * Used to define the routes in the system.
 * 
 * A route should be defined with a key matching the URL and an
 * controller#action-to-call method. E.g.:
 * 
 * '/' => 'index#index',
 * '/calendar' => 'calendar#index'
 */
$routes = array(
	'/test' => 'test#index',
	'/task/new' => 'task#new',
	'/task/create' => 'task#create',
	'/task/list' => 'task#list',
	'/task/show' => 'task#show',
	'/task/update' => 'task#update',
	'/task/delete' => 'task#delete',
	'/task/edit' => 'task#edit',
	'/task/save' => 'task#save',
);