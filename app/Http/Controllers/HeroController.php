<?php

namespace App\Http\Controllers;

use App\Models\Backup;
use App\Models\Donation;
use App\Models\Hero;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    public function index()
    {
        $heroes = Hero::paginate(30);
        return view('pages.hero.index',["heroes"=>$heroes]);
    }
    public function backups()
    {
        $backups = Backup::orderBy('updated _at','desc')->paginate(30);
        return view('pages.hero.backups',["backups"=>$backups]);
    }
    public function create()
    {
        $donations = Donation::where('status','aktif')->get();
        return view('pages.form',["donations"=>$donations]);
    }
    public function store(Request $request)
    {
        $donation = Donation::find($request["donation"]);
        if($donation->sisa==0){
            return back();
        }
        $request->validate([
            "telepon"=>'regex:/^8/'
        ]);
        $kode = $this->generate();
        Hero::create([
            "nama" => $request["nama"],
            "telepon" => "62".$request["telepon"],
            "fakultas" => $request["fakultas"],
            "donation" => $request["donation"],
            "kode" => $kode,
            "status" => "belum",
        ]);
        $donation->sisa = $donation->sisa - 1;
        $donation->save();
        session(['donation' => $donation->id]);
        session(['kode' => $kode]);
        return back();
    }
    public function show(Hero $hero)
    {
        return view('pages.hero.show');
    }
    public function update(Request $request, Hero $hero)
    {
        $hero->status = "sudah";
        $hero->save();
        return back();
    }
    public function restore(Backup $backup)
    {
        $donation = $backup->donation();
        if($donation->sisa > 0){
            Hero::create([
                "nama" => $backup->nama,
                "telepon" => $backup->telepon,
                "fakultas" => $backup->fakultas,
                "donation" => $backup->donation,
                "kode" => $backup->kode,
                "status"=> "belum"
            ]);
            $donation->sisa = $donation->sisa -1;
            $donation->save();
            $backup->delete();
        }
        return back();
    }
    public function trash(Backup $backup)
    {
        $backup->delete();
        return back();
    }
    public function destroy(Hero $hero)
    {
        $donation = $hero->donation();
        $donation->sisa = $donation->sisa +1;
        $donation->save();
        Backup::create([
            "nama" => $hero->nama,
            "telepon" => $hero->telepon,
            "fakultas" => $hero->fakultas,
            "donation" => $hero->donation,
            "kode" => $hero->kode,
        ]);
        $hero->delete();
        return back();
    }
    public function generate()
    {
        $characters = '1234567890';
        $charactersLength = strlen($characters);
        $uniqueString = '';
        
        for ($i = 0; $i < 6; $i++) {
            $index = rand(0, $charactersLength - 1);
            $uniqueString .= $characters[$index];
        }
        
        return $uniqueString;
    }
    public function faculty($faculty){
        $heroes = Hero::where('fakultas',$faculty)->get();
        return view('pages.hero.faculty',["heroes"=>$heroes]);
    }
    public function cancel(Request $request){
        $hero = Hero::where('donation',session('donation'))->where('kode',session('kode'))->first();
        $donation = $hero->donation();
        $donation->sisa = $donation->sisa +1;
        $donation->save();
        $hero->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("/");
    }
}
