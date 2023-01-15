<?php

namespace App\Services;

use App\Models\ChargeGroup;
use Illuminate\Support\Facades\Http;

class GetEnergiDataServiceChargeGroups
{
    /**
     * @return array
     */
    public function requestChargeGroups(int $limit = 100, int $offset = 0): array
    {
        $url = 'https://api.energidataservice.dk/dataset/ChargeGroupYear?limit=' . $limit . '&offset=' . $offset;

        return Http::acceptJson()
            ->get($url)->json('records');
    }

    /**
     * @return ChargeGroup
     */
    public function getChargeGroup(string $chargeOwner): ChargeGroup
    {
        $chargeGroup = new ChargeGroup();
        switch ($chargeOwner) {
            case 'Energinet Systemansvar A/S (SYO)':
                $chargeGroup->grid_operator_gln = '5790000432752-DDM';

                return $chargeGroup;
            case 'Vores Elnet A/S - 554':
                $chargeGroup->grid_operator_gln = '5790000610976-DDM';

                return $chargeGroup;
            case 'UDGÅET - N1 A/S - 044':
                $chargeGroup->grid_operator_gln = '5790000610860-DDM';

                return $chargeGroup;
            case 'N1 A/S - 344':
                $chargeGroup->grid_operator_gln = '5790000611003-DDM';

                return $chargeGroup;
            case 'Netselskabet Elværk A/S - 042':
                $chargeGroup->grid_operator_gln = '5790000681075-DDM';

                return $chargeGroup;
            case 'Netselskabet Elværk A/S - 331':
                $chargeGroup->grid_operator_gln = '5790000681358-DDM';

                return $chargeGroup;
            case 'UDGÅET - MES Net A/S':
                $chargeGroup->grid_operator_gln = '5790000682225-DDM';

                return $chargeGroup;
            case 'UDGÅET - N1 A/S - 052':
                $chargeGroup->grid_operator_gln = '5790000683291-DDM';

                return $chargeGroup;
            case 'Vores Elnet A/S - 553':
                $chargeGroup->grid_operator_gln = '5790000683321-DDM';

                return $chargeGroup;
            case 'UDGÅET - VOS Net A/S':
                $chargeGroup->grid_operator_gln = '5790000701223-DDM';

                return $chargeGroup;
            case 'UDGÅET - Evonet A/S - 023':
                $chargeGroup->grid_operator_gln = '5790000701254-DDM';

                return $chargeGroup;
            case'UDGÅET - RAH Net A/S - 359':
                $chargeGroup->grid_operator_gln = '5790001088163-DDM';

                return $chargeGroup;
            case 'Vores Elnet A/S - 552':
                $chargeGroup->grid_operator_gln = '5790001088187-DDM';

                return $chargeGroup;
            case 'Cerius A/S (Vordingborg)':
                $chargeGroup->grid_operator_gln = '5790001088248-DDM';

                return $chargeGroup;
            case 'N1 A/S - 131':
                $chargeGroup->grid_operator_gln = '5790001089030-DDM';

                return $chargeGroup;
            case 'Vores Elnet A/S - 587':
                $chargeGroup->grid_operator_gln = '5790001089108-DDM';

                return $chargeGroup;
            case 'Vores Elnet A/S - 592':
                $chargeGroup->grid_operator_gln = '5790001089313-DDM';

                return $chargeGroup;
            case 'Midtfyns Elforsyning A.m.b.A. - 591':
                $chargeGroup->grid_operator_gln = '5790001089399-DDM';

                return $chargeGroup;
            case 'Vores Elnet A/S - 588':
                $chargeGroup->grid_operator_gln = '5790001090074-DDM';

                return $chargeGroup;
            case 'Vores Elnet A/S - 590':
                $chargeGroup->grid_operator_gln = '5790001090081-DDM';

                return $chargeGroup;
            case'Midtfyns Elforsyning A.m.b.A. - 589':
                $chargeGroup->grid_operator_gln = '5790001090128-DDM';

                return $chargeGroup;
            case 'UDGÅET - Ærø Elforsyning Net A/S':
                $chargeGroup->grid_operator_gln = '5790001095185-DDM';

                return $chargeGroup;
            case 'UDGÅET - N1 A/S - 146':
                $chargeGroup->grid_operator_gln = '5790001095192-DDM';

                return $chargeGroup;
            case 'Kimbrer Elnet A/S':
                $chargeGroup->grid_operator_gln = '5790001095239-DDM';

                return $chargeGroup;
            case 'UDGÅET - Nibe El-Forsyning Netvirksomhed A.m.b.a.':
                $chargeGroup->grid_operator_gln = '5790001095246-DDM';

                return $chargeGroup;
            case 'Aars-Hornum Net A/S - 014':
                $chargeGroup->grid_operator_gln = '5790001095253-DDM';

                return $chargeGroup;
            case 'UDGÅET - Kjellerup Elnet A/S':
                $chargeGroup->grid_operator_gln = '5790001095338-DDM';

                return $chargeGroup;
            case 'UDGÅET - Kibæk Elværk A M B A':
                $chargeGroup->grid_operator_gln = '5790001095345-DDM';

                return $chargeGroup;
            case 'UDGÅET - Nord Energi Net A/S - 096':
                $chargeGroup->grid_operator_gln = '5790001102968-DDM';

                return $chargeGroup;
            case 'UDGÅET - Hirtshals El-Netselskab A/S':
                $chargeGroup->grid_operator_gln = '5790001103170-DDM';

                return $chargeGroup;
            default:
                return ChargeGroup::whereGridOperatorName($chargeOwner)->firstOrFail();
        }
    }
}
