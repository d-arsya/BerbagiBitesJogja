<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Sponsor;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::orderBy('status')->paginate(10);
        return view("pages.donation.index",["donations"=>$donations]);
    }
    public function create()
    {
        $sponsors = Sponsor::all();
        return view("pages.donation.create",["sponsors"=>$sponsors]);
    }
    public function store(Request $request)
    {
        // dd(Sponsor::class);
        $data = $request->all();
        $data['sisa'] = $request->kuota;
        $data['status'] = "aktif";
        Donation::create($data);
        return redirect(route('donation.index'));
    }
    public function show(Donation $donation)
    {

        return view("pages.donation.show",["donation"=>$donation,"heroes"=>$donation->heroes(),"foods"=>$donation->foods()]);
    }
    public function edit(Donation $donation)
    {
        return view("pages.donation.edit",["donation"=>$donation]);
    }
    public function update(Request $request, Donation $donation)
    {
        $donation->pengambilan = $request->pengambilan;
        $donation->status = $request->status;
        $donation->jam = $request->jam;

        if($request->tambah){
            $donation->sisa = $donation->sisa + $request->tambah;
            $donation->kuota = $donation->kuota + $request->tambah;
        }
        if($request->kurang){
            $donation->sisa = $donation->sisa - $request->kurang;
            $donation->kuota = $donation->kuota - $request->kurang;
        }
        $donation->save();

        return redirect(route('donation.index'));
    }
    public function destroy(Donation $donation)
    {
        if($donation->heroes()->count()==0 && $donation->foods()->count()==0){
            $donation->delete();
        }
        return redirect(route('donation.index'));
    }
}
