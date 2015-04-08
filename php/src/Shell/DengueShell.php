<?php

namespace App\Shell;

use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;

class DengueShell extends Shell
{
    var $regions = [
        'central' => 'http://www.onemap.sg/API/services.svc/mashupData?token=qo/s2TnSUmfLz+32CvLC4RMVkzEFYjxqyti1KhByvEacEdMWBpCuSSQ+IFRT84QjGPBCuz/cBom8PfSm3GjEsGc8PkdEEOEr&themeName=DengueCase_Central_Area&otptFlds=AREANAME&extents=-4423.6,15672.6,69773.4,52887.4',
        'northeast' => 'http://www.onemap.sg/API/services.svc/mashupData?token=qo/s2TnSUmfLz+32CvLC4RMVkzEFYjxqyti1KhByvEacEdMWBpCuSSQ+IFRT84QjGPBCuz/cBom8PfSm3GjEsGc8PkdEEOEr&themeName=DengueCase_Northeast_Area&otptFlds=AREANAME&extents=-4423.6,15672.6,69773.4,52887.4',
        'northwest' => 'http://www.onemap.sg/API/services.svc/mashupData?token=qo/s2TnSUmfLz+32CvLC4RMVkzEFYjxqyti1KhByvEacEdMWBpCuSSQ+IFRT84QjGPBCuz/cBom8PfSm3GjEsGc8PkdEEOEr&themeName=DengueCase_Northwest_Area&otptFlds=AREANAME&extents=-4423.6,15672.6,69773.4,52887.4',
        'southeast' => 'http://www.onemap.sg/API/services.svc/mashupData?token=qo/s2TnSUmfLz+32CvLC4RMVkzEFYjxqyti1KhByvEacEdMWBpCuSSQ+IFRT84QjGPBCuz/cBom8PfSm3GjEsGc8PkdEEOEr&themeName=DengueCase_Southeast_Area&otptFlds=AREANAME&extents=-4423.6,15672.6,69773.4,52887.4',
        'southwest' => 'http://www.onemap.sg/API/services.svc/mashupData?token=qo/s2TnSUmfLz+32CvLC4RMVkzEFYjxqyti1KhByvEacEdMWBpCuSSQ+IFRT84QjGPBCuz/cBom8PfSm3GjEsGc8PkdEEOEr&themeName=DengueCase_Southwest_Area&otptFlds=AREANAME&extents=-4423.6,15672.6,69773.4,52887.4',
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
            $noOfPeopleInfected = intval(explode(":", $r->NAME));
            $p = explode("|", $r->XY);
            $p1 = explode(",", $p[0]);
            $p2 = explode(",", $p[1]);
            $p3 = explode(",", $p[2]);
            $p4 = explode(",", $p[3]);

            $p1 = $converter->onemap_compute($p1[1], $p1[0]);
            $p2 = $converter->onemap_compute($p2[1], $p2[0]);
            $p3 = $converter->onemap_compute($p3[1], $p3[0]);
            $p4 = $converter->onemap_compute($p4[1], $p4[0]);

            $topMid = $this->midPoint($p1['lat'], $p1['lng'], $p2['lat'], $p2['lng']);
            $btmMid = $this->midPoint($p3['lat'], $p3['lng'], $p4['lat'], $p4['lng']);
            $centerMid = $this->midPoint($topMid[0], $topMid[1], $btmMid[0], $btmMid[1]);
            $radius = $this->getDistanceFromLatLonInM($topMid[0], $topMid[1], $centerMid[0], $centerMid[1]);

            $severity = 'Normal';

            if ($noOfPeopleInfected >= 10){
                $severity = 'Alert';
            } elseif ($noOfPeopleInfected > 0) {
                $severity = 'Warning';
            }

            $data[] = [
                'region' => $region,
                'noOfPeopleInfected' => $noOfPeopleInfected,
                'latitude' => $centerMid[0],
                'longitude' => $centerMid[1],
                'radius' => $radius,
                'severity' => $severity
            ];

            $totalNoOfPeopleInfected += $noOfPeopleInfected;
        }

        $severity = 'Normal';

        if ($noOfPeopleInfected >= 10){
            $severity = 'Alert';
        } elseif ($noOfPeopleInfected > 0) {
            $severity = 'Warning';
        }

        $total[] = [
                'region' => $region,
                'noOfPeopleInfected' => $totalNoOfPeopleInfected,
                'severity' => $severity
            ];

        $denguestat = $this->DengueStat->newEntities($total);

        foreach ($denguestat as $stat) {
            $this->DengueStat->save($stat);
        }

        $dengues = $this->Dengue->newEntities($data);

        foreach ($dengues as $dengue) {
            $this->Dengue->save($dengue);
        }
    }
}