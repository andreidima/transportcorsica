<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Masina;
use App\Models\Sofer;
// use App\Mail\CronJobTrimitere;
use Carbon\Carbon;

class CronJobTrimitereController extends Controller
{
    public function trimitere($key = null)
    {
        $config_key = \Config::get('variabile.cron_job_key');
        // dd($key, $config_key);

        if ($key === $config_key){
            $mesaj = '';

            $masini = Masina::all();
            $soferi = Sofer::all();

            foreach ($masini as $masina) {
                if($masina->itp) {
                    // echo Carbon::parse($masina->itp) . ' --- ' . (Carbon::today()) . '<br>';
                    // echo Carbon::parse($masina->itp)->diffInDays(Carbon::today()) . '<br><br>';
                    switch ($zile_ramase = Carbon::parse($masina->itp)->diffInDays(Carbon::today())){
                        case (Carbon::parse($masina->itp) < Carbon::today()):
                            $mesaj .= 'Masina ' . $masina->nume . ' a depasit cu ' . $zile_ramase . ' zile ITP-ul. ';
                            break;
                        case ($zile_ramase < 10):
                            $mesaj .= 'Masina ' . $masina->nume . ' mai are ' . $zile_ramase . ' zile pana la ITP. ';
                            break;
                        case ($zile_ramase == 30):
                            $mesaj .= 'Masina ' . $masina->nume . ' mai are 30 de zile pana la ITP. ';
                            break;
                    }
                }
                if($masina->asigurare_rca) {
                    switch ($zile_ramase = Carbon::parse($masina->asigurare_rca)->diffInDays(Carbon::today())){
                        case (Carbon::parse($masina->asigurare_rca) < Carbon::today()):
                            $mesaj .= 'Masina ' . $masina->nume . ' a depasit cu ' . $zile_ramase . ' zile RCA-ul. ';
                            break;
                        case ($zile_ramase < 10):
                            $mesaj .= 'Masina ' . $masina->nume . ' mai are ' . $zile_ramase . ' zile pana la RCA. ';
                            break;
                        case ($zile_ramase == 30):
                            $mesaj .= 'Masina ' . $masina->nume . ' mai are 30 de zile pana la RCA. ';
                            break;
                    }
                }
            }
                    // \Mail::
                    //     to($to_email)
                    //     ->bcc(['contact@validsoftware.ro', 'adima@validsoftware.ro'])
                    //     ->send(new CronJobTrimitere($cron_job)
                    // );
                    dd($mesaj);
            // return redirect('/clienti')->with('status', 'Cron Joburile de astăzi au fost trimise!' . $cron_jobs->count());
        } else {
            // return redirect('/clienti')->with('error', 'Cron Joburile de astăzi nu fost trimise! Cheia ' . $key . ' nu este validă');
        }

    }
}
