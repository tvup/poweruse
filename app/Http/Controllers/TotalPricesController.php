<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TotalPricesController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return View
     */
    public function __invoke(Request $request): View
    {
        $data = session('data');
        $chart = session('chart');

        $companies = cache()->remember('companies-list for total prices', Carbon::now('Europe/Copenhagen')->endOfDay(), function () {
            $toDay = Carbon::now('Europe/Copenhagen')->startOfDay()->toDateString();
            $results = DB::connection('mysql')->select(DB::raw("
                SELECT GLN_Number, concat(concat(ChargeOwner, ' '), Note) as tariff, Note, ChargeOwner
                FROM datahub_price_lists
                WHERE
                    '" . $toDay . "' between ValidFrom and ValidTo
                AND GLN_Number IN (SELECT SUBSTRING(grid_operator_gln,
                                                      1,
                                                      CHAR_LENGTH(grid_operator_gln) - 4)
                                     FROM charge_groups
                                     WHERE charge_group_2 = 'C')
                  AND ChargeType = 'D03'
                  AND Note NOT IN ( " . list_of_tariffs_for_non_private_consumers() . "
                    )
                group by ChargeOwner, Note, GLN_Number
            "));
            return array_map(function ($record) {
                $key = $record->ChargeOwner . '//' . $record->Note;

                return [$key => $record->tariff];
            }, $results);
        });


        return view('totalprices')->with('data', $data ?: null)->with('chart', $chart ?: null)->with('companies', $companies);
    }
}
