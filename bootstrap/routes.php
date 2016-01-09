<?php

return [
    // Hello
    ['GET', '/', ['App\Controllers\HelloController', 'get']],
    ['GET', '/home', ['App\Controllers\HelloController', 'home']],
    // Todos
    ['GET', '/todos', ['App\Controllers\TodosController', 'get']],
    ['POST', '/todos', ['App\Controllers\TodosController', 'post']],
    ['GET', '/todos/{id:\d+}', ['App\Controllers\TodosController', 'show']],
];
