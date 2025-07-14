<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\MotifBatik;
use Illuminate\Http\Request;

class MotifBatikController extends Controller
{
    //
    public function index()
    {
        $motifBatik = MotifBatik::paginate(10);
        return view('admin.motif_batik.index', compact('motifBatik'));
    }

}
