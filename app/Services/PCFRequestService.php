<?php

namespace App\Services;

use App\Models\User;
use App\Models\PCFRequest;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use App\Notifications\ApprovePCFRequestNotification;
use App\Notifications\AccountingApprovedPCFRequestNotification;
use App\Notifications\AccountingDisapprovedPCFRequestNotification;

class PCFRequestService
{
    public function approveRequestService($pcfRequest_id): PCFRequest
    {
        $user = auth()->user();
        $pcfRequest = PCFRequest::findOrFail($pcfRequest_id);

        $psr = User::find($pcfRequest->created_by);
        $salesAsst = User::role('Sales Assistant')->get();
        $nsms = User::role('National Sales Manager')->get(); 
        $cfos = User::role('Chief Finance Officer')->get(); 

        if (($user->can('psr_mgr_approve_pcf') && $pcfRequest->status_id == 1)) {
            $status = 2;
        } else if (($user->can('mktg_approve_pcf') && $pcfRequest->status_id == 1)) {
            $status = 3;
        } else if ($user->can('nsm_approve_pcf') && in_array($pcfRequest->status_id, [2, 3]) && 
            $pcfRequest->countDistinct($pcfRequest->id) > 1) {
                $status = 4;
        } else if ($user->can('nsm_approve_pcf') && in_array($pcfRequest->status_id, [2, 3])
            && $pcfRequest->countDistinct($pcfRequest->id) == 1
            && $pcfRequest->checkColumnValue($pcfRequest->id) == 'NO') {
                $status = 4;
        } else if ($user->can('nsm_approve_pcf') && in_array($pcfRequest->status_id, [2, 3])
            && $pcfRequest->countDistinct($pcfRequest->id) == 1
            && $pcfRequest->checkColumnValue($pcfRequest->id) == 'YES') {
                $status = 4;
        } else if ($user->can('acct_approve_pcf') &&  $pcfRequest->status_id == 4) {
            $status = 5;
            $pcfRequest->update(['approved_by' => $user->id,]);

            foreach($salesAsst as $asst) {
                $psr->notify(new AccountingApprovedPCFRequestNotification(
                    $asst->email,
                    $user->name,
                    $pcfRequest->institution, 
                    $pcfRequest->supplier,
                    $psr->name
                ));
            }
        } else if ($user->can('cfo_approve_pcf') &&  $pcfRequest->status_id == 5) {

                $acct = User::find($pcfRequest->approved_by);
                $status = 6;

                foreach($salesAsst as $asst) {
                    foreach($nsms as $nsm) {
                        foreach($cfos as $cfo) {
                            $psr->notify(new ApprovePCFRequestNotification(
                                $asst->email,
                                $acct->name, 
                                $pcfRequest->institution, 
                                $pcfRequest->supplier,
                                $psr->name,
                                $nsm->name,
                                $cfo->name
                            ));
                        }
                    }
                }
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }

        // DB::transaction();
        
        // try {
            $pcfRequest->update([
                'status_id' => $status,
            ]);    
        //     DB::commit();
        //     return response()->json(['success' => 'success'], 200);
        // }
        // catch (\Throwable $th) {
        //     DB::rollBack();
        // }

        return $pcfRequest;
    }

    public function disapproveRequestService($pcfRequest_id): PCFRequest
    {
        $user = auth()->user();
        $pcfRequest = PCFRequest::findOrFail($pcfRequest_id);

        $psr = User::find($pcfRequest->created_by);
        $acct = User::find($user->id);
        $salesAsst = User::role('Sales Assistant')->get(); 

        if (($user->can('psr_mgr_reject_pcf') || $user->can('mktg_reject_pcf')) &&  $pcfRequest->status_id == 1) {
            $status = 7;
        } else if ($user->can('nsm_reject_pcf') && in_array($pcfRequest->status_id, [2, 3])) {
            $status = 7;
        } else if ($user->can('acct_reject_pcf') &&  $pcfRequest->status_id == 4) {
            $status = 7;

            foreach($salesAsst as $asst) {
                $psr->notify(new AccountingDisapprovedPCFRequestNotification(
                    $asst->email,
                    $acct->name, 
                    $pcfRequest->institution, 
                    $pcfRequest->supplier,
                    $psr->name
                ));
            }

        } else if ($user->can('cfo_reject_pcf') &&  $pcfRequest->status_id == 5) {
            $status = 7;
        } else {
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        }

        // DB::beginTransaction();

        // try {
            $pcfRequest->update([
                'status_id' => $status,
                'approved_by' => NULL,
            ]);

        //     DB::commit();
        //     return response()->json(['success' => 'success'], 200);
        // }
        // catch (\Throwable $th) {
        //     DB::rollBack();
        // }

        return $pcfRequest;
    }
}