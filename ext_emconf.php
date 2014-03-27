<?php

$EM_CONF[$_EXTKEY] = array(
    'title' => 'Eve Online Corp Tool',
    'description' => 'Using different EVE services: direct from CCP through PhealNG or third party sites like eve-central.com',
    'category' => 'plugin',
    'author' => 'Henning Gerhardt',
    'author_company' => '',
    'author_email' => 'henning.gerhardt@web.de',
    'dependencies' => 'extbase,fluid',
    'clearCacheOnLoad' => 1,
    'state' => 'alpha',
    'version' => '0.3.1',
    'constraints' => array(
        'depends' => array(
            'php' => '5.4.0',
            'typo3' => '6.0',
            'extbase' => '6.0',
            'fluid' => '6.0',
        ),
    )
);
