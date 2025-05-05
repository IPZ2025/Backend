<?php

namespace App;

use OpenApi\Attributes as OA;

#[OA\OpenApi(
    openapi: "3.1.0",
    info: new OA\Info(
        version: "1.0.0",
        title: "Torgo api",
    ),
    servers: [new OA\Server(url: "http://localhost/api")],
)]
class Documentation {}
