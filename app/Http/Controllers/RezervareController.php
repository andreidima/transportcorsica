<?php

namespace App\Http\Controllers;

use App\Models\Rezervare;
use App\Models\Oras;
use App\Models\Pasager;
use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use DB;

use Carbon\Carbon;

use App\Mail\RezervareFinalizata;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

use App\Traits\TrimiteSmsTrait;

class RezervareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    use TrimiteSmsTrait;

    public function index()
    {
        $search_nume = \Request::get('search_nume');
        $search_bilet_numar = \Request::get('search_bilet_numar');
        $search_data = \Request::get('search_data');

        // if ($search_nume){
        //     $pasageri = Pasager::where('nume', 'like', '%' . $search_nume . '%')->pluck('id')->all();
        //     // dd($search_nume, $pasageri);
        // }

        $rezervari = Rezervare::with('oras_plecare_nume', 'oras_sosire_nume', 'retur_relation', 'pasageri_relation', 'user')
            // ->when($search_nume, function (Builder $query, $search_nume) {
            //     $query->whereHas('pasageri_relation', function (Builder $query) use ($search_nume) {
            //         $query->where('nume', 'like', '%' . $search_nume . '%');
            //     });
            // })
            ->when($search_nume, function (Builder $query, $search_nume) {
                if (strlen($search_nume) >= 3){
                    $pasageri = Pasager::where('nume', 'like', '%' . $search_nume . '%')->pluck('id')->all();
                    $rezervari = DB::table('pasageri_rezervari')
                        ->whereIn('pasager_id', $pasageri)
                        ->pluck('rezervare_id')
                        ->all();
                    // dd($rezervari, $pasageri);
                    // return $query->where(function($query) use($rezervari, $search_nume) {
                            $query->whereIn('id', $rezervari) // rezervarile cu pasageri
                                ->orwhere('nume', 'like', '%' . $search_nume . '%'); // rezervarile de colete
                    // });
                } else {
                    return $query->where('id', 0); // nu va returna nici un rezultat
                }
            })
            // ->when($search_nume, function (Builder $query, $search_nume) {
            //     $query->whereHas('pasageri_relation', function (Builder $query) use ($search_nume) {
            //         $query->where('nume', 'like', '%' . $search_nume . '%');
            //     });
            // })
            // Daca se cauta dupa bilet, se afiseaza chiar daca este retur, pentru ca altfel e posibil sa nu apara nici o rezervare
            // Daca nu se cauta dupa bilet, se afiseaza doar turul rezervarilor
            ->when($search_bilet_numar, function ($query, $search_bilet_numar) {
                return $query->where('bilet_numar', $search_bilet_numar);
            }, function ($query) {
                    return $query->whereNull('tur');
            })
            ->when($search_data, function ($query, $search_data) {
                return $query->whereDate('data_cursa', '=', $search_data);
            })
            // ->whereNull('tur')
            ->where(function ($query) use ($search_nume) {
                if ( !(strlen($search_nume) >= 3) ){ // doar la cautare pot si soferii sa caute prin toata baza de date
                    if ((auth()->user()->role === 'administrator') || (auth()->user()->role === 'superadmin')){
                        return;
                    } elseif (auth()->user()->role === 'sofer'){
                        // return $query->whereBetween('data_cursa', [\Carbon\Carbon::now()->startOfWeek(), \Carbon\Carbon::now()->endOfWeek()]);
                        return $query->whereDate('data_cursa', '>=', \Carbon\Carbon::now()->startOfWeek());
                    }
                }
            })
            ->orderBy('rezervari.created_at', 'desc')
            ->simplePaginate(25);

        $clienti_neseriosi = \App\Models\ClientNeserios::pluck('nume')->all();

        return view('rezervari.index', compact('rezervari', 'search_nume', 'search_data', 'search_bilet_numar', 'clienti_neseriosi'));
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
        $this->authorize('update', $rezervare);

        $rezervare_tur = $rezervare;
        $rezervare_retur = Rezervare::find($rezervare->retur);
        return view('rezervari.show', compact('rezervare_tur', 'rezervare_retur'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rezervare  $rezervare
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Rezervare $rezervare)
    {
        $this->authorize('update', $rezervare);

        // In cazul in care se intra pe modificare retur, se cauta si se deschide turul, pentru a se pastra logica de lucru cu datele de plecare si intoarcere
        $rezervare = (!$rezervare->tur) ? $rezervare : Rezervare::find($rezervare->tur);
        // dd($rezervare, $rezervare->data_cursa);
        // Setarea informatiilor suplimentare necesare formularului
        $rezervare->tip_calatorie = isset($rezervare->nr_adulti) ? "Calatori" : "Colete";
        $rezervare->traseu = (($rezervare->oras_plecare_nume->tara ?? null) === "Romania") ? "Romania-Corsica" : "Corsica-Romania";
        $rezervare->tur_retur = ($rezervare->retur) ? "true" : "false";
        $rezervare->data_plecare = $rezervare->data_cursa;
        $rezervare->data_intoarcere = ($rezervare->retur) ? (Rezervare::find($rezervare->retur)->data_cursa ?? '') : '';
        $rezervare->pret_total_tur = $rezervare->pret_total;
        $rezervare->pret_total_retur = ($rezervare->retur) ? (Rezervare::find($rezervare->retur)->pret_total ?? '') : 0;
        // $rezervare->judet_plecare = $rezervare->oras_plecare_nume->judet ?? null;
        // $rezervare->judet_sosire = $rezervare->oras_sosire_nume->judet ?? null;
        $rezervare->acord_de_confidentialitate = "1";
        $rezervare->termeni_si_conditii = "1";

        // Incarcare pasageri in rezervare
        $adulti = [
            'nume' => [],
            // 'buletin' => [],
            'data_nastere' => [],
            'localitate_nastere' => [],
            // 'localitate_domiciliu' => []
            'sex' => [],
        ];
        $i = 1;
        foreach ($rezervare->pasageri_relation_adulti as $adult){
            $adulti['nume'] = Arr::add($adulti['nume'], $i, $adult->nume);
            // $adulti['buletin'] = Arr::add($adulti['buletin'], $i, $adult->buletin);
            $adulti['data_nastere'] = Arr::add($adulti['data_nastere'], $i, $adult->data_nastere);
            $adulti['localitate_nastere'] = Arr::add($adulti['localitate_nastere'], $i, $adult->localitate_nastere);
            // $adulti['localitate_domiciliu'] = Arr::add($adulti['localitate_domiciliu'], $i, $adult->localitate_domiciliu);
            $adulti['sex'] = Arr::add($adulti['sex'], $i, $adult->sex);
            $i++;
        }
        $rezervare->adulti = $adulti;
        $copii = [
            'nume' => [],
            // 'buletin' => [],
            'data_nastere' => [],
            'localitate_nastere' => [],
            // 'localitate_domiciliu' => []
            'sex' => [],
        ];
        $i = 1;
        foreach ($rezervare->pasageri_relation_copii as $copil) {
            $copii['nume'] = Arr::add($copii['nume'], $i, $copil->nume);
            // $copii['buletin'] = Arr::add($copii['buletin'], $i, $copil->buletin);
            $copii['data_nastere'] = Arr::add($copii['data_nastere'], $i, $copil->data_nastere);
            $copii['localitate_nastere'] = Arr::add($copii['localitate_nastere'], $i, $copil->localitate_nastere);
            // $copii['localitate_domiciliu'] = Arr::add($copii['localitate_domiciliu'], $i, $copil->localitate_domiciliu);
            $copii['sex'] = Arr::add($copii['sex'], $i, $copil->sex);
            $i++;
        }
        $rezervare->copii = $copii;

        // Incarcarea datelor de facturare in rezervare
        if ($rezervare->factura){
            $rezervare->cumparator = $rezervare->factura->cumparator;
            $rezervare->nr_reg_com = $rezervare->factura->nr_reg_com;
            $rezervare->cif = $rezervare->factura->cif;
            $rezervare->sediul = $rezervare->factura->sediul;
        }

        // Se foloseste acelasi formular ca si la adaugare, asa ca este necesara aceasta variabila pentru diferentiere
        $tip_operatie = "modificare";

        // salvarea ultimului URL, pentru intoarcerea la Rapoarte daca de acolo s-a initiat modificarea
        $last_url = url()->previous();

        return view('rezervari.guest-create/adauga-rezervare-pasul-1', compact('rezervare', 'tip_operatie', 'last_url'));
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
        // dd($request, $rezervare);
        $this->authorize('update', $rezervare);

        $rezervare_tur = (!$rezervare->tur) ? $rezervare : Rezervare::find($rezervare->tur);
        if (!$rezervare_retur = Rezervare::find($rezervare->retur)){
            if ($request->tur_retur === "true"){
                $rezervare_retur = new Rezervare;
            }
        }

        // dd($rezervare_tur, $rezervare_retur);

        $this->validateRequest($request, '', $rezervare_tur, $rezervare_retur);
        // dd($request);

        // Stergerea pasagerilor si adaugarea lor din nou
        foreach ($rezervare_tur->pasageri_relation as $pasager) {
                $pasager->delete();
        }
        $rezervare_tur->pasageri_relation()->detach();
        isset($rezervare_retur) ? $rezervare_retur->pasageri_relation()->detach() : '';

        // // dd($request->request, $rezervare_tur, $rezervare_retur, $rezervare);

        $rezervare_tur->lista_plecare = ($rezervare_tur->oras_plecare != $request->oras_plecare) ? (Oras::find($request->oras_plecare)->traseu ?? null) : $rezervare_tur->lista_plecare;
        $rezervare_tur->lista_sosire = ($rezervare_tur->oras_sosire != $request->oras_sosire) ? (Oras::find($request->oras_sosire)->traseu ?? null) : $rezervare_tur->lista_sosire;
        // $rezervare_tur->lista_plecare = ($rezervare_tur->oras_plecare != $request->oras_plecare) ? null : $rezervare_tur->lista_plecare;
        // $rezervare_tur->lista_sosire = ($rezervare_tur->oras_sosire != $request->oras_sosire) ? null : $rezervare_tur->lista_sosire;
        $rezervare_tur->oras_plecare = $request->oras_plecare;
        $rezervare_tur->oras_sosire = $request->oras_sosire;
        $rezervare_tur->data_cursa = $request->data_plecare;
        $rezervare_tur->bilet_nava = $request->bilet_nava;
        $rezervare_tur->nume = $request->nume;
        $rezervare_tur->telefon = $request->telefon;
        $rezervare_tur->email = $request->email;
        $rezervare_tur->adresa = $request->adresa;
        $rezervare_tur->observatii = $request->observatii;
        $rezervare_tur->document_de_calatorie = $request->document_de_calatorie;
        $rezervare_tur->serie_document = $request->serie_document;
        $rezervare_tur->cnp = $request->cnp;
        $rezervare_tur->acord_newsletter = $request->acord_newsletter;
        $rezervare_tur->updated_at = \Carbon\Carbon::now();

        if(isset($rezervare_retur)){
            $rezervare_retur->lista_plecare = ($rezervare_retur->oras_plecare != $request->oras_sosire) ? (Oras::find($request->oras_sosire)->traseu ?? null) : $rezervare_retur->lista_plecare;
            $rezervare_retur->lista_sosire = ($rezervare_retur->oras_sosire != $request->oras_plecare) ? (Oras::find($request->oras_plecare)->traseu ?? null) : $rezervare_retur->lista_sosire;
            // $rezervare_retur->lista_plecare = ($rezervare_retur->oras_plecare != $request->oras_sosire) ? null : $rezervare_retur->lista_plecare;
            // $rezervare_retur->lista_sosire = ($rezervare_retur->oras_plecare != $request->oras_plecare) ? null : $rezervare_retur->lista_sosire;
            $rezervare_retur->oras_plecare = $request->oras_sosire;
            $rezervare_retur->oras_sosire = $request->oras_plecare;
            $rezervare_retur->data_cursa = $request->data_intoarcere;
            $rezervare_retur->bilet_nava = $request->bilet_nava;
            $rezervare_retur->nume = $request->nume;
            $rezervare_retur->telefon = $request->telefon;
            $rezervare_retur->email = $request->email;
            $rezervare_retur->adresa = $request->adresa;
            $rezervare_retur->observatii = $request->observatii;
            $rezervare_retur->document_de_calatorie = $request->document_de_calatorie;
            $rezervare_retur->serie_document = $request->serie_document;
            $rezervare_retur->cnp = $request->cnp;
            $rezervare_retur->acord_newsletter = $request->acord_newsletter;
            $rezervare_retur->updated_at = \Carbon\Carbon::now();
        }

        if($request->tip_calatorie === "Calatori"){
            $rezervare_tur->nr_adulti = $request->nr_adulti;
            $rezervare_tur->nr_copii = $request->nr_copii;
            $rezervare_tur->pret_total = $request->pret_total_tur;

            // Salvarea preturilor in lei in tabelul de rezervari, pentru a emite chitante
            $rezervare_tur->valoare_lei_tva = ($rezervare_tur->pret_total * $rezervare_tur->curs_bnr_euro) * 0.19;
            $rezervare_tur->valoare_lei = ($rezervare_tur->pret_total * $rezervare_tur->curs_bnr_euro) - $rezervare_tur->valoare_lei_tva;

            if (isset($rezervare_retur)){
                $rezervare_retur->nr_adulti = $request->nr_adulti;
                $rezervare_retur->nr_copii  = $request->nr_copii;
                $rezervare_retur->pret_total = $request->pret_total_retur;

                // Salvarea preturilor in lei in tabelul de rezervari, pentru a emite chitante
                $rezervare_retur->curs_bnr_euro = $rezervare_tur->curs_bnr_euro;
                $rezervare_retur->valoare_lei_tva = ($rezervare_retur->pret_total * $rezervare_retur->curs_bnr_euro) * 0.19;
                $rezervare_retur->valoare_lei = ($rezervare_retur->pret_total * $rezervare_retur->curs_bnr_euro) - $rezervare_retur->valoare_lei_tva;
            }
        }elseif($request->tip_calatorie === "Colete"){
            $rezervare_tur->nr_adulti = null;
            $rezervare_tur->nr_copii = null;

            $rezervare_tur->pret_total = $request->pret_total_tur;
            // Salvarea preturilor in lei in tabelul de rezervari, pentru a emite chitante
            $rezervare_tur->valoare_lei_tva = ($rezervare_tur->pret_total * $rezervare_tur->curs_bnr_euro) * 0.19;
            $rezervare_tur->valoare_lei = ($rezervare_tur->pret_total * $rezervare_tur->curs_bnr_euro) - $rezervare_tur->valoare_lei_tva;

            $rezervare_tur->colete_numar = $request->colete_numar;
            $rezervare_tur->colete_kg = $request->colete_kg;
            $rezervare_tur->colete_volum = $request->colete_volum;
            $rezervare_tur->colete_natura_marfii = $request->colete_natura_marfii;
            $rezervare_tur->colete_mod_ambalare = $request->colete_mod_ambalare;
            $rezervare_tur->colete_descriere = $request->colete_descriere;

            $rezervare_tur->colete_nume_destinatar = $request->colete_nume_destinatar;
            $rezervare_tur->colete_telefon_destinatar = $request->colete_telefon_destinatar;
            $rezervare_tur->colete_email_destinatar = $request->colete_email_destinatar;
            $rezervare_tur->colete_adresa_destinatar = $request->colete_adresa_destinatar;


            if (isset($rezervare_retur)){
                $rezervare_retur->nr_adulti = null;
                $rezervare_retur->nr_copii = null;

                $rezervare_retur->pret_total = $request->pret_total_tur;
                // Salvarea preturilor in lei in tabelul de rezervari, pentru a emite chitante
                $rezervare_retur->valoare_lei_tva = ($rezervare_retur->pret_total * $rezervare_retur->curs_bnr_euro) * 0.19;
                $rezervare_retur->valoare_lei = ($rezervare_retur->pret_total * $rezervare_retur->curs_bnr_euro) - $rezervare_retur->valoare_lei_tva;

                $rezervare_retur->colete_numar = $request->colete_numar;
                $rezervare_retur->colete_kg = $request->colete_kg;
                $rezervare_retur->colete_volum = $request->colete_volum;
                $rezervare_retur->colete_natura_marfii = $request->colete_natura_marfii;
                $rezervare_retur->colete_mod_ambalare = $request->colete_mod_ambalare;
                $rezervare_retur->colete_descriere = $request->colete_descriere;

                $rezervare_retur->colete_nume_destinatar = $request->colete_nume_destinatar;
                $rezervare_retur->colete_telefon_destinatar = $request->colete_telefon_destinatar;
                $rezervare_retur->colete_email_destinatar = $request->colete_email_destinatar;
                $rezervare_retur->colete_adresa_destinatar = $request->colete_adresa_destinatar;
            }
        }

        if ($request->tur_retur === 'false') {
            //Inserarea rezervarii in baza de date
            $rezervare_tur->retur = null;
            $rezervare_tur->save();
            isset($rezervare_retur) ? $rezervare_retur->delete() : '';

            //Trimitere sms
            // $this->trimiteSms($rezervare_tur);
        } else {
            //Inserarea rezervarilor in baza de date
            $rezervare_tur->save();
            $rezervare_retur->save();

            // Adaugarea cheii unice la retur daca aceasta lipseste, in cazul in care rezervarea initiala era fara retur
            ($rezervare_retur->cheie_unica === null) ? ($rezervare_retur->cheie_unica = uniqid('retur')) : '';

            //adaugarea id-urilor de tur - retur la fiecare in parte
            $rezervare_tur->retur = $rezervare_retur->id;
            $rezervare_tur->update();
            $rezervare_retur->tur = $rezervare_tur->id;
            $rezervare_retur->update();

            //Trimitere sms
            // $this->trimiteSms($rezervare_tur);
            // $this->trimiteSms($rezervare_retur);
        }

        // salvare pasageri si atasare la rezervari
        if ($request->tip_calatorie === "Calatori") {
            for ($i = 1; $i <= $request->nr_adulti; $i++) {
                $pasager = new Pasager;
                $pasager->nume = $request->adulti['nume'][$i];
                // $pasager->buletin = $request->adulti['buletin'][$i];
                $pasager->data_nastere = $request->adulti['data_nastere'][$i];
                $pasager->localitate_nastere = $request->adulti['localitate_nastere'][$i];
                // $pasager->localitate_domiciliu = $request->adulti['localitate_domiciliu'][$i];
                $pasager->sex = $request->adulti['sex'][$i] ?? '';
                $pasager->categorie = 'Adult';
                $pasager->save();

                if ($request->tur_retur === 'false') {
                    $rezervare_tur->pasageri_relation()->attach($pasager->id);
                } else {
                    $rezervare_tur->pasageri_relation()->attach($pasager->id);
                    $rezervare_retur->pasageri_relation()->attach($pasager->id);
                }
            }
            for ($i = 1; $i <= $request->nr_copii; $i++) {
                $pasager = new Pasager;
                $pasager->nume = $request->copii['nume'][$i];
                // $pasager->buletin = $request->copii['buletin'][$i];
                $pasager->data_nastere = $request->copii['data_nastere'][$i];
                $pasager->localitate_nastere = $request->copii['localitate_nastere'][$i];
                // $pasager->localitate_domiciliu = $request->copii['localitate_domiciliu'][$i];
                $pasager->sex = $request->copii['sex'][$i] ?? '';
                $pasager->categorie = 'Copil';
                $pasager->save();

                if ($request->tur_retur === 'false') {
                    $rezervare_tur->pasageri_relation()->attach($pasager->id);
                } else {
                    $rezervare_tur->pasageri_relation()->attach($pasager->id);
                    $rezervare_retur->pasageri_relation()->attach($pasager->id);
                }
            }

            // Salvare Factura
            if ($rezervare->factura_valida()->count() === 0){
                if ($request->cumparator) {
                    $factura = new Factura;
                    $factura->cumparator = $request->cumparator;
                    $factura->nr_reg_com = $request->nr_reg_com;
                    $factura->cif = $request->cif;
                    $factura->sediul = $request->sediul;
                    $factura->seria = Factura::select('seria')->latest()->first()->seria ?? 'MRW88';
                    $factura->numar = (Factura::select('numar')->latest()->first()->numar ?? 0) + 1;
                    // dd($rezervare_tur->pret_total, $rezervare_retur->pret_total ?? 0);
                    $factura->valoare_euro = $rezervare_tur->pret_total + ($rezervare_retur->pret_total ?? 0);

                    $factura->curs_bnr_euro = $rezervare_tur->curs_bnr_euro;

                    $factura->valoare_lei_tva = $rezervare_tur->valoare_lei_tva + ($rezervare_retur->valoare_lei_tva ?? 0);
                    $factura->valoare_lei = $rezervare_tur->valoare_lei + ($rezervare_retur->valoare_lei ?? 0);

                    $rezervare_tur->factura()->save($factura);
                }
            }
        }

        return redirect($request->last_url)->with('status', 'Rezervarea a fost modificată cu succes!');
        // return back()->with('status', 'Rezervarea a fost modificată cu succes! sasdf');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rezervare  $rezervare
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rezervare $rezervare)
    {
        $this->authorize('update', $rezervare);

        // Daca exista factura emisa, se blocheaza stergerea rezervarii
        // In cazul in care se intra pe stergere retur (lucru posibil doar din rapoarte), se cauta si se verifica turul
        $rezervare_factura = (!$rezervare->tur) ? $rezervare : Rezervare::find($rezervare->tur);
        if ($rezervare_factura->factura()->exists()){
            return back()->with('error', 'Rezervarea nu poate fi ștearsă pentru că are deja factură emisă!');
        }

        // if (strpos(url()->previous(), 'rezervari') !== false) {
        //     echo 'rezervari <br>';
        // }
        // if (strpos(url()->previous(), 'rapoarte') !== false) {
        //     echo 'rapoarte <br>';
        // }
        // dd(url()->previous(), strpos(url()->previous(), 'rezervari'), strpos(url()->previous(), 'rapoarte'));


        // Daca stergerea se face din „rezervari”, se va sterge complet si turul si returul
        if ((strpos(url()->previous(), '.test/rezervari') !== false) || (strpos(url()->previous(), '.ro/rezervari') !== false)) {
            // Daca exista bilet emis, se blocheaza stergerea rezervarii.
            if (is_null($rezervare->bilet_numar)){
                // stergere pasageri
                foreach ($rezervare->pasageri_relation as $pasager) {
                        $pasager->delete();
                }

                $rezervare->pasageri_relation()->detach();
                $rezervare->delete();

                if ($rezervare->retur){
                    $rezervare_retur = Rezervare::find($rezervare->retur);
                    if($rezervare_retur){
                        $rezervare_retur->pasageri_relation()->detach();
                        $rezervare_retur->delete();
                    }
                }
                // elseif ($rezervare->tur){
                //     $rezervare_tur = Rezervare::find($rezervare->tur);
                //     if($rezervare_tur){
                //         $rezervare_tur->pasageri_relation()->detach();
                //         $rezervare_tur->delete();
                //     }
                // }
                return back()->with('status', 'Rezervarea a fost ștearsă cu succes!');
            } else {
                return back()->with('error', 'Rezervarea nu poate fi ștearsă pentru că are deja bilet emis!');
            }

        // Daca stergerea se face din „rapoarte”, se va sterge doar turul sau returul
        } elseif (strpos(url()->previous(), 'rapoarte/') !== false) {
            // Daca rezervarea este tur - retur, se va trimite utilizatorul sa o vizualizeze complet in rezervari, pentru a putea lua o decizie in deplina cunostinta de cauza
            if ($rezervare->tur || $rezervare->retur) {
                return back()->with('error', 'Această rezervare este tur-retur. Vizualizează întâi această rezervare în pagina de Rezervări, de unde poate fi modificată sau ștearsă complet!');
            } else {
                // Daca exista bilet emis, se blocheaza stergerea rezervarii.
                if (is_null($rezervare->bilet_numar)){

                    // Pasagerii se sterg din baza de date
                    foreach ($rezervare->pasageri_relation as $pasager) {
                            $pasager->delete();
                    }

                    $rezervare->pasageri_relation()->detach();
                    $rezervare->delete();

                    return back()->with('status', 'Rezervarea a fost ștearsă cu succes!');
                } else {
                    return back()->with('error', 'Rezervarea nu poate fi ștearsă pentru că are deja bilet emis!');
                }
            }
        }
    }


    /**
     * Insereaza Pasagerii in lista de Clienti Neseriosi
     *
     * @param  \App\Models\Rezervare  $rezervare
     * @return \Illuminate\Http\Response
     */
    public function insereazaPasageriNeseriosi(Request $request, Rezervare $rezervare)
    {
        // dd($rezervare, $rezervare->oras_plecare_nume->oras);
        foreach ($rezervare->pasageri_relation as $pasager){
            $client_neserios = \App\Models\ClientNeserios::make();
            $client_neserios->nume = $pasager->nume;
            $client_neserios->telefon = $rezervare->telefon;
            $client_neserios->data_cursa = $rezervare->data_cursa;
            $client_neserios->oras_plecare = $rezervare->oras_plecare_nume->oras;
            $client_neserios->oras_sosire = $rezervare->oras_sosire_nume->oras;
            $client_neserios->observatii = $request->observatii;
            // dd($client_neserios);
            $client_neserios->save();
        }

        if (is_null($rezervare->bilet_numar)) {
            // Trimitere catre stergere rezervare
            $this->destroy($rezervare);

            return back()->with('status', 'Pasagerii au fost introduși cu succes în lista de „Clienți Neserioși”, iar apoi au fost șterși!');
        } else {
            return back()->with('warning', 'Pasagerii au fost introduși cu succes în lista de „Clienți Neserioși”, dar Rezervarea nu poate fi ștearsă pentru că are deja bilet emis!');
        }
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
            // case 'orase_plecare':
            //     $raspuns = Oras::select('id', 'oras', 'judet')
            //         ->where('judet', $request->judet)
            //         ->orderBy('oras')
            //         ->get();
            //     break;
            case 'orase_plecare':
                $raspuns = Oras::select('id', 'oras', 'tara')
                    ->where('tara', $request->tara)
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
            // case 'orase_sosire':
            //     $raspuns = Oras::select('id', 'oras', 'judet')
            //         ->where('judet', $request->judet)
            //         ->orderBy('oras')
            //         ->get();
            //     break;
            case 'orase_sosire':
                $raspuns = Oras::select('id', 'oras', 'tara')
                    ->where('tara', '<>', $request->tara)
                    ->orderBy('oras')
                    ->get();
                break;
            case 'tarife':
                $pret_adult = '';
                $pret_copil = '';
                $pret_adult_tur_retur = '';
                $pret_copil_tur_retur = '';
                $pret_colete_kg = '';

                $preturi_modificate_la_data_string_de_afisat = '';
                $pret_adult_retur = '';
                $pret_copil_retur = '';

                if ($request->data_plecare){
                    $tarife = \App\Models\Tarif::whereDate('de_la_data', '<', $request->data_plecare)->whereDate('pana_la_data', '>', $request->data_plecare)->first() ?? \App\Models\Tarif::latest()->first();
                    $pret_adult = $tarife->adult;
                    $pret_copil = $tarife->copil;
                    $pret_adult_tur_retur = $tarife->adult_tur_retur;
                    $pret_copil_tur_retur = $tarife->copil_tur_retur;
                    $pret_colete_kg = $tarife->colete_kg;
                }

                if (($request->diferenta_date) && ($request->diferenta_date > 15)){
                    $tarife_retur = \App\Models\Tarif::whereDate('de_la_data', '<', $request->data_intoarcere)->whereDate('pana_la_data', '>', $request->data_intoarcere)->first() ?? \App\Models\Tarif::latest()->first();
                    $pret_adult_retur = $tarife_retur->adult;
                    $pret_copil_retur = $tarife_retur->copil;
                    if ($tarife->de_la_data != $tarife_retur->de_la_data) {
                        $preturi_modificate_la_data_string_de_afisat = Carbon::parse($tarife_retur->de_la_data)->isoFormat('DD.MM.YYYY');
                    }
                }

                // $pret_adult = 77;
                return response()->json([
                    'pret_adult' => $pret_adult,
                    'pret_copil' => $pret_copil,
                    'pret_adult_tur_retur' => $pret_adult_tur_retur,
                    'pret_copil_tur_retur' => $pret_copil_tur_retur,
                    'pret_colete_kg' => $pret_colete_kg,

                    'preturi_modificate_la_data_string_de_afisat' => $preturi_modificate_la_data_string_de_afisat,
                    'pret_adult_retur' => $pret_adult_retur,
                    'pret_copil_retur' => $pret_copil_retur,
                ]);
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
    protected function validateRequest(Request $request, $rezervari = null, $rezervare_tur = null, $rezervare_retur = null)
    {
        // Inainte de validare, se scot diacriticele de la nume, data nastere, localitate nastere
        if ($request->tip_calatorie === "Calatori") {
            // Referitor la diacritice, puteti face conversia unui string cu diacritice intr-unul fara diacritice, in mod automatizat cu aceasta functie PHP:
            $transliterator = \Transliterator::createFromRules(':: Any-Latin; :: Latin-ASCII; :: NFD; :: [:Nonspacing Mark:] Remove; :: NFC;', \Transliterator::FORWARD);

            $adulti = $request->adulti;
            $copii = $request->copii;

            for ($i = 1; $i <= $request->nr_adulti; $i++) {
                $adulti['nume'][$i] = $transliterator->transliterate($adulti['nume'][$i]);
                $adulti['data_nastere'][$i] = $transliterator->transliterate($adulti['data_nastere'][$i]);
                $adulti['localitate_nastere'][$i] = $transliterator->transliterate($adulti['localitate_nastere'][$i]);
            }
            for ($i = 1; $i <= $request->nr_copii; $i++) {
                $copii['nume'][$i] = $transliterator->transliterate($copii['nume'][$i]);
                $copii['data_nastere'][$i] = $transliterator->transliterate($copii['data_nastere'][$i]);
                $copii['localitate_nastere'][$i] = $transliterator->transliterate($copii['localitate_nastere'][$i]);
            }
            $request->merge([
                'adulti' => $adulti,
                'copii' => $copii,
            ]);
            // dd($adulti, $request);
        }

        if (Auth::check()) {
            return request()->validate(
                [
                    'tip_calatorie' => ['required'],
                    'traseu' => ['required'],
                    // 'judet_plecare' => [''],
                    'oras_plecare' => ['nullable', 'integer'],
                    // 'judet_sosire' => [''],
                    'oras_sosire' => ['nullable', 'integer'],
                    'tur_retur' => [''],
                    'bilet_nava' => ['nullable'],
                    'nr_adulti' => ['nullable', 'integer', ''],
                    'nr_copii' => ['nullable', 'integer', ''],
                    'pret_total_tur' => ['nullable', 'integer', ''],
                    'pret_total_retur' => ['nullable', 'integer', ''],
                    'adulti.nume.*' => ['nullable', 'max:100',
                        function ($attribute, $value, $fail) use ($request, $rezervare_tur) {
                            if (!empty($request->data_plecare)){
                                $pasageri = Pasager::where('nume', $value)->whereHas('rezervari', function (Builder $query) use ($request, $rezervare_tur) {
                                        if ($request->_method === "PATCH") {
                                            // dd($rezervare_tur->id);
                                            $query->where('rezervari.id', '<>', $rezervare_tur->id)
                                                ->whereDate('data_cursa', '=', $request->data_plecare);
                                        } else {
                                            $query->whereDate('data_cursa', '=', $request->data_plecare);
                                        }
                                    })->pluck('nume')->all();
                                if (stripos($value, 'Andrei Dima test') === false) {
                                    if (in_array($value, $pasageri)) {
                                        $fail('Pasagerul „' . $value . '” mai are o cursă în data de ' .
                                            \Carbon\Carbon::parse($request->data_plecare)->isoFormat('DD.MM.YYYY'));
                                    }
                                }
                            }
                        },
                        function ($attribute, $value, $fail) use ($request, $rezervare_retur) {
                            if (!empty($request->data_intoarcere)) {
                                $pasageri = Pasager::where('nume', $value)->whereHas('rezervari', function (Builder $query) use ($request, $rezervare_retur) {
                                    if ($request->_method === "PATCH") {
                                        // dd($request, $rezervare_retur->id);
                                        $query->where('rezervari.id', '<>', $rezervare_retur->id)
                                            ->whereDate('data_cursa', '=', $request->data_intoarcere);
                                    } else {
                                        $query->whereDate('data_cursa', '=', $request->data_intoarcere);
                                    }
                                })->pluck('nume')->all();
                                if (stripos($value, 'Andrei Dima test') === false) {
                                    if (in_array($value, $pasageri)) {
                                        $fail('Pasagerul „' . $value . '” mai are o cursă în data de ' .
                                            \Carbon\Carbon::parse($request->data_intoarcere)->isoFormat('DD.MM.YYYY'));
                                    }
                                }
                            }
                        },
                    ],
                    // 'adulti.buletin.*' => ['nullable', 'max:100'],
                    'adulti.data_nastere.*' => ['nullable', 'max:100'],
                    'adulti.localitate_nastere.*' => ['nullable', 'max:100'],
                    // 'adulti.localitate_domiciliu.*' => ['nullable', 'max:100'],
                    'adulti.sex.*' => ['nullable', 'max:100'],
                    'copii.nume.*' => [
                        'nullable', 'max:100',
                        function ($attribute, $value, $fail) use ($request, $rezervare_tur) {
                            if (!empty($request->data_plecare)) {
                                $pasageri = Pasager::where('nume', $value)->whereHas('rezervari', function (Builder $query) use ($request, $rezervare_tur) {
                                    if ($request->_method === "PATCH") {
                                        // dd($rezervare_tur->id);
                                        $query->where('rezervari.id', '<>', $rezervare_tur->id)
                                            ->whereDate('data_cursa', '=', $request->data_plecare);
                                    } else {
                                        $query->whereDate('data_cursa', '=', $request->data_plecare);
                                    }
                                })->pluck('nume')->all();
                                if (stripos($value, 'Andrei Dima test') === false) {
                                    if (in_array($value, $pasageri)) {
                                        $fail('Pasagerul „' . $value . '” mai are o cursă în data de ' .
                                            \Carbon\Carbon::parse($request->data_plecare)->isoFormat('DD.MM.YYYY'));
                                    }
                                }
                            }
                        },
                        function ($attribute, $value, $fail) use ($request, $rezervare_retur) {
                            if (!empty($request->data_intoarcere)) {
                                $pasageri = Pasager::where('nume', $value)->whereHas('rezervari', function (Builder $query) use ($request, $rezervare_retur) {
                                    if ($request->_method === "PATCH") {
                                        // dd($request, $rezervare_retur->id);
                                        $query->where('rezervari.id', '<>', $rezervare_retur->id)
                                            ->whereDate('data_cursa', '=', $request->data_intoarcere);
                                    } else {
                                        $query->whereDate('data_cursa', '=', $request->data_intoarcere);
                                    }
                                })->pluck('nume')->all();
                                if (stripos($value, 'Andrei Dima test') === false) {
                                    if (in_array($value, $pasageri)) {
                                        $fail('Pasagerul „' . $value . '” mai are o cursă în data de ' .
                                            \Carbon\Carbon::parse($request->data_intoarcere)->isoFormat('DD.MM.YYYY'));
                                    }
                                }
                            }
                        },
                    ],
                    // 'copii.buletin.*' => ['nullable', 'max:100'],
                    'copii.data_nastere.*' => ['nullable', 'max:100'],
                    'copii.localitate_nastere.*' => ['nullable', 'max:100'],
                    // 'copii.localitate_domiciliu.*' => ['nullable', 'max:100'],
                    'copii.sex.*' => ['nullable', 'max:100'],
                    'colete_numar' => ['nullable', 'numeric'],
                    'colete_kg' => ['nullable', 'numeric'],
                    'colete_volum' => ['nullable', 'numeric'],
                    'colete_natura_marfii' => ['nullable', 'max:1000'],
                    'colete_mod_ambalare' => ['nullable', 'max:1000'],
                    'colete_descriere' => ['nullable', 'max:2000'],
                    'data_plecare' => [
                        'nullable'
                    ],
                    'data_intoarcere' => [
                        'nullable',
                        'after:data_plecare',
                        'max:50'
                        // function ($attribute, $value, $fail) use ($request) {
                        //     $data_plecare = \Carbon\Carbon::parse($request->data_plecare);
                        //     $data_intoarcere = \Carbon\Carbon::parse($request->data_intoarcere);
                        //     if (($request->tur_retur == true) && ($data_plecare->diffInDays($data_intoarcere) > 15)) {
                        //         $fail('Data de intoarcere trebuie sa fie la maxim 15 zile de la data de plecare.');
                        //     }
                        // },
                    ],
                    'nume' => ($request->_method === "PATCH") ?
                        [
                            'nullable', 'max:200',
                            // Rule::unique('rezervari')->ignore($rezervari->id)->where(function ($query) use ($rezervari, $request) {
                            //     return $query->where('telefon', $request->telefon)
                            //         ->where('data_cursa', $request->data_cursa);
                            // }),
                        ]
                        : [
                            'nullable', 'max:200',
                            // Rule::unique('rezervari')->where(function ($query) use ($rezervari, $request) {
                            //     return $query->where('telefon', $request->telefon)
                            //         ->where('data_cursa', $request->data_plecare);
                            // }),
                        ],
                    'telefon' => [
                        'nullable',
                        // 'regex:/^[0-9 ]+$/',
                        'max: 100'
                    ],
                    'email' => ['nullable', 'email', 'max:100'],
                    'adresa' => ['nullable', 'max:500'],
                    'colete_nume_destinatar' => ['nullable', 'max:200'],
                    'colete_telefon_destinatar' => ['nullable', 'max: 100'],
                    'colete_email_destinatar' => ['nullable', 'email', 'max:100'],
                    'colete_adresa_destinatar' => ['nullable', 'max:500'],
                    'observatii' => ['nullable', 'max:2000'],
                    // 'plata_online' => [''],
                    'cumparator' => ['nullable', 'max:100'],
                    'nr_reg_com' => ['nullable', 'max:100'],
                    'cif' => ['nullable', 'max:100'],
                    'sediul' => ['nullable', 'max:100'],
                    'cnp' => ['nullable', 'max:100'],
                    'acord_de_confidentialitate' => ['nullable'],
                    'termeni_si_conditii' => ['nullable'],
                    'acord_newsletter' => [''],
                ],
                [
                    'telefon.regex' => 'Câmpul Telefon poate conține doar cifre și spații.',
                    'nume.unique' => 'Această Rezervare este deja înregistrată.',
                    'data_plecare.required_if' => 'Câmpul data plecare este necesar.',
                    'data_intoarcere.required_unless' => 'Câmpul data plecare este necesar.',
                    'nr_adulti.required_if' => 'Câmpul Nr. Pasageri este necesar.',
                    'nr_adulti.integer' => 'Câmpul Nr. Pasageri trebuie să conțină un număr.',
                    'nr_adulti.between' => 'Câmpul Nr. Pasageri trebuie să fie între 1 și 100.',
                    // 'colete_kg.required_without' => 'Este necesară introducerea a minim unuia dintre câmpurile: Cantitate sau Volum',
                    // 'adresa.required_if' => 'Câmpul Adresa este obligatoriu dacă este selectată plata cu card'
                ]
            );
        } else{
            return request()->validate(
                [
                    'tip_calatorie' => ['required'],
                    'traseu' => ['required'],
                    // 'judet_plecare' => [''],
                    'oras_plecare' => ['required', 'integer'],
                    // 'judet_sosire' => [''],
                    'oras_sosire' => ['required', 'integer'],
                    'tur_retur' => [''],
                    'bilet_nava' => ['required_if:tip_calatorie,Calatori'],
                    'nr_adulti' => ['required_if:tip_calatorie,Calatori', 'integer', 'between:1,100'],
                    'nr_copii' => ['required_if:tip_calatorie,Calatori', 'integer', 'between:0,100'],
                    'pret_total_tur' => ['nullable', 'integer', ''],
                    'pret_total_retur' => ['nullable', 'integer', ''],
                    'adulti.nume.*' => [
                        'required', 'max:100',
                        function ($attribute, $value, $fail) use ($request) {
                            if (!empty($request->data_plecare)) {
                                $pasageri = Pasager::where('nume', $value)->whereHas('rezervari', function (Builder $query) use ($request) {
                                    $query->whereDate('data_cursa', '=', $request->data_plecare);
                                })->pluck('nume')->all();
                                if (stripos($value, 'Andrei Dima test') === false) {
                                    if (in_array($value, $pasageri)) {
                                        $fail('Pasagerul „' . $value . '” mai are o cursă în data de ' .
                                            \Carbon\Carbon::parse($request->data_plecare)->isoFormat('DD.MM.YYYY'));
                                    }
                                }
                            }
                        },
                        function ($attribute, $value, $fail) use ($request) {
                            if (!empty($request->data_intoarcere)) {
                                $pasageri = Pasager::where('nume', $value)->whereHas('rezervari', function (Builder $query) use ($request) {
                                    $query->whereDate('data_cursa', '=', $request->data_intoarcere);
                                })->pluck('nume')->all();
                                if (stripos($value, 'Andrei Dima test') === false) {
                                    if (in_array($value, $pasageri)) {
                                        $fail('Pasagerul „' . $value . '” mai are o cursă în data de ' .
                                            \Carbon\Carbon::parse($request->data_intoarcere)->isoFormat('DD.MM.YYYY'));
                                    }
                                }
                            }
                        },
                    ],
                    // 'adulti.buletin.*' => ['nullable', 'max:100'],
                    'adulti.data_nastere.*' => ['required', 'max:100'],
                    'adulti.localitate_nastere.*' => ['required', 'max:100'],
                    // 'adulti.localitate_domiciliu.*' => ['nullable', 'max:100'],
                    'adulti.sex.*' => ['nullable', 'max:100'],
                    'copii.nume.*' => ['required', 'max:100',
                        function ($attribute, $value, $fail) use ($request) {
                            if (!empty($request->data_plecare)){
                                $pasageri = Pasager::where('nume', $value)->whereHas('rezervari', function (Builder $query) use ($request) {
                                        $query->whereDate('data_cursa', '=', $request->data_plecare);
                                    })->pluck('nume')->all();
                                if (stripos($value, 'Andrei Dima test') === false) {
                                    if (in_array($value, $pasageri)) {
                                        $fail('Pasagerul „' . $value . '” mai are o cursă în data de ' .
                                            \Carbon\Carbon::parse($request->data_plecare)->isoFormat('DD.MM.YYYY'));
                                    }
                                }
                            }
                        },
                        function ($attribute, $value, $fail) use ($request) {
                            if (!empty($request->data_intoarcere)) {
                                $pasageri = Pasager::where('nume', $value)->whereHas('rezervari', function (Builder $query) use ($request) {
                                    $query->whereDate('data_cursa', '=', $request->data_intoarcere);
                                })->pluck('nume')->all();
                                if (stripos($value, 'Andrei Dima test') === false) {
                                    if (in_array($value, $pasageri)) {
                                        $fail('Pasagerul „' . $value . '” mai are o cursă în data de ' .
                                            \Carbon\Carbon::parse($request->data_intoarcere)->isoFormat('DD.MM.YYYY'));
                                    }
                                }
                            }
                        },
                    ],
                    // 'copii.buletin.*' => ['nullable', 'max:100'],
                    'copii.data_nastere.*' => ['required', 'max:100'],
                    'copii.localitate_nastere.*' => ['required', 'max:100'],
                    // 'copii.localitate_domiciliu.*' => ['nullable', 'max:100'],
                    'copii.sex.*' => ['nullable', 'max:100'],
                    'colete_numar' => ['required_if:tip_calatorie,Colete', 'numeric'],
                    'colete_kg' => ['nullable', 'required_if:tip_calatorie,Colete', 'numeric'],
                    'colete_volum' => ['nullable', 'numeric'],
                    'colete_natura_marfii' => ['required_if:tip_calatorie,Colete', 'max:1000'],
                    'colete_mod_ambalare' => ['required_if:tip_calatorie,Colete', 'max:1000'],
                    'colete_descriere' => ['nullable', 'max:2000'],
                    'data_plecare' => [
                        'required'
                    ],
                    'data_intoarcere' => [
                        'required_if:tur_retur,true',
                        'after:data_plecare',
                        'max:50'
                        // function ($attribute, $value, $fail) use ($request) {
                        //     $data_plecare = \Carbon\Carbon::parse($request->data_plecare);
                        //     $data_intoarcere = \Carbon\Carbon::parse($request->data_intoarcere);
                        //     if (($request->tur_retur == true) && ($data_plecare->diffInDays($data_intoarcere) > 15)) {
                        //         $fail('Data de intoarcere trebuie sa fie la maxim 15 zile de la data de plecare.');
                        //     }
                        // },
                    ],
                    'nume' => ($request->_method === "PATCH") ?
                        [
                            'nullable'
                            // 'required_if:tip_calatorie,Colete', 'max:200',
                            // Rule::unique('rezervari')->ignore($rezervari->id)->where(function ($query) use ($rezervari, $request) {
                            //     return $query->where('telefon', $request->telefon)
                            //         ->where('data_cursa', $request->data_cursa);
                            // }),
                        ]
                        : [
                            'required_if:tip_calatorie,Colete', 'max:200',
                            Rule::unique('rezervari')->where(function ($query) use ($rezervari, $request) {
                                return $query->where('telefon', $request->telefon)
                                    ->where('data_cursa', $request->data_plecare);
                            }),
                        ],
                    'telefon' => [
                        'required',
                        // 'regex:/^[0-9 ]+$/',
                        'max: 100'
                    ],
                    'email' => ['nullable', 'email', 'max:100'],
                    'adresa' => ['max:2000'],
                    'colete_nume_destinatar' => ['required_if:tip_calatorie,Colete', 'max:200'],
                    'colete_telefon_destinatar' => ['required_if:tip_calatorie,Colete', 'max: 100'],
                    'colete_email_destinatar' => ['nullable', 'email', 'max:100'],
                    'colete_adresa_destinatar' => ['required_if:tip_calatorie,Colete', 'nullable', 'max:500'],
                    'observatii' => ['max:2000'],
                    // 'plata_online' => [''],
                    'cumparator' => ['nullable', 'max:100'],
                    'nr_reg_com' => ['nullable', 'max:100'],
                    'cif' => ['nullable', 'max:100'],
                    'sediul' => ['nullable', 'max:100'],
                    'acord_de_confidentialitate' => ['required'],
                    'termeni_si_conditii' => ['required'],
                    'acord_newsletter' => [''],
                ],
                [
                    'telefon.regex' => 'Câmpul Telefon poate conține doar cifre și spații.',
                    'nume.unique' => 'Această Rezervare este deja înregistrată.',
                    'data_plecare.required_if' => 'Câmpul data plecare este necesar.',
                    'data_intoarcere.required_unless' => 'Câmpul data plecare este necesar.',
                    // 'nr_adulti.required_if' => 'Câmpul Nr. Pasageri este necesar.',
                    // 'nr_adulti.integer' => 'Câmpul Nr. Pasageri trebuie să conțină un număr.',
                    // 'nr_adulti.between' => 'Câmpul Nr. Pasageri trebuie să fie între 1 și 100.',
                    // 'adresa.required_if' => 'Câmpul Adresa este obligatoriu dacă este selectată plata cu card'
                    // 'colete_kg.required_without' => 'Este necesară introducerea a minim unuia dintre câmpurile: Cantitate sau Volum',
                ]
            );
        }
    }

    public function pdfExport(Request $request, $view_type = null, Rezervare $rezervare_tur = null, Rezervare $rezervare_retur = null)
    {
        // dd($view_type, $rezervare_tur, $rezervare_retur);

        if ($request->view_type === 'rezervare-html') {
            return view('rezervari.export.rezervare-pdf', compact('rezervare_tur', 'rezervare_retur'));
        } elseif ($request->view_type === 'rezervare-pdf') {
            $pdf = \PDF::loadView('rezervari.export.rezervare-pdf', compact('rezervare_tur', 'rezervare_retur'))
                ->setPaper('a4');
            return $pdf->download('Rezervare ' . $rezervare_tur->nume . '.pdf');
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
        if(!empty($request->session()->get('rezervare'))){
            $rezervare = $request->session()->forget('rezervare');
        }

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
        // $rezervare = $request->session()->get('rezervare');
        if(empty($request->session()->get('rezervare'))){
            $rezervare = new Rezervare();
        }else{
            $rezervare = $request->session()->get('rezervare');
        }

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
        }else{
            $rezervare = $request->session()->get('rezervare');
        }
        $rezervare->fill($this->validateRequest($request));
        $rezervare->user_id = auth()->user()->id ?? null;
        // dd($request);
        // Recalcularea pretului total pentru siguranta
        if (!Auth::check()) {
            $rezervare->pret_total_tur = 0;
            $rezervare->pret_total_retur = 0;

            if ($request->data_plecare){
                $tarife = \App\Models\Tarif::whereDate('de_la_data', '<', $request->data_plecare)->whereDate('pana_la_data', '>', $request->data_plecare)->first() ?? \App\Models\Tarif::latest()->first();
            }

            if ($request->data_plecare && $request->data_intoarcere) {
                $diferenta_date = \Carbon\Carbon::parse($request->data_plecare)->diffInDays(\Carbon\Carbon::parse($request->data_intoarcere));
                if ($diferenta_date > 15){
                    $tarife_retur = \App\Models\Tarif::whereDate('de_la_data', '<', $request->data_intoarcere)->whereDate('pana_la_data', '>', $request->data_intoarcere)->first() ?? \App\Models\Tarif::latest()->first();
                }
            }

            if ($request->tip_calatorie === "Calatori") {
                if (isset($diferenta_date) && ($diferenta_date < 15)) {
                    $rezervare->pret_total_tur = $rezervare->nr_adulti * $tarife->adult_tur_retur + $rezervare->nr_copii * $tarife->copil_tur_retur;
                } else {
                    $rezervare->pret_total_tur = $rezervare->nr_adulti * $tarife->adult + $rezervare->nr_copii * $tarife->copil;
                    if ($request->tur_retur === "true"){
                        $rezervare->pret_total_retur = $rezervare->nr_adulti * $tarife_retur->adult + $rezervare->nr_copii * $tarife_retur->copil;
                    }
                }
            } else if ($request->tip_calatorie === "Colete") {
                if ($request->colete_kg && $request->colete_volum) {
                    if ($request->colete_kg > $request->colete_volum * 166) {
                        $rezervare->pret_total_tur = round($request->colete_kg * $tarife->colete_kg);
                    } else {
                        $rezervare->pret_total_tur = round($request->colete_volum * $tarife->colete_kg);
                    }
                } else if ($request->colete_kg){
                    $rezervare->pret_total_tur = round($request->colete_kg * $tarife->colete_kg);
                } else if ($request->colete_volum) {
                    $rezervare->pret_total_tur = round($request->colete_volum * $tarife->colete_kg);
                }

                if ($request->tur_retur == true) {
                    $rezervare->pret_total_retur = $rezervare->pret_total_tur;
                }
            }
        }

        // dd($request, $diferenta_date, $rezervare);
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
        if(empty($request->session()->get('rezervare'))){
            return redirect('/adauga-rezervare-noua');
        }else{
            $rezervare = $request->session()->get('rezervare');
            return view('rezervari.guest-create/adauga-rezervare-pasul-2', compact('rezervare'));
        }
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

        // Verificare rezervare duplicat
            $request_verificare_duplicate = new Request([
                'adulti' => $request->session()->get('rezervare.adulti'),
                'copii' => $request->session()->get('rezervare.copii'),
                'data_plecare' => $request->session()->get('rezervare.data_plecare'),
                'data_intoarcere' => $request->session()->get('rezervare.data_intoarcere')
            ]);

            $this->validate(
                $request_verificare_duplicate,
                [
                    'adulti.nume.*' => [
                        'nullable', 'max:100',
                        function ($attribute, $value, $fail) use ($request_verificare_duplicate) {
                            if (!empty($request_verificare_duplicate->data_plecare)) {
                                $pasageri = Pasager::where('nume', $value)->whereHas('rezervari', function (Builder $query) use ($request_verificare_duplicate) {
                                    $query->whereDate('data_cursa', '=', $request_verificare_duplicate->data_plecare);
                                })->pluck('nume')->all();
                                if (stripos($value, 'Andrei Dima test') === false) {
                                    if (in_array($value, $pasageri)) {
                                        $fail('Pasagerul „' . $value . '” mai are o cursă în data de ' .
                                            \Carbon\Carbon::parse($request_verificare_duplicate->data_plecare)->isoFormat('DD.MM.YYYY'));
                                    }
                                }
                            }
                        },
                        function ($attribute, $value, $fail) use ($request_verificare_duplicate) {
                            if (!empty($request_verificare_duplicate->data_intoarcere)) {
                                $pasageri = Pasager::where('nume', $value)->whereHas('rezervari', function (Builder $query) use ($request_verificare_duplicate) {
                                    $query->whereDate('data_cursa', '=', $request_verificare_duplicate->data_intoarcere);
                                })->pluck('nume')->all();
                                if (stripos($value, 'Andrei Dima test') === false) {
                                    if (in_array($value, $pasageri)) {
                                        $fail('Pasagerul „' . $value . '” mai are o cursă în data de ' .
                                            \Carbon\Carbon::parse($request_verificare_duplicate->data_intoarcere)->isoFormat('DD.MM.YYYY'));
                                    }
                                }
                            }
                        },
                    ],
                    'copii.nume.*' => [
                        'nullable', 'max:100',
                        function ($attribute, $value, $fail) use ($request_verificare_duplicate) {
                            if (!empty($request_verificare_duplicate->data_plecare)) {
                                $pasageri = Pasager::where('nume', $value)->whereHas('rezervari', function (Builder $query) use ($request_verificare_duplicate) {
                                    $query->whereDate('data_cursa', '=', $request_verificare_duplicate->data_plecare);
                                })->pluck('nume')->all();
                                if (stripos($value, 'Andrei Dima test') === false) {
                                    if (in_array($value, $pasageri)) {
                                        $fail('Pasagerul „' . $value . '” mai are o cursă în data de ' .
                                            \Carbon\Carbon::parse($request_verificare_duplicate->data_plecare)->isoFormat('DD.MM.YYYY'));
                                    }
                                }
                            }
                        },
                        function ($attribute, $value, $fail) use ($request_verificare_duplicate) {
                            if (!empty($request_verificare_duplicate->data_intoarcere)) {
                                $pasageri = Pasager::where('nume', $value)->whereHas('rezervari', function (Builder $query) use ($request_verificare_duplicate) {
                                    $query->whereDate('data_cursa', '=', $request_verificare_duplicate->data_intoarcere);
                                })->pluck('nume')->all();
                                if (stripos($value, 'Andrei Dima test') === false) {
                                    if (in_array($value, $pasageri)) {
                                        $fail('Pasagerul „' . $value . '” mai are o cursă în data de ' .
                                            \Carbon\Carbon::parse($request_verificare_duplicate->data_intoarcere)->isoFormat('DD.MM.YYYY'));
                                    }
                                }
                            }
                        },
                    ],
                ]
            );

        $rezervare_unset = clone $rezervare;
        unset($rezervare_unset->tip_calatorie,
            $rezervare_unset->traseu,
            $rezervare_unset->tur_retur,
            $rezervare_unset->data_plecare,
            $rezervare_unset->data_intoarcere,
            // $rezervare_unset->judet_plecare,
            // $rezervare_unset->judet_sosire,
            $rezervare_unset->oras_plecare_nume,
            $rezervare_unset->oras_sosire_nume,
            $rezervare_unset->adulti,
            $rezervare_unset->copii,
            $rezervare_unset->pret_total_tur,
            $rezervare_unset->pret_total_retur,
            $rezervare_unset->cumparator,
            $rezervare_unset->nr_reg_com,
            $rezervare_unset->cif,
            $rezervare_unset->sediul,
            $rezervare_unset->acord_de_confidentialitate,
            $rezervare_unset->termeni_si_conditii
        );

        if($rezervare->tip_calatorie === "Calatori"){
            unset($rezervare_unset->colete_kg,
                $rezervare_unset->colete_descriere
            );
        }else{
            unset(
                $rezervare_unset->nr_adulti,
                $rezervare_unset->nr_copii
            );
        }

        $rezervare_tur = clone $rezervare_unset;
        $rezervare_retur = clone $rezervare_unset;

        $rezervare_tur->data_cursa = $rezervare->data_plecare;
        $rezervare_tur->lista_plecare = Oras::find($rezervare_tur->oras_plecare)->traseu ?? null;
        $rezervare_tur->lista_sosire = Oras::find($rezervare_tur->oras_sosire)->traseu ?? null;
        $rezervare_retur->data_cursa = $rezervare->data_intoarcere;
        $rezervare_retur->oras_plecare = $rezervare_tur->oras_sosire;
        $rezervare_retur->oras_sosire = $rezervare_tur->oras_plecare;
        $rezervare_retur->lista_plecare = Oras::find($rezervare_retur->oras_plecare)->traseu ?? null;
        $rezervare_retur->lista_sosire = Oras::find($rezervare_retur->oras_sosire)->traseu ?? null;

        $rezervare_tur->pret_total = $rezervare->pret_total_tur;
        $rezervare_retur->pret_total = $rezervare->pret_total_retur;

        $rezervare_tur->cheie_unica = uniqid('tur');
        $rezervare_retur->cheie_unica = uniqid('retur');
        // dd($rezervare);

        if ($rezervare->tur_retur === 'false') {
            //Inserarea rezervarii in baza de date
            $rezervare_tur->save();
            $rezervare_retur = null;

            $request->session()->put('rezervare_tur', $rezervare_tur);
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
        }

        // salvare pasageri si atasare la rezervari
        if($rezervare->tip_calatorie === "Calatori"){
            for ($i = 1; $i <= $rezervare->nr_adulti; $i++) {
                $pasager = new Pasager;
                $pasager->nume = $rezervare->adulti['nume'][$i];
                // $pasager->buletin = $rezervare->adulti['buletin'][$i];
                $pasager->data_nastere = $rezervare->adulti['data_nastere'][$i];
                $pasager->localitate_nastere = $rezervare->adulti['localitate_nastere'][$i];
                // $pasager->localitate_domiciliu = $rezervare->adulti['localitate_domiciliu'][$i];
                $pasager->sex = $rezervare->adulti['sex'][$i] ?? '';
                $pasager->categorie = 'Adult';
                $pasager->save();

                if ($rezervare->tur_retur === 'false') {
                    $rezervare_tur->pasageri_relation()->attach($pasager->id);
                }else{
                    $rezervare_tur->pasageri_relation()->attach($pasager->id);
                    $rezervare_retur->pasageri_relation()->attach($pasager->id);
                }
            }
            for ($i = 1; $i <= $rezervare->nr_copii; $i++) {
                $pasager = new Pasager;
                $pasager->nume = $rezervare->copii['nume'][$i];
                // $pasager->buletin = $rezervare->copii['buletin'][$i];
                $pasager->data_nastere = $rezervare->copii['data_nastere'][$i];
                $pasager->localitate_nastere = $rezervare->copii['localitate_nastere'][$i];
                // $pasager->localitate_domiciliu = $rezervare->copii['localitate_domiciliu'][$i];
                $pasager->sex = $rezervare->copii['sex'][$i] ?? '';
                $pasager->categorie = 'Copil';
                $pasager->save();

                if ($rezervare->tur_retur === 'false') {
                    $rezervare_tur->pasageri_relation()->attach($pasager->id);
                } else {
                    $rezervare_tur->pasageri_relation()->attach($pasager->id);
                    $rezervare_retur->pasageri_relation()->attach($pasager->id);
                }
            }
        }

        // Cursul EURO se actualizeaza pe site-ul BNR in fiecare zi imediat dupa ora 13:00
        $curs_bnr_euro = \App\Models\Variabila::where('nume', 'curs_bnr_euro')->first();
        if (\Carbon\Carbon::now()->hour >= 14) {
            if (\Carbon\Carbon::parse($curs_bnr_euro->updated_at) < (\Carbon\Carbon::today()->hour(14))){
                $xml=simplexml_load_file("https://www.bnr.ro/nbrfxrates.xml") or die("Error: Cannot create object");
                foreach($xml->Body->Cube->children() as $curs_bnr) {
                    if ((string) $curs_bnr['currency'] === 'EUR'){
                        $curs_bnr_euro->valoare = $curs_bnr[0];
                        $curs_bnr_euro->save();
                    }
                }
            }
            // Dupa actualizarea cursului euro, variabila $curs_bnr_euro se transforma intr-o variabila de tip simpleXML, ce va da eroare mai departe in aplicatie, motiv pentru care necesita reinitializare
            $curs_bnr_euro = \App\Models\Variabila::where('nume', 'curs_bnr_euro')->first();
        } else {
            if (\Carbon\Carbon::parse($curs_bnr_euro->updated_at) < (\Carbon\Carbon::yesterday()->hour(14))){
                $xml=simplexml_load_file("https://www.bnr.ro/nbrfxrates.xml") or die("Error: Cannot create object");
                foreach($xml->Body->Cube->children() as $curs_bnr) {
                    if ((string) $curs_bnr['currency'] === 'EUR'){
                        $curs_bnr_euro->valoare = $curs_bnr;
                        $curs_bnr_euro->save();
                    }
                }
            }
            // Dupa actualizarea cursului euro, variabila $curs_bnr_euro se transforma intr-o variabila de tip simpleXML, ce va da eroare mai departe in aplicatie, motiv pentru care necesita reinitializare
            $curs_bnr_euro = \App\Models\Variabila::where('nume', 'curs_bnr_euro')->first();
        }

        // Salvarea preturilor in lei in tabelul de rezervari, pentru a emite chitante
        $rezervare_tur->curs_bnr_euro = $curs_bnr_euro->valoare;
        $rezervare_tur->valoare_lei_tva = ($rezervare_tur->pret_total * $rezervare_tur->curs_bnr_euro) * 0.19;
        $rezervare_tur->valoare_lei = ($rezervare_tur->pret_total * $rezervare_tur->curs_bnr_euro) - $rezervare_tur->valoare_lei_tva;
        $rezervare_tur->update();

        if ($rezervare->tur_retur !== 'false') {
            $rezervare_retur->curs_bnr_euro = $curs_bnr_euro->valoare;
            $rezervare_retur->valoare_lei_tva = ($rezervare_retur->pret_total * $rezervare_retur->curs_bnr_euro) * 0.19;
            $rezervare_retur->valoare_lei = ($rezervare_retur->pret_total * $rezervare_retur->curs_bnr_euro) - $rezervare_retur->valoare_lei_tva;
            $rezervare_retur->update();
        }

        // Salvare Factura
        if ($rezervare->cumparator){
            $factura = new Factura;
            $factura->cumparator = $rezervare->cumparator;
            $factura->nr_reg_com = $rezervare->nr_reg_com;
            $factura->cif = $rezervare->cif;
            $factura->sediul = $rezervare->sediul;
            $factura->seria = Factura::select('seria')->latest()->first()->seria ?? 'MRW88';
            $factura->numar = (Factura::select('numar')->latest()->first()->numar ?? 0) + 1;
            $factura->valoare_euro = $rezervare->pret_total_tur + $rezervare->pret_total_retur;

            $factura->curs_bnr_euro = $curs_bnr_euro->valoare;

            $factura->valoare_lei_tva = $rezervare_tur->valoare_lei_tva;
            $factura->valoare_lei = $rezervare_tur->valoare_lei;

            if ($rezervare_retur) {
                $factura->valoare_lei_tva += $rezervare_retur->valoare_lei_tva;
                $factura->valoare_lei += $rezervare_retur->valoare_lei;
            }

            $rezervare_tur->factura()->save($factura);
        }

        // Trimitere email
        if (!Auth::check()) {
            if (stripos($rezervare_tur->pasageri_relation_adulti->first()->nume ?? '', 'Andrei Dima test') !== false) {
                // dd('da');
                if (stripos($rezervare->nume, 'fara email') !== false) {
                    // nu se trimite email
                } else {
                    if ($rezervare_tur->email){
                        $mail = \Mail::to($rezervare_tur->email)
                            ->bcc('andrei.dima@usm.ro');
                    } else {
                        $mail = \Mail::to('andrei.dima@usm.ro');
                    }
                    $mail->send(new RezervareFinalizata($rezervare_tur));
                }
            } else {
                if ($rezervare_tur->email && $rezervare_tur->colete_email_destinatar) {
                    $mail = \Mail::to([$rezervare_tur->email, $rezervare_tur->colete_email_destinatar])
                        ->bcc('rezervari@transportcorsica.ro');
                } else if ($rezervare_tur->email){
                    $mail = \Mail::to($rezervare_tur->email)
                        ->bcc('rezervari@transportcorsica.ro');
                } else if ($rezervare_tur->colete_email_destinatar){
                    $mail = \Mail::to($rezervare_tur->colete_email_destinatar)
                        ->bcc('rezervari@transportcorsica.ro');
                } else {
                    $mail = \Mail::to('rezervari@transportcorsica.ro');
                }
                $mail->send(new RezervareFinalizata($rezervare_tur));
            }
        }

        //Trimitere sms
        // $mesaj = 'Buna ziua! ';
        // if($rezervare->tip_calatorie === "Calatori"){
        //     $mesaj .= 'Rezervarea pentru pasagerii: ';
        //     foreach ($rezervare_tur->pasageri_relation_adulti as $adult) {
        //         $mesaj .= $adult->nume . ', ';
        //     }
        //     foreach ($rezervare_tur->pasageri_relation_copii as $copil) {
        //         $mesaj .= $copil->nume . ', ';
        //     }
        //     $mesaj .= 'a fost inregistrata in sistem. ';
        // } else {
        //     $mesaj .= 'Rezervarea pentru coletele dumneavoastra a fost inregistrata in sistem. ';
        // }
        // $mesaj .= 'O zi placuta va dorim!';

        $mesaj = 'Rezervarea dumneavoastra a fost inregistrata cu succes in sistem. Veti fi contactat cu minim 12 ore inainte de plecare. Cu stima, MRW Transport  +40791881888!';

        /**
         * Trimitere SMS
         */
        if (stripos($rezervare_tur->pasageri_relation->first()->nume ?? '', 'Andrei Dima test') !== false) {
            if (stripos($rezervare_tur->pasageri_relation->first()->nume ?? '', 'fara sms') !== false) {
                // ...
            } else {
                // Trait continand functie cu argumentele: categorie(string), subcategorie(string), referinta_id(integer), telefoane(array), mesaj(string)
                $this->trimiteSms('rezervari', null, $rezervare_tur->id, [$rezervare_tur->telefon], $mesaj);
            }
        } else {
            // Trait continand functie cu argumentele: categorie(string), subcategorie(string), referinta_id(integer), telefoane(array), mesaj(string)
            $this->trimiteSms('rezervari', null, $rezervare_tur->id, [$rezervare_tur->telefon], $mesaj);
        }

        // Cu sau fara plata online
        switch ($request->input('action')) {
            case 'cu_plata_online':
                if (stripos($rezervare_tur->pasageri_relation->first()->nume ?? '', 'Andrei Dima test') !== false) {
                    if (stripos($rezervare_tur->pasageri_relation->first()->nume ?? '', 'fara plata') !== false) {
                        return redirect('/adauga-rezervare-pasul-3');
                    } else {
                        return redirect()->route('trimitere-catre-plata', ['rezervare_tur' => $rezervare_tur]);
                    }
                } else {
                    return redirect()->route('trimitere-catre-plata', ['rezervare_tur' => $rezervare_tur]);
                }
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
        // Verificare plata online, si cautarea rezervarii
        if ($request->has('orderId')) {
            $plata_online = \App\Models\PlataOnline::where('order_id', $request->orderId)->latest()->first();
            $rezervare_tur = \App\Models\Rezervare::where('id', $plata_online->rezervare_id)->first();
            $request->session()->forget('rezervare_tur');
            $request->session()->put('rezervare_tur', $rezervare_tur);

            if (!$rezervare_tur->retur){
                $rezervare_retur = null;
            } else {
                $rezervare_retur = \App\Models\Rezervare::where('id', $rezervare_tur->retur)->first();
                $request->session()->forget('rezervare_retur');
                $request->session()->put('rezervare_retur', $rezervare_retur);
            }
        } else {
            // Daca a fost fara plata online, se cauta rezervarea in sesiune
            $rezervare_tur = $request->session()->get('rezervare_tur');
            $rezervare_retur = $request->session()->get('rezervare_retur');
        }

        // Daca nu a fost platita online, si nici in sesiune nu se gaseste rezervarea, atunci $rezervare_tur si $rezervare_retur vor fi null
        if(!$rezervare_tur){
            return redirect('adauga-rezervare-noua');
        } else{
            return view('rezervari.guest-create/adauga-rezervare-pasul-3', compact('rezervare_tur', 'rezervare_retur'));
        }
    }

    public function pdfExportGuest(Request $request)
    {
        // if (Session::has('plata_online')) {
        //     $rezervare = \App\Rezervare::where('id', $request->session()->get('rezervare_id'))->first();
        // } else {
        //     $rezervare = $request->session()->get('rezervare');
        // }

        $rezervare_tur = $request->session()->get('rezervare_tur');

        if(!$rezervare_tur){
            return redirect('adauga-rezervare-noua');
        }

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

    public function exportPDFGuest(Request $request)
    {
        $rezervare_tur = $request->session()->get('rezervare_tur');
        $factura = $rezervare_tur->factura;

        if ($request->view_type === 'export-html') {
            return view('facturi.export.factura', compact('factura'));
        } elseif ($request->view_type === 'export-pdf') {
                $pdf = \PDF::loadView('facturi.export.factura', compact('factura'))
                    ->setPaper('a4', 'portrait');
                return $pdf->download('Factura ' . $factura->cumparator . ' - ' . \Carbon\Carbon::parse($factura->created_at)->isoFormat('DD.MM.YYYY') . '.pdf');
        }
    }

    public function chitantaSeteazaOraseGuest(Request $request, $cheie_unica = null)
    {
        $rezervare = Rezervare::where('cheie_unica', $cheie_unica)->first();

        return view('chitante.export.seteaza-orase', compact('rezervare', 'cheie_unica'));
    }

    public function postChitantaSeteazaOraseGuest(Request $request, $cheie_unica = null)
    {
        $rezervare = Rezervare::where('cheie_unica', $cheie_unica)->first();

        if ($rezervare->nr_adulti){
            $request->validate(
                [
                    'oras_plecare' => 'required|max:100',
                    'oras_sosire' => 'required|max:100',
                ]
            );
            $rezervare->oras_plecare_sofer = $request->oras_plecare;
            $rezervare->oras_sosire_sofer = $request->oras_sosire;
            $rezervare->bilet_serie = 'MRW88';
            $rezervare->bilet_numar = $rezervare->bilet_numar ?? ((Rezervare::max('bilet_numar') ?? 0) + 1);

            $rezervare->update();

            // return redirect('chitanta-descarca/' . $rezervare->cheie_unica . '/export-html');
            return redirect()->away('rawbt:url:https://rezervari.transportcorsica.ro/chitanta-descarca/' . $rezervare->cheie_unica . '/export-html');
        } else {
            $request->validate(
                [
                    'colete_kg' => 'nullable|numeric',
                    'colete_numar' => 'nullable|numeric',
                    'pret' => 'required|numeric|integer|max:99999',
                ]
            );

            $rezervare->colete_kg = $request->colete_kg;
            $rezervare->colete_numar = $request->colete_numar;
            $rezervare->pret_total = $request->pret;

            // Calcularea preturilor in lei
            $rezervare->valoare_lei_tva = ($rezervare->pret_total * $rezervare->curs_bnr_euro) * 0.19;
            $rezervare->valoare_lei = ($rezervare->pret_total * $rezervare->curs_bnr_euro) - $rezervare->valoare_lei_tva;

            $rezervare->update();

            // return redirect('chitanta-descarca/' . $rezervare->cheie_unica . '/export-html');
            return redirect()->away('rawbt:url:https://rezervari.transportcorsica.ro/chitanta-descarca/' . $rezervare->cheie_unica . '/export-html');
        }


        // return redirect()->action(
        //     [RezervareController::class, 'chitantaExportPDFGuest'],
        //     [
        //         'cheie_unica' => $cheie_unica,
        //         'view_type' => 'export-html',
        //     ]
        // );
    }

    public function chitantaExportPDFGuest(Request $request, $cheie_unica = null)
    {
        $rezervare = Rezervare::where('cheie_unica', $cheie_unica)->first();

        // Daca exista rezervare retur, cea la oferta, pana in 14 zile, se afiseaza si ea pe bilet
        $rezervare_retur = null;
        if (!is_null($rezervare->retur)){
            $rezervare_retur = Rezervare::find($rezervare->retur);
            if ( \Carbon\Carbon::parse($rezervare->data_cursa)->diffInDays(\Carbon\Carbon::parse($rezervare_retur->data_cursa)) > 15 ){
                $rezervare_retur = null;
            }
        }

        // if ($rezervare->nr_adulti){
        //     if ($request->view_type === 'export-html') {
        //         return view('chitante.export.chitanta', compact('rezervare'));
        //     } elseif ($request->view_type === 'export-pdf') {
        //             $pdf = \PDF::loadView('chitante.export.chitanta', compact('rezervare'))
        //                 ->setPaper([0,0,384,500]);
        //             return $pdf->stream();
        //     }
        //     return view('chitante.export.chitanta', compact('rezervare'));
        // } else {
        //     if ($request->view_type === 'export-html') {
        //         return view('chitante.export.awb_colete', compact('rezervare'));
        //     } elseif ($request->view_type === 'export-pdf') {
        //             $pdf = \PDF::loadView('chitante.export.awb_colete', compact('rezervare'))
        //                 ->setPaper('a4', 'portrait');
        //             return $pdf->download('AWB.pdf');
        //     }
        //     return view('chitante.export.awb_colete', compact('rezervare'));
        // }

        if ($request->view_type === 'export-html') {
            return view('chitante.export.chitanta', compact('rezervare', 'rezervare_retur'));
        } elseif ($request->view_type === 'export-pdf') {
            $pdf = \PDF::loadView('chitante.export.chitanta', compact('rezervare', 'rezervare_retur'))
                ->setPaper([0,0,384,500]);
                // ->setPaper('a5', 'portrait');
            return $pdf->stream();
            // return $pdf->download('Chitanta.pdf');
        }

    }

    public function cmrExportPDFGuest(Request $request, $cheie_unica = null)
    {
        $rezervare = Rezervare::
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
            ->where('cheie_unica', $cheie_unica)->first();

        if ($rezervare->nr_adulti){
            return back()->with('error', 'Această rezervare este pentru pasageri, deci nu are CMR.');

        } else {
            if ($request->view_type === 'export-html') {
                return view('chitante.export.cmr_colete', compact('rezervare'));
            } elseif ($request->view_type === 'export-pdf') {
                    $pdf = \PDF::loadView('chitante.export.cmr_colete', compact('rezervare'))
                        ->setPaper('a4', 'portrait');
                    return $pdf->stream();
                    // return $pdf->download('CMR.pdf');
            }

            return view('chitante.export.CMR_colete', compact('rezervare'));
        }

    }

    public function duplicaRezervare(Request $request, Rezervare $rezervare)
    {
        $rezervare_tur = $rezervare;
        $rezervare_retur = Rezervare::find($rezervare_tur->retur);

        // Cursul EURO se actualizeaza pe site-ul BNR in fiecare zi imediat dupa ora 13:00
        $curs_bnr_euro = \App\Models\Variabila::where('nume', 'curs_bnr_euro')->first();
        if (\Carbon\Carbon::now()->hour >= 14) {
            if (\Carbon\Carbon::parse($curs_bnr_euro->updated_at) < (\Carbon\Carbon::today()->hour(14))) {
                $xml = simplexml_load_file("https://www.bnr.ro/nbrfxrates.xml") or die("Error: Cannot create object");
                foreach ($xml->Body->Cube->children() as $curs_bnr) {
                    if ((string) $curs_bnr['currency'] === 'EUR') {
                        $curs_bnr_euro->valoare = $curs_bnr[0];
                        $curs_bnr_euro->save();
                    }
                }
            }
            // Dupa actualizarea cursului euro, variabila $curs_bnr_euro se transforma intr-o variabila de tip simpleXML, ce va da eroare mai departe in aplicatie, motiv pentru care necesita reinitializare
            $curs_bnr_euro = \App\Models\Variabila::where('nume', 'curs_bnr_euro')->first();
        } else {
            if (\Carbon\Carbon::parse($curs_bnr_euro->updated_at) < (\Carbon\Carbon::yesterday()->hour(14))) {
                $xml = simplexml_load_file("https://www.bnr.ro/nbrfxrates.xml") or die("Error: Cannot create object");
                foreach ($xml->Body->Cube->children() as $curs_bnr) {
                    if ((string) $curs_bnr['currency'] === 'EUR') {
                        $curs_bnr_euro->valoare = $curs_bnr;
                        $curs_bnr_euro->save();
                    }
                }
            }
            // Dupa actualizarea cursului euro, variabila $curs_bnr_euro se transforma intr-o variabila de tip simpleXML, ce va da eroare mai departe in aplicatie, motiv pentru care necesita reinitializare
            $curs_bnr_euro = \App\Models\Variabila::where('nume', 'curs_bnr_euro')->first();
        }

        // Stergere din datele care nu trebuie sa se duplice, si actualizarea celor care trebuie sa fie diferite
        $rezervare_tur->oras_plecare_sofer = NULL;
        $rezervare_tur->oras_sosire_sofer = NULL;
        $rezervare_tur->data_cursa = \Carbon\Carbon::now();
        $rezervare_tur->curs_bnr_euro = $curs_bnr_euro->valoare;
        $rezervare_tur->valoare_lei_tva = ($rezervare_tur->pret_total * $rezervare_tur->curs_bnr_euro) * 0.19;
        $rezervare_tur->valoare_lei = ($rezervare_tur->pret_total * $rezervare_tur->curs_bnr_euro) - $rezervare_tur->valoare_lei_tva;
        $rezervare_tur->bilet_serie = NULL;
        $rezervare_tur->bilet_numar = NULL;
        $rezervare_tur->lista_plecare = Oras::find($rezervare_tur->oras_plecare)->traseu ?? null;
        $rezervare_tur->lista_sosire = Oras::find($rezervare_tur->oras_sosire)->traseu ?? null;
        $rezervare_tur->plata_efectuata = NULL;
        $rezervare_tur->user_id = auth()->user()->id;
        if (isset($rezervare_retur)) {
            $rezervare_retur->oras_plecare_sofer = NULL;
            $rezervare_retur->oras_sosire_sofer = NULL;
            $rezervare_retur->data_cursa = \Carbon\Carbon::now();
            $rezervare_retur->curs_bnr_euro = $curs_bnr_euro->valoare;
            $rezervare_retur->valoare_lei_tva = ($rezervare_retur->pret_total * $rezervare_retur->curs_bnr_euro) * 0.19;
            $rezervare_retur->valoare_lei = ($rezervare_retur->pret_total * $rezervare_retur->curs_bnr_euro) - $rezervare_retur->valoare_lei_tva;
            $rezervare_retur->bilet_serie = NULL;
            $rezervare_retur->bilet_numar = NULL;
            $rezervare_retur->lista_plecare = Oras::find($rezervare_retur->oras_plecare)->traseu ?? null;
            $rezervare_retur->lista_sosire = Oras::find($rezervare_retur->oras_sosire)->traseu ?? null;
            $rezervare_retur->plata_efectuata = NULL;
            $rezervare_retur->user_id = auth()->user()->id;
        }

        $clone_rezervare = $rezervare_tur->replicate();
        (isset($rezervare_retur)) ? $clone_rezervare_retur = $rezervare_retur->replicate() : '';

        $clone_rezervare->cheie_unica = uniqid('tur');
        $clone_rezervare->created_at = \Carbon\Carbon::now();
        $clone_rezervare->updated_at = \Carbon\Carbon::now();
        $clone_rezervare->save();
        if (isset($clone_rezervare_retur)) {
            $clone_rezervare_retur->cheie_unica = uniqid('retur');
            $clone_rezervare_retur->created_at = \Carbon\Carbon::now();
            $clone_rezervare_retur->updated_at = \Carbon\Carbon::now();
            $clone_rezervare_retur->save();

            //adaugarea id-urilor de tur - retur la fiecare in parte
            $clone_rezervare->retur = $clone_rezervare_retur->id;
            $clone_rezervare->update();
            $clone_rezervare_retur->tur = $clone_rezervare->id;
            $clone_rezervare_retur->update();
        }
        // dd($rezervare_tur->pasageri_relation, $rezervare_retur, $clone_rezervare, $clone_rezervare_retur);
        // salvare pasageri si atasare la rezervari
        // if ($rezervare_tur->pasageri_relation->exists()){
            foreach ($rezervare_tur->pasageri_relation as $pasager) {
                $clone_pasager = $pasager->replicate();
                $clone_pasager->save();

                $clone_rezervare->pasageri_relation()->attach($clone_pasager->id);
                (isset($clone_rezervare_retur)) ? $clone_rezervare_retur->pasageri_relation()->attach($clone_pasager->id) : '';
            }
        // }

        // $tip_operatie = "modificare";
        return redirect()->action(
            [RezervareController::class, 'edit'],
            ['rezervare' => $clone_rezervare->id]
        );
        // return view('rezervari.guest-create/adauga-rezervare-pasul-1', compact('rezervare', 'tip_operatie'));
        // return redirect('/rezervari')->with('status', 'Rezervarea clientului "' . $rezervare_tur->nume . '" a fost duplicată');
    }

    public function test()
    {
        // $telefoane = ['5749262658'];
        $telefon1 = '5749262658';
        $telefon2 = '00005749262658';
        $telefoane = [$telefon1, $telefon2];
        $this->trimiteSms('rezervari', null, '2', $telefoane, 'Salutare tuturor');
    }

}
