<?php
	return [
		'names' => ['max'=>150],
		'name' => ['max'=>100],
        'company_name' => ['max'=>191],
		'username' => ['max'=>191],
		'surnames' => ['max'=>150],
        'full_name' => ['max'=>191],
		'email' => ['max'=>150],
		'phone' => ['min'=>7,'max'=>15],

        'cellphone' => [
            'digits'=>9,
            'regex' => '/^(9)[0-9]{8}$/',
            'min'=>9,
            'max'=>15,
        ],

		'address' => ['max'=>191],
		'password' => [
						'min'=>8,
						'max'=>50,
                        'regex'=>'/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{6,}$/'
//						'regex'=>'/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[$+=?@_#%&*!$^-]).{6,}$/'
					],
		'short_description' => ['max'=>300],
		'description' => ['max'=>1500],
		'short_text' => ['max'=>300],
		'medium_text' => ['max'=>1500],
		'long_text'=> ['max'=>5000],
		'image_name' => ['max'=>150],
		'generated_image_name' => ['max'=>191],
		'title' => ['max'=>150],
		'identification_document' => ['min'=>8,'max'=>9],
		'slug' => ['max'=>191],
		'url' => ['max'=>191],
		'token'=> ['max'=>191],

        'float'=>[
            'integer_digits' => 8,
            'decimal_digits' => 2,
        ],


        'question_registration' => ['max'=>191],

    ]

?>
