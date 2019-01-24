<?php

use craft\elements\Entry;
use craft\helpers\UrlHelper;

return [
    'endpoints' => [
        'interviews.json' => function() {
            return [
                'elementType' => Entry::class,
                'criteria' => ['section' => 'interviews'],
                'transformer' => function(Entry $entry) {
                    return [
                        'title' => $entry->title,
                        'url' => $entry->url,
                        'jsonUrl' => UrlHelper::url("interviews/{$entry->slug}.json"),
                    ];
                },
            ];
        }
    ]
];

?>