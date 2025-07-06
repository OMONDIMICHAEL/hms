<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class InsuranceClaimController extends Controller
{
    public function approve(InsuranceClaim $claim)
    {
        $claim->update(['status' => 'approved']);
        return back()->with('success', 'Claim approved');
    }

    public function reject(InsuranceClaim $claim)
    {
        $claim->update(['status' => 'rejected']);
        return back()->with('success', 'Claim rejected');
    }
    public function index()
    {
        $claims = Patient::all();
        return view('insurance_claims.index', compact('claims'));
    }
}
