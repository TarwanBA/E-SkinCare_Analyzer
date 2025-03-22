<?php

namespace App\Http\Controllers;

use App\Models\Fpgrowth;
use Illuminate\Http\Request;

class FpgrowthController extends Controller
{
    public function index()
    {
        $fp = Fpgrowth::all();
        $support = Fpgrowth::value('support');
        $confidence = Fpgrowth::value('confidance');

        return view("backend.fpgrowth", compact('fp', 'support', 'confidence'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'support' => 'required|integer',
            'confidance' => 'required|integer',
        ]);

        $produk = Fpgrowth::findOrFail($id);
        $produk->update([
            'support' => $request->support,
            'confidance' => $request->confidance,
        ]);

        return redirect()->route('fp.index')->with('success', 'Nilai berhasil diperbarui.');
    }
}
