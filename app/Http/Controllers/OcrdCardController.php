<?php

namespace App\Http\Controllers;

use App\Models\OcrdCard;
use App\Models\OcrdLocal;
use App\Models\OcrdPerson;
use App\Models\OslpLocal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OcrdCardController extends Controller
{
    public function create(string $cardCode)
    {
        $sales = OslpLocal::get();
        $ocrdMaster = OcrdLocal::where('CardCode', $cardCode)->firstOrFail();
        $ocrdCard = OcrdCard::firstOrNew(
            ['card_code' => $cardCode],
            [
                'card_name' => $ocrdMaster->npwp_name ?? $ocrdMaster->CardName,
                'office_address' => $ocrdMaster->npwp_address ?? '',
            ]
        );

        if (blank($ocrdCard->office_address)) {
            $ocrdCard->office_address = $ocrdMaster->npwp_address;
        }

        // map detail rows ke array buat AlpineJS
        $persons = $ocrdCard->person->sortBy('id')->values()->map(function($r){
            return [
                'id' => $r->id,
                'name' => $r->name,
                'position' => $r->position,
                'phone' => $r->phone,
                'date_of_birth' => $r->date_of_birth,
                'hobby' => $r->hobby,
                'gender' => $r->gender,
                'religion' => $r->religion,
                'is_active' => $r->is_active,
            ];
        })->toArray();
        return view('ocrd.ocrd_card_create', [
            'title' => 'SAPConnect KKJ - Kartu Pelanggan',
            'titleHeader' => 'Kartu Pelanggan',
            'ocrdMaster' => $ocrdMaster,
            'ocrdCard' => $ocrdCard,
            'sales' => $sales,
            'persons' => $persons
        ]);
    }

    public function save(Request $request, string $cardCode)
    {
        DB::transaction(function () use ($request, $cardCode) {
            // dd($cardCode);
            $card = OcrdCard::updateOrCreate(
                ['card_code' => $cardCode],
                [
                    // 'card_code'        => $ocrdCard->card_code,
                    'slp_code'         => $request->slp_code,
                    'card_name'        => $request->card_name,
                    'segment'          => $request->segment,

                    'office_address'   => $request->office_address,
                    'office_lat'       => $request->office_lat,
                    'office_lng'       => $request->office_lng,
                    'office_phone'     => $request->office_phone,
                    'office_mail'      => $request->office_mail,
                    'office_fax'       => $request->office_fax,

                    'site_address'     => $request->site_address,
                    'site_lat'         => $request->site_lat,
                    'site_lng'         => $request->site_lng,
                    'site_phone'       => $request->site_phone,
                    'site_mail'        => $request->site_mail,
                    'site_fax'         => $request->site_fax,

                    'customer_desc'    => $request->customer_desc,
                    'service_desc'     => $request->service_desc,
                    'competitor_desc'  => $request->competitor_desc,
                ]
            );
            $personIds = [];
            foreach ($request->persons ?? [] as $person) {
                $personModel = OcrdPerson::updateOrCreate(
                    [
                        'id' => $person['id'] ?? null,
                    ],
                    [
                        'ocrd_card_id' => $card->id,
                        'name' => $person['name'] ?? null,
                        'position' => $person['position'] ?? null,
                        'phone' => $person['phone'] ?? null,
                        'email' => $person['email'] ?? null,
                        'date_of_birth' => $person['date_of_birth'] ?? null,
                        'gender' => $person['gender'] ?? null,
                        'hobby' => $person['hobby'] ?? null,
                        'religion' => $person['religion'] ?? null,
                    ]
                );
                $personIds[] = $personModel->id;
            }
            OcrdPerson::where('ocrd_card_id', $card->id)
                ->whereNotIn('id', $personIds)
                ->delete();
        });

        return redirect()->back()->with('success', 'Data berhasil disimpan.');
    }

    public function api()
    {
        return OcrdCard::select(
            'id',
            'card_code',
            'card_name',
            'segment'
        )
        ->orderBy('card_name')
        ->get()
        ->map(function ($item) {
            $item->label = "{$item->card_name} ({$item->card_code})";
            return $item;
        });
    }

    public function persons($id)
    {
        $ocrdCard = OcrdCard::findOrFail($id);

        return response()->json(
            $ocrdCard->person()
                ->select(
                    'id',
                    'name',
                    'position',
                    'phone',
                    'gender'
                )
                ->where('is_active', 1)
                ->orderBy('name')
                ->get()
        );
    }
}
