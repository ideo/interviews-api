<?php

use craft\elements\Entry;
use craft\elements\Category;
use craft\elements\Asset;
use craft\helpers\UrlHelper;

return [
  'endpoints' => [
    'interviews.json' => /**
     * @return array
     */
    function () {
      Craft::$app->getResponse()->getHeaders()->set('Access-Control-Allow-Origin', '*');

      return [
        'elementType' => Entry::class,
        'criteria'    => ['section' => 'interviews'],
        'transformer' => function (Entry $entry) {
          return [
            'title'  => $entry->title,
            'featured' => $entry->featured[0]->selected,
            'person' => array_map(function (Category $category) {
              return [
              'title' => $category->title,
              'age' => $category->age,
              'city' => $category->city,
              'persondescription' => $category->persondescription,
              ];
            }, $entry->person->find()),
            'video' => array_map(function (Asset $asset) {
              return [
              'filename' => $asset->filename,
              ];
            }, $entry->video->find()),
            'thumbnail' => array_map(function (Asset $asset) {
              return [
              'filename' => $asset->filename,
              ];
            }, $entry->thumbnail->find()),
            'theme' => array_map(function (Category $category) {
              return [
              'title' => $category->title,
              'themedescription' => $category->themedescription,
              ];
            }, $entry->theme->find()),
            'jsonUrl' => UrlHelper::url("interviews/{$entry->slug}.json")
          ];
        },
      ];
    }
  ]
];

?>
