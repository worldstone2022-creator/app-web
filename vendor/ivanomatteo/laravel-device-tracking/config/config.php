<?php


use IvanoMatteo\LaravelDeviceTracking\DeviceHijackingDetectorDefault;

return [
    // if user_model is null, will be probed: App\Model\User and then App\User
    'user_model' => null,

    // if user_model is App\Model\User, model_relation_id will be user_id
    'model_relation_id' => 'user_id',

    'device_table' => 'track_devices',

    'detect_on_login' => true,

    'geoip_provider' => null, // must implement: IvanoMatteo\LaravelDeviceTracking\GeoIpProvider

    // the device identifier cookie
    'device_cookie' => 'device_uuid',

    'cookie_http_only' => true,

    'session_key' => 'laravel-device-tracking',

    // must implement: IvanoMatteo\LaravelDeviceTracking\DeviceHijackingDetector
    'hijacking_detector' => DeviceHijackingDetectorDefault::class,
];
