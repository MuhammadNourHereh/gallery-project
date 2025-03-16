<?php

$apis = [
    // user APIs
    '/users' => ['controller' => 'UserController', 'method' => 'getAllUsers', 'allowed_methods' => ['GET']],
    '/login' => ['controller' => 'UserController', 'method' => 'login', 'allowed_methods' => ['POST']],
    '/signup' => ['controller' => 'UserController', 'method' => 'signup', 'allowed_methods' => ['POST']],
    '/delete-account' => ['controller' => 'UserController', 'method' => 'deleteAccount', 'allowed_methods' => ['DELETE']],
    '/update-account' => ['controller' => 'UserController', 'method' => 'updateAccount', 'allowed_methods' => ['PUT', 'PATCH']],

    // photo APIs
    '/get-photos' => ['controller' => 'PhotoController', 'method' => 'getPhotos', 'allowed_methods' => ['GET', 'POST']],
    '/get-photos-by-tag' => ['controller' => 'PhotoController', 'method' => 'getPhotosByTag', 'allowed_methods' => ['GET']],
    '/get-photo' => ['controller' => 'PhotoController', 'method' => 'getPhoto', 'allowed_methods' => ['GET']],
    '/upload-photo' => ['controller' => 'PhotoController', 'method' => 'uploadPhoto', 'allowed_methods' => ['POST']],
    '/update-photo' => ['controller' => 'PhotoController', 'method' => 'updatePhoto', 'allowed_methods' => ['PUT', 'PATCH']],
    '/delete-photo' => ['controller' => 'PhotoController', 'method' => 'deletePhoto', 'allowed_methods' => ['DELETE']],

    // tag APIs
    '/get-tag' => ['controller' => 'TagController', 'method' => 'getTag', 'allowed_methods' => ['GET']],
    '/get-tags' => ['controller' => 'TagController', 'method' => 'getTags', 'allowed_methods' => ['GET', 'POST']],
    '/create-tag' => ['controller' => 'TagController', 'method' => 'createTag', 'allowed_methods' => ['POST']],
    '/update-tag' => ['controller' => 'TagController', 'method' => 'updateTag', 'allowed_methods' => ['PUT', 'PATCH']],
    '/delete-tag' => ['controller' => 'TagController', 'method' => 'deleteTag', 'allowed_methods' => ['DELETE']],

    // photo-tag APIs
    '/get-attached-tags' => ['controller' => 'PhotoTagController', 'method' => 'getAttachedTags', 'allowed_methods' => ['GET']],
    '/attach-tag' => ['controller' => 'PhotoTagController', 'method' => 'attachTag', 'allowed_methods' => ['POST']],
    '/detach-tag' => ['controller' => 'PhotoTagController', 'method' => 'detachTag', 'allowed_methods' => ['DELETE']],

];