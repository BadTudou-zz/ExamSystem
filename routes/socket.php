<?php

/*
 *  Routes for WebSocket
 *
 * Add route (Symfony Routing Component)
 * 
 */

$socket->route('/', new App\Http\Sockets\WebSocket, ['*']);
