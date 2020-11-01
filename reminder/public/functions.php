<?php

// 日本のタイムゾーンを設定
date_default_timezone_set('Asia/Tokyo');

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

// 曜日を日本語1文字で取得
function getWeek() {
    $today = date('w');
    $weekday = ['日','月','火','水','木','金','土'];
    return $weekday[$today];
}


function getLineTemplate($results)
{
    $array = [
        'type'      => 'flex',
        'altText'   => 'Today\'s Schedule',
        'contents'  => [
            'type'     => 'bubble',
            'size'     => 'mega',
            'header'   => [
                'type'          => 'box',
                'layout'        => 'vertical',
                'contents'      => [
                    [
                        'type'     => 'box',
                        'layout'   => 'baseline',
                        'contents' => [
                            [
                                'type'        => 'text',
                                'text'        => 'Today\'s',
                                'color'       => '#ffffff66',
                                'size'        => 'sm',
                            ],
                            [
                                'type'        => 'text',
                                'text'        => 'Schedule',
                                'color'       => '#ffffff',
                                'size'        => 'xl',
                                'flex'        => 4,
                                'weight'      => 'bold',
                                'align'       => 'start',
                                'offsetStart' => '25px'
                            ]
                        ]
                    ]
                ],
                'backgroundColor' => '#0367D3'
            ],
            'hero'  => [
                'type' => 'box',
                'layout' => 'vertical',
                'contents' => [
                    [
                        'type' => 'text',
                        'text' => date('m月d日').' ('.getWeek().')',
                        'size' => 'md',
                        'color' => '#b7b7b7',
                        'margin' => 'xl',
                        'offsetStart' => '20px'
                    ]
                ]
            ],  
            'body'  => [
                'type'      => 'box',
                'layout'    => 'vertical',
                'contents'  =>  getPlan($results)
            ]
            
        ]
    ];
    return $array;
}

function getLineTemplateBody($start, $end, $summary) {
    $array = 
    [
        'type' => 'box',
        'layout' => 'vertical',
        'contents' => [
            [
                'type' => 'box',
                'layout' => 'horizontal',
                'contents' => [
                    [
                        'type' => 'text',
                        'text' => $start,
                        'size' => 'md',
                        'weight' => 'bold'
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
                                'contents' => [],
                                'width' => '12px',
                                'height' => '12px',
                                'borderWidth' => '2px',
                                'borderColor' => '#EF454D',
                                'cornerRadius' => '30px'
                            ],
                            [
                                'type' => 'filler'
                            ]
                        ],
                        'flex' => 4
                    ]
                ],
                'spacing' => 'lg',
                'margin' => 'xl',
                'cornerRadius' => '30px'
            ],
            [
                'type' => 'box',
                'layout' => 'horizontal',
                'contents' => [
                    [
                        'type' => 'box',
                        'layout' => 'vertical',
                        'contents' => [],
                        'margin' => '67px',
                        'width' => '2px',
                        'backgroundColor' => '#B7B7B7'
                    ],
                    [
                        'type' => 'box',
                        'layout' => 'vertical',
                        'contents' => [
                            [
                                'type' => 'text',
                                'text' => $summary,
                                'size' => 'sm',
                                'wrap' => true,
                                'align' => 'center'
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
                                'text' => $end,
                                'size' => 'sm'
                            ]
                        ]
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
                                'contents' => [],
                                'width' => '12px',
                                'height' => '12px',
                                'flex' => 4,
                                'cornerRadius' => '30px',
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
    ];
    return $array;
}

function getPlan($samplePlan) {
    // 本日の予定を格納
    $plans = [];

    for($i = 0; $i < count($samplePlan); $i++) {
        $plan = getLineTemplateBody($samplePlan[$i]['startTime'], $samplePlan[$i]['endTime'], $samplePlan[$i]['summary']);
        array_push($plans, $plan);
    }

    return $plans;
}