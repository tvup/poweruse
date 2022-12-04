<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class ChargesManualLoad extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'charges:manual-load';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $charges = [[[
            'name'=>'Netabo C forbrug skabelon/flex',
            'description' => 'Abonnement, hvor aftagepunktet typisk er i 0,4 kV-nettet med en årsaflæst måler',
            'owner' => '5790000705689',
            'validFromDate' => '2015-05-31T22:00:00.000Z',
            'validToDate' => null,
            'price' => 58.25,
            'quantity' => 1]],
            [[
                'name' => 'Transmissions nettarif',
                'description' => 'Netafgiften, for både forbrugere og producenter, dækker omkostninger til drift og vedligehold af det overordnede elnet (132/150 og 400 kv nettet) og drift og vedligehold af udlandsforbindelserne.',
                'owner' => '5790000432752',
                'periodType' => 'P1D',
                'validFromDate' => '2014-12-31T23:00:00.000Z',
                'validToDate' => null,
                'prices' => [[
                    'position' => '1',
                    'price' => 0.049]
                ],
            ], [
                'name' => 'Systemtarif',
                'description' => 'Systemafgiften dækker omkostninger til forsyningssikkerhed og elforsyningens kvalitet.',
                'owner' => '5790000432752',
                'periodType' => 'P1D',
                'validFromDate' => '2014-12-31T23:00:00.000Z',
                'validToDate' => null,
                'prices' => [[
                    'position' => '1',
                    'price' => 0.061]
                ],
            ], [
                'name' => 'Balancetarif for forbrug',
                'description' => 'Balancetarif for forbrug',
                'owner' => '5790000432752',
                'periodType' => 'P1D',
                'validFromDate' => '2014-12-31T23:00:00.000Z',
                'validToDate' => null,
                'prices' => [[
                    'position' => '1',
                    'price' => 0.00229]
                ],
            ], [
                'name' => 'Elafgift',
                'description' => 'Elafgiften',
                'owner' => '5790000432752',
                'periodType' => 'P1D',
                'validFromDate' => '2015-05-31T22:00:00.000Z',
                'validToDate' => null,
                'prices' => [[
                    'position' => '1',
                    'price' => 0.723]
                ],
            ], [
                'name' => 'Nettarif C time',
                'description' => 'Nettarif C time',
                'owner' => '5790000705689',
                'periodType' => 'PT1H',
                'validFromDate' => '2019-04-30T22:00:00.000Z',
                'validToDate' => null,
                'prices' => [
                    [
                        'position' => '1',
                        'price' => 0.3028
                    ], [
                        'position' => '2',
                        'price' => 0.3028
                    ], [
                        'position' => '3',
                        'price' => 0.3028
                    ], [
                        'position' => '4',
                        'price' => 0.3028
                    ], [
                        'position' => '5',
                        'price' => 0.3028
                    ], [
                        'position' => '6',
                        'price' => 0.3028
                    ], [
                        'position' => '7',
                        'price' => 0.3028
                    ], [
                        'position' => '8',
                        'price' => 0.3028
                    ], [
                        'position' => '9',
                        'price' => 0.3028
                    ], [
                        'position' => '10',
                        'price' => 0.3028
                    ], [
                        'position' => '11',
                        'price' => 0.3028
                    ], [
                        'position' => '12',
                        'price' => 0.3028
                    ], [
                        'position' => '13',
                        'price' => 0.3028
                    ], [
                        'position' => '14',
                        'price' => 0.3028
                    ], [
                        'position' => '15',
                        'price' => 0.3028
                    ], [
                        'position' => '16',
                        'price' => 0.3028
                    ], [
                        'position' => '17',
                        'price' => 0.3028
                    ], [
                        'position' => '18',
                        'price' => 0.7885
                    ], [
                        'position' => '19',
                        'price' => 0.7885
                    ], [
                        'position' => '20',
                        'price' => 0.7885
                    ], [
                        'position' => '21',
                        'price' => 0.3028
                    ], [
                        'position' => '22',
                        'price' => 0.3028
                    ], [
                        'position' => '23',
                        'price' => 0.3028
                    ], [
                        'position' => '24',
                        'price' => 0.3028
                    ]

                ],
            ]
            ]];
        $expiresAt = Carbon::now()->addDay()->startOfDay();
        $key = 'charges ' . 'info@butikkenvedhojen.dk';
        cache([$key => $charges], $expiresAt);
        return Command::SUCCESS;
    }
}
