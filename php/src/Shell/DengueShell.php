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
    }

    public function main()
    {
        $this->Dengue->deleteAll([]);
        foreach ($this->regions as $region => $url) {
            $this->out("Fetching for region $region...");
            $this->fetchAndStoreData($region, $url);
        }
    }

    public function fetchAndStoreData($region, $url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $resp = curl_exec($curl);

        $results = json_decode($resp);

        $data = [];
        $coord = [];

        $converter = new SVY21Converter();
        $noOfPeopleInfected = 0;

        for ($i = 1; $i <= $results->SrchResults[0]->FeatCount; $i++) {
            $r = $results->SrchResults[$i];
            $noOfPeopleInfected += intval(explode(":", $r->NAME));
            $xy = explode(",", explode("|", $r->XY)[0]);
            $coord = $converter->onemap_compute($xy[0], $xy[1]);
        }

        $data[] = [
                'region' => $region,
                'noOfPeopleInfected' => $noOfPeopleInfected,
                'latitude' => $coord['lat'],
                'longitude' => $coord['lng'],
                'radius' => 10
            ];

        $dengues = $this->Dengue->newEntities($data);

        foreach ($dengues as $dengue) {
            $this->Dengue->save($dengue);
        }
    }
}