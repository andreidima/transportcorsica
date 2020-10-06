<?php

namespace App\Http\Controllers;

use App\Models\Rezervare;
use App\Models\Oras;
use App\Models\Pasager;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;

use Illuminate\Support\Arr;

class RezervareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_nume = \Request::get('search_nume');
        $search_data = \Request::get('search_data');

        $rezervari = Rezervare::with('oras_plecare_nume', 'oras_sosire_nume')
            ->when($search_nume, function ($query, $search_nume) {
                return $query->where('nume', 'like', '%' . $search_nume . '%');
            })
            ->when($search_data, function ($query, $search_data) {
                return $query->whereDate('data_cursa', '=', $search_data);
            })
            ->latest()
            ->simplePaginate(25);

        return view('rezervari.index', compact('rezervari', 'search_nume', 'search_data'));
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
        return view('rezervari.show', compact('rezervare'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rezervare  $rezervare
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Rezervare $rezervare)
    {
        // In cazul in care se intra pe modificare retur, se cauta si se deschide turul, pentru a se pastra logica de lucru cu datele de plecare si intoarcere
        $rezervare = (!$rezervare->tur) ? $rezervare : Rezervare::find($rezervare->tur);

        // Setarea informatiilor suplimentare necesare formularului
        $rezervare->tip_calatorie = $rezervare->nr_adulti ? "Calatori" : "Bagaje";
        $rezervare->traseu = ($rezervare->oras_plecare_nume->tara === "Romania") ? "Romania-Corsica" : "Corsica-Romania";
        $rezervare->tur_retur = ($rezervare->retur) ? "true" : "false";
        $rezervare->data_plecare = $rezervare->data_cursa;
        $rezervare->data_intoarcere = ($rezervare->retur) ? Rezervare::find($rezervare->retur)->data_cursa : '';
        $rezervare->judet_plecare = $rezervare->oras_plecare_nume->judet;
        $rezervare->judet_sosire = $rezervare->oras_sosire_nume->judet;
        $rezervare->acord_de_confidentialitate = "1";
        $rezervare->termeni_si_conditii = "1";

        // Incarcare pasageri in rezervare
        $pasageri = ['nume' => [], 'buletin' => [], 'data_nastere' => [], 'localitate_nastere' => [], 'localitate_domiciliu' => []];
        $i = 1;
        foreach ($rezervare->pasageri_relation as $pasager){
            $pasageri['nume'] = Arr::add($pasageri['nume'], $i, $pasager->nume);
            $pasageri['buletin'] = Arr::add($pasageri['buletin'], $i, $pasager->buletin);
            $pasageri['data_nastere'] = Arr::add($pasageri['data_nastere'], $i, $pasager->data_nastere);
            $pasageri['localitate_nastere'] = Arr::add($pasageri['localitate_nastere'], $i, $pasager->localitate_nastere);
            $pasageri['localitate_domiciliu'] = Arr::add($pasageri['localitate_domiciliu'], $i, $pasager->localitate_domiciliu);
            $i++;
        }
        $rezervare->pasageri = $pasageri;
        // dd($pasageri, $rezervare);
        // Se foloseste acelasi formular ca si la adaugare, asa ca este necesara aceasta variabila pentru diferentiere
        $tip_operatie = "modificare";

        return view('rezervari.guest-create/adauga-rezervare-pasul-1', compact('rezervare', 'tip_operatie'));
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
        // dd($request);
        $this->validateRequest($request);

        $rezervare_tur = (!$rezervare->tur) ? $rezervare : Rezervare::find($rezervare->tur);
        $rezervare_retur = Rezervare::find($rezervare->retur);

        // // Stergerea pasagerilor si adaugarea lor din nou
        // foreach ($rezervare_tur->pasageri_relation as $pasager) {
        //         $pasager->delete();
        // }
        // $rezervare_tur->pasageri_relation()->detach();
        // $rezervare_retur ? $rezervare_retur->pasageri_relation()->detach() : '';
        
        // // dd($request->request, $rezervare_tur, $rezervare_retur, $rezervare);

        $rezervare_tur->traseu_raport = ($rezervare_tur->oras_plecare != $request->oras_plecare) ? Oras::find($request->oras_plecare)->traseu : $rezervare_tur->traseu_raport;
        $rezervare_tur->oras_plecare = $request->oras_plecare;
        $rezervare_tur->oras_sosire = $request->oras_sosire;
        $rezervare_tur->data_cursa = $request->data_plecare;
        $rezervare_tur->nume = $request->nume;
        $rezervare_tur->telefon = $request->telefon;
        $rezervare_tur->email = $request->email;
        $rezervare_tur->observatii = $request->observatii;
        $rezervare_tur->document_de_calatorie = $request->document_de_calatorie;
        $rezervare_tur->serie_document = $request->serie_document;
        $rezervare_tur->cnp = $request->cnp;
        $rezervare_tur->updated_at = \Carbon\Carbon::now();

        if ($rezervare_retur){
            $rezervare_retur->traseu_raport = ($rezervare_retur->oras_plecare != $request->oras_sosire) ? Oras::find($request->oras_sosire)->traseu : $rezervare_retur->traseu_raport;
            $rezervare_retur->oras_plecare = $request->oras_sosire;
            $rezervare_retur->oras_sosire = $request->oras_plecare;
            $rezervare_retur->data_cursa = $request->data_intoarcere;
            $rezervare_retur->nume = $request->nume;
            $rezervare_retur->telefon = $request->telefon;
            $rezervare_retur->email = $request->email;
            $rezervare_retur->observatii = $request->observatii;
            $rezervare_retur->document_de_calatorie = $request->document_de_calatorie;
            $rezervare_retur->serie_document = $request->serie_document;
            $rezervare_retur->cnp = $request->cnp;
            $rezervare_retur->updated_at = \Carbon\Carbon::now();
        }
        
        if($request->tip_calatorie === "Calatori"){
            $rezervare_tur->nr_adulti = $request->nr_adulti;

            if ($rezervare_retur){
                $rezervare_retur->nr_adulti = $request->nr_adulti;
            }
        }else{
            $rezervare_tur->nr_adulti = null;
            $rezervare_tur->pret_total = 0;

            $rezervare_tur->bagaje_kg = $request->bagaje_kg;
            $rezervare_tur->bagaje_descriere = $request->bagaje_descriere;

            if ($rezervare_retur){
                $rezervare_retur->nr_adulti = null;

                $rezervare_retur->bagaje_kg = $request->bagaje_kg;
                $rezervare_retur->bagaje_descriere = $request->bagaje_descriere;
            }
        }

        // Recalcularea pretului total pentru siguranta
        if ($request->tur_retur === "false") {
            $rezervare_tur->pret_total = $rezervare->nr_adulti * 120;
        } elseif ($request->tur_retur === "true") {
            $rezervare->pret_total = $rezervare->nr_adulti * 200;
        }
        if ($rezervare_retur){
            $rezervare_retur->pret_total = 0;
        }

        if ($request->tur_retur === 'false') {
            //Inserarea rezervarii in baza de date
            $rezervare_tur->save();
            $rezervare_retur ? $rezervare_retur->delete() : '';

            //Trimitere sms
            // $this->trimiteSms($rezervare_tur);
        } else {
            //Inserarea rezervarilor in baza de date
            $rezervare_tur->save();
            $rezervare_retur->save();

            //Trimitere sms
            // $this->trimiteSms($rezervare_tur);
            // $this->trimiteSms($rezervare_retur);
        }

        // salvare pasageri si atasare la rezervari
        if($request->tip_calatorie === "Calatori"){
            for ($i = 1; $i <= $request->nr_adulti; $i++) {
                $pasager = new Pasager;
                $pasager->nume = $request->pasageri['nume'][$i];
                $pasager->buletin = $request->pasageri['buletin'][$i];
                $pasager->data_nastere = $request->pasageri['data_nastere'][$i];
                $pasager->localitate_nastere = $request->pasageri['localitate_nastere'][$i];
                $pasager->localitate_domiciliu = $request->pasageri['localitate_domiciliu'][$i];
                $pasager->save();

                if ($request->tur_retur === 'false') {
                    $rezervare_tur->pasageri_relation()->attach($pasager->id);
                }else{
                    $rezervare_tur->pasageri_relation()->attach($pasager->id);
                    $rezervare_retur->pasageri_relation()->attach($pasager->id);
                }
            }
        }

        return redirect('/rezervari')->with('status', 'Rezervarea pentru clientul "' . $rezervare_tur->nume . '" a fost modificată cu succes!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rezervare  $rezervare
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rezervare $rezervare)
    {
        // stergere pasageri - daca nu mai sunt alte rezervari (tur, retur) continand acesti pasageri 
        foreach ($rezervare->pasageri_relation as $pasager) {
            if ($pasager->rezervari->count() < 2) {
                $pasager->delete();
            }
        }

        $rezervare->pasageri_relation()->detach();
        $rezervare->delete();

        if($rezervare->tur){
            $rezervare_tur = Rezervare::find($rezervare->tur);
            if ($rezervare->tur){
                $rezervare_tur->retur = null;
                $rezervare_tur->save();
            }
        } elseif ($rezervare->retur){
            $rezervare_retur = Rezervare::find($rezervare->retur);
            if ($rezervare->retur){
                $rezervare_retur->tur = null;
                $rezervare_retur->save();
            }
        }

        return redirect('/rezervari')->with('status', 'Rezervarea pentru clientul "' . $rezervare->nume . '" a fost ștearsă cu succes!');
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
                'tip_calatorie' => ['required'],
                'traseu' => ['required'],
                'judet_plecare' => [''],
                'oras_plecare' => ['required', 'integer'],
                'judet_sosire' => [''],
                'oras_sosire' => ['required', 'integer'],
                'tur_retur' => [''],
                // 'statie_id' => ['nullable', 'numeric', 'max:999'],
                // 'statie_imbarcare' => ['nullable'],
                'nr_adulti' => ['required_if:tip_calatorie,Calatori', 'integer', 'between:1,100'],
                // 'pasageri.nume' => ['required_if:tip_calatorie,Calatori', 'min:nr_adulti+1'],
                'pasageri.nume.*' => ['filled', 'max:100'],
                'pasageri.buletin.*' => ['filled', 'max:100'],
                'pasageri.data_nastere.*' => ['filled', 'max:100'],
                'pasageri.localitate_nastere.*' => ['filled', 'max:100'],
                'pasageri.localitate_domiciliu.*' => ['filled', 'max:100'],
                // "bagaje_kg" => "required_if:tip_calatorie,Bagaje|regex:/^\d+(\.\d{1,2})?$/",
                'bagaje_kg' => ['required_if:tip_calatorie,Bagaje', 'numeric'],
                'bagaje_descriere' => ['required_if:tip_calatorie,Bagaje', 'max:2000'],
                // 'pret' => ['nullable', 'numeric', 'between:-0, 99999.99'],
                // 'nr_copii' => ['nullable', 'integer', 'between:0,100'],
                // 'data_plecare' => [''],
                'data_plecare' => [
                    // 'required_if:traseu,Romania-Corsica', 
                    // 'required_if:tur_retur,true'
                    'required'
                ],
                'data_intoarcere' => [
                    // 'basil',
                    'required_if:tur_retur,true',
                    // 'required_unless:traseu,Romania-Corsica',
                    'after:data_plecare', 
                    'max:50',
                    function ($attribute, $value, $fail) use ($request) {
                        $data_plecare = \Carbon\Carbon::parse($request->data_plecare);
                        $data_intoarcere = \Carbon\Carbon::parse($request->data_intoarcere);
                        // if (($request->traseu == 'Romania-Corsica') && ($request->tur_retur == true) && ($data_plecare > $data_intoarcere)) {
                        //     $fail('Data de intoarcere trebuie sa fie mai mare decât data de plecare.');
                        // } elseif (($request->traseu == 'Corsica-Romania') && ($request->tur_retur == true) && ($data_plecare < $data_intoarcere)) {
                        //     $fail('Data de intoarcere trebuie sa fie mai mare decât data de plecare.');
                        // } elseif (($request->tur_retur == true) && ($data_plecare->diffInDays($data_intoarcere) > 15)) {
                        //     $fail('Data de intoarcere trebuie sa fie la maxim 30 de zile de la data de plecare.');
                        // }
                        if (($request->tur_retur == true) && ($data_plecare->diffInDays($data_intoarcere) > 15)) {
                            $fail('Data de intoarcere trebuie sa fie la maxim 15 zile de la data de plecare.');
                        }
                    },
                ],
                // 'ora_id' =>[ 'required', 'nullable', 'max:99'],
                'nume' => ($request->_method === "PATCH") ?
                    [
                        'required', 'max:200',
                        // Rule::unique('rezervari')->ignore($rezervari->id)->where(function ($query) use ($rezervari, $request) {
                        //     return $query->where('telefon', $request->telefon)
                        //         ->where('data_cursa', $request->data_cursa);
                        // }),
                    ]
                    : [
                        'required', 'max:200',
                        Rule::unique('rezervari')->where(function ($query) use ($rezervari, $request) {
                            return $query->where('telefon', $request->telefon)
                                ->where('data_cursa', $request->data_plecare);
                        }),
                    ],
                'telefon' => ['required', 'regex:/^[0-9 ]+$/', 'max: 100'],
                'email' => ['nullable', 'email', 'max:100'],
                // 'pret_total' => ['nullable', 'numeric', 'max:999999'],
                'adresa' => ['max:2000'],
                'observatii' => ['max:2000'],
                // 'pasageri' => ['max:2000'],

                // 'plata_online' => [''],
                // 'adresa' => ['required_if:plata_online,true', 'nullable', 'max:99'],

                'document_de_calatorie' => ['', 'max:100'],
                'expirare_document' => ['', 'max:100'],
                'serie_document' => ['', 'max:100'],
                'cnp' => ['', 'max:100'],
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
                'nr_adulti.required_if' => 'Câmpul Nr. Pasageri este necesar.',
                'nr_adulti.integer' => 'Câmpul Nr. Pasageri trebuie să conțină un număr.',
                'nr_adulti.between' => 'Câmpul Nr. Pasageri trebuie să fie între 1 și 100.',
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
    public function adaugaRezervareNoua(Request $request)
    {
        $rezervare = $request->session()->forget('rezervare');
        return redirect('/adauga-rezervare-pasul-1');
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
        $rezervare = $request->session()->get('rezervare');
        return view('rezervari.guest-create/adauga-rezervare-pasul-1', compact('rezervare'));
    }

    /**
     * Post Request to store step1 info in session
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postAdaugaRezervarePasul1(Request $request)
    {
        if(empty($request->session()->get('rezervare'))){
            $rezervare = new Rezervare();
            $rezervare->fill($this->validateRequest($request));
        }else{
            $rezervare = $request->session()->get('rezervare');
            $rezervare->fill($this->validateRequest($request));
        }

        // Recalcularea pretului total pentru siguranta
        if ($rezervare->tur_retur === "false") {
            $rezervare->pret_total = $rezervare->nr_adulti * 120;
        } elseif ($rezervare->tur_retur === "true") {
            $rezervare->pret_total = $rezervare->nr_adulti * 200;
        }

        $request->session()->put('rezervare', $rezervare);

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
        // dd($rezervare);
        return view('rezervari.guest-create/adauga-rezervare-pasul-2', compact('rezervare'));
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
        // dd($rezervare);
        $rezervare->created_at = \Carbon\Carbon::now();
               
        // Verificare rezervare duplicat
        $request_verificare_duplicate = new Request([
            'nume' => $request->session()->get('rezervare.nume'),
            'telefon' => $request->session()->get('rezervare.telefon'),
            'data_plecare' => $request->session()->get('rezervare.data_plecare')
        ]);

        $this->validate(
            $request_verificare_duplicate,
            [
                'nume' => ['required', 'max:100', 'unique:rezervari,nume,NULL,id,telefon,' . $request_verificare_duplicate->telefon . ',data_cursa,' . $request_verificare_duplicate->data_plecare]
            ],
            [
                'nume.unique' => 'Această Rezervare este deja înregistrată.'
            ]
        );

        $rezervare_unset = clone $rezervare;
        unset($rezervare_unset->tip_calatorie,
            $rezervare_unset->traseu,
            $rezervare_unset->tur_retur,
            $rezervare_unset->data_plecare,
            $rezervare_unset->data_intoarcere,
            $rezervare_unset->judet_plecare,
            $rezervare_unset->judet_sosire,
            $rezervare_unset->oras_plecare_nume,
            $rezervare_unset->oras_sosire_nume,
            $rezervare_unset->pasageri,
            $rezervare_unset->acord_de_confidentialitate,
            $rezervare_unset->termeni_si_conditii
        );
        
        if($rezervare->tip_calatorie === "Calatori"){
            unset($rezervare_unset->bagaje_kg,
                $rezervare_unset->bagaje_descriere
            );
        }else{
            unset($rezervare_unset->nr_adulti);
            $rezervare_unset->pret_total = 0;
        }

        $rezervare_tur = clone $rezervare_unset;
        $rezervare_retur = clone $rezervare_unset;

        $rezervare_tur->data_cursa = $rezervare->data_plecare;
        $rezervare_tur->traseu_raport = Oras::find($rezervare_tur->oras_plecare)->traseu;
        $rezervare_retur->data_cursa = $rezervare->data_intoarcere;
        $rezervare_retur->oras_plecare = $rezervare_tur->oras_sosire;
        $rezervare_retur->oras_sosire = $rezervare_tur->oras_plecare;
        $rezervare_retur->traseu_raport = Oras::find($rezervare_retur->oras_plecare)->traseu;
        $rezervare_retur->pret_total = 0;

        if ($rezervare->tur_retur === 'false') {
            //Inserarea rezervarii in baza de date
            $rezervare_tur->save();

            $request->session()->put('rezervare_tur', $rezervare_tur);

            //Trimitere sms
            // $this->trimiteSms($rezervare_tur);
        } else {
            //Inserarea rezervarilor in baza de date
            $rezervare_tur->save();
            $rezervare_retur->save();

            //adaugarea id-urilor de tur - retur la fiecare in parte
            $rezervare_tur->retur = $rezervare_retur->id;
            $rezervare_tur->update();
            $rezervare_retur->tur = $rezervare_tur->id;
            $rezervare_retur->update();

            $request->session()->put('rezervare_tur', $rezervare_tur);
            $request->session()->put('rezervare_retur', $rezervare_retur);

            //Trimitere sms
            // $this->trimiteSms($rezervare_tur);
            // $this->trimiteSms($rezervare_retur);
        }

        // salvare pasageri si atasare la rezervari
        if($rezervare->tip_calatorie === "Calatori"){
            for ($i = 1; $i <= $rezervare->nr_adulti; $i++) {
                $pasager = new Pasager;
                $pasager->nume = $rezervare->pasageri['nume'][$i];
                $pasager->buletin = $rezervare->pasageri['buletin'][$i];
                $pasager->data_nastere = $rezervare->pasageri['data_nastere'][$i];
                $pasager->localitate_nastere = $rezervare->pasageri['localitate_nastere'][$i];
                $pasager->localitate_domiciliu = $rezervare->pasageri['localitate_domiciliu'][$i];
                $pasager->save();

                if ($rezervare->tur_retur === 'false') {
                    $rezervare_tur->pasageri_relation()->attach($pasager->id);
                }else{
                    $rezervare_tur->pasageri_relation()->attach($pasager->id);
                    $rezervare_retur->pasageri_relation()->attach($pasager->id);
                }
            }
        }

        // Trimitere email
        if (stripos($rezervare->nume, 'Andrei Dima Test') !== false) {
            if (stripos($rezervare->nume, 'fara email') !== false) {
                // nu se trimite email
            } else {
                // \Mail::to('adima@validsoftware.ro')->send(
                //     new CreareRezervare($rezervare, $tarife)
                // );
            }
        } else {
            // \Mail::to('alsimy_mond_travel@yahoo.com')->send(
            //     new CreareRezervare($rezervare, $tarife)
            // );
        }

        // Cu sau fara plata online
        switch ($request->input('action')) {
            case 'cu_plata_online':
                // if (stripos($rezervare->nume, 'Andrei Dima Test') !== false) {
                //     if (stripos($rezervare->nume, 'fara plata') !== false) {
                //         return redirect('/adauga-rezervare-pasul-3');
                //     } else {
                //         return redirect('/trimitere-catre-plata');
                //     }
                // } else {
                //     $rezervare->tabel = 'rezervari';
                //     $rezervare->currency = 'EUR';
                //     $rezervare->return_url = 'https://aplicatie.alsimymondtravel.ro/adauga-rezervare-pasul-3';

                //     return redirect('/trimitere-catre-plata');
                // }
                return redirect('/adauga-rezervare-pasul-3');
            break;
            case 'fara_plata_online':
                return redirect('/adauga-rezervare-pasul-3');
            case 'modificare_rezervare':
                return redirect('/adauga-rezervare-pasul-1');
            break; 
        }
    }

    /**
     * Show the step 3 Form for creating a new 'rezervare'.
     *
     * @return \Illuminate\Http\Response
     */
    public function adaugaRezervarePasul3(Request $request)
    {
        // if ($request->has('orderId')) {
        //     $plata_online = \App\PlataOnline::where('order_id', $request->orderId)->latest()->first();
        //     $rezervare = \App\Rezervare::where('id', $plata_online->rezervare_id)->first();

        //     $request->session()->put('plata_online', $plata_online);
        //     $request->session()->forget('rezervare');
        //     $request->session()->put('rezervare_id', $rezervare->id);

        //     return view('rezervari.guest-create/adauga-rezervare-pasul-3', compact('rezervare', 'plata_online'));
        // } else {
        //     $rezervare = $request->session()->get('rezervare');

        //     return view('rezervari.guest-create/adauga-rezervare-pasul-3', compact('rezervare'));
        // }

        $rezervare_tur = $request->session()->get('rezervare_tur');

        if (!$rezervare_tur->retur){
            $rezervare_retur = null;
        } else {
            $rezervare_retur = $request->session()->get('rezervare_retur');
        }

        return view('rezervari.guest-create/adauga-rezervare-pasul-3', compact('rezervare_tur', 'rezervare_retur'));
    }

    public function pdfExportGuest(Request $request)
    {
        // if (Session::has('plata_online')) {
        //     $rezervare = \App\Rezervare::where('id', $request->session()->get('rezervare_id'))->first();
        // } else {
        //     $rezervare = $request->session()->get('rezervare');
        // }

        $rezervare_tur = $request->session()->get('rezervare_tur');

        if (!$rezervare_tur->retur){
            $rezervare_retur = null;
        } else {
            $rezervare_retur = $request->session()->get('rezervare_retur');
        }

        if ($request->view_type === 'rezervare-html') {
            return view('rezervari.export.rezervare-pdf', compact('rezervare_tur', 'rezervare_retur'));
        } elseif ($request->view_type === 'rezervare-pdf') {
            $pdf = \PDF::loadView('rezervari.export.rezervare-pdf', compact('rezervare_tur', 'rezervare_retur'))
                ->setPaper('a4');
            return $pdf->download('Rezervare ' . $rezervare_tur->nume . '.pdf');
        }
    }
}
