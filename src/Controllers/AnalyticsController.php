<?php

namespace CMS\Controllers;

use Google_Client;
use Google_Service_Analytics;
use http\Env;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    private $VIEW_ID; //env'den çekebiliriz..
    private $analytics;

    function __construct() {
        $this->VIEW_ID = env("VIEW_ID");
        $KEY_FILE_LOCATION = app_path( 'local-test-a22b0e8c360a.json');
        $client = new Google_Client();
        $client->setApplicationName("Analytics Reporting");
        $client->setAuthConfig($KEY_FILE_LOCATION);
        $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
        $this->analytics = new Google_Service_Analytics($client);
    }

    public function google(){
        return response()->json([
            'device' => $this->getDevice(),
            'page_views' => $this->pageViews(),
            'page_views_date' => $this->pageViewsDate(),
        ]);
    }
    //Son 30 günlük izleme.
    public function getDevice()
    {
        $result = $this->analytics->data_ga->get(
            'ga:'.$this->VIEW_ID,
            '30daysAgo',
            'today',
            'ga:pageViews',
            [
                'dimensions' => 'ga:deviceCategory'
            ]
        );

        $device[] = ['Browser' , 'Count'];
        foreach ($result->rows as $key => $row) {
            $device[++$key] = [$row[0],$row[1]];
        }
        return $device;
    }

    public function pageViews()
    {
        $result = $this->analytics->data_ga->get(
            'ga:'.$this->VIEW_ID,
            '30daysAgo',
            'today',
            'ga:pageViews',
    );

        return $result->rows[0][0];
    }

    public function pageViewsDate()
    {
        $result = $this->analytics->data_ga->get(
            'ga:'.$this->VIEW_ID,
            '30daysAgo',
            'today',
            'ga:pageViews',[
                'dimensions' => 'ga:date']
        );
        return $result->rows;

    }
}
