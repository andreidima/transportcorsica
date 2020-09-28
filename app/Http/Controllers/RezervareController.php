<?php

namespace App\Http\Controllers;

use App\Models\Rezervare;
use App\Models\Oras;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RezervareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rezervare  $rezervare
     * @return \Illuminate\Http\Response
     */
    public function show(Rezervare $rezervare)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rezervare  $rezervare
     * @return \Illuminate\Http\Response
     */
    public function edit(Rezervare $rezervare)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rezervare  $rezervare
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rezervare $rezervare)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rezervare  $rezervare
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rezervare $rezervare)
    {
        //
    }



    /**
     * Returnarea oraselor de sosire
     */
    public function orase_rezervari(Request $request)
    {
        $tur_retur = 0;
        $raspuns = '';
        switch ($_GET['request']) {
            case 'judete_plecare':
                $raspuns = Oras::select('id', 'judet', 'tara')
                    ->where('tara', $request->tara)
                    ->orderBy('judet')
                    ->get()
                    ->unique('judet');
                break;
            case 'orase_plecare':
                $raspuns = Oras::select('id', 'oras', 'judet')
                    ->where('judet', $request->judet)
                    ->orderBy('oras')
                    ->get();
                break;
            case 'judete_sosire':
                $raspuns = Oras::select('id', 'judet', 'tara')
                    ->where('tara', '<>', $request->tara)
                    ->orderBy('judet')
                    ->get()
                    ->unique('judet');
                break;
            case 'orase_sosire':
                $raspuns = Oras::select('id', 'oras', 'judet')
                    ->where('judet', $request->judet)
                    ->orderBy('oras')
                    ->get();
                break;
            default:
                break;
        }
        return response()->json([
            'raspuns' => $raspuns,
        ]);
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest(Request $request, $rezervari = null)
    {
        // dd ($request->traseu);
        return request()->validate(
            [
                // 'cursa_id' =>['nullable', 'numeric', 'max:999'],
                'traseu' => ['required'],
                'oras_plecare' => ['required', 'integer', 'max:999'],
                'oras_sosire' => ['required', 'integer', 'max:999'],
                'tur_retur' => [''],
                // 'statie_id' => ['nullable', 'numeric', 'max:999'],
                // 'statie_imbarcare' => ['nullable'],
                'nr_adulti' => ['required', 'integer', 'between:1,100'],
                // 'nr_copii' => ['nullable', 'integer', 'between:0,100'],
                // 'data_plecare' => [''],
                'data_plecare' => ['required_if:traseu,1', 'required_if:tur_retur,true'],
                'data_intoarcere' => [
                    // 'basil',
                    'required_if:tur_retur,true',
                    'required_unless:traseu,1',
                    // 'after:data_plecare', 
                    'max:50',
                    function ($attribute, $value, $fail) use ($request) {
                        $data_plecare = \Carbon\Carbon::parse($request->data_plecare);
                        $data_intoarcere = \Carbon\Carbon::parse($request->data_intoarcere);
                        // dd($data_plecare, $data_intoarcere, $request->traseu, $request->tur_retur);
                        if (($request->traseu == 1) && ($request->tur_retur == true) && ($data_plecare > $data_intoarcere)) {
                            // dd($request->traseu);
                            $fail('Data de intoarcere trebuie sa fie mai mare decât data de plecare.');
                        } elseif (($request->traseu == 2) && ($request->tur_retur == true) && ($data_plecare < $data_intoarcere)) {
                            // dd($request->traseu);
                            $fail('Data de intoarcere trebuie sa fie mai mare decât data de plecare.');
                        } elseif (($request->tur_retur == true) && ($data_plecare->diffInDays($data_intoarcere) > 30)) {
                            $fail('Data de intoarcere trebuie sa fie la maxim 30 de zile de la data de plecare.');
                        }
                    },
                ],
                // 'ora_id' =>[ 'required', 'nullable', 'max:99'],
                'nume' => ($request->_method === "PATCH") ?
                    [
                        'required', 'max:200',
                        Rule::unique('rezervari')->ignore($rezervari->id)->where(function ($query) use ($rezervari, $request) {
                            return $query->where('telefon', $request->telefon)
                                ->where('data_cursa', $request->data_cursa);
                        }),
                    ]
                    : [
                        'required', 'max:200',
                        Rule::unique('rezervari')->where(function ($query) use ($rezervari, $request) {
                            return $query->where('telefon', $request->telefon)
                                ->where('data_plecare', $request->data_plecare);
                        }),
                    ],
                'telefon' => ['required', 'regex:/^[0-9 ]+$/', 'max: 100'],
                'email' => ['required', 'email', 'max:100'],
                // 'pret_total' => ['nullable', 'numeric', 'max:999999'],
                'adresa' => ['max:2000'],
                'observatii' => ['max:2000'],

                // 'plata_online' => [''],
                // 'adresa' => ['required_if:plata_online,true', 'nullable', 'max:99'],

                'document_de_calatorie' => ['', 'max:20'],
                'expirare_document' => ['', 'max:50'],
                'serie_document' => ['', 'max:20'],
                'cnp' => ['', 'max:20'],
                'acord_de_confidentialitate' => ['required'],
                'termeni_si_conditii' => ['required'],
                // 'oferta' => [''],
            ],
            [
                // 'ora_id.required' => 'Câmpul Ora de plecare este obligatoriu.',
                'telefon.regex' => 'Câmpul Telefon poate conține doar cifre și spații.',
                'nume.unique' => 'Această Rezervare este deja înregistrată.',
                'data_plecare.required_if' => 'Câmpul data plecare este necesar.',
                'data_intoarcere.required_unless' => 'Câmpul data plecare este necesar.',
                // 'adresa.required_if' => 'Câmpul Adresa este obligatoriu dacă este selectată plata cu card'
            ]
        );
    }

    public function pdfexport(Request $request, Rezervare $rezervari)
    {
        if ($request->view_type === 'rezervare-html') {
            return view('rezervari.export.rezervare-pdf', compact('rezervari'));
        } elseif ($request->view_type === 'rezervare-pdf') {
            $pdf = \PDF::loadView('rezervari.export.rezervare-pdf', compact('rezervari'))
                ->setPaper('a4');
            // return $pdf->stream('Rezervare ' . $rezervari->nume . '.pdf');
            return $pdf->download('Rezervare ' . $rezervari->nume . '.pdf');
        }
        // elseif($request->view_type === 'fisa-de-date-a-imobilului-pdf'){
        //     $pdf = PDF::loadView('registru.export.pdf-fisa-de-date-a-imobilului', ['registre' => $registre]) ->setPaper('a4');
        //     return $pdf->download($registru->id.'.pdf');
        // }
        // else{
        // } 
    }


    //
    // Functii pentru Multi Page Form pentru Clienti
    //
    /**
     * Show the step 1 Form for creating a new 'rezervare'.
     *
     * @return \Illuminate\Http\Response
     */
    public function adaugaRezervarePasul1(Request $request)
    {
        return view('rezervari.guest-create/adauga-rezervare-pasul-1');
    }

    /**
     * Post Request to store step1 info in session
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postAdaugaRezervarePasul1(Request $request)
    {
        $this->validateRequest($request);
        dd($request->request);
        $request->session()->forget('rezervare');
        $rezervare = Rezervare::make($this->validateRequest($request));

        //Animalele nu mai sunt folosite, sunt setate doar ca sa nu genereze erori mai departe in logic aplicatiei
        $rezervare->nr_animale_mici = 0;
        $rezervare->nr_animale_mari = 0;

        //Schimbare tur_retur din "true or false" din vue, in "0 or 1" pentru baza de date
        ($rezervare->tur_retur === "true") ? ($rezervare->tur_retur = 1) : ($rezervare->tur_retur = 0);

        // dd($rezervare);

        // calcularea pretului total
        if ($rezervare->traseu == 1) {
            $oras = DB::table('orase')
                ->where('id', $rezervare->oras_sosire)
                ->first();
        } elseif ($rezervare->traseu == 2) {
            $oras = DB::table('orase')
                ->where('id', $rezervare->oras_plecare)
                ->first();
        }
        // elseif ($rezervare->traseu == 3){
        //     $oras = DB::table('orase')
        //         ->where('id', $rezervare->oras_plecare)
        //         ->first();
        // }

        $tarife = DB::table('tarife')
            ->where([
                ['traseu_id', $oras->traseu],
                ['tur_retur', $rezervare->tur_retur]
            ])
            ->first();
        // dd($rezervare, $oras, $tarife);

        //Calcularea preturilor rezervarii
        $rezervare->pret_total = $tarife->adult * $rezervare->nr_adulti +
            $tarife->copil * $rezervare->nr_copii +
            $tarife->animal_mic * $rezervare->nr_animale_mici +
            $tarife->animal_mare * $rezervare->nr_animale_mari;

        //Calcularea preturilor rezervarii cu aplicarea reducerii de 10%
        // $rezervare->pret_total = floor((string) ($tarife->adult * 90)) / 100 * $rezervare->nr_adulti +
        //     floor((string) ($tarife->copil * 90)) / 100 * $rezervare->nr_copii +
        //     $tarife->animal_mic * $rezervare->nr_animale_mici +
        //     $tarife->animal_mare * $rezervare->nr_animale_mari; 


        // $rezervare->pret_total_cu_reducere_10_procente = floor((string) ($tarife->adult * 90)) / 100 * $rezervare->nr_adulti +
        //                         floor((string) ($tarife->copil * 90)) / 100 * $rezervare->nr_copii +
        //                         ($tarife->animal_mic) * $rezervare->nr_animale_mici +
        //                         ($tarife->animal_mare) * $rezervare->nr_animale_mari;

        $request->session()->put('rezervare', $rezervare);
        $request->session()->put('tarife', $tarife);
        // dd($rezervare, $tarife);
        return redirect('/adauga-rezervare-pasul-2');
    }

    /**
     * Show the step 2 Form for creating a new 'rezervare'.
     *
     * @return \Illuminate\Http\Response
     */
    public function adaugaRezervarePasul2(Request $request)
    {
        $rezervare = $request->session()->get('rezervare');
        $tarife = $request->session()->get('tarife');


        // dd($rezervare, $tarife);

        // $tarife = DB::table('tarife')
        //     ->where([
        //         ['traseu_id', $rezervare->traseu],
        //         ['tur_retur', ($rezervare->tur_retur=='true' ? 1 : 0)]
        //     ])
        //     ->first();

        return view('rezervari.guest-create/adauga-rezervare-pasul-2', compact('rezervare', 'tarife'));
    }

    /**
     * Post Request to store step2 info in session
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postAdaugaRezervarePasul2(Request $request)
    {
        $rezervare = $request->session()->get('rezervare');
        $rezervare->created_at = \Carbon\Carbon::now();

        $tarife = $request->session()->get('tarife');

        //Calcularea preturilor rezervarii
        // $rezervare->pret_total = $tarife->adult * $rezervare->nr_adulti +
        //                         $tarife->copil * $rezervare->nr_copii +
        //                         $tarife->animal_mic * $rezervare->nr_animale_mici +
        //                         $tarife->animal_mare * $rezervare->nr_animale_mari;    

        //Calcularea preturilor rezervarii cu aplicarea reducerii de 10%
        // $rezervare->pret_total = floor((string) ($tarife->adult * 90)) / 100 * $rezervare->nr_adulti +
        //                         floor((string) ($tarife->copil * 90)) / 100 * $rezervare->nr_copii +
        //                         $tarife->animal_mic * $rezervare->nr_animale_mici +
        //                         $tarife->animal_mare * $rezervare->nr_animale_mari;             

        // Verificare rezervare duplicat
        $request_verificare_duplicate = new Request([
            'nume' => $request->session()->get('rezervare.nume'),
            'telefon' => $request->session()->get('rezervare.telefon'),
            'data_plecare' => $request->session()->get('rezervare.data_plecare')
        ]);

        $this->validate(
            $request_verificare_duplicate,
            [
                'nume' => ['required', 'max:100', 'unique:rezervari,nume,NULL,id,telefon,' . $request_verificare_duplicate->telefon . ',data_plecare,' . $request_verificare_duplicate->data_plecare]
            ],
            [
                'nume.unique' => 'Această Rezervare este deja înregistrată.'
            ]
        );

        //Schimbare tur_retur din "true or false" din vue, in "0 or 1" pentru baza de date
        // ($rezervare->tur_retur === "true") ? ($rezervare->tur_retur = 1) : ($rezervare->tur_retur = 0);

        $rezervare_array = $rezervare->toArray();
        $plata_online = $rezervare_array['plata_online'];
        unset($rezervare_array['traseu'], $rezervare_array['oras_plecare_nume'], $rezervare_array['oras_sosire_nume'],
        $rezervare_array['plata_online'], $rezervare_array['acord_de_confidentialitate'], $rezervare_array['termeni_si_conditii']);

        //Inserarea rezervarii in baza de date
        $id = DB::table('rezervari')->insertGetId($rezervare_array);

        // $id = $rezervari->save->insertGetId;

        $rezervare->id = $id;

        $rezervare->tabel = 'rezervari';
        $rezervare->currency = 'EUR';
        $rezervare->return_url = 'https://aplicatie.alsimymondtravel.ro/adauga-rezervare-pasul-3';

        $request->session()->put('rezervare', $rezervare);

        // Trimitere email
        if (stripos($rezervare->nume, 'Andrei Dima Test') !== false) {
            if (stripos($rezervare->nume, 'fara email') !== false) {
                // nu se trimite email
            } else {
                \Mail::to('adima@validsoftware.ro')->send(
                    new CreareRezervare($rezervare, $tarife)
                );
            }
        } else {
            \Mail::to('alsimy_mond_travel@yahoo.com')->send(
                new CreareRezervare($rezervare, $tarife)
            );
        }

        //Trimitere catre plata
        if ($plata_online == 1) {
            if (stripos($rezervare->nume, 'Andrei Dima Test') !== false) {
                if (stripos($rezervare->nume, 'fara plata') !== false) {
                    return redirect('/adauga-rezervare-pasul-3');
                } else {
                    return redirect('/trimitere-catre-plata');
                }
            } else {
                return redirect('/trimitere-catre-plata');
            }
        }
    }

    /**
     * Show the step 3 Form for creating a new 'rezervare'.
     *
     * @return \Illuminate\Http\Response
     */
    public function adaugaRezervarePasul3(Request $request)
    {
        if ($request->has('orderId')) {
            $plata_online = \App\PlataOnline::where('order_id', $request->orderId)->latest()->first();
            $rezervare = \App\Rezervare::where('id', $plata_online->rezervare_id)->first();

            $request->session()->put('plata_online', $plata_online);
            $request->session()->forget('rezervare');
            $request->session()->put('rezervare_id', $rezervare->id);

            // dd($rezervare, $rezervare->ora->ora);

            return view('rezervari.guest-create/adauga-rezervare-pasul-3', compact('rezervare', 'plata_online'));
        } else {
            $rezervare = $request->session()->get('rezervare');

            return view('rezervari.guest-create/adauga-rezervare-pasul-3', compact('rezervare'));
        }

        // $request->session()->forget('rezervare');
        // $request->session()->flush();
        // dd (session()); 
    }

    public function pdfExportGuest(Request $request)
    {
        if (Session::has('plata_online')) {
            $rezervare = \App\Rezervare::where('id', $request->session()->get('rezervare_id'))->first();
        } else {
            $rezervare = $request->session()->get('rezervare');
        }

        $tarife = $request->session()->get('tarife');

        // $tarife = DB::table('tarife')
        //     ->where([
        //         ['traseu_id', $rezervari->traseu],
        //         ['tur_retur', ($rezervari->tur_retur == 'true' ? 1 : 0)]
        //     ])
        //     ->first();

        if ($request->view_type === 'rezervare-html') {
            return view('rezervari.export.rezervare-pdf', compact('rezervare', 'tarife'));
        } elseif ($request->view_type === 'rezervare-pdf') {
            $pdf = \PDF::loadView('rezervari.export.rezervare-pdf', compact('rezervare', 'tarife'))
                ->setPaper('a4');
            return $pdf->download('Rezervare ' . $rezervare->nume . '.pdf');
        }
    }
}
