<?php
namespace App\Http\Controllers;

use App\Models\Ovoz;
use App\Models\Savol;
use App\Models\Variant;
use Illuminate\Http\Request;

class SavolController extends Controller
{
    public function index()
    {
        $savols = Savol::with('variants')->get();
        return response()->json([
            'savols' => $savols,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        
        $savol = new Savol();
        $savol->name = $request->name;
        $savol->is_active = $request->has('is_active');
        $savol->save();
    
        if ($request->has('variants')) {
            foreach ($request->variants as $variantName) {
                $variant = new Variant();
                $variant->name = $variantName;
                $variant->savol_id = $savol->id;
                $variant->save();
            }
        }
    
        return response()->json([
            'success' => true,
            'message' => 'So\'rovnoma muvaffaqiyatli qo\'shildi.',
            'savol' => $savol,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'savol_name' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
            'variants' => 'required|array',
            'variants.*' => 'required|string|max:255',
        ]);

        $savol = Savol::findOrFail($id);
        $savol->update([
            'name' => $request->savol_name,
            'is_active' => $request->is_active ? true : false,
        ]);

        $savol->variants()->delete();

        foreach ($request->variants as $variantName) {
            Variant::create([
                'savol_id' => $savol->id,
                'name' => $variantName,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'So\'rovnoma muvaffaqiyatli yangilandi.',
            'savol' => $savol,
        ]);
    }

    public function destroy($id)
    {
        $savol = Savol::findOrFail($id);
        $savol->variants()->delete();
        $savol->delete();

        return response()->json([
            'success' => true,
            'message' => 'So\'rovnoma muvaffaqiyatli o\'chirildi.',
        ]);
    }
}
