<?php
return [
    '/\/rest\/retrieve\/([0-9]+)/' => [Random::class, 'retrieve'],
    '/\/rest\/generate/'           => [Random::class, 'generate']
];