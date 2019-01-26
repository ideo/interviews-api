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
                        'featured' => $entry->featured->selected,
                        'video' => $entry->video,
                        'thumbnail' => $entry->thumbnail,
                        'person' => $entry->person,
                        'theme' => $entry->theme,
                        'jsonUrl' => UrlHelper::url("interviews/{$entry->slug}.json"),
                    ];
                },
            ];
        }
    ]
];

?>