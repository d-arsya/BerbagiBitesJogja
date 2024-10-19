<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    public function index()
    {
        $sponsors = Sponsor::paginate(10);
        return view("pages.sponsor.index",["sponsors"=>$sponsors]);
    }
    public function create()
    {
        return view("pages.sponsor.create");
    }
    public function store(Request $request)
    {
        Sponsor::create($request->all());
        return redirect(route('sponsor.index'));
    }
    public function show(Sponsor $sponsor)
    {
        return view("pages.sponsor.show",['sponsor'=>$sponsor,"donations"=>$sponsor->donation()]);
    }
    public function edit(Sponsor $sponsor)
    {
        return view("pages.sponsor.edit",['sponsor'=>$sponsor]);
    }
    public function update(Request $request, Sponsor $sponsor)
    {
        $sponsor->update($request->all());
        return redirect(route('sponsor.index'));
    }
    public function destroy(Sponsor $sponsor)
    {
        if($sponsor->donation()->count()==0){
            $sponsor->delete();
        }
        return redirect(route('sponsor.index'));
    }
}
