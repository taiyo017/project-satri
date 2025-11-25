<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Section Templates
    |--------------------------------------------------------------------------
    |
    */

    'hero' => [
        'name' => 'Hero Section',
        'layouts' => ['hero_1', 'hero_2'],
        'fields' => [
            ['key' => 'title', 'type' => 'text', 'label' => 'Title'],
            ['key' => 'subtitle', 'type' => 'text', 'label' => 'Subtitle'],
            ['key' => 'content', 'type' => 'wysiwyg', 'label' => 'Content'],
            ['key' => 'background', 'type' => 'image', 'label' => 'Background Image'],
            ['key' => 'image', 'type' => 'image', 'label' => 'Image'],
            ['key' => 'buttons', 'type' => 'repeater', 'label' => 'Buttons', 'fields' => [
                ['key' => 'text', 'type' => 'text', 'label' => 'Button Text'],
                ['key' => 'url', 'type' => 'url', 'label' => 'Button URL'],
            ]],
        ],
    ],

    'other_hero' => [
        'name' => 'Inner Page Hero',
        'layouts' => ['other_hero_1'],
        'fields' => [
            ['key' => 'title', 'type' => 'text', 'label' => 'Page Title'],
            ['key' => 'background', 'type' => 'image', 'label' => 'Background Image'],
            ['key' => 'image', 'type' => 'image', 'label' => 'Optional Image'],

            ['key' => 'breadcrumbs', 'type' => 'repeater', 'label' => 'Breadcrumbs', 'fields' => [
                ['key' => 'label', 'type' => 'text', 'label' => 'Label (Example: Careers, Apply)'],
                ['key' => 'url', 'type' => 'url', 'label' => 'URL (Optional)'],
            ]],
        ],
    ],


    'about' => [
        'name' => 'About Section',
        'layouts' => ['about_1', 'about_2'],
        'fields' => [
            ['key' => 'title', 'type' => 'text', 'label' => 'Heading'],
            ['key' => 'subtitle', 'type' => 'text', 'label' => 'Subtitle'],
            ['key' => 'content', 'type' => 'wysiwyg', 'label' => 'Content'],
            ['key' => 'image', 'type' => 'image', 'label' => 'Side Image'],
            ['key' => 'buttons', 'type' => 'repeater', 'label' => 'Buttons', 'fields' => [
                ['key' => 'text', 'type' => 'text', 'label' => 'Button Text'],
                ['key' => 'url', 'type' => 'url', 'label' => 'Button URL'],
            ]],
        ],
    ],

    'about_main' => [
        'name' => 'About Page Main Section',
        'layouts' => ['about_default'],
        'fields' => [
            [
                'key' => 'title',
                'type' => 'text',
                'label' => 'Main Heading',
                'placeholder' => 'About Us',
            ],
            [
                'key' => 'subtitle',
                'type' => 'text',
                'label' => 'Subtitle',
                'placeholder' => 'Who we are',
            ],
            [
                'key' => 'content_paragraphs',
                'type' => 'repeater',
                'label' => 'Content Paragraphs',
                'fields' => [
                    ['key' => 'paragraph', 'type' => 'wysiwyg', 'label' => 'Paragraph'],
                ],
            ],
            [
                'key' => 'mission',
                'type' => 'group',
                'label' => 'Our Mission',
                'fields' => [
                    ['key' => 'title', 'type' => 'text', 'label' => 'Mission Title', 'placeholder' => 'Our Mission'],
                    ['key' => 'subtitle', 'type' => 'text', 'label' => 'Mission Subtitle', 'placeholder' => 'Why we exist'],
                    ['key' => 'content', 'type' => 'wysiwyg', 'label' => 'Mission Content'],
                ],
            ],
            [
                'key' => 'vision',
                'type' => 'group',
                'label' => 'Our Vision',
                'fields' => [
                    ['key' => 'title', 'type' => 'text', 'label' => 'Vision Title', 'placeholder' => 'Our Vision'],
                    ['key' => 'subtitle', 'type' => 'text', 'label' => 'Vision Subtitle', 'placeholder' => 'Where we are heading'],
                    ['key' => 'content', 'type' => 'wysiwyg', 'label' => 'Vision Content'],
                ],
            ],
            [
                'key' => 'features',
                'type' => 'repeater',
                'label' => 'Key Features',
                'fields' => [
                    ['key' => 'icon', 'type' => 'text', 'label' => 'Icon (class or URL)'],
                    ['key' => 'title', 'type' => 'text', 'label' => 'Feature Title'],
                    ['key' => 'content', 'type' => 'textarea', 'label' => 'Feature Description'],
                ],
            ],
            [
                'key' => 'image',
                'type' => 'image',
                'label' => 'Main Image',
            ],
            [
                'key' => 'buttons',
                'type' => 'repeater',
                'label' => 'Buttons',
                'fields' => [
                    ['key' => 'text', 'type' => 'text', 'label' => 'Button Text'],
                    ['key' => 'url', 'type' => 'url', 'label' => 'Button URL'],
                ],
            ],
        ],
    ],

    'why_choose_us' => [
        'name' => 'Why Choose Us Section',
        'layouts' => ['why_choose_us_default'],
        'fields' => [
            [
                'key' => 'title',
                'type' => 'text',
                'label' => 'Main Title',
                'placeholder' => 'Why Choose SATRI?',
            ],
            [
                'key' => 'subtitle',
                'type' => 'text',
                'label' => 'Subtitle',
                'placeholder' => 'Where Tech Enthusiasts Elevate',
            ],
            [
                'key' => 'description',
                'type' => 'wysiwyg',
                'label' => 'Main Description',
                'placeholder' => 'Write main intro about SATRI…',
            ],
            [
                'key' => 'features',
                'type' => 'repeater',
                'label' => 'Key Features',
                'fields' => [
                    ['key' => 'title', 'type' => 'text', 'label' => 'Feature Title'],
                    ['key' => 'content', 'type' => 'textarea', 'label' => 'Feature Description'],
                ],
            ],
            [
                'key' => 'image',
                'type' => 'image',
                'label' => 'Side Image (optional)',
            ],
        ],
    ],

    'career_intro' => [
        'name' => 'Career Intro Section',
        'layouts' => ['career_1', 'career_2'],
        'fields' => [
            ['key' => 'title', 'type' => 'text', 'label' => 'Heading'],
            ['key' => 'subtitle', 'type' => 'text', 'label' => 'Subtitle'],
            ['key' => 'content', 'type' => 'wysiwyg', 'label' => 'Content'],

            ['key' => 'buttons', 'type' => 'repeater', 'label' => 'Buttons', 'fields' => [
                ['key' => 'text', 'type' => 'text', 'label' => 'Button Text'],
                ['key' => 'url', 'type' => 'url', 'label' => 'Button URL'],
            ]],
        ],
    ],

    'features' => [
        'name' => 'Features Section',
        'layouts' => ['grid', 'list'],
        'fields' => [
            ['key' => 'heading', 'type' => 'text', 'label' => 'Heading'],
            ['key' => 'subtitle', 'type' => 'text', 'label' => 'Subtitle'],
            ['key' => 'content', 'type' => 'wysiwyg', 'label' => 'Content'],
            ['key' => 'buttons', 'type' => 'repeater', 'label' => 'Buttons', 'fields' => [
                ['key' => 'text', 'type' => 'text', 'label' => 'Button Text'],
                ['key' => 'url', 'type' => 'url', 'label' => 'Button URL'],
            ]],
        ],
    ],

    'courses' => [
        'name' => 'Courses Section',
        'layouts' => ['grid', 'carousel'],
        'fields' => [
            ['key' => 'title', 'type' => 'text', 'label' => 'Heading'],
            ['key' => 'subtitle', 'type' => 'text', 'label' => 'Subtitle'],
            ['key' => 'content', 'type' => 'wysiwyg', 'label' => 'Content'],
            ['key' => 'buttons', 'type' => 'repeater', 'label' => 'Buttons', 'fields' => [
                ['key' => 'text', 'type' => 'text', 'label' => 'Button Text'],
                ['key' => 'url', 'type' => 'url', 'label' => 'Button URL'],
            ]],
        ],
    ],

    'projects' => [
        'name' => 'Projects Section',
        'layouts' => ['grid', 'masonry'],
        'fields' => [
            ['key' => 'title', 'type' => 'text', 'label' => 'Heading'],
            ['key' => 'subtitle', 'type' => 'text', 'label' => 'Subtitle'],
            ['key' => 'content', 'type' => 'wysiwyg', 'label' => 'Content'],
            ['key' => 'buttons', 'type' => 'repeater', 'label' => 'Buttons', 'fields' => [
                ['key' => 'text', 'type' => 'text', 'label' => 'Button Text'],
                ['key' => 'url', 'type' => 'url', 'label' => 'Button URL'],
            ]],
        ],
    ],

    'services' => [
        'name' => 'Services Section',
        'layouts' => ['services_grid', 'services_carousel'],
        'fields' => [
            ['key' => 'heading', 'type' => 'text', 'label' => 'Heading'],
            ['key' => 'subtitle', 'type' => 'text', 'label' => 'Subtitle'],
            ['key' => 'content', 'type' => 'wysiwyg', 'label' => 'Content'],
            ['key' => 'buttons', 'type' => 'repeater', 'label' => 'Buttons', 'fields' => [
                ['key' => 'text', 'type' => 'text', 'label' => 'Button Text'],
                ['key' => 'url', 'type' => 'url', 'label' => 'Button URL'],
            ]],
        ],
    ],

    'gallery' => [
        'name' => 'Gallery Section',
        'layouts' => ['grid', 'masonry'],
        'fields' => [
            ['key' => 'title', 'type' => 'text', 'label' => 'Heading'],
            ['key' => 'subtitle', 'type' => 'text', 'label' => 'Subtitle'],
            ['key' => 'content', 'type' => 'wysiwyg', 'label' => 'Content'],
            ['key' => 'buttons', 'type' => 'repeater', 'label' => 'Buttons', 'fields' => [
                ['key' => 'text', 'type' => 'text', 'label' => 'Button Text'],
                ['key' => 'url', 'type' => 'url', 'label' => 'Button URL'],
            ]],
        ],
    ],


    'teams' => [
        'name' => 'Team Section',
        'layouts' => ['team_grid', 'team_carousel'],
        'fields' => [
            ['key' => 'heading', 'type' => 'text', 'label' => 'Heading'],
            ['key' => 'subtitle', 'type' => 'text', 'label' => 'Subtitle'],
            ['key' => 'content', 'type' => 'wysiwyg', 'label' => 'Content'],
        ],
    ],

    'testimonials' => [
        'name' => 'Testimonials Section',
        'layouts' => ['carousel', 'grid'],
        'fields' => [
            ['key' => 'heading', 'type' => 'text', 'label' => 'Heading'],
            ['key' => 'subtitle', 'type' => 'text', 'label' => 'Subtitle'],
            ['key' => 'content', 'type' => 'wysiwyg', 'label' => 'Content'],
        ],
    ],

    'faq' => [
        'name' => 'FAQ Section',
        'layouts' => ['accordion', 'list'],
        'fields' => [
            ['key' => 'heading', 'type' => 'text', 'label' => 'Heading'],
            ['key' => 'subtitle', 'type' => 'text', 'label' => 'Subtitle'],
            ['key' => 'content', 'type' => 'wysiwyg', 'label' => 'Content'],
        ],
    ],

    'contact' => [
        'name' => 'Contact Section',
        'layouts' => ['contact_form', 'contact_info'],
        'fields' => [
            ['key' => 'heading', 'type' => 'text', 'label' => 'Heading'],
            ['key' => 'subheading', 'type' => 'text', 'label' => 'Subheading'],
            ['key' => 'content', 'type' => 'wysiwyg', 'label' => 'Content'],
        ],
    ],

    'call_to_action' => [
        'name' => 'Call To Action Section',
        'layouts' => ['cta_1', 'cta_2'],
        'fields' => [
            ['key' => 'headline', 'type' => 'text', 'label' => 'Headline'],
            ['key' => 'subheadline', 'type' => 'textarea', 'label' => 'Subheadline'],
            ['key' => 'buttons', 'type' => 'repeater', 'label' => 'Buttons', 'fields' => [
                ['key' => 'text', 'type' => 'text', 'label' => 'Button Text'],
                ['key' => 'url', 'type' => 'url', 'label' => 'Button URL'],
            ]],
        ],
    ],

];
