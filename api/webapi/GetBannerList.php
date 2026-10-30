<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: *');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$banners = [
    [
        "url" => "",
        "bannerUrl" => "https://ossimg.yaaprwipayn.com/yaarwin/banner/Banner_20260429103413f448.png",
        "categoryType" => 0,
        "jumpLinkType" => 0,
        "vendorCode" => "",
        "gameCode" => "",
        "gameNameEn" => ""
    ],
    [
        "url" => "",
        "bannerUrl" => "https://ossimg.yaaprwipayn.com/yaarwin/banner/Banner_202604291034393dla.png",
        "categoryType" => 0,
        "jumpLinkType" => 0,
        "vendorCode" => "",
        "gameCode" => "",
        "gameNameEn" => ""
    ],
    [
        "url" => "",
        "bannerUrl" => "https://ossimg.yaaprwipayn.com/yaarwin/banner/Banner_20260429103501iudv.png",
        "categoryType" => 0,
        "jumpLinkType" => 0,
        "vendorCode" => "",
        "gameCode" => "",
        "gameNameEn" => ""
    ],
    [
        "url" => "",
        "bannerUrl" => "https://ossimg.yaaprwipayn.com/yaarwin/banner/Banner_202604291035221jwd.png",
        "categoryType" => 0,
        "jumpLinkType" => 0,
        "vendorCode" => "",
        "gameCode" => "",
        "gameNameEn" => ""
    ],
    [
        "url" => "",
        "bannerUrl" => "https://ossimg.yaaprwipayn.com/yaarwin/banner/Banner_20260429103629dquv.png",
        "categoryType" => 0,
        "jumpLinkType" => 0,
        "vendorCode" => "",
        "gameCode" => "",
        "gameNameEn" => ""
    ],
    [
        "url" => "",
        "bannerUrl" => "https://ossimg.yaaprwipayn.com/yaarwin/banner/Banner_20260429103722gvhf.png",
        "categoryType" => 0,
        "jumpLinkType" => 0,
        "vendorCode" => "",
        "gameCode" => "",
        "gameNameEn" => ""
    ]
];

echo json_encode([
    'data' => $banners,
    'code' => 0,
    'msg' => 'Succeed',
    'msgCode' => 0,
    'serviceNowTime' => date('Y-m-d H:i:s')
]);
