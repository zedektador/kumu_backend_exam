<?php
return [
    "public-key" => [
        "user" => file_get_contents( storage_path("keys/user.key.pub") )
    ],
    "private-key" => [
        "user" => file_get_contents( storage_path( "keys/user.key" ) )
    ],
    "message-403" => "Access Forbidden",
    "message-419" => "Token expired",
];
