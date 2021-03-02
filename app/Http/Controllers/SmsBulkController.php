<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Helpers\SMSLinkSMSGatewayBulkPackage;
use App\Http\Helpers\Test;

class SmsBulkController extends Controller
{
    public function trimiteSmsBulk($rezervari){
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
        $BulkSMSPackage = new SMSLinkSMSGatewayBulkPackage(config('sms_link.connection_id'), config('sms_link.password'), true);

        /*
        * 
        *    Insert Messages to SMS Package
        *    
        */
        $BulkSMSPackage->insertMessage(1, "0749262658", "numeric", "Test SMS 1");
        $BulkSMSPackage->insertMessage(2, "0749262658567", "numeric", "Test SMS 2");
        $BulkSMSPackage->insertMessage(3, "0749262658", "numeric", "Test SMS 3");

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
            $smsTrimis = new \App\Models\MesajTrimisSms;
            $smsTrimis->categorie = $categorie;
            $smsTrimis->subcategorie = $subcategorie;
            $smsTrimis->referinta_id = $referinta_id;
            $smsTrimis->telefon = $telefon;
            $smsTrimis->mesaj = $mesaj;
            $smsTrimis->content = $content;
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
                        
                        // return back()->with('status',  "Succes for Local Message ID: ".
                        //     $value["localMessageId"].
                        //     ", Remote Message ID: ".
                        //     $value["remoteMessageId"].
                        //     "<br />"
                        //     );
                        
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
                    
                        // $statusCounters["failedInsufficientCredit"]++;
                    
                        break;
                }
                
                // $statusCounters["totalCounter"]++;
                
            }
                
        }
        else
        {
            echo "Error Transmitting Package to SMSLink: ".$BulkSMSPackage->errorMessage."<br />";
            
        }
    }
}
