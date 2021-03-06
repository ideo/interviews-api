<?php

use craft\elements\Entry;
use craft\elements\Category;
use craft\elements\Asset;

return [
    'endpoints' => [
        'people.json' =>
            function () {
                Craft::$app->getResponse()->getHeaders()->set('Access-Control-Allow-Origin', '*');

                return [
                    'elementType' => Category::class,
                    'criteria'    => ['group' => 'person'],
                    'transformer' => function (Category $category) {
                        /**
                         * Get the featured video to be able to access to it below.
                         */
                        $featured = array_map(function (Entry $entry) {
                            return [
                                'id'        => $entry->id,
                                'title'     => $entry->title,
                                'video'     => array_map(function (Asset $asset) {
                                    return [
                                        'filename' => $asset->filename,
                                    ];
                                }, $entry->video->find()),
                                'thumbnail' => array_map(function (Asset $asset) {
                                    return [
                                        'filename' => $asset->filename,
                                        'tablet' => Craft::$app->getAssets()->getAssetUrl($asset,'featuredTablet', true),
                                        'mobile' => Craft::$app->getAssets()->getAssetUrl($asset,'featuredMobile', true),
                                        'lazyLoad' => Craft::$app->getAssets()->getAssetUrl($asset,'lazyLoad', true)
                                    ];
                                }, $entry->thumbnail->find()),
                            ];
                        }, $category->featured->find());

                        /**
                         * The code below is equal to craft.entries.section(section).relatedTo(category).all()
                         */
                        $query = \craft\elements\Entry::find();
                        $query->section('interviews')->relatedTo($category);
                        $videos = $query->all();

                        /**
                         * Here we going to remove the FEATURED video from related videos to prevent duplicates.
                         */
                        $i = -1;
                        foreach ($videos as $video) {
                            $i++;
                            if ($featured) {
                                if ($video->id === $featured[0]['id']) {
                                    unset($videos[$i]);
                                }
                            }
                        }
                        $videos = array_values($videos);

                        /**
                         * Return an object :)
                         */
                        return [
                            'title'       => $category->title,
                            'age'         => $category->age,
                            'city'        => $category->city,
                            'description' => $category->persondescription,
                            'featured'    => $featured,
                            'videos'      => [
                                array_map(function (Entry $entry) {
                                        return [
                                        'id'        => $entry->id,
                                        'title'     => $entry->title,
                                        'video'     => array_map(function (Asset $asset) {
                                            return [
                                                'filename' => $asset->filename,
                                            ];
                                        }, $entry->video->find()),
                                        'thumbnail' => array_map(function (Asset $asset) {
                                            return [
                                                'filename' => $asset->filename,
                                                'universal' => Craft::$app->getAssets()->getAssetUrl($asset,'gridThumbnail', true),
                                                'lazyLoad' => Craft::$app->getAssets()->getAssetUrl($asset,'lazyLoad', true),
                                            ];
                                        }, $entry->thumbnail->find()),
                                    ];
                                }, $videos),
                            ],
                        ];
                    }
                ];
            },
        'themes.json' =>
            function () {
                Craft::$app->getResponse()->getHeaders()->set('Access-Control-Allow-Origin', '*');

                return [
                    'elementType' => Category::class,
                    'criteria'    => ['group' => 'theme'],
                    'transformer' => function (Category $category) {
                        /**
                         * The code below is equal to craft.entries.section(section).relatedTo(category).all()
                         */
                        $query = \craft\elements\Entry::find();
                        $query->section('interviews')->relatedTo($category);
                        $videos = $query->all();
                        return [
                            'title'       => $category->title,
                            'description' => $category->themedescription,
                            'thumbnail'   => array_map(function (Asset $asset) {
                                return [
                                    'filename' => $asset->filename,
                                    'tablet' => Craft::$app->getAssets()->getAssetUrl($asset,'featuredTablet', true),
                                    'mobile' => Craft::$app->getAssets()->getAssetUrl($asset,'featuredMobile', true),
                                    'lazyLoad' => Craft::$app->getAssets()->getAssetUrl($asset,'lazyLoad', true),
                                ];
                            }, $category->themethumbnail->find()),
                            'videos'      => [
                                array_map(function (Entry $entry) {
                                    return [
                                        'id'        => $entry->id,
                                        'title'     => $entry->title,
                                        'video'     => array_map(function (Asset $asset) {
                                            return [
                                                'filename' => $asset->filename,
                                            ];
                                        }, $entry->video->find()),
                                        'thumbnail' => array_map(function (Asset $asset) {
                                            return [
                                                'filename' => $asset->filename,
                                                'universal' => Craft::$app->getAssets()->getAssetUrl($asset,'gridThumbnail', true),
                                                'lazyLoad' => Craft::$app->getAssets()->getAssetUrl($asset,'lazyLoad', true),
                                            ];
                                        }, $entry->thumbnail->find()),
                                    ];
                                }, $videos),
                            ],
                        ];
                    }
                ];
            }
    ]
]

?>
