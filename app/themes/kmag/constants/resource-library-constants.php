<?php

define('RESOURCE_LIBRARY_FILTERS', [
    'crop' => [
        'id' => 'crops',
        'value' => 'Crops',
        'filters' => [
            'alfalfa' => ['id' => 'alfalfa', 'value' => 'Alfalfa'],
            //'barley' => ['id' => 'barley', 'value' => 'Barley'],
            'canola' => ['id' => 'canola', 'value' => 'Canola'],
            //'citrus' => ['id' => 'citrus', 'value' => 'Citrus'],
            'corn' => ['id' => 'corn', 'value' => 'Corn'],
            'cotton' => ['id' => 'cotton', 'value' => 'Cotton'],
            //'dry-beans' => ['id' => 'dry-beans', 'value' => 'Dry Beans'],
            //'hay' => ['id' => 'hay', 'value' => 'Hay'],
            //'oats' => ['id' => 'oats', 'value' => 'Oats'],
            'onions' => ['id' => 'onions', 'value' => 'Onions'],
            //'peanuts' => ['id' => 'peanuts', 'value' => 'Peanuts'],
            //'peas' => ['id' => 'peas', 'value' => 'Peas'],
            'potato' => ['id' => 'potato', 'value' => 'Potato'],
            'rice' => ['id' => 'rice', 'value' => 'Rice'],
            'sorghum' => ['id' => 'sorghum', 'value' => 'Sorghum'],
            'soybean' => ['id' => 'soybean', 'value' => 'Soybean'],
            //'specialty' => ['id' => 'specialty', 'value' => 'Specialty'],
            //'spring-cereals' => ['id' => 'spring-cereals', 'value' => 'Spring Cereals'],
            'spring-wheat' => ['id' => 'spring-wheat', 'value' => 'Spring Wheat'],
            'sugar-beets' => ['id' => 'sugar-beets', 'value' => 'Sugar Beets'],
            'sugar-cane' => ['id' => 'sugar-cane', 'value' => 'Sugar Cane'],
            //'sunflower' => ['id' => 'sunflower', 'value' => 'Sunflower'],
            //'tree-fruit' => ['id' => 'tree-fruit', 'value' => 'Tree Fruit'],
            //'turf' => ['id' => 'turf', 'value' => 'Turf'],
            'vegetables' => ['id' => 'vegetables', 'value' => 'Vegetables'],
            'durum-wheat' => ['id' => 'durum-wheat', 'value' => 'Durum Wheat'],
            'alfalfa' => ['id' => 'alfalfa', 'value' => 'Alfalfa'],
            'barley' => ['id' => 'barley', 'value' => 'Barley'],
            'canola' => ['id' => 'canola', 'value' => 'Canola'],
            'citrus' => ['id' => 'citrus', 'value' => 'Citrus'],
            'corn' => ['id' => 'corn', 'value' => 'Corn'],
            'cotton' => ['id' => 'cotton', 'value' => 'Cotton'],
            'dry-beans' => ['id' => 'dry-beans', 'value' => 'Dry Beans'],
            'hay' => ['id' => 'hay', 'value' => 'Hay'],
            'oats' => ['id' => 'oats', 'value' => 'Oats'],
            'onions' => ['id' => 'onions', 'value' => 'Onions'],
            'peanuts' => ['id' => 'peanuts', 'value' => 'Peanuts'],
            'peas' => ['id' => 'peas', 'value' => 'Peas'],
            'potato' => ['id' => 'potato', 'value' => 'Potato'],
            'rice' => ['id' => 'rice', 'value' => 'Rice'],
            'sorghum' => ['id' => 'sorghum', 'value' => 'Sorghum'],
            'soybean' => ['id' => 'soybean', 'value' => 'Soybean'],
            'specialty' => ['id' => 'specialty', 'value' => 'Specialty'],
            'spring-cereals' => ['id' => 'spring-cereals', 'value' => 'Spring Cereals'],
            'spring-wheat' => ['id' => 'spring-wheat', 'value' => 'Spring Wheat'],
            'sugar-beets' => ['id' => 'sugar-beets', 'value' => 'Sugar Beets'],
            'sugar-cane' => ['id' => 'sugar-cane', 'value' => 'Sugar Cane'],
            'sunflower' => ['id' => 'sunflower', 'value' => 'Sunflower'],
            'tree-fruit' => ['id' => 'tree-fruit', 'value' => 'Tree Fruit'],
            'turf' => ['id' => 'turf', 'value' => 'Turf'],
            'vegetables' => ['id' => 'vegetables', 'value' => 'Vegetables'],
            'winter-wheat' => ['id' => 'winter-wheat', 'value' => 'Winter Wheat'],
        ]

    ],

    'nutrients' => [
        'id' => 'nutrients',
        'value' => 'All Nutrients',
        'filters' => [
            'n' => ['id' => 'n', 'value' => 'N'],
            'p' => ['id' => 'p', 'value' => 'P'],
            'k' => ['id' => 'k', 'value' => 'K'],
            'mg' => ['id' => 'mg', 'value' => 'Mg'],
            's' => ['id' => 's', 'value' => 'S'],
            'ca' => ['id' => 'ca', 'value' => 'Ca'],
            'b' => ['id' => 'b', 'value' => 'B'],
            'cl' => ['id' => 'cl', 'value' => 'Cl'],
            'mn' => ['id' => 'mn', 'value' => 'Mn'],
            'fe' => ['id' => 'fe', 'value' => 'Fe'],
            'ni' => ['id' => 'ni', 'value' => 'Ni'],
            'cu' => ['id' => 'cu', 'value' => 'Cu'],
            'zn' => ['id' => 'zn', 'value' => 'Zn'],
            'mo' => ['id' => 'mo', 'value' => 'Mo'],
            'h' => ['id' => 'h', 'value' => 'H'],
            'c' => ['id' => 'c', 'value' => 'C'],
            'o' => ['id' => 'o', 'value' => 'O'],
        ]

    ],

    'agronomy-topics' => [
        'id' => 'agronomy-topics',
        'value' => 'Agronomy Topics',
        'filters' => [
            'nutrient-deficiency' => ['id' => 'nutrient-deficiency', 'value' => 'Nutrient Deficiency'],
            'nutrient-removal' => ['id' => 'nutrient-removal', 'value' => 'Nutrient Removal'],
            'balanced-kmag' => ['id' => 'balanced-kmag', 'value' => 'Balanced Crop Nutrition'],
            'nutrient-use-enhancers' => ['id' => 'nutrient-use-enhancers', 'value' => 'Nutrient Use Enhancers'],
            'biostimulants' => ['id' => 'biostimulants', 'value' => 'Bio Crop Stimulants'],
            'r4-stewardship' => ['id' => 'r4-stewardship', 'value' => '4R Stewardship'],
            'soil-testing' => ['id' => 'soil-testing', 'value' => 'Soil Testing'],
            'soil-ph' => ['id' => 'soil-ph', 'value' => 'Soil pH'],
            'fertilizer-application' => ['id' => 'fertilizer-application', 'value' => 'Fertilizer Application'],
        ]

    ],

    'products' => [
        'id' => 'products',
        'value' => 'Products',
        'filters' => [
            'microessentials' => [
                'id' => 'micro-essentials',
                'value' => 'MicroEssentials',
                'label' => 'MicroEssentials'.PERFORMANCE_PRODUCT_COPYRIGHT_MAP['microessentials']],
            'aspire' => [
                'id' => 'aspire',
                'value' => 'Aspire',
                'label' => 'Aspire'.PERFORMANCE_PRODUCT_COPYRIGHT_MAP['aspire']],
             'commodity ' => [
                'id' => 'commodity',
                'value' => 'Commodity',
                'label' => 'Commodity'],    
            'k-mag' => [
                'id' => 'k-mag',
                'value' => 'K-Mag',
                'label' => 'K-Mag'.PERFORMANCE_PRODUCT_COPYRIGHT_MAP['k-mag']],
            'pegasus' => [
                'id' => 'pegasus',
                'value' => 'Pegasus',
                'label' => 'Pegasus'.PERFORMANCE_PRODUCT_COPYRIGHT_MAP['pegasus']],
            'biopath' => [
                'id' => 'biopath',
                'value' => 'BioPath',
                'label' => 'BioPath'.PERFORMANCE_PRODUCT_COPYRIGHT_MAP['biopath']],
            'powercoat' => [
                'id' => 'powercoat',
                'value' => 'PowerCoat',
                'label' => 'PowerCoat'.PERFORMANCE_PRODUCT_COPYRIGHT_MAP['powercoat']],
            'root-honey-plus-1-0-1' => [
                'id' => 'root-honey-plus-1-0-1',
                'value'  => 'Root Honey Plus 1-0-1' ,
                'label' => 'Root Honey Plus 1-0-1'.PERFORMANCE_PRODUCT_COPYRIGHT_MAP['root-honey-plus-1-0-1']
            ],
            /*'manage' => [
                'id' => 'manage',
                'value' => 'Manage',
                'label' => 'Manage'.PERFORMANCE_PRODUCT_COPYRIGHT_MAP['manage']
            ],*/
            'refirma-hydraguard' => [
                'id' => 'refirma-hydraguard',
                'value' => 'Refirma HydraGuard™',
                'label' => 'Refirma HydraGuard'.PERFORMANCE_PRODUCT_COPYRIGHT_MAP['refirma-hydraguard']
            ],
            
        ]

    ],

    'resource-type' => [
        'id' => 'resource-type',
        'value' => 'Resource Type',
        'filters' => [
            'article' => ['id' => 'standard-articles', 'value' => 'Article'],
            'trending-topic' => ['id' => 'robust-articles', 'value' => 'Trending Topic'],
            'agrifacts' => ['id' => 'agrifacts', 'value' => 'Agrifacts'],
            'calculators' => ['id' => 'calculators', 'value' => 'Calculators'],
            'agrisights' => ['id' => 'agrisights', 'value' => 'Agrisight'],
            'video-article' => ['id' => 'video-articles', 'value' => 'Video'],
            'audio-article' => ['id' => 'audio-articles', 'value' => 'Listen Now'],
            'documents-labels' => ['id' => 'documents', 'value' => 'Documents & Labels'],
            'success-story' => ['id' => 'success-story', 'value' => 'Success Story'],
            'trures-trial-data' => ['id' => 'trures-trial-data', 'value' => 'TruResponse Trial Data'],
            'trures-insights' => ['id' => 'trures-insights', 'value' => 'TruResponse Insights']
        ]

    ],
]);

// posts to be shown in resource library results state
define("ARCHIVE_RESULTS_PER_PAGE", 33);
define("RESOURCE_LIBRARY_TAGS_TAXONOMIES", array("article-tag", "performance-product", "crop", "nutrients-tag"));
