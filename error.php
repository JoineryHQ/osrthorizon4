<?php
if ($this->error->getCode() == '404') {
  $osrthorizonErrorContentHtml = file_get_contents(__DIR__ . '/error-body-404.html');
  $osrthorizonErrorBodyClass = 'osrthorizon-error';
  include __DIR__ . '/index.php';
}
else {
  include JPATH_SITE . '/templates/system/error.php';
}