<?php
$article = $client->post('articles',array(
		"name" => "Artikelname",
		"active" => true,
		"tax" => 19,
		"supplier" => "Herstellername",
		"categories" => array(array("id" => 79)),
		"descriptionLong" => "Beschreibung",
		'related' => array(
			array(
				'id' => 495, // cross-selling
			),
		),
		"mainDetail" => array(
			'number' => ('SHOP-'.str_pad((1), 8, '0', STR_PAD_LEFT)),
			"inStock" => "1000000",
	        "weight" => "4",
	        "purchaseUnit" => "1",
	        "referenceUnit" => "1",
	        'prices' => array(
	            array(
	            	'customerGroupKey' => 'EK',
	                'price' => mt_rand(100,999),
	            ),
	        )
		),
		'images' => array(
			array(
				'link' => 'http://lorempixel.com/640/480/food/'
			)
		),
	   'configuratorSet' => array(
	        'groups' => array(
	            array(
	                'name' => 'Gruppe1',
	                'options' => array(
	                    array('name' => 'Option1'),
	                    array('name' => 'Option2'),
	                    array('name' => 'Option3'),
	                )
	            ),
	            array(
	                'name' => 'Gruppe2',
	                'options' => array(
	                    array('name' => 'Option1'),
	                    array('name' => 'Option2'),
	                    array('name' => 'Option3'),
	                )
	            )
	        )
	    ),
		'variants' => array(
			array(
				'isMain' => true,
				"active" => true,
				'number' => ('SHOP-'.str_pad((1), 8, '0', STR_PAD_LEFT)),
				"inStock" => "1000000",
		        "weight" => "4",
		        "purchaseUnit" => "1",
		        "referenceUnit" => "1",
	            'configuratorOptions' => array(
	                array('group' => 'Gruppe1', 'option' => 'Option1'),
	                array('group' => 'Gruppe2', 'option' => 'Option1'),
	            ),
		        'prices' => array(
		            array(
		            	'customerGroupKey' => 'EK',
		                'price' => mt_rand(100,999),
		            ),
		        ),
				'images' => array(
					array(
						'link' => 'http://lorempixel.com/540/480/food/'
					)
				),
	        ),
			array(
				'isMain' => false,
				"active" => true,
				'number' => ('SHOP-'.str_pad((1), 8, '0', STR_PAD_LEFT)).".1",
				"inStock" => "1000000",
		        "weight" => "4",
		        "purchaseUnit" => "1",
		        "referenceUnit" => "1",
	            'configuratorOptions' => array(
	                array('group' => 'Gruppe1', 'option' => 'Option1'),
	                array('group' => 'Gruppe2', 'option' => 'Option2'),
	            ),
		        'prices' => array(
		            array(
		            	'customerGroupKey' => 'EK',
		                'price' => mt_rand(100,999),
		            ),
		        ),
				'images' => array(
					array(
						'link' => 'http://lorempixel.com/440/480/food/'
					)
				),
	        )
        )


	));