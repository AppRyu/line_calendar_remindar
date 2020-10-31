<?php

// クライアントを取得
function getClient() {
    $client = new Google_Client();
    // スコープをカレンダーの読み取りに設定
    $client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
    // 認証設定
    $json_path =  $_ENV['AUTH_JSON_PATH'];
    $client->setAuthConfig($json_path);
    return $client;
}

function getLineTemplate()
{
    $array = [
        'type' => 'bubble',
        'size' => 'mega',
        'header' => [
            'type' => 'box',
            'layout' => 'vertical',
            'contents' => [
                [
                    'type' => 'box',
                    'layout' => 'baseline',
                    'contents' => [
                        [
                            'type' => 'text',
                            'text' => 'Todays',
                            'color' => '#ffffff66',
                            'size' => 'sm',
                        ],
                        [
                          'type' => 'text',
                          'text' => 'Schedule',
                          'color' => '#ffffff',
                          'size' => 'xl',
                          'flex' => 4,
                          'weight' => 'bold',
                          'align' => 'start',
                          'offsetStart' => '25px'
                        ]
                    ]
                ]
            ],
            'backgroundColor' => '#0367D3'
        ],
        'body' => [
            'type' => 'box',
            'layout' => 'vertical',
            'contents' => [
                [
                    'type' => 'text',
                    'text' => '10月31日（土）',
                    'color' => '#b7b7b7',
                    'size' => 'md',
                    'align' => 'start'
                ],
                [
                    'type' => 'box',
                    'layout' => 'horizontal',
                    'contents' => [
                        [
                            'type' => 'text',
                            'text' => '20:30',
                            'size' => 'sm'
                        ],
                        [
                            'type' => 'box',
                            'layout' => 'vertical',
                            'contents' => [
                                [
                                    'type' => 'filler'
                                ],
                                [
                                    'type' => 'box',
                                    'layout' => 'vertical',
                                    'cornerRadius' => '30px',
                                    'height' => '12px',
                                    'width' => '12px',
                                    'borderColor' => '#EF454D',
                                    'borderWidth' => '2px'
                                ],
                                [
                                    'type' => 'filler'
                                ]
                            ],
                            'flex' => 4
                        ]
                    ],
                    'spacing' => 'lg',
                    'cornerRadius' => '30px',
                    'margin' => 'xl',
                ],
                [
                    'type' => 'box',
                    'layout' => 'horizontal',
                    'contents' => [
                        [
                            'type' => 'box',
                            'layout' => 'vertical',
                            'width' => '2px',
                            'backgroundColor' => '#B7B7B7',
                            'margin' => '67px'
                        ],
                        [
                            'type' => 'box',
                            'layout' => 'vertical',
                            'contents' => [
                                [
                                    'type' => 'text',
                                    'text' => 'カフェで勉強',
                                    'align' => 'center',
                                    'size' => 'sm',
                                    'wrap' => true
                                ]
                            ],
                            'alignItems' => 'center',
                            'justifyContent' => 'center'
                        ]
                    ],
                    'spacing' => 'lg',
                    'height' => '50px'
              ],
              [
                  'type' => 'box',
                  'layout' => 'horizontal',
                  'contents' => [
                      [
                          'type' => 'box',
                          'layout' => 'horizontal',
                          'contents' => [
                              [
                                  'type' => 'text',
                                  'text' => '20:34',
                                  'gravity' => 'center',
                                  'size' => 'sm'
                              ]
                          ],
                          'flex' => 1
                      ],
                      [
                          'type' => 'box',
                          'layout' => 'vertical',
                          'contents' => [
                              [
                                  'type' => 'filler'
                              ],
                              [
                                  'type' => 'box',
                                  'layout' => 'vertical',
                                  'cornerRadius' => '30px',
                                  'width' => '12px',
                                  'height' => '12px',
                                  'borderWidth' => '2px',
                                  'borderColor' => '#6486E3'
                              ],
                              [
                                  'type' => 'filler'
                              ]
                          ],
                          'flex' => 4
                      ]
                  ],
                  'spacing' => 'lg',
                  'cornerRadius' => '30px'
              ]
            ]
        ],
        'style' => [
            'header' => [
                'backgroundColor' => '#3B5998'
            ]
        ]
    ];

    return $array;
}