<?php

return [
    'access_controle' => [
        //Users access controle
        ['uri' => '^api/users$', 'method' => ['get', 'head'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/users/{user}$', 'method' => ['get', 'head'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/users/{user}$', 'method' => ['put', 'patch'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/users/{user}$', 'method' => 'delete', 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        //Countries Access Controle
        ['uri' => '^api/countries$', 'method' => ['get', 'head'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/countries$', 'method' => ['post'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/countries$/{country}$', 'method' => ['get', 'head'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/countries$/{country}$', 'method' => ['put', 'patch'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/countries$/{country}$', 'method' => 'delete', 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        //Languages Access Controle
        ['uri' => '^api/languages$', 'method' => ['post'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/languages$/{language}$', 'method' => ['get', 'head'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/languages$/{language}$', 'method' => ['put', 'patch'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/languages$/{language}$', 'method' => 'delete', 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        //States Access Controle
        ['uri' => '^api/states$', 'method' => ['post'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/states$/{state}$', 'method' => ['get', 'head'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/states$/{state}$', 'method' => ['put', 'patch'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/states$/{state}$', 'method' => 'delete', 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        //Regions Access Controle
        ['uri' => '^api/regions$', 'method' => ['post'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/regions$/{region}$', 'method' => ['get', 'head'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/regions$/{region}$', 'method' => ['put', 'patch'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/regions$/{region}$', 'method' => 'delete', 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        //Parkings Access Controle
        ['uri' => '^api/parkings$', 'method' => ['post'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/parkings$/{parking}$', 'method' => ['get', 'head'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/parkings$/{parking}$', 'method' => ['put', 'patch'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/parkings$/{parking}$', 'method' => 'delete', 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        //Car Bodies Access Controle
        ['uri' => '^api/car_bodies$', 'method' => ['post'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/car_bodies$/{car_body}$', 'method' => ['get', 'head'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/car_bodies$/{car_body}$', 'method' => ['put', 'patch'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/car_bodies$/{car_body}$', 'method' => 'delete', 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        //Car Models Access Controle
        ['uri' => '^api/car_models$', 'method' => ['post'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/car_models$/{car_model}$', 'method' => ['get', 'head'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/car_models$/{car_model}$', 'method' => ['put', 'patch'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/car_models$/{car_model}$', 'method' => 'delete', 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        //Car Brand Access Controle
        ['uri' => '^api/car_brands$', 'method' => ['post'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/car_brands$/{car_brand}$', 'method' => ['get', 'head'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/car_brands$/{car_brand}$', 'method' => ['put', 'patch'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/car_brands$/{car_brand}$', 'method' => 'delete', 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        //Cars Access Controle
        ['uri' => '^api/cars$', 'method' => ['post'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/cars$/{car}$', 'method' => ['get', 'head'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/cars$/{car}$', 'method' => ['put', 'patch'], 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        ['uri' => '^api/cars$/{car}$', 'method' => 'delete', 'roles' => ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']],
        
    ]
];
