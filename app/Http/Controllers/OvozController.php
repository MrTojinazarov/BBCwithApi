<?php
namespace App\Http\Controllers;

use App\Models\Ovoz;
use Illuminate\Http\Request;

class OvozController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'savol_id' => 'required|exists:savols,id',
            'variant_id' => 'required|exists:variants,id',
        ]);

        $userIp = $request->ip();

        Ovoz::create([
            'savol_id' => $request->savol_id,
            'variant_id' => $request->variant_id,
            'user_ip' => $userIp,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Ovoz berish muvaffaqiyatli amalga oshirildi.'
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'savol_id' => 'required|exists:savols,id',
            'variant_id' => 'required|exists:variants,id',
        ]);

        $userIp = $request->ip();

        $existingVote = Ovoz::where('user_ip', $userIp)->where('savol_id', $request->savol_id)->first();

        if ($existingVote) {
            if ($existingVote->variant_id != $request->variant_id) {
                $existingVote->variant_id = $request->variant_id;
                $existingVote->save();
            }
        } else {
            Ovoz::create([
                'savol_id' => $request->savol_id,
                'variant_id' => $request->variant_id,
                'user_ip' => $userIp,
            ]);
        }

        $totalVotes = Ovoz::where('savol_id', $request->savol_id)->count();
        $variantVotes = Ovoz::where('variant_id', $request->variant_id)
                             ->where('savol_id', $request->savol_id)
                             ->count();

        return response()->json([
            'success' => true,
            'variantVotes' => $variantVotes,
            'totalVotes' => $totalVotes
        ]);
    }
}
