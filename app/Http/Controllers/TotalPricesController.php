<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TotalPricesController extends Controller
{


    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return View
     */
    public function __invoke(Request $request) : View
    {
        $data = session('data');
        $chart = session('chart');
        $results = DB::select( DB::raw("
            SELECT GLN_Number, concat(concat(ChargeOwner, ' '), Note) as tariff, Note, ChargeOwner
            FROM ".config('database.connections.mysql.database').".datahub_price_lists
            WHERE GLN_Number IN (SELECT SUBSTRING(grid_operator_gln,
                                                  1,
                                                  CHAR_LENGTH(grid_operator_gln) - 4)
                                 FROM ".config('database.connections.mysql.database').".charge_groups
                                 WHERE charge_group_2 = 'C')
              AND ChargeType = 'D03'
              AND Note NOT IN ('Nettarif A0', 'Nettarif A høj',
                               'Nettarif A lav',
                               'Nettarif B høj',
                               'Nettarif B høj særtarif',
                               'Nettarif B lav time',
                               'Nettarif B lav særtarif',
                               'Net rådighedstarif B lav',
                               'Rådighedstarif BH - TREFOR',
                               'Rådighedstarif BL - TREFOR',
                               'Rådighedstarif BH niveau',
                               'Rådighedstarif BL',
                               'Net rådighedstarif B høj',
                               'Nettarif A - Transportbetaling TREFOR',
                               'Nettarif A0 - Transportbetaling',
                               'Nettarif A0 - Transportbetaling TREFOR',
                               'Nettarif A høj (fritaget for energisparebidrag)',
                               'Nettarif A lav (fritaget for energisparebidrag)',
                               'Nettarif BH - Transportbetaling',
                               'Nettarif BH - Transportbetaling TREFOR',
                               'Nettarif B høj (fritaget for energisparebidrag)',
                               'Nettarif B høj (selvejer.)',
                               'Nettarif BH - selvejer',
                               'Nettarif BH - Transportbetaling',
                               'Nettarif BH - Transportbetaling TREFOR',
                               'Nettarif indfødning A høj',
                               'Nettarif indfødning A lav',
                               'Nettarif indfødning B høj',
                               'Nettarif indfødning B høj særtarif',
                               'Nettarif indfødning B lav',
                               'Nettarif indfødning B lav særtarif',
                               'Net rådighedstarif A',
                               'Net rådighedstarif A lav', 'Nettarif B lav',
                               'Nettarif B lav (fritaget for energisparebidrag)',
                               'Nettarif B høj time', 'Nettarif  B høj', 'Rabat på Nettarif A lav - KONSTANT Net A/S',
                               'Rabat på Nettarif B lav - KONSTANT Net A/S',
                               'Net rådighedstarif A høj', 'Nettarif B Lav produktion',
                               'Nettarif B Høj produktion',
                               'Nettarif B Lav (Rabat)',
                               'Nettarif B Lav produktion (Rabat)', 'Nettarif A Høj produktion',
                               'Nettarif A Lav produktion',
                               'Nettarif A Høj (Rabat)',
                               'Nettarif A Høj produktion (Rabat)',
                               'Nettarif A Lav (Rabat)',
                               'Nettarif A Lav produktion (Rabat)',
                               'Nettarif B Høj (Rabat)',
                               'Nettarif B Høj produktion (Rabat)', 'Nettarif B lav time - Affald',
                               'Overliggende net',
                               'Nettarif B lav time (Rabat)',
                               'Nettarif A lav egenprod',
                               'Rabat på Nettarif B lav (fritaget for energisparebidrag) - KONSTANT Net A/S',
                               'Nettarif B lav 20 GWh',
                               'Nettarif overordnet net - rabat tidsdifferentieret',
                               'Nettarif overordnet net - tidsdifferenceret',
                               'Nettarif B høj varmeproduktion', 'Nettarif A lav (DNU)',
                               'Rabat på Nettarif A lav (DNU) - KONSTANT Net A/S',
                               'Nettarif overordnet net',
                               'Rabat på Nettarif A0 - KONSTANT Net A/S', 'Nettarif overordnet net  NT-11',
                               'Transport - Overordnet net (time)',
                               'Transport - Overordnet net (time) (Rabat)',
                               'B Tarif  50/10 kV Net Transport betaling til Forsyning Helngør Elnet',
                               'B Tarif Net 0,4 kV Transport  betaling til Forsyning Helsingør El net',
                               'Nettarif B lav produktion time', 'Nettarif B lav produktion time (Rabat)',
                               'Rabat på Nettarif A høj (fritaget for energisparebidrag) - KONSTANT Net A/S',
                               'Nettarif B lav varmeproduktion', 'Nettarif indfødning - Overordnet net NT-90',
                               'Rabat på Nettarif A høj - KONSTANT Net A/S',
                               'Rabat på Nettarif A høj - KONSTANTNet A/S',
                               'Indfødningstarif A Høj',
                               'Indfødningstarif A Lav',
                               'Indfødningstarif B Høj',
                               'Indfødningstarif B Lav',
                               'Nettarif A høj, tidsdifferentieret',
                               'Nettarif A lav forbrug elkedel, tidsdifferentieret',
                               'Nettarif A lav, tidsdifferentieret',
                               'Netarif B høj forbrug Elkedel, tidsdifferentieret',
                               'Nettarif B høj, tidsdifferentieret',
                               'Netarif B lav forbrug Elkedel, tidsdifferentieret',
                               'Nettarif B lav time, tidsdifferentieret',
                               'Transport 0,4, 10 og 60 kV',
                               'Transport 0,5, 10 og 60 kV',
                               'Bindende midlertidig tarifnedsættelse A',
                               'Bindende midlertidig tarifnedsættelse B-høj',
                               'Bindende midlertidig tarifnedsættelse B-lav',
                               'Nettarif indfødning A høj plus',
                               'Ekstraordinært net abo A - NRGi A/S',
                               'Rabat på netarif A lav - NRGi A/S',
                               'Rabat på nettarif A - NRGi Net A/S',
                               'Rabat på nettarif A lav - NRGi AS',
                               'Rabat på nettarif A lav - NRGi Net A/S',
                               'Rabat på nettarif NRGi AS',
                               'Rabat på nettarif B -  NRGi Net A/S',
                               'Rabat på nettarif B - NRGi Net A/S',
                               'Rabat på nettarif B lav -   NRGi Net A/S',
                               'Rabat på nettarif B lav -  NRG Net AS',
                               'Rabat på nettarif B lav -  NRGi A/S',
                               'Rabat på nettarif B lav -  NRGi AS',
                               'Rabat på Nettarif B lav - NRGi Net A/S',
                               'Rabat på nettarif A -  NRGi Net A/S',
                               'Rabat på nettarif A lav -   NRGi Net A/S',
                               'Rabat på nettarif A lav -  NRGi A/S',
                               'Rabat på nettarif A lav -  NRGi AS',
                               'Rabat på nettarif A lav -  NRGi Net A/S',
                               'Rabat på Nettarif A lav (DNU) - NRGi Net A/S',
                               'Rabat på Nettarif B høj - KONSTANT Net A/S',
                               'Nettarif A - NRGi Net A/S',
                               'Nettarif A lav -  NRGi Net A/S',
                               'Nettarif A lav - NRGi Net A/s',
                               'Nettarif A lav - NRGi Net AS',
                               'Nettarif NRGi Net AS',
                               'Nettarif B - NRGi Net A/S',
                               'Nettarif B lav time -  NRGi Net A/S',
                               'Nettarif B lav time - NRGi Net AS',
                               'Nettarif A lav  NRGi Net A/S',
                               'Nettarif A lav NRGi Net AS',
                               'Nettarif A NRGi Net A/S',
                               'Net rådighedstarif B - NRGi Net A/S',
                               'Net rådighedstarif B lav - NRGi Net A/S',
                               'Net rådighedstarif B lav - NRGi Net AS',
                               'Net rådighedstarif A - NRGi Net A/S',
                               'Net rådighedstarif A lav - NRGi Net A/S',
                               'Net rådighedstarif A lav - NRGi Net AS',
                               'B-kunder',
                               'Nettarai B lav time',
                               'Trans-lokalnet',
                               'Nettarif A lav time NT-40',
                               'Rabat på nettarif A - NRGi A/S',
                               'Rabat på nettarif B -  NRGi A/S',
                               'Rabat på nettarif B lav Time -  NRGi AS',
                               'Rabat på nettarif B lav Time -  NRGi Net A/S',
                               'Nettarif B lav - NRGi Net AS',
                               'Net Rådiighedstarif B - NRGi Net A/S',
                               'Rådighedstarif B-lav',
                               'Rådighedstarif B-høj',
                               'Transport af el - B1',
                               'Nettarif B lav skabelon (gadelys)',
                               'Nettarif A0 - Bindende midlertidig tarifnedsættelse',
                               'Nettarif A0 (u/energisparebidr.) - Bindende midl. tarifneds.',
                               'Nettarif A høj - Bindende midlertidig tarifnedsættelse',
                               'Nettarif A høj (u/energisparebidr.) - Bind. midl. tarifneds.',
                               'Nettarif A lav - Bindende midlertidig tarifnedsættelse',
                               'Nettarif A lav (u/energisparebidr.) - Bind. midl. tarifneds.',
                               'Nettarif B høj - Bindende midlertidig tarifnedsættelse',
                               'Nettarif B høj (u/energisparebidr.) - Bind. midl. tarifneds.',
                               'Nettarif B lav (u/energisparebidr.) - Bind. midl. tarifneds.',
                               'Nettarif B lav time - Bindende midlertidig tarifnedsættelse',
                               'Nettarif A',
                               'Nettarif A0 (fritaget for energispa',
                               'Nettarif A høj (bev.)',
                               'Nettarif A høj (fritaget for energi',
                               'Nettarif A lav (bev.)',
                               'Nettarif A lav (fritaget for energi',
                               'Nettarif B',
                               'Nettarif B høj (bev)',
                               'Nettarif B høj (fritaget for energi',
                               'Nettarif B lav (bev.)',
                               'Nettarif B lav (fritaget for energi',
                               'Nettarif B lav skabelon',
                               'Nettab',
                               'Timetarif for nettab',
                               'Net rådighedstarif B',
                               'Transport af el - B2',
                               'Nettarif B-Lav time',
                               'Transportbetaling M-BL',
                               'Transportbetaling M-BL2',
                               'Transportbetaling M-BL1',
                               'Transportbetaling M-BH',
                               'Nettarif B-lav',
                               'Transportbetaling B-lav',
                               'Nettarif B-høj',
                               'Transportbetaling B-høj',
                               'Nettarif A-Høj',
                               'Nettarif A-Lav',
                               'Transportbetaling, eget net A',
                               'Transportbetaling, eget net A Lav',
                               'Transportbetaling B - SK Net',
                               'Transportbetaling, eget net A Høj',
                               'Rådighedsbetaling B-lav',
                               'Indfødningstarif',
                               'Nettarif Læsø Elnet A-lav',
                               'Nettarif A-lav time',
                               'Nettarif Læsø Elnet B-lav',
                               'Nettarif Læsø Elnet B-høj',
                               'Transportbetaling, eget net A Lav -egen bevil.',
                               'Transportbetaling, eget net B',
                               'Transportbetaling, eget net B Lav',
                               'Transportbetaling, eget net B Høj',
                               'Indfødningstarif  Læsø Elnet A/S A-lav',
                               'Indfødningstarif Læsø Elnet A/S A-lav',
                               'Indfødningstarif Læsø Elnet A/S B-lav',
                               'Indfødningstarif Læsø Elnet A/S B-høj',
                               'A-lav rådighedstarif',
                               'B-høj rådighedstarif',
                               'B-lav rådighedstarif',
                               'Nettarif indfødning A høj plus maske',
                               'Nettarif  B lav time',
                               'Nettarif B2',
                               'Nettarif - Alm. 10/0,4kV',
                               'Nettarif - B Tarif 10/0,4 kV',
                               'Lokal indfødningsnettarif',
                               'Regional indfødningsnettarif B lav',
                               'Indfødningstarif A-Lav',
                               'Indfødningstarif B-Høj',
                               'Indfødningstarif B-Lav',
                               'A høj',
                               'A Højspænding',
                               'Nettarif A høj (fritaget  for \r\nenergisparebidrag)',
                               'Nettarif A høj (fritaget  for energisparebidrag)',
                               'Nettarif A høj - kollektiv varmeproduktion\r\n\r\n',
                               'Nettarif A høj - kollektiv varmeproduktion',
                               'A lav',
                               'Nettarif A lav (fritaget  for \r\nenergisparebidrag)',
                               'Nettarif A lav (fritaget  for energisparebidrag)',
                               'Nettarif A lav (bev.)\r\n',
                               'Nettarif A lav\r\n',
                               'Nettarif A lav - kollektiv varmeproduktion\r\n',
                               'A lav - uden afgift',
                               'Nettarif A lav - uden afgift',
                               'A lav - egen netbevilling',
                               'Nettarif A lav - kollektiv varmeproduktion',
                               'A-lav 200GWh',
                               'Nettarif A 200GWH',
                               'Tarif overliggende net Radius',
                               'B-Lav Kunde tarif',
                               'B høj',
                               'Nettarif B høj (fritaget for \r\nenergisparebidrag)',
                               'Net rådighedtarif B høj\r\n',
                               'Nettarif B høj - kollektiv varmeproduktion\r\n',
                               'B høj - uden afgift',
                               'Nettarif B høj - uden afgift',
                               'B høj - udveksling',
                               'Nettarif B høj - udveksling',
                               'Nettarif B høj - kollektiv varmeproduktion',
                               'B lav',
                               'Nettarif B lav (fritaget  for \r\nenergisparebidrag)',
                               'Nettarif B lav (fritaget  for energisparebidrag)',
                               'Nettarif B lav (bev.)\r\n',
                               'Nettarif B lav - kollektiv varmeproduktion\r\n',
                               'Nettarif B lav time\r\n',
                               'B lav - skabelon 6 regninger',
                               'Nettarif B lav - skabelon 6 regninger',
                               'B lav - uden afgift',
                               'Nettarif B lav - uden afgift',
                               'B lav - skabelon',
                               'B lav - egen netbevilling',
                               'Nettarif B lav - egen netbevilling',
                               'Nettarif B lav - kollektiv varmeproduktion',
                               'B-lav 20GWh',
                               'Nettarif B 20GWh',
                               'Nettarif B lav skabelon\r\n',
                               'B lav - uden måler',
                               'Nettarif B lav - uden måler',
                               'B lav - nettoafregnet',
                               'Nettarif B lav - nettoafregnet',
                               'A høj rådighedstarif',
                               'A lav rådighedstarif',
                               'B høj rådighedstarif',
                               'B lav rådighedstarif',
                               'Netrådighedstarif A høj',
                               'Netrådighedstarif A lav',
                               'Netrådighedstarif B høj',
                               'Netrådighedstarif B lav',
                               'Nettarif B høj overliggende net (time)',
                               'Nettarif B lav overliggende net (time)',
                               'Nettarif B lav time lokalt net',
                               'Nettarif overliggende net 60/10 (time)',
                               'Nettarif B høj uden aftagepligt',
                               'Nettarif B høj overliggende net (time) (rabat)',
                               'Nettarif B lav overliggende net (time) (rabat)',
                               'Nettarif overliggende net 60/10 (time) (rabat)',
                               'Nettarif overliggende net 60/10 (time)(rabat)',
                               'Nettarif overliggende net 60/10 (time)(rabet)',
                               'Rådighedsbetaling Net B1 kunder',
                               'Rådighedstarif EM B1 kunder',
                               'Net Rådighedstarif B høj (rabat)',
                               'Transportbetaling overliggende net',
                               'Nettarif B høj overliggende net',
                               'Transportbetaling overl.net B1 kunder',
                               'Nettarrif B lav overliggende net',
                               'Overliggende net - B1 Kunde',
                               'Overliggende net B1',
                               'Net rådighedstarif  A lav',
                               'Tarif for VE A-kunder',
                               'Tarif for VE B-kunder',
                               'Indfødningstarif B-lav uden aftagepligt',
                               'Indfødningstarif B-høj uden aftagepligt',
                               'Indfødningstarif A uden aftagepligt',
                               'Nettarif VE - B1 Kunde',
                               'Nettarif VE- B1 Kunde',
                               'Nettarif VE B2 Kunder',
                               'Nettarif B-høj vindmølle',
                               'Nettarif Vindmøller B-høj',
                               'Nettarif B lav vindmølle',
                               'Nettarif B-lav vindmølle',
                               'Nettarif B lav egen station time',
                               'Nettarif B høj vindmølle',
                               'Nettarif Vindmølle B-høj',
                               'Nettarif Vindmølle B-lav',
                               'Nettarif B-høj produktion',
                               'Nettarif B-lav produktion',
                               'Nettarif Produktion B-høj',
                               'Nettarif Produktion B-lav',
                               'Rådighedstarif A-Høj',
                               'Rådighedstarif A-Lav',
                               'Raadighedsbetaling nettoafregning',
                               'Rabat - Nettarif indfødning A høj',
                               'Rabat - Net rådighedstarif A høj',
                               'Net tarif A høj',
                               'Rabat - Nettarif A høj',
                               'Rabat - Nettarif indfødning A lav',
                               'Rabat - Net rådighedstarif A lav',
                               'Rabat - Nettarif A lav',
                               'Nettarif B lav time uden LES',
                               'Nettarif B lav flex, tidsdifferentieret',
                               'Nettarif B lav time med forbrug over 20 GWh, tidsdifferentieret',
                               'Nettarif B lav time med forbrug over 20 GWh',
                               'Rabat - Nettarif indfødning B høj',
                               'Rabat - Net rådighedstarif B høj',
                               'Rabat - Nettarif B høj (fritaget for energisparebi',
                               'Rabat - Nettarif B høj',
                               'Rabat - Nettarif indfødning B lav',
                               'Rabat - Net rådighedstarif B lav',
                               'Rabat - Nettarif B lav (fritaget for energisparebi',
                               'Rabat - Nettarif B lav time',
                               'Nettarif Tarm Elværk Net',
                               'Nettarif Tarm Elværk Net B-lav',
                               'Nettarit B-lav time',
                               'Nettarit Tarm elværk net B-lav',
                               'Nettarif B-lav time rabat',
                               'Nettarif A-lav rabat',
                               'Nettarif B-lav uden aftagepligt',
                               'Nettarit B-høj uden aftagepligt',
                               'Transportbetaling over 100.000kWh',
                               'Nettarif BL - Transportbetaling',
                               'Nettarif BL - Transportbetaling TREFOR',
                               'Nettarif B lav - selvejer',
                               'Nettarif B lav (selvejer.)',
                               'Nettarif B høj (Fritaget for energibesparebidrag)',
                               'Rådighedstarif B høj',
                               'Netarif B lav forbrug Elkedel',
                               'DE nettarif B lav time',
                               'DE nettarif B lav skabelon',
                               'Rådighedstarif B lav',
                               'B-tarif - lavspænding',
                               'B-tarif - højspænding',
                               'Nettarif A lav forbrug elkedel',
                               'DE nettarif A lav',
                               'Netarif B høj forbrug Elkedel',
                               'DE nettarif B høj',
                               'DE nettarif A høj',
                               'DE nettarif A0',
                               'Regional nettarif B1',
                               'Regional nettarif høj',
                               'Lokal nettarif B1',
                               'Regional nettarif B2',
                               'Lokal nettarif B2',
                               'Net rådighedtarif B høj',
                               'Tilbagebetaling B-tarif',
                               'Tilbagebetaling A-tarif',
                               'Tilbagebetalingstarif A lav, egenprod',
                               'Tilbagebetalingstarif A lav',
                               'Rådighedstarif A',
                               'Rådighedstarif A - TREFOR',
                               'Net A høj+maske indfødning',
                               'Net A høj+ indfødning',
                               'Net A høj indfødning',
                               'Net A lav indfødning',
                               'Net B høj indfødning',
                               'Net B lav indfødning',
                               'Rådighedstarif nettoafregnede B1-kunder',
                               'Rådighedstarif nettoafregnede B2-kunder',
                               'Rabat på nettarif indfødning A høj - KONSTANT NET A/S',
                               'Rabat på nettarif indfødning A lav - KONSTANT NET A/S',
                               'Rabat på nettarif indfødning B høj - KONSTANT NET A/S',
                               'Rabat på nettarif indfødning B lav - KONSTANT NET A/S',
                               'Midlertidig tarifreduktion A',
                               'Midlertidig tarifreduktion B1',
                               'Midlertidig tarifreduktion B2',
                               'Nettransport B-forbrugere',
                               'Nettarif A-kunder',
                               'Nettarif B1-kunder',
                               'Nettarif B2-kunder',
                               'NETTARIF 60 KV',
                               'Nettarif - A høj',
                               'Transport i GEV Net (A1 kunde)',
                               'Transport i GEV Net (A1 netto kunde)',
                               'Nettarif - A lav',
                               'Transport i GEV Net (A2 kunde)',
                               'Nettarif - B høj',
                               'Transport i GEV Net (B1 kunde)',
                               'Nettarif - B lav',
                               'Transport i GEV Net (B2 kunde)',
                               'Transport i GEV Net (B3 kunde)',
                               'Nettarif - A-høj uden aftagepligt',
                               'Nettarif - A-lav uden aftagepligt',
                               'Nettarif - B-høj uden aftagepligt',
                               'Nettarif - A høj (rabat)',
                               'Nettarif - A lav (rabat)',
                               'Nettarif - B høj (rabat)',
                               'Nettarif - B lav (rabat)',
                               'Net indfødningstarif B lav',
                               'Net indfødningstarif B høj',
                               'Net indfødningstarif A lav',
                               'Netbetaling 60/20 kV HEF',
                               'Netbetaling 60/20 kV HEF Net',
                               'Netbetaling 60/20 kV N1 Net',
                               'Nettarif - B-lav uden aftagepligt',
                               'Nettarif 60/20 kV, N1',
                               'Energisparemål på 150 kV niveau',
                               'Energisparemål på 15/10 kV niveau',
                               'Nettarif - Transport - Overordnet net',
                               'Transport i overordnet net',
                               'Transport overordnet net',
                               'Transportbetaling 60kV-MT Net',
                               'Nettarif 60KV net og TME net time',
                               'Nettarif Indfødning 60 KV TME net',
                               'Hillerød Nettarif B høj',
                               'Hillerød Nettarif B lav',
                               'Hillerød Netrådighedstarif B lav',
                               'Netbetaling 20 kV Nibe Net',
                               'Nettarif 60 kV Energi Fyn',
                               'Nettarif B lav time  NT-20',
                               'Transportbetaling 60 kV-net, Fynsnet',
                               'Nettarif B høj (bev.)',
                               'Transportbetaling 60 kV-net',
                               'Nettarif Overliggende Net (60 kV-Net)',
                               'Nettarif Overliggende Net (FynsNet)',
                               'Nettarif rabat - B2+B1',
                               'Nettarif overliggende net'
                )
            group by ChargeOwner, Note, GLN_Number") );
        $companies = array_map(function ($record) {
            $key= $record->ChargeOwner . '//' . $record->Note;
            return [$key => $record->tariff];
        }, $results);

        return view('totalprices')->with('data', $data ? : null)->with('chart', $chart ? : null)->with('companies', $companies);
    }
}
