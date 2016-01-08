<?php

return [
    // Hello
    ['GET', '/', ['AloPHP\Controllers\HelloController', 'get']],
    ['GET', '/home', ['AloPHP\Controllers\HelloController', 'home']],
    // Todos
    ['GET', '/todos', ['AloPHP\Controllers\TodosController', 'get']],
    ['POST', '/todos', ['AloPHP\Controllers\TodosController', 'post']],
    ['GET', '/todos/{id:\d+}', ['AloPHP\Controllers\TodosController', 'show']],
];
