<?php

use App\Enum\Page;
use App\Enum\Section;

return [
    Page::SPLASH->value => [
        Section::BANNER_SECTION->value => [
            'fields' => ['title', 'description', 'background_image', 'video'],
            'items' => []
        ]
    ],   
    Page::LOGIN->value => [
        Section::BANNER_SECTION->value => [
            'fields' => ['title', 'description', 'image'],
            'items' => []
        ]
    ],

    Page::SIGNUP->value => [
        Section::BANNER_SECTION->value => [
            'fields' => ['title', 'description', 'image'],
            'items' => []
        ]
    ],
    Page::FORGOT_PASSWORD->value => [
        Section::BANNER_SECTION->value => [
            'fields' => ['title', 'description', 'image'],
            'items' => []
        ]
    ],
    Page::OTP_VERIFICATION->value => [
        Section::BANNER_SECTION->value => [
            'fields' => ['title', 'description', 'image'],
            'items' => []
        ]
    ],
    
    Page::NEW_PASSWORD->value => [
        Section::BANNER_SECTION->value => [
            'fields' => ['title', 'description', 'image'],
            'items' => []
        ]
    ],

    Page::HOME->value => [
        Section::HERO_SECTION->value => [
            'fields' => ['main_title', 'title', 'description', 'background_image', 'button_text', 'button_link'],
            'items' => ['title', 'description']
        ],
        Section::SERVICES_SECTION->value => [
            'fields' => ['title', 'description'],
            'items' => []
        ],

        Section::WORK_SECTION->value => [
            'fields' => ['title', 'description'],
            'items' => []
        ],
        Section::SUB_FOOTER_SECTION->value => [
            'fields' => ['title', 'description', 'button_text', 'button_link', 'background_image'],
            'items' => []
        ],
        Section::FOOTER_SECTION->value => [
            'fields' => ['image'],
            'items' => []
        ]
    ],
    Page::ABOUT->value => [
        Section::HERO_SECTION->value => [
            'fields' => ['title',  'background_image'],
            'items' => ['title', 'description']
        ],
        Section::ABOUT_SECTION->value => [
            'fields' => ['title', 'description', 'image'],
            'items' => ['title']
        ]
    ],

    Page::SERVICES->value => [

        Section::HERO_SECTION->value => [
            'fields' => ['title', 'description', 'background_image'],
            'items' => []
        ],
        Section::SERVICES_SECTION->value => [
            'fields' => ['title', 'description'],
            'items' => []
        ],

    ],

    Page::PROJECTS->value => [
        Section::HERO_SECTION->value => [
            'fields' => ['title', 'description', 'background_image'],
            'items' => []
        ],
        Section::WORK_SECTION->value => [
            'fields' => ['title', 'description'],
            'items' => []
        ],
    ],

    Page::FAQ->value => [
        Section::HERO_SECTION->value => [
            'fields' => ['title', 'background_image'],
            'items' => []
        ],
        Section::FAQ_SECTION->value => [
            'fields' => ['title'],
            'items' => ['title', 'description']
        ],
    ],   

    Page::CONTACT->value => [
        Section::HERO_SECTION->value => [
            'fields' => ['title', 'background_image'],
            'items' => ['title','description']
        ],        
    ],
     Page::SHOP->value => [
        Section::HERO_SECTION->value => [
            'fields' => ['main_title', 'title', 'description', 'background_image', 'button_text', 'button_link'],
            'items' => []
        ],
        Section::SHOP_SECTION->value => [
            'fields' => ['title', 'description'],
            'items' => []
        ],        
    ],    
];
