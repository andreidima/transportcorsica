<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Masina;
use App\Models\Sofer;
use App\Mail\CronJobAlerteMasiniSoferi;
use Carbon\Carbon;

use App\Traits\TrimiteSmsTrait;

class CronJobTrimitereController extends Controller
{
    use TrimiteSmsTrait;

    public function trimitere($key = null)
    {
        $config_key = \Config::get('variabile.cron_job_key');
        // dd($key, $config_key);

        if ($key === $config_key){
            $mesaj_per_total = '';

            $masini = Masina::all();
            $soferi = Sofer::all();

            // Se calculeaza zilele ramase pana la data din DB. Valoarea poate fi negativa daca a trecut deja data
            // Se verifica daca mai sunt 30 de zile pana la data din DB, daca mai sunt maxim 10 zile, sau daca deja a trecut data din DB.

            foreach ($masini as $masina) {
                $mesaj_per_masina = '';
                if($masina->itp) {
                    $zile_ramase = Carbon::parse(Carbon::today())->diffInDays($masina->itp, false);
                    if(($zile_ramase < 10) || ($zile_ramase == 30)){
                        $mesaj_per_masina .= 'ITP ' . Carbon::parse($masina->itp)->isoFormat('DD.MM.YYYY') . ', ';
                    }
                }
                if($masina->asigurare_rca) {
                    $zile_ramase = Carbon::parse(Carbon::today())->diffInDays($masina->asigurare_rca, false);
                    if(($zile_ramase < 10) || ($zile_ramase == 30)){
                        $mesaj_per_masina .= 'RCA ' . Carbon::parse($masina->asigurare_rca)->isoFormat('DD.MM.YYYY') . ', ';
                    }
                }
                if($masina->asigurari_persoane_colete) {
                    $zile_ramase = Carbon::parse(Carbon::today())->diffInDays($masina->asigurari_persoane_colete, false);
                    if(($zile_ramase < 10) || ($zile_ramase == 30)){
                        $mesaj_per_masina .= 'Asigurari persoane colete ' . Carbon::parse($masina->asigurari_persoane_colete)->isoFormat('DD.MM.YYYY') . ', ';
                    }
                }
                if($masina->licenta) {
                    $zile_ramase = Carbon::parse(Carbon::today())->diffInDays($masina->licenta, false);
                    if(($zile_ramase < 10) || ($zile_ramase == 30)){
                        $mesaj_per_masina .= 'Licenta ' . Carbon::parse($masina->licenta)->isoFormat('DD.MM.YYYY') . ', ';
                    }
                }
                if($masina->clasificare) {
                    $zile_ramase = Carbon::parse(Carbon::today())->diffInDays($masina->clasificare, false);
                    if(($zile_ramase < 10) || ($zile_ramase == 30)){
                        $mesaj_per_masina .= 'Clasificare ' . Carbon::parse($masina->clasificare)->isoFormat('DD.MM.YYYY') . ', ';
                    }
                }
                if($masina->verificare_tahograf) {
                    $zile_ramase = Carbon::parse(Carbon::today())->diffInDays($masina->verificare_tahograf, false);
                    if(($zile_ramase < 10) || ($zile_ramase == 30)){
                        $mesaj_per_masina .= 'Verificare tahograf ' . Carbon::parse($masina->verificare_tahograf)->isoFormat('DD.MM.YYYY') . ', ';
                    }
                }
                if($masina->rovinieta_romania) {
                    $zile_ramase = Carbon::parse(Carbon::today())->diffInDays($masina->rovinieta_romania, false);
                    if(($zile_ramase < 10) || ($zile_ramase == 30)){
                        $mesaj_per_masina .= 'Rovinieta Romania ' . Carbon::parse($masina->rovinieta_romania)->isoFormat('DD.MM.YYYY') . ', ';
                    }
                }
                if($masina->rovinieta_ungaria) {
                    $zile_ramase = Carbon::parse(Carbon::today())->diffInDays($masina->rovinieta_ungaria, false);
                    if(($zile_ramase < 10) || ($zile_ramase == 30)){
                        $mesaj_per_masina .= 'Rovinieta Ungaria ' . Carbon::parse($masina->rovinieta_ungaria)->isoFormat('DD.MM.YYYY') . ', ';
                    }
                }
                if($masina->rovinieta_slovenia) {
                    $zile_ramase = Carbon::parse(Carbon::today())->diffInDays($masina->rovinieta_slovenia, false);
                    if(($zile_ramase < 10) || ($zile_ramase == 30)){
                        $mesaj_per_masina .= 'Rovinieta Slovenia ' . Carbon::parse($masina->rovinieta_slovenia)->isoFormat('DD.MM.YYYY') . ', ';
                    }
                }
                if($masina->revizie) {
                    $zile_ramase = Carbon::parse(Carbon::today())->diffInDays($masina->revizie, false);
                    if(($zile_ramase < 10) || ($zile_ramase == 30)){
                        $mesaj_per_masina .= 'Revizie ' . Carbon::parse($masina->revizie)->isoFormat('DD.MM.YYYY') . ', ';
                    }
                }

                if ($mesaj_per_masina) {
                    $mesaj_per_total .= 'Masina ' . $masina->nume . ': ' . $mesaj_per_masina . '. ';
                }
            }

            foreach ($soferi as $sofer) {
                $mesaj_per_sofer = '';
                if($sofer->analize_medicale) {
                    $zile_ramase = Carbon::parse(Carbon::today())->diffInDays($sofer->analize_medicale, false);
                    if(($zile_ramase < 10) || ($zile_ramase == 30)){
                        $mesaj_per_sofer .= 'Analize medicale ' . Carbon::parse($sofer->analize_medicale)->isoFormat('DD.MM.YYYY') . ', ';
                    }
                }
                if($sofer->permis) {
                    $zile_ramase = Carbon::parse(Carbon::today())->diffInDays($sofer->permis, false);
                    if(($zile_ramase < 10) || ($zile_ramase == 30)){
                        $mesaj_per_sofer .= 'Permis ' . Carbon::parse($sofer->permis)->isoFormat('DD.MM.YYYY') . ', ';
                    }
                }
                if($sofer->buletin) {
                    $zile_ramase = Carbon::parse(Carbon::today())->diffInDays($sofer->buletin, false);
                    if(($zile_ramase < 10) || ($zile_ramase == 30)){
                        $mesaj_per_sofer .= 'Buletin ' . Carbon::parse($sofer->buletin)->isoFormat('DD.MM.YYYY') . ', ';
                    }
                }

                if ($mesaj_per_sofer) {
                    $mesaj_per_total .= 'Soferul ' . $sofer->nume . ': ' . $mesaj_per_sofer . '. ';
                }
            }


            // Trimitere alerta prin email
            \Mail::
                // to('rezervari@transportcorsica.ro')
                to('adima@validsoftware.ro')
                // ->bcc(['contact@validsoftware.ro', 'adima@validsoftware.ro'])
                ->send(new CronJobAlerteMasiniSoferi($mesaj_per_total)
            );

            // Trimitere alerta prin SMS
            // Trait continand functie cu argumentele: categorie(string), subcategorie(string), referinta_id(integer), telefoane(array), mesaj(string)
            $this->trimiteSms('alerte masini soferi', null, null, ['0749262658'], $mesaj_per_total);



                    echo $mesaj_per_total;
            // return redirect('/clienti')->with('status', 'Cron Joburile de astăzi au fost trimise!' . $cron_jobs->count());
        } else {
            echo 'Cheia pentru Cron Joburi nu este corectă!'
            // return redirect('/clienti')->with('error', 'Cron Joburile de astăzi nu fost trimise! Cheia ' . $key . ' nu este validă');
        }

    }
}
