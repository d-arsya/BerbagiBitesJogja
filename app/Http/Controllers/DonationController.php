<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Faculty;
use App\Models\Sponsor;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::orderByRaw("CASE WHEN status = 'aktif' THEN 0 WHEN status = 'selesai' THEN 1 ELSE 2 END")
	                        ->orderBy('pengambilan')
		                     ->paginate(10);
        return view("pages.donation.index",["donations"=>$donations]);
    }
    public function create()
    {
        $sponsors = Sponsor::all();
        $faculties = Faculty::all();
        return view("pages.donation.create",compact('sponsors','faculties'));
    }
    public function store(Request $request)
    {
        $jatah = [];
        for ($i=1; $i <= 20; $i++) { 
            $jatah[]=["faculty_id"=>$i,"kuota"=>$request["kuota-fakultas-".$i]];
            unset($request["kuota-fakultas-".$i]);
        }
        $data = $request->all();
        $data["jatah"] = json_encode($jatah);
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

        $faculties = Faculty::all();
        return view("pages.donation.edit",compact('donation','faculties'));
    }
    public function update(Request $request, Donation $donation)
    {
        if($request->catatan){
            $donation->catatan = $request->catatan;
            $donation->save(); 
            return back();
        }
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
        $jatah = [];
        for ($i=1; $i <= 20; $i++) { 
            $jatah[]=["faculty_id"=>$i,"kuota"=>$request["kuota-fakultas-".$i]];
            unset($request["kuota-fakultas-".$i]);
        }
        $donation->jatah = json_encode($jatah);
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
