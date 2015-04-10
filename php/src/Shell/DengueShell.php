<?php

namespace App\Shell;

use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;

class DengueShell extends Shell
{
    var $regions = [
        'cluster' => 'http://www.onemap.sg/API/services.svc/mashupData?token=qo/s2TnSUmfLz+32CvLC4RMVkzEFYjxqyti1KhByvEacEdMWBpCuSSQ+IFRT84QjGPBCuz/cBom8PfSm3GjEsGc8PkdEEOEr&themeName=DENGUE_CLUSTER&otptFlds=NAME&extents=-4423.6,15672.6,69773.4,52887.4'
    ];

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Dengue');
        $this->loadModel('DengueStat');
    }

    public function main()
    {
        $this->Dengue->deleteAll([]);
        $this->DengueStat->deleteAll([]);
        foreach ($this->regions as $region => $url) {
            $this->out("Fetching for region $region...");
            $this->fetchAndStoreData($region, $url);
        }
    }

    public function midPoint($lat1, $lon1, $lat2, $lon2){

        $dLon = deg2rad($lon2 - $lon1);

        //convert to radians
        $lat1 = deg2rad($lat1);
        $lat2 = deg2rad($lat2);
        $lon1 = deg2rad($lon1);

        $Bx = cos($lat2) * cos($dLon);
        $By = cos($lat2) * sin($dLon);
        $lat3 = rad2deg(atan2(sin($lat1) + sin($lat2), sqrt((cos($lat1) + $Bx) * (cos($lat1) + $Bx) + $By * $By)));
        $lon3 = rad2deg($lon1 + atan2($By, cos($lat1) + $Bx));

        return [$lat3, $lon3];
    }

    public function getDistanceFromLatLonInM($lat1, $lon1, $lat2, $lon2) {
        $R = 6371000; // Radius of the earth in m
        $dLat = deg2rad($lat2-$lat1);  // deg2rad below
        $dLon = deg2rad($lon2-$lon1); 
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a)); 
        $d = $R * $c; // Distance in m
        return $d;
    }

    public function fetchAndStoreData($region, $url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $resp = curl_exec($curl);

        $results = json_decode($resp);

        $total = [];
        $coord = [];
        $data = [];

        $converter = new SVY21Converter();
        $totalNoOfPeopleInfected = 0;

        for ($i = 1; $i <= $results->SrchResults[0]->FeatCount - 1; $i++) {
            $r = $results->SrchResults[$i];
            $region = $r->DESCRIPTION;
            $noOfPeopleInfected = intval(explode(":", $r->NAME));
            $p = explode("|", $r->XY);

            $convertedPoints = [];

            for ($j = 0; $j < count($p); $j++) {
                $point = explode(",", $p[$j]);
                $point = $converter->onemap_compute($point[1], $point[0]);
                array_push($convertedPoints, $point['lat'].",".$point['lng']);
            }

            $severity = 'Normal';

            if ($noOfPeopleInfected >= 10){
                $severity = 'Alert';
            } elseif ($noOfPeopleInfected > 0) {
                $severity = 'Warning';
            }

            $data[] = [
                'region' => $region,
                'noOfPeopleInfected' => $noOfPeopleInfected,
                'polygon' => implode("|", $convertedPoints),
                'severity' => $severity
            ];

            $totalNoOfPeopleInfected += $noOfPeopleInfected;
        }

        $severity = 'Normal';

        $dengues = $this->Dengue->newEntities($data);

        foreach ($dengues as $dengue) {
            $this->Dengue->save($dengue);
        }
    }
}