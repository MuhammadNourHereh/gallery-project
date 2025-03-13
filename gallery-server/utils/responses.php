<?php
// Success responses
define("SUCCESS", 200);
define("CREATED", 201);
define("ACCEPTED", 202);
define("NO_CONTENT", 204);

// Client error responses
define("BAD_REQUEST", 400);
define("UNAUTHORIZED", 401);
define("FORBIDDEN", 403);
define("NOT_FOUND", 404);
define("METHOD_NOT_ALLOWED", 405);
define("CONFLICT", 409);
define("UNPROCESSABLE_ENTITY", 422);

// Server error responses
define("INTERNAL_SERVER_ERROR", 500);
define("NOT_IMPLEMENTED", 501);
define("BAD_GATEWAY", 502);
define("SERVICE_UNAVAILABLE", 503);
define("GATEWAY_TIMEOUT", 504);
