<?php
include 'config.php';

use Utils\InlinePage;

spl_autoload_register();

$fields = InlinePage::getFields('test', 'inline_page');

echo '<pre>';
print_r($fields);
echo '</pre>';


