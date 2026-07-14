<?php

namespace App\Http\Controllers;

use App\Models\OslpTeam;
use App\Models\Visit;
use App\Models\VisitOcrdPerson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class VisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Visit::with(['salesman','ocrd_card',]);

        $query->filter($request->only(['search']));
        if ($request->filled('date_from')) {
            $query->whereDate('visit_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('visit_date', '<=', $request->date_to);
        }

        if ($user->role === 'salesman_ids') {
            if ($user->oslpReg) {
                $slpCode = $user->oslpReg->RegSlpCode;
                $slpCodeMember = OslpTeam::where('SlpCodeLeader', $slpCode)->pluck('SlpCodeMember');
                if ($slpCodeMember->isNotEmpty()) {
                    $query->whereIn('slp_code', $slpCodeMember);
                } else {
                    $query->where('slp_code', $slpCode);
                }
                // dd($slpCodeMember);
            } else {
                $query->whereRaw('1=0'); // tidak punya sales code
            }

        } 
        
        $visits = $query->orderByDesc('visit_date')->orderByDesc('id')->paginate(50)->withQueryString();
        
        return view('visit.visit', [
            'title' => 'SAPConnect KKJ - Daftar Kunjungan',
            'titleHeader' => 'Daftar Kunjungan',
            'visits' => $visits
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('visit.visit_create', [
            'title' => 'SAPConnect KKJ - Buat Kunjungan',
            'titleHeader' => 'Buat Kunjungan',
            // 'ocrdCard' => $ocrdCard
            // 'grouped' => $grouped
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'visit_date' => ['required', 'date'],
            'ocrd_card_id' => ['required', 'exists:ocrd_card,id'],
            'note' => ['nullable', 'string'],
            'persons' => ['required', 'array', 'min:1'],
            'persons.*.ocrd_person_id' => [
                'required',
                'exists:ocrd_person,id'
            ],
        ]);

        DB::transaction(function () use ($validated) {
            $visit = Visit::create([
                'slp_code' => auth()->user()->oslpReg?->RegSlpCode ?? -1,
                'ocrd_card_id' => $validated['ocrd_card_id'],
                'visit_date' => $validated['visit_date'],
                'note' => $validated['note'] ?? null,
            ]);

            foreach ($validated['persons'] as $person) {
                VisitOcrdPerson::create([
                    'visit_id' => $visit->id,
                    'ocrd_person_id' => $person['ocrd_person_id'],
                ]);
            }
        });

        return redirect()->route('visit')->with('success', 'Kunjungan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $visit = Visit::with(['ocrd_card', 'salesman', 'persons'])->findOrFail($id);
        
        if (Gate::denies('visit.edit', $visit)) {
            abort(403, 'Unauthorized');
        }

        return view('visit.visit_detail', [
            'title' => 'SAPConnect KKJ - Detail Kunjungan',
            'titleHeader' => 'Detail Kunjungan',
            'visit' => $visit
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Visit $visit)
    {
        if (Gate::denies('visit.edit', $visit)) {
            abort(403, 'Unauthorized');
        }

        $visit->load([
            'persons',
            'ocrd_card',
        ]);
        // dd($visit->persons->toArray());
        return view('visit.visit_edit', [
            'title' => 'Edit Kunjungan',
            'titleHeader' => 'Edit Kunjungan',
            'visit' => $visit,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'visit_date' => 'required|date',
            'ocrd_card_id' => 'required',
            'note' => 'nullable|string',
        ]);

        $visit = Visit::findOrFail($id);

        $visit->update([
            'ocrd_card_id' => $request->ocrd_card_id,
            'visit_date' => $request->visit_date,
            'note' => $request->note,
        ]);

        // update penanggung jawab
        if ($request->has('persons')) {
            $personIds = collect($request->persons)->pluck('ocrd_person_id')->filter()->values()->toArray();
            $visit->persons()->sync($personIds);
        } else {
            // kalau semua penanggung jawab dihapus
            $visit->persons()->detach();
        }

        return redirect()->route('visit')->with('success', 'Kunjungan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
