<?php

namespace App\Http\Controllers;

use App\Models\Donation\Donation;
use App\Models\Donation\Sponsor;
use App\Models\Heroes\University;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DonationController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth', only: ['create', 'store', 'show', 'edit', 'update', 'destroy']),
        ];
    }

    public function index()
    {
        $donations = Donation::with('sponsor')->orderByRaw("CASE WHEN status = 'aktif' THEN 0 WHEN status = 'selesai' THEN 1 ELSE 2 END")
            ->orderBy('take')
            ->paginate(10);

        return view('pages.donation.index', compact('donations'));
    }

    public function create()
    {
        $sponsors = Sponsor::all();
        $universities = University::all();

        return view('pages.donation.create', compact('sponsors', 'universities'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['remain'] = $request->quota;
        $data['status'] = 'aktif';
        $data['beneficiaries'] = json_encode($request->beneficiaries);
        if ($data['beneficiaries'] == "null") {
            return back()->with('error', 'Pilih minimal satu beneficiaries');
        }
        Donation::create($data);

        return redirect(route('donation.index'));
    }

    public function show(Donation $donation)
    {
        if ($donation->partner_id) {
            $heroes = $donation->partner->heroes()->with('faculty')->get();
            $donations = Donation::whereNot('id', $donation->id)->where('status', 'aktif')->orWhere('id', '=', $donation->partner_id)->get();
        } else {
            $donations = Donation::whereNot('id', $donation->id)->where('status', 'aktif')->get();
            $heroes = $donation->heroes()->with('faculty')->get();
        }
        $foods = $donation->foods;

        return view('pages.donation.show', compact('donation', 'foods', 'heroes', 'donations'));
    }

    public function edit(Donation $donation)
    {
        $universities = University::all();
        return view('pages.donation.edit', compact('donation', 'universities'));
    }

    public function update(Request $request, Donation $donation)
    {
        if ($request->notes) {
            $donation->notes = $request->notes;
            if ($request->partner_id != "") {
                $donation->partner_id = $request->partner_id;
            } else {
                $donation->partner_id = null;
            }
            $donation->save();

            return back();
        }
        $donation->take = $request->take;
        $donation->status = $request->status;
        $donation->hour = $request->hour;
        $donation->minute = $request->minute;
        $donation->message = $request->message;

        if ($request->add) {
            $donation->remain = $donation->remain + $request->add;
            $donation->quota = $donation->quota + $request->add;
        }
        if ($request->diff) {
            $donation->remain = $donation->remain - $request->diff;
            $donation->quota = $donation->quota - $request->diff;
        }
        $beneficiaries = json_encode($request->beneficiaries);
        if ($beneficiaries == 'null') {
            $beneficiaries = null;
        }
        $donation->beneficiaries = $beneficiaries;


        if ($donation->status == 'selesai') {
            if ($donation->partner_id == null) {
                $foods = $donation->foods->sum('weight');
                $partners = $donation->partners;
                if ($partners->count() > 0) {
                    foreach ($partners as $partner) {
                        $foods += $partner->foods->sum('weight');
                    }
                }
                $foods = $foods / $donation->heroes->sum('quantity');
                $heroes = $donation->heroes;
                foreach ($heroes as $hero) {
                    $hero->weight = $foods * $hero->quantity;
                    $hero->save();
                }
            }
            $donation->quota = $donation->quota - $donation->remain;
            $donation->remain = 0;
        }
        $donation->save();
        return redirect(route('donation.index'));
    }

    public function destroy(Donation $donation)
    {
        if ($donation->heroes->count() == 0 && $donation->foods->count() == 0) {
            $donation->delete();
        }

        return redirect(route('donation.index'));
    }
}
