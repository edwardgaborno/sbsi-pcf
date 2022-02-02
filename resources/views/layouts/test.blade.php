@php
if (auth()->user()->can('pcf_request_edit')) {
    if (!empty($data->pcf_document)) {
        if ((auth()->user()->can('psr_mgr_approve_pcf') || auth()->user()->can('mktg_approve_pcf')) && 
            ($data->status_id == 1)) {
            return $uploadedPcfEditApproval;
        } else if (auth()->user()->can('nsm_approve_pcf') && (in_array($data->status_id, [2, 3]))) {
            return $uploadedPcfWQuotationApproval;
        } else if (auth()->user()->can('view_approved_pcf') && in_array($data->status_id, [4, 5, 6])) {
            return $uploadedPcfwQuotationView;
        }
    } else {
        if ((auth()->user()->can('psr_mgr_approve_pcf') || auth()->user()->can('mktg_approve_pcf')) && 
            ($data->status_id == 1)) {
                return $wEditApproval;
        } else if (auth()->user()->can('nsm_approve_pcf') && (in_array($data->status_id, [2, 3]))) {
            return $wEditQuotation;
        } else if (auth()->user()->can('view_approved_pcf') && in_array($data->status_id, [4, 5, 6])) {
            return $wViewQuotation;
        }
    }
}
else {
    if (!empty($data->pcf_document)) {
        if (auth()->user()->can('psr_view_pcf') && ($data->status_id == 7)) {
            return $uploadedPcfwEditView;
        } elseif (auth()->user()->can('psr_view_pcf')) {
            return $uploadedPcfView;
        } else if (auth()->user()->can('acct_approve_pcf') && ($data->status_id == 4)) {
            return $uploadedPcfApproval;
        } else if (auth()->user()->can('cfo_approve_pcf') && ($data->status_id == 5)) {
            return $uploadedPcfWOEditApproval;
        } else if (auth()->user()->can('view_approved_pcf') && in_array($data->status_id, [4, 5, 6])) {
            return $uploadedPcfwQuotationView;
        }
    } else {
        if (auth()->user()->can('psr_view_pcf') && ($data->status_id == 7)) {
            return $uploadPcf;
        } elseif (auth()->user()->can('psr_view_pcf')) {
            return '<a target="_blank" href="' . route('PCF.view_pdf', $data->pcf_no) .'" class="badge badge-light" 
                    rel="noopener noreferrer"><i class="far fa-file-pdf"></i> View PCF (PDF)</a>';
        } else if (auth()->user()->can('acct_approve_pcf') && ($data->status_id == 4)) {
            return $approval;
        } else if (auth()->user()->can('cfo_approve_pcf') && ($data->status_id == 5)) {
            return $wQuotation;
        } else if (auth()->user()->can('view_approved_pcf') && in_array($data->status_id, [4, 5, 6])) {
            return $wViewQuotation;
        }
    }
}  
@endphp