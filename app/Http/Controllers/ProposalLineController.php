<?php

namespace App\Http\Controllers;

use App\Models\ProposalLine;
use Illuminate\Http\Request;

class ProposalLineController extends Controller
{
    public function destroy(ProposalLine $proposalLine)
    {
        $proposalLine->delete();
        return back()->with('success', 'Line deleted successfully.');
    }
}
