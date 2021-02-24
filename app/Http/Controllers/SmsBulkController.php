<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Helpers\SMSLinkSMSGatewayBulkPackage;
use App\Http\Helpers\Test;

class SmsBulkController extends Controller
{
    public function test(){
        // dd(storage_path('app/fisiere_temporare/'));
        $sms = new SMSLinkSMSGatewayBulkPackage(config('sms_link.connection_id'), config('sms_link.password'), true);
        $sms->insertMessage(1, "0749262658",   "numeric", "Test SMS 1");
        $sms->insertMessage(2, "0749262658",   "numeric", "Test SMS 2");
        $sms->insertMessage(3, "0749262658",   "numeric", "Test SMS 3");

        
        $BulkSMSPackage->sendPackage();
        // $test = new Test(1, 2);
        dd($sms);
    }
}
