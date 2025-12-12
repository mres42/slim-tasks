<?php

use App\Module\V1\Routes\Routes as V1Routes;

return function ($app) {
    V1Routes::routes($app);
};
