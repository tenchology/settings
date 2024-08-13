<?php

return [
    "general" => [
        "icon" => "heroicon-o-cog-6-tooth",
        "elements" => [
            [
                "key" => "body_font",
                "type" => "input",
                "title" => "Content font name",
                "help" => "Select a font for your titles <a target=\"_blank\" href=\"https://fonts.bunny.net\">bunny fonts</a>",
                  "placeholder" => "IBM Plex Serif"
               ],
            [
                "type" => "upload",
                "key" => "app_logo",
                "title" => "Logo",
                "width" => 350,
                "height" => 150
            ],
            [
                "type" => "upload",
                "key" => "favicon",
                "title" => "Favicon",
                "width" => 350,
                "height" => 150
            ]
         ]
      ],
    "contact" => [
        "sort" => 2,
        "icon" => "heroicon-o-envelope-open",
        "elements" => [
            [
                "key" => "smtp_mail_enabled",
                "type" => "checkbox",
                "title" => "Enable SMTP?"
            ],
            [
                "type" => "input",
                "key" => "smtp_username",
                "title" => "SMTP Username"
            ],
            [
                "type" => "input",
                "key" => "smtp_password",
                "title" => "SMTP Password"
            ],
            [
                "type" => "input",
                "key" => "mail_host",
                "title" => "SMTP Host"
            ],
            [
                "type" => "input",
                "key" => "smtp_url",
                "title" => "SMTP URL"
            ],
            [
                "type" => "input",
                "key" => "smtp_port",
                "title" => "SMTP Port"
            ],
            [
                "type" => "toggleButtons",
                "key" => "smtp_encryption",
                "title" => "SMTP Encryption",
                "options" => [
                    "tls" => "TLS",
                    "ssl" => "SSL"
                ]
            ],
            [
                "type" => "input",
                "key" => "from_email",
                "title" => "From Email"
            ],
            [
                "type" => "input",
                "key" => "from_name",
                "title" => "From Name"
            ],
            [
                "type" => "input",
                "key" => "email_subject",
                "title" => "Email Subject"
            ],
            [
                "type" => "input",
                "key" => "app_email",
                "title" => "Email"
            ],
            [
                "type" => "input",
                "key" => "app_phone",
                "title" => "Phone"
            ],
            [
                "type" => "input",
                "key" => "app_fax",
                "title" => "Fax"
            ],
            [
                "type" => "input",
                "key" => "app_address",
                "title" => "Address Line 1"
            ],
            [
                "type" => "input",
                "key" => "app_address2",
                "title" => "Address Line 2"
            ],
            [
                "type" => "input",
                "key" => "app_opentime",
                "title" => "Address"
            ],
            [
                "type" => "input",
                "key" => "app_tripadvisor",
                "title" => "Tripadvisor"
            ],
            [
                "type" => "input",
                "key" => "app_facebook",
                "title" => "Facebook"
            ],
            [
                "type" => "input",
                "key" => "app_instagram",
                "title" => "Instagram"
            ],
            [
                "type" => "input",
                "key" => "app_twitter",
                "title" => "Twitter"
            ],
            [
                "type" => "input",
                "key" => "app_youtube",
                "title" => "Youtube"
            ],
            [
                "type" => "input",
                "key" => "app_linkedin",
                "title" => "Linkedin"
            ],
            [
                "type" => "input",
                "key" => "app_pinterest",
                "title" => "Pinterest"
            ],
            [
                "type" => "input",
                "key" => "app_whatsapp",
                "title" => "Whatsapp"
            ],
            [
                "type" => "input",
                "key" => "app_telegram",
                "title" => "Telegram"
            ],
            [
                "type" => "input",
                "key" => "app_telegram",
                "title" => "Telegram"
            ]
        ]
    ],
    "theme" => [
        "icon" => "heroicon-o-swatch",
        "elements" => [
            [
                "type" => "select",
                "key" => "app_theme",
                "title" => "Default Theme",
                "options" => [
                    "default" => "default",
                    "one" => "one"
                ]
            ]
        ]
    ],
    "tours" => [
        "icon" => "heroicon-o-swatch",
        "elements" => [
            [
                "type" => "editor",
                "key" => "terms_and_conditions",
                "title" => "Terms and Conditions"
            ],
            [
                "type" => "editor",
                "key" => "cancellation_policy",
                "title" => "Cancellation Policy"
            ],
            [
                "type" => "editor",
                "key" => "privacy_policy",
                "title" => "Privacy Policy"
            ]
        ]
    ],
];
