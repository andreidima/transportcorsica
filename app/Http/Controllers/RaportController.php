<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Rezervare;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Illuminate\Support\Facades\Storage;

use Illuminate\Database\Eloquent\Builder;

use App\Traits\TrimiteSmsTrait;

class RaportController extends Controller
{
    use TrimiteSmsTrait;

    public function rapoarte(Request $request, $tip_transport = null){
        // dd(\Request::get('search_data'), \Carbon\Carbon::today()->dayOfWeek, \Carbon\Carbon::today()->addDays(1));
        if (\Request::get('search_data')){
            $search_data = \Request::get('search_data');
        } else {
            switch (\Carbon\Carbon::today()->dayOfWeek){
                case 0:
                    $search_data = \Carbon\Carbon::today()->addDays(3);
                    break;
                case 1:
                    $search_data = \Carbon\Carbon::today()->addDays(2);
                    break;
                case 2:
                    $search_data = \Carbon\Carbon::today()->addDays(1);
                    break;
                case 3:
                    $search_data = \Carbon\Carbon::today();
                    break;
                case 4:
                    $search_data = \Carbon\Carbon::today()->addDays(2);
                    break;
                case 5:
                    $search_data = \Carbon\Carbon::today()->addDays(1);
                    break;
                case 6:
                    $search_data = \Carbon\Carbon::today();
                    break;
            }
        }
        // $search_data = \Request::get('search_data') ? \Request::get('search_data') : \Carbon\Carbon::today();

        $rezervari = Rezervare::
            join('orase as orase_plecare', 'rezervari.oras_plecare', '=', 'orase_plecare.id')
            ->join('orase as orase_sosire', 'rezervari.oras_sosire', '=', 'orase_sosire.id')
            ->select(
                'rezervari.*',
                'orase_plecare.tara as oras_plecare_tara',
                'orase_plecare.oras as oras_plecare_nume',
                'orase_plecare.traseu as oras_plecare_traseu',
                'orase_plecare.ordine as oras_plecare_ordine',
                'orase_sosire.tara as oras_sosire_tara',
                'orase_sosire.oras as oras_sosire_nume',
                'orase_sosire.traseu as oras_sosire_traseu',
                'orase_sosire.ordine as oras_sosire_ordine',
            )
            ->withCount('factura')
            ->with('pasageri_relation')
            ->with('pasageri_relation')
            ->whereDate('data_cursa', '=', $search_data)
            ->where(function ($query) {
                if ((auth()->user()->role === 'administrator') || (auth()->user()->role === 'superadmin')) {
                    return;
                } elseif (auth()->user()->role === 'sofer') {
                    return $query->whereBetween('data_cursa', [\Carbon\Carbon::now()->startOfWeek(), \Carbon\Carbon::now()->endOfWeek()]);
                }
            })
            ->where(function (Builder $query) use ($tip_transport) {
                $tip_transport === 'calatori' ?  $query->whereNotNull('nr_adulti') : $query->whereNull('nr_adulti');
            })
            ->get();
            // dd($rezervari);

        // dd($rezervari);
        $clienti_neseriosi = \App\Models\ClientNeserios::pluck('nume')->all();
        // dd($clienti_neseriosi);

        $view_type = $request->view_type;
        return view('rapoarte.raport', compact('rezervari', 'clienti_neseriosi', 'search_data', 'view_type', 'tip_transport'));
    }


    public function mutaRezervari(Request $request, $tip_transport = null){
        $request->validate(
            [
                'traseu' => ['required', 'numeric'],
                'lista' => ['required', 'numeric'],
                'data_cursa' => ['required']
            ],
        );

        if ($request->tip_lista === "lista_plecare") {
            $rezervari = Rezervare::
                join('orase as orase_plecare', 'rezervari.oras_plecare', '=', 'orase_plecare.id')
                // ->join('orase as orase_sosire', 'rezervari.oras_sosire', '=', 'orase_sosire.id')
                // ->select(
                //     'rezervari.*',
                //     'orase_plecare.traseu as oras_plecare_traseu'
                // )
                ->whereDate('data_cursa', '=', $request->data_cursa)
                ->where('orase_plecare.traseu', $request->traseu)
                ->where(function (Builder $query) use ($tip_transport) {
                    $tip_transport === 'calatori' ?  $query->whereNotNull('nr_adulti') : $query->whereNull('nr_adulti');
                })
                ->update(['lista_plecare' => $request->lista]);

            return redirect()
                ->action([\App\Http\Controllers\RaportController::class , 'rapoarte'],
                    ['search_data' => $request->data_cursa, 'tip_transport' => $tip_transport, 'view_type' => 'plecare']);
        } elseif ($request->tip_lista === "lista_sosire") {
            $rezervari = Rezervare::
                // join('orase as orase_plecare', 'rezervari.oras_plecare', '=', 'orase_plecare.id')
                join('orase as orase_sosire', 'rezervari.oras_sosire', '=', 'orase_sosire.id')
                // ->select(
                //     'rezervari.*',
                //     'orase_plecare.traseu as oras_plecare_traseu'
                // )
                ->whereDate('data_cursa', '=', $request->data_cursa)
                ->where('orase_sosire.traseu', $request->traseu)
                ->where(function (Builder $query) use ($tip_transport) {
                    $tip_transport === 'calatori' ?  $query->whereNotNull('nr_adulti') : $query->whereNull('nr_adulti');
                })
                ->update(['lista_sosire' => $request->lista]);

            return redirect()
                ->action(
                    [\App\Http\Controllers\RaportController::class, 'rapoarte'],
                    ['search_data' => $request->data_cursa, 'tip_transport' => $tip_transport, 'view_type' => 'sosire']
                );
        }

        // $request->validate(
        //     [
        //         'lista_noua' => ['required', 'numeric']
        //     ],
        // );

        // if($request->tip_lista === "lista_plecare"){
        //     $rezervari = Rezervare::whereIn('id', $request->rezervari)
        //         ->update(['lista_plecare' => $request->lista_noua]);
        // } elseif ($request->tip_lista === "lista_sosire"){
        //     $rezervari = Rezervare::whereIn('id', $request->rezervari)
        //         ->update(['lista_sosire' => $request->lista_noua]);
        // }

        // return redirect()->route('rapoarte', ['search_data' => $request->data_traseu]);
    }

    public function mutaRezervare(Request $request, $tip_transport = null, Rezervare $rezervare){
        $request->validate(
            [
                'lista' => ['required', 'numeric']
            ],
        );


        // dd($rezervare, $request->tip_lista);

        if ($request->tip_lista === "lista_plecare") {
            $rezervare->lista_plecare = $request->lista;
        } elseif ($request->tip_lista === "lista_sosire") {
            $rezervare->lista_sosire = $request->lista;
        }

        $rezervare->update();

        return back();

        //     $rezervari = Rezervare::
        //         join('orase as orase_plecare', 'rezervari.oras_plecare', '=', 'orase_plecare.id')
        //         // ->join('orase as orase_sosire', 'rezervari.oras_sosire', '=', 'orase_sosire.id')
        //         // ->select(
        //         //     'rezervari.*',
        //         //     'orase_plecare.traseu as oras_plecare_traseu'
        //         // )
        //         ->whereDate('data_cursa', '=', $request->data_cursa)
        //         ->where('orase_plecare.traseu', $request->traseu)
        //         ->where(function (Builder $query) use ($tip_transport) {
        //             $tip_transport === 'calatori' ?  $query->whereNotNull('nr_adulti') : $query->whereNull('nr_adulti');
        //         })
        //         ->update(['lista_plecare' => $request->lista]);

        //     return redirect()
        //         ->action([\App\Http\Controllers\RaportController::class , 'rapoarte'],
        //             ['search_data' => $request->data_cursa, 'tip_transport' => $tip_transport, 'view_type' => 'plecare']);
        // } elseif ($request->tip_lista === "lista_sosire") {
        //     $rezervari = Rezervare::
        //         // join('orase as orase_plecare', 'rezervari.oras_plecare', '=', 'orase_plecare.id')
        //         join('orase as orase_sosire', 'rezervari.oras_sosire', '=', 'orase_sosire.id')
        //         // ->select(
        //         //     'rezervari.*',
        //         //     'orase_plecare.traseu as oras_plecare_traseu'
        //         // )
        //         ->whereDate('data_cursa', '=', $request->data_cursa)
        //         ->where('orase_sosire.traseu', $request->traseu)
        //         ->where(function (Builder $query) use ($tip_transport) {
        //             $tip_transport === 'calatori' ?  $query->whereNotNull('nr_adulti') : $query->whereNull('nr_adulti');
        //         })
        //         ->update(['lista_sosire' => $request->lista]);

        //     return redirect()
        //         ->action(
        //             [\App\Http\Controllers\RaportController::class, 'rapoarte'],
        //             ['search_data' => $request->data_cursa, 'tip_transport' => $tip_transport, 'view_type' => 'sosire']
        //         );
        // }

        // $request->validate(
        //     [
        //         'lista_noua' => ['required', 'numeric']
        //     ],
        // );

        // if($request->tip_lista === "lista_plecare"){
        //     $rezervari = Rezervare::whereIn('id', $request->rezervari)
        //         ->update(['lista_plecare' => $request->lista_noua]);
        // } elseif ($request->tip_lista === "lista_sosire"){
        //     $rezervari = Rezervare::whereIn('id', $request->rezervari)
        //         ->update(['lista_sosire' => $request->lista_noua]);
        // }

        // return redirect()->route('rapoarte', ['search_data' => $request->data_traseu]);
    }

    public function extrageRezervari(Request $request){
        // cautarea rezervarilor dupa array-ul de id-uri primit din request
        $rezervari = Rezervare::
            join('orase as orase_plecare', 'rezervari.oras_plecare', '=', 'orase_plecare.id')
            ->join('orase as orase_sosire', 'rezervari.oras_sosire', '=', 'orase_sosire.id')
            ->with('pasageri_relation')
            ->select(
                'rezervari.*',
                'orase_plecare.tara as oras_plecare_tara',
                'orase_plecare.oras as oras_plecare_nume',
                'orase_plecare.traseu as oras_plecare_traseu',
                'orase_sosire.tara as oras_sosire_tara',
                'orase_sosire.oras as oras_sosire_nume',
                'orase_sosire.traseu as oras_sosire_traseu'
            )
            ->find($request->rezervari);

        // asezare rezervarilor in aceeasi ordine ca id-urile primite din request
        $ids = $request->rezervari;
        $rezervari = $rezervari->sortBy(function($model) use ($ids) {
            return array_search($model->getKey(), $ids);
        });

        // dd($rezervari);

        $clienti_neseriosi = \App\Models\ClientNeserios::pluck('nume')->all();

        // foreach ($rezervari as $rezervare){
        //     echo $rezervare->telefon . '<br>';
        // }
        // dd('stop');

        $tip_lista = $request->tip_lista;

        switch ($request->input('action')) {
            case 'lista_sofer':
                switch($request->view_type) {
                    case 'raport-html':
                        return view('rapoarte.export.raport-pdf', compact('rezervari', 'clienti_neseriosi', 'tip_lista'));
                        break;
                    case 'raport-pdf':
                        // dd('here');
                        $pdf = \PDF::loadView('rapoarte.export.raport-pdf', compact('rezervari', 'clienti_neseriosi', 'tip_lista'))
                            ->setPaper('a4');
                            // return $pdf->stream('Rezervare ' . $rezervari->nume . '.pdf');
                        // dd($pdf);
                            return $pdf->download('Raport ' .
                                ($tip_lista === "lista_plecare" ? 'lista plecare ' : 'lista sosire ') .
                                \Carbon\Carbon::parse($rezervari->first()->data_cursa)->isoFormat('DD.MM.YYYY') .
                                '.pdf');
                        break;
                }
                break;
            case 'lista_pasageri':
                switch ($request->view_type) {
                    case 'raport-html':
                        return view('rapoarte.export.lista-pasageri-pdf', compact('rezervari', 'clienti_neseriosi', 'tip_lista'));
                        break;
                    case 'raport-pdf':
                        $pdf = \PDF::loadView('rapoarte.export.lista-pasageri-pdf', compact('rezervari', 'clienti_neseriosi', 'tip_lista'))
                            ->setPaper('a4');
                        // return $pdf->stream('Rezervare ' . $rezervari->nume . '.pdf');
                        return $pdf->download('Raport lista pasageri' .
                            \Carbon\Carbon::parse($rezervari->first()->data_cursa)->isoFormat('DD.MM.YYYY') .
                            '.pdf');
                        break;
                }
                break;
            case 'excel_nava':
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
                $sheet->setCellValue('A1', 'Nume');
                $sheet->setCellValue('B1', 'Prenume');
                // $sheet->setCellValue('C1', 'Buletin');
                $sheet->setCellValue('C1', 'Data de naștere');
                $sheet->setCellValue('D1', 'Localitate naștere');
                // $sheet->setCellValue('F1', 'Localitate domiciliu');
                $sheet->setCellValue('E1', 'Sex');
                $sheet->setCellValue('F1', 'Cetățenie');
                $sheet->setCellValue('G1', 'Categorie');

                // dd($rezervari, $rezervari->where('bilet_nava', 1));

                $nr_celula = 2;
                foreach ($rezervari
                        ->where('bilet_nava', 1)
                        as $rezervare){
                    foreach ($rezervare->pasageri_relation as $pasager){
                    // $array[$nr_celula][1] = strtok($pasager->nume, " ");
                    // $array[$nr_celula][2] = substr(strstr($pasager->nume, " "), 1);
                    // $array[$nr_celula][3] = $pasager->buletin;
                    // $array[$nr_celula][4] = \Carbon\Carbon::parse($pasager->data_nastere)->isoFormat('DD.MM.YYYY');
                    // $array[$nr_celula][5] = $pasager->localitate_nastere;
                    // $array[$nr_celula][6] = $pasager->localitate_domiciliu;
                    // $array[$nr_celula][7] = 'Română';
                    $sheet->setCellValue('A' . ($nr_celula), strtok($pasager->nume, " "));
                    $sheet->setCellValue('B' . ($nr_celula), (substr(strstr($pasager->nume, " "), 1) === false) ? '' : substr(strstr($pasager->nume, " "), 1));
                    // $sheet->setCellValue('C' . ($nr_celula), $pasager->buletin);
                    // $sheet->setCellValue('C' . ($nr_celula), \Carbon\Carbon::parse($pasager->data_nastere ?? '0')->isoFormat('DD.MM.YYYY'));
                    $sheet->setCellValue('C' . ($nr_celula), ($pasager->data_nastere));
                    $sheet->setCellValue('D' . ($nr_celula), $pasager->localitate_nastere);
                    // $sheet->setCellValue('F' . ($nr_celula), $pasager->localitate_domiciliu);
                    $sheet->setCellValue('E' . ($nr_celula), $pasager->sex);
                    $sheet->setCellValue('F' . ($nr_celula), 'Română');
                    // $sheet->setCellValue('G' . ($nr_celula), $pasager->categorie);
                    $nr_celula++;
                    }
                }

                // // redirect output to client browser
                // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                // header('Content-Disposition: attachment;filename="Lista Navă.xlsx"');
                // header('Cache-Control: max-age=0');

                // // $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
                // $writer = new Xlsx($spreadsheet);
                // $writer->save('php://output');

                try {
                    Storage::makeDirectory('fisiere_temporare');
                    $writer = new Xlsx($spreadsheet);
                    $writer->save(storage_path(
                        'app/fisiere_temporare/' .
                        'Lista Nava' . '.xlsx'
                    ));
                } catch (Exception $e) { }

                return response()->download(storage_path(
                    'app/fisiere_temporare/' .
                    'Lista Nava' . '.xlsx'
                ));

                break;

        }

        return back();

    }

    public function extrageRezervariIphone(Request $request){
        $tip_transport = $request->tip_transport;
        $lista = $request->lista;
        $rezervari = Rezervare::
            join('orase as orase_plecare', 'rezervari.oras_plecare', '=', 'orase_plecare.id')
            ->join('orase as orase_sosire', 'rezervari.oras_sosire', '=', 'orase_sosire.id')
            ->with('pasageri_relation')
            ->with('pasageri_relation')
            ->select(
                'rezervari.*',
                'orase_plecare.tara as oras_plecare_tara',
                'orase_plecare.oras as oras_plecare_nume',
                'orase_plecare.traseu as oras_plecare_traseu',
                'orase_plecare.ordine as oras_plecare_ordine',
                'orase_sosire.tara as oras_sosire_tara',
                'orase_sosire.oras as oras_sosire_nume',
                'orase_sosire.traseu as oras_sosire_traseu',
                'orase_sosire.ordine as oras_sosire_ordine',
            )
            ->whereDate('data_cursa', $request->data)
            ->where(function (Builder $query) use ($tip_transport) {
                $tip_transport === 'calatori' ?  $query->whereNotNull('nr_adulti') : $query->whereNull('nr_adulti');
            })
            ->where(function (Builder $query) use ($request){
                ($request->lista === 'toate') ? '' : $query->where($request->tip_lista, $request->lista);
            })
            ->when($request, function ($query, $request) {
                if ($request->tip_lista === "lista_plecare") {
                    if ($request->tara_plecare === 'Romania') {
                        return $query->orderBy('oras_plecare_traseu')->orderBy('oras_plecare_ordine')->orderBy('oras_plecare_nume');
                    } else {
                        return $query->orderBy('oras_plecare_traseu', 'desc')->orderBy('oras_plecare_ordine', 'desc')->orderBy('oras_plecare_nume', 'desc');
                    }
                } else if ($request->tip_lista === "lista_sosire") {
                    if ($request->tara_plecare === 'Romania') {
                        // dd('da');
                        return $query->orderBy('oras_sosire_traseu')->orderBy('oras_sosire_ordine')->orderBy('oras_sosire_nume');
                    } else {
                        return $query->orderBy('oras_sosire_traseu', 'desc')->orderBy('oras_sosire_ordine', 'desc')->orderBy('oras_sosire_nume', 'desc');
                    }
                }

            })
            ->get();
        // dd($rezervari);
        // foreach ($rezervari as $rezervare) {
        //     echo $rezervare->oras_plecare_traseu . ' ' . $rezervare->oras_plecare_ordine;
        //     echo '<br>';
        // }
        // dd($rezervari);

        // if($request->tip_lista === "lista_plecare"){
        //     if (($rezervari->first()->oras_plecare_tara ?? '') === 'Romania') {
        //         $rezervari = $rezervari->sortBy('oras_plecare_nume')->sortBy('oras_plecare_ordine')->sortBy('oras_plecare_traseu');
        //     } else {
        //         $rezervari = $rezervari->sortByDesc('oras_plecare_nume')->sortByDesc('oras_plecare_ordine')->sortByDesc('oras_plecare_traseu');
        //         foreach ($rezervari as $rezervare){
        //             echo $rezervare->oras_plecare_traseu . ' ' . $rezervare->oras_plecare_ordine;
        //             echo '<br>';
        //         }
        //         dd($rezervari);
        //     }
        // } else if ($request->tip_lista === "lista_sosire") {
        //     // dd($rezervari);
        //     if (($rezervari->first()->oras_sosire_tara ?? '') === 'Corsica') {
        //         $rezervari = $rezervari->sortBy('oras_sosire_nume')->sortBy('oras_sosire_ordine')->sortBy('oras_sosire_traseu');
        //     } else {
        //         $rezervari = $rezervari->sortBy('oras_sosire_nume')->sortByDesc('oras_sosire_ordine')->sortByDesc('oras_sosire_traseu');
        //     }
        // }

        // asezare rezervarilor in aceeasi ordine ca id-urile primite din request
        // $ids = $request->rezervari;
        // $rezervari = $rezervari->sortBy(function($model) use ($ids) {
        //     return array_search($model->getKey(), $ids);
        // });

        // dd($rezervari);

        $clienti_neseriosi = \App\Models\ClientNeserios::pluck('nume')->all();

        $tip_lista = $request->tip_lista;

        switch ($request->raport) {
            case 'lista_sofer':
                switch($request->view_type) {
                    case 'raport-html':
                        return view('rapoarte.export.raport-pdf', compact('rezervari', 'clienti_neseriosi', 'tip_lista'));
                        break;
                    case 'raport-pdf':
                        $pdf = \PDF::loadView('rapoarte.export.raport-pdf', compact('rezervari', 'clienti_neseriosi', 'tip_lista'))
                            ->setPaper('a4');
                            // return $pdf->stream('Rezervare ' . $rezervari->nume . '.pdf');
                            return $pdf->download('Raport ' .
                                ($tip_lista === "lista_plecare" ? 'lista plecare ' : 'lista sosire ') .
                                (isset($rezervari->first()->data_cursa) ? \Carbon\Carbon::parse($rezervari->first()->data_cursa)->isoFormat('DD.MM.YYYY') : '') .
                                '.pdf');
                        break;
                }
                break;
            case 'lista_pasageri':
                switch ($request->view_type) {
                    case 'raport-html':
                        return view('rapoarte.export.lista-pasageri-pdf', compact('rezervari', 'clienti_neseriosi', 'tip_lista'));
                        break;
                    case 'raport-pdf':
                        $pdf = \PDF::loadView('rapoarte.export.lista-pasageri-pdf', compact('rezervari', 'clienti_neseriosi', 'tip_lista'))
                            ->setPaper('a4');
                        // return $pdf->stream('Rezervare ' . $rezervari->nume . '.pdf');
                        return $pdf->download('Raport lista pasageri' .
                            \Carbon\Carbon::parse($rezervari->first()->data_cursa)->isoFormat('DD.MM.YYYY') .
                            '.pdf');
                        break;
                }
                break;
            case 'excel-nava':
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
                $sheet->setCellValue('A1', 'Nume');
                $sheet->setCellValue('B1', 'Prenume');
                // $sheet->setCellValue('C1', 'Buletin');
                $sheet->setCellValue('C1', 'Data de naștere');
                $sheet->setCellValue('D1', 'Localitate naștere');
                // $sheet->setCellValue('F1', 'Localitate domiciliu');
                $sheet->setCellValue('E1', 'Sex');
                $sheet->setCellValue('F1', 'Cetățenie');
                $sheet->setCellValue('G1', 'Categorie');

                // dd($rezervari, $rezervari->where('bilet_nava', 1));

                $nr_celula = 2;
                foreach ($rezervari
                        ->where('bilet_nava', 1)
                        as $rezervare){
                    foreach ($rezervare->pasageri_relation as $pasager){
                    // $array[$nr_celula][1] = strtok($pasager->nume, " ");
                    // $array[$nr_celula][2] = substr(strstr($pasager->nume, " "), 1);
                    // $array[$nr_celula][3] = $pasager->buletin;
                    // $array[$nr_celula][4] = \Carbon\Carbon::parse($pasager->data_nastere)->isoFormat('DD.MM.YYYY');
                    // $array[$nr_celula][5] = $pasager->localitate_nastere;
                    // $array[$nr_celula][6] = $pasager->localitate_domiciliu;
                    // $array[$nr_celula][7] = 'Română';
                    $sheet->setCellValue('A' . ($nr_celula), strtok($pasager->nume, " "));
                    $sheet->setCellValue('B' . ($nr_celula), (substr(strstr($pasager->nume, " "), 1) === false) ? '' : substr(strstr($pasager->nume, " "), 1));
                    // $sheet->setCellValue('C' . ($nr_celula), $pasager->buletin);
                    // $sheet->setCellValue('C' . ($nr_celula), \Carbon\Carbon::parse($pasager->data_nastere ?? '0')->isoFormat('DD.MM.YYYY'));
                    $sheet->setCellValue('C' . ($nr_celula), ($pasager->data_nastere));
                    $sheet->setCellValue('D' . ($nr_celula), $pasager->localitate_nastere);
                    // $sheet->setCellValue('F' . ($nr_celula), $pasager->localitate_domiciliu);
                    $sheet->setCellValue('E' . ($nr_celula), $pasager->sex);
                    $sheet->setCellValue('F' . ($nr_celula), 'Română');
                    $sheet->setCellValue('G' . ($nr_celula), $pasager->categorie);
                        if ($pasager->categorie === "Copil"){
                            $sheet->getStyle('G' . ($nr_celula))->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
                        }
                    $nr_celula++;
                    }
                }

                // // redirect output to client browser
                // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                // header('Content-Disposition: attachment;filename="Lista Navă.xlsx"');
                // header('Cache-Control: max-age=0');

                // // $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
                // $writer = new Xlsx($spreadsheet);
                // $writer->save('php://output');

                try {
                    Storage::makeDirectory('fisiere_temporare');
                    $writer = new Xlsx($spreadsheet);
                    $writer->save(storage_path(
                        'app/fisiere_temporare/' .
                        'Lista Nava' . '.xlsx'
                    ));
                } catch (Exception $e) { }

                return response()->download(storage_path(
                    'app/fisiere_temporare/' .
                    'Lista Nava' . '.xlsx'
                ));

                break;
            case 'chitante':
                switch ($request->view_type) {
                    case 'raport-html':
                        return view('rapoarte.export.chitante-pdf', compact('rezervari', 'clienti_neseriosi', 'tip_lista'));
                        break;
                    case 'raport-pdf':
                        $pdf = \PDF::loadView('rapoarte.export.chitante-pdf', compact('rezervari', 'clienti_neseriosi', 'tip_lista'))
                            ->setPaper('a4', 'portrait');
                        // return $pdf->stream('Rezervare ' . $rezervari->nume . '.pdf');
                        return $pdf->download('Raport bilete pasageri' .
                            \Carbon\Carbon::parse($rezervari->first()->data_cursa)->isoFormat('DD.MM.YYYY') .
                            '.pdf');
                        break;
                }
                break;
            case 'facturi':
                switch ($request->view_type) {
                    case 'raport-html':
                        return view('rapoarte.export.facturi-pdf', compact('rezervari', 'clienti_neseriosi', 'tip_lista'));
                        break;
                    case 'raport-pdf':
                        $pdf = \PDF::loadView('rapoarte.export.facturi-pdf', compact('rezervari', 'clienti_neseriosi', 'tip_lista'))
                            ->setPaper('a4');
                        // return $pdf->stream('Rezervare ' . $rezervari->nume . '.pdf');
                        return $pdf->download('Raport facturi' .
                            \Carbon\Carbon::parse($rezervari->first()->data_cursa)->isoFormat('DD.MM.YYYY') .
                            '.pdf');
                        break;
                }
                break;
            case 'cmr':
                switch ($request->view_type) {
                    case 'raport-html':
                        return view('rapoarte.export.cmruri-pdf', compact('rezervari', 'clienti_neseriosi', 'tip_lista'));
                        break;
                    case 'raport-pdf':
                        $pdf = \PDF::loadView('rapoarte.export.cmruri-pdf', compact('rezervari', 'clienti_neseriosi', 'tip_lista'))
                            ->setPaper('a4');
                        // return $pdf->stream('Rezervare ' . $rezervari->nume . '.pdf');
                        return $pdf->download('Raport CMRuri' .
                            \Carbon\Carbon::parse($rezervari->first()->data_cursa)->isoFormat('DD.MM.YYYY') .
                            '.pdf');
                        break;
                }
                break;
            case 'trimite-sms':
                $request->validate([
                    'text_sms' => 'required|min:1|max:500',
                ]);
                $mesaj = $request->text_sms;

                // Referitor la diacritice, puteti face conversia unui string cu diacritice intr-unul fara diacritice, in mod automatizat cu aceasta functie PHP:
                $transliterator = \Transliterator::createFromRules(':: Any-Latin; :: Latin-ASCII; :: NFD; :: [:Nonspacing Mark:] Remove; :: NFC;', \Transliterator::FORWARD);
                // $textFaraDiacritice = $transliterator->transliterate($textCuDiacritice);
                $mesaj = $transliterator->transliterate($mesaj);

                // dd($mesaj, $rezervari->count());
                // foreach ($rezervari as $rezervare)
                // {
                //     $this->trimiteSms('rezervari', null, $rezervare->id, [$rezervare->telefon], $mesaj);
                // }

                // return back()->with('status', 'SMS-ul a fost trimis către ' . $rezervari->count() . ' rezervări');



                // Mesaje Bulk
                /**
                 *
                 *
                 *     Usage Examples for the SMSLinkSMSGatewayBulkPackage() class
                 *
                 *
                 *
                 */

                /*
                *
                *
                *     Initialize SMS Gateway Bulk Package
                *
                *       Get your SMSLink / SMS Gateway Connection ID and Password from
                *       https://www.smslink.ro/get-api-key/
                *
                *
                *
                */
                $BulkSMSPackage = new \App\Http\Helpers\SMSLinkSMSGatewayBulkPackage(config('sms_link.connection_id'), config('sms_link.password'), false);

                /*
                *
                *    Insert Messages to SMS Package
                *
                */
                foreach ($rezervari as $rezervare)
                {
                    $smsTrimis = new \App\Models\MesajTrimisSms;
                    $smsTrimis->categorie = 'rezervari';
                    $smsTrimis->subcategorie = NULL;
                    $smsTrimis->referinta_id = $rezervare->id;
                    $smsTrimis->telefon = $rezervare->telefon;
                    // $smsTrimis->mesaj = $mesaj;
                    $smsTrimis->mesaj = $mesaj;
                    $smsTrimis->save();

                    $BulkSMSPackage->insertMessage($smsTrimis->id, $smsTrimis->telefon, "numeric", $smsTrimis->mesaj);
                }

                /*
                *
                *    Send SMS Package to SMSLink
                *
                */
                $BulkSMSPackage->sendPackage();

                /*
                *
                *    Process Result
                *
                */
                echo "Remote Package ID: ".$BulkSMSPackage->remotePackageID."<br />";

                // $statusCounters = array();

                if (sizeof($BulkSMSPackage->remoteMessageIDs) > 0)
                {
                    foreach ($BulkSMSPackage->remoteMessageIDs as $key => $value)
                    {
                        switch ($value["messageStatus"])
                        {
                            /**
                             *
                             *
                             *     Message Status:     1
                             *     Status Description: Sender Failed
                             *
                             *
                             */
                            case 1:
                                $timestamp_send = -1;

                                /*

                                    .. do something ..
                                    for example check the sender because is incorrect

                                */

                                echo "Error for Local Message ID: ".$value["localMessageId"]." (Sender Failed).<br />";

                                // $statusCounters["failedSenderCounter"]++;

                                // return back()->with('status', "Error for Local Message ID: ".$value["localMessageId"]." (Sender Failed).<br />");

                                $smsTrimis = \App\Models\MesajTrimisSms::find($value["localMessageId"]);
                                $smsTrimis->trimis = 0;
                                $smsTrimis->mesaj_id = $value["remoteMessageId"];
                                $smsTrimis->raspuns = "Eroare! (Sender Failed)";
                                $smsTrimis->save();

                                break;
                            /**
                             *
                             *
                             *     Message Status:     2
                             *     Status Description: Number Failed
                             *
                             *
                             */
                            case 2:
                                $timestamp_send = -2;

                                /*

                                    .. do something ..
                                    for example check the number because is incorrect

                                */

                                echo "Error for Local Message ID: ".$value["localMessageId"]." (Incorrect Number).<br />";

                                // $statusCounters["failedNumberCounter"]++;

                                // return back()->with('status', "Error for Local Message ID: ".$value["localMessageId"]." (Incorrect Number).<br />");

                                $smsTrimis = \App\Models\MesajTrimisSms::find($value["localMessageId"]);
                                $smsTrimis->trimis = 0;
                                $smsTrimis->mesaj_id = $value["remoteMessageId"];
                                $smsTrimis->raspuns = "Eroare! (Incorrect Number)";
                                $smsTrimis->save();

                                break;
                            /**
                             *
                             *
                             *     Message Status:     3
                             *     Status Description: Success
                             *
                             *
                             */
                            case 3:
                                $timestamp_send = date("U");
                                /*

                                    .. do something ..

                                    Save in database the Remote Message ID, sent in variabile: $value["RemoteMessageID"].
                                    Delivery  reports will  identify  your SMS  using our Message ID. Data type  for the
                                    variabile should be considered to be hundred milions (example: 220000000)

                                */

                                echo "Succes for Local Message ID: ".
                                    $value["localMessageId"].
                                    ", Remote Message ID: ".
                                    $value["remoteMessageId"].
                                    "<br />";

                                // $statusCounters["successCounter"]++;

                                $smsTrimis = \App\Models\MesajTrimisSms::find($value["localMessageId"]);
                                $smsTrimis->trimis = 1;
                                $smsTrimis->mesaj_id = $value["remoteMessageId"];
                                $smsTrimis->raspuns = "Succes!";
                                $smsTrimis->save();

                                break;
                            /**
                             *
                             *
                             *     Message Status:     4
                             *     Status Description: Internal Error or Number Blacklisted
                             *
                             *
                             */
                            case 4:
                                $timestamp_send = -4;

                                /*

                                    .. do something ..
                                    for example try again later

                                    Internal Error may occur in the following circumstances:

                                    (1) Number is Blacklisted (please check the Blacklist associated to your account), or
                                    (2) An error occured at SMSLink (our technical support team is automatically notified)

                                */

                                echo "Error for Local Message ID: ".$value["localMessageId"]." (Internal Error or Number Blacklisted).<br />";

                                // $statusCounters["failedInternalCounter"]++;

                                $smsTrimis = \App\Models\MesajTrimisSms::find($value["localMessageId"]);
                                $smsTrimis->trimis = 0;
                                $smsTrimis->mesaj_id = $value["remoteMessageId"];
                                $smsTrimis->raspuns = "Eroare! (Internal Error or Number Blacklisted)";
                                $smsTrimis->save();

                                break;
                            /**
                             *
                             *
                             *     Message Status:     5
                             *     Status Description: Insufficient Credit
                             *
                             *
                             */
                            case 5:
                                $timestamp_send = -5;

                                /*

                                    .. do something ..
                                    for example top-up the account

                                */

                                echo "Error for Local Message ID: ".$value["localMessageId"]." (Insufficient Credit).<br />";

                                $smsTrimis = \App\Models\MesajTrimisSms::find($value["localMessageId"]);
                                $smsTrimis->trimis = 0;
                                $smsTrimis->mesaj_id = $value["remoteMessageId"];
                                $smsTrimis->raspuns = "Eroare! (Insufficient Credit)";
                                $smsTrimis->save();

                                // $statusCounters["failedInsufficientCredit"]++;

                                break;
                        }

                        // $statusCounters["totalCounter"]++;

                    }

                }
                else
                {
                    echo "Error Transmitting Package to SMSLink: ".$BulkSMSPackage->errorMessage."<br />";
                    return back()->with('eroare', 'Error Transmitting Package to SMSLink: ' . $BulkSMSPackage->errorMessage);
                }
                // $rezervari = '123';
                // dd($rezervari);
                // return redirect()->action([\App\Http\Controllers\SmsBulkController::class, 'trimiteSmsBulk'], ['rezervari' => $rezervari]);
                return back()->with('status', 'Sms-urile catre cele ' . $rezervari->count() . ' rezervări au fost trimise cu success!');

                break;

            // // return redirect()
            // //     ->action(
            // //         [\App\Http\Controllers\RaportController::class, 'rapoarte'],
            // //         ['search_data' => $request->data_cursa, 'tip_transport' => $tip_transport, 'view_type' => 'sosire']
            // //     );
        }

        return back();

    }
}
