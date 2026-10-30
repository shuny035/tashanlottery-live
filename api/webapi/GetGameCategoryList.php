<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: *');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$categories = [
    [
        "id" => 9,
        "typeNameCode" => 9309,
        "categoryCode" => "BigAward",
        "categoryName" => "电子大奖",
        "state" => 1,
        "sort" => 98,
        "categoryImg" => "https://ossimg.yaaprwipayn.com/yaarwin/gamecategory/gamecategory_20260427185010r2fk.png"
    ],
    [
        "id" => 4,
        "typeNameCode" => 9304,
        "categoryCode" => "Slot",
        "categoryName" => "电子游戏",
        "state" => 1,
        "sort" => 7,
        "categoryImg" => "https://ossimg.yaaprwipayn.com/yaarwin/gamecategory/gamecategory_20260427184804ey3l.png"
    ],
    [
        "id" => 1,
        "typeNameCode" => 9301,
        "categoryCode" => "Lottery",
        "categoryName" => "彩票",
        "state" => 1,
        "sort" => 6,
        "categoryImg" => "https://ossimg.yaaprwipayn.com/yaarwin/gamecategory/gamecategory_20260427184716d9h5.png"
    ],
    [
        "id" => 5,
        "typeNameCode" => 9305,
        "categoryCode" => "Sport",
        "categoryName" => "体育游戏",
        "state" => 1,
        "sort" => 5,
        "categoryImg" => "https://ossimg.yaaprwipayn.com/yaarwin/gamecategory/gamecategory_20260427184853xor3.png"
    ],
    [
        "id" => 6,
        "typeNameCode" => 9306,
        "categoryCode" => "Video",
        "categoryName" => "视讯游戏",
        "state" => 1,
        "sort" => 4,
        "categoryImg" => "https://ossimg.yaaprwipayn.com/yaarwin/gamecategory/gamecategory_20260427184833jesv.png"
    ],
    [
        "id" => 7,
        "typeNameCode" => 9307,
        "categoryCode" => "Chess",
        "categoryName" => "棋牌游戏",
        "state" => 1,
        "sort" => 3,
        "categoryImg" => "https://ossimg.yaaprwipayn.com/yaarwin/gamecategory/gamecategory_20260427184918237i.png"
    ],
    [
        "id" => 8,
        "typeNameCode" => 9308,
        "categoryCode" => "Fish",
        "categoryName" => "捕鱼游戏",
        "state" => 1,
        "sort" => 2,
        "categoryImg" => "https://ossimg.yaaprwipayn.com/yaarwin/gamecategory/gamecategory_20260427184949bgyg.png"
    ],
    [
        "id" => 3,
        "typeNameCode" => 9303,
        "categoryCode" => "Flash",
        "categoryName" => "小游戏",
        "state" => 1,
        "sort" => 1,
        "categoryImg" => "https://ossimg.yaaprwipayn.com/yaarwin/gamecategory/gamecategory_20260427184742w13a.png"
    ],
    [
        "id" => 2,
        "typeNameCode" => 9302,
        "categoryCode" => "Popular",
        "categoryName" => "热门游戏",
        "state" => 1,
        "sort" => 0,
        "categoryImg" => "https://ossimg.yaaprwipayn.com/yaarwin/gamecategory/gamecategory_20260427184650h6v6.png"
    ]
];

echo json_encode([
    'data' => $categories,
    'code' => 0,
    'msg' => 'Succeed',
    'msgCode' => 0,
    'serviceNowTime' => date('Y-m-d H:i:s')
]);
