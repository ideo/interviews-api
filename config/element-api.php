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
            }, $entry->theme->find())
          ];
        },
      ];
    },
    'people.json' =>
    function() {
      Craft::$app->getResponse()->getHeaders()->set('Access-Control-Allow-Origin', '*');
      // $criteria = craft()->elements->getCriteria(ElementType::Category);
      // $criteria->group = 'person';

      return [
        'elementType' => Category::class,
        'criteria' => ['group' => 'person']
      ];
    },
    'themes.json' =>
    function() {
      Craft::$app->getResponse()->getHeaders()->set('Access-Control-Allow-Origin', '*');
      // $criteria = craft()->elements->getCriteria(ElementType::Category);
      // $criteria->group = 'theme';
      return [
        'elementType' => Category::class,
        'criteria' => ['group' => 'theme']
      ];
    }
  ]
];

?>
