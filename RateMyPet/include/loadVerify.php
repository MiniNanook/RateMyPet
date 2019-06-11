<?php

// This script loads a list of Pets / Posts that need to be verified

require_once __DIR__.'/config.php';
require_once __DIR__.'/Usuario.php';

$pets = Pet::getNotVerified(); // Return a list with all the users that need to be verified
$posts = Post::getPending(); // Return a list with all the users that need to be verified

?>