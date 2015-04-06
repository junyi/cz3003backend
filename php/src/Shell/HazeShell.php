<?php

namespace App\Shell;

use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;

class HazeShell extends Shell
{
    var $url = 'http://www.nea.gov.sg/api/WebAPI/?dataset=psi_update&keyref=781CF461BB6606ADFF9FEDFE7B872FDB37B699D4ACFA5CF4';
    var $regionCodes = [
        'NRS' => 'national',
        'rNO' => 'north',
        'rSO' => 'south',
        'rCE' => 'central',
        'rWE' => 'west',
        'rEA' => 'east'
    ];
    var $field = 'NPSI_PM25_3HR';

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Haze');
    }

    public function main()
    {
        $this->Haze->deleteAll([]);
        $this->fetchAndStoreData($this->url);
    }

    private function getAirQualityDescriptor($value)
    {
        $descriptor = 'Good';
        if ($value >= 0 && $value <= 50){
            $descriptor = "Good";
        } elseif ($value >= 51 && $value <= 100) {
            $descriptor = "Moderate";
        } elseif ($value >= 101 && $value <= 200) {
            $descriptor = "Unhealthy";
        } elseif ($value >= 201 && $value <= 300) {
            $descriptor = "Very unhealthy";
        } elseif ($value >= 301) {
            $descriptor = "Hazardous";
        }
        return $descriptor;
    }

    public function fetchAndStoreData($url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $resp = curl_exec($curl);

        $result = simplexml_load_string($resp);

        $data = [];

        foreach ($result->item->region as $region) {
            $reading = 0;

            foreach ($region->record->reading as $reading) {

                if (((string) $reading['type']) === $this->field) {

                    $reading = intval($reading['value']);

                    break;
                }
            }

            $descriptor = $this->getAirQualityDescriptor($reading);

            $data[] = [
                'region' => $this->regionCodes[(string)$region->id],
                'psiValue' => $reading,
                'airQualityDescriptor' => $descriptor
            ];

        }

        $hazes = $this->Haze->newEntities($data);

        foreach ($hazes as $haze) {
            $this->Haze->save($haze);
        }

    }
}