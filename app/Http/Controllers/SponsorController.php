<?php

namespace App\Http\Controllers;

use App\Models\Donation\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SponsorController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    public function index()
    {
        $sponsors = Sponsor::where('status', 'always')->paginate(10);

        return view('pages.sponsor.index', compact('sponsors'));
    }
    public function individu()
    {
        $sponsors = Sponsor::whereNot('status', 'always')->paginate(10);

        return view('pages.sponsor.index', compact('sponsors'));
    }

    public function create()
    {
        return view('pages.sponsor.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data["hidden"] = $request->hidden == "on";
        $data["status"] = $request->status == "on" ? 'pending' : 'always';
        Sponsor::create($data);

        return redirect(route('sponsor.index'));
    }

    public function show(Sponsor $sponsor)
    {
        return view('pages.sponsor.show', ['sponsor' => $sponsor, 'donations' => $sponsor->donation()]);
    }

    public function edit(Sponsor $sponsor)
    {
        return view('pages.sponsor.edit', ['sponsor' => $sponsor]);
    }

    public function update(Request $request, Sponsor $sponsor)
    {
        $data = $request->all();
        $data["hidden"] = $request->hidden == "on";
        $sponsor->update($data);

        return redirect(route('sponsor.index'));
    }

    public function destroy(Sponsor $sponsor)
    {
        if ($sponsor->donation()->count() == 0) {
            $sponsor->delete();
        }

        return redirect(route('sponsor.index'));
    }
}
