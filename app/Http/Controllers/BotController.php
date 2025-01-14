<?php

namespace App\Http\Controllers;

use App\Models\Donation\Donation;
use App\Models\Heroes\Hero;
use Illuminate\Http\Request;

class BotController extends Controller
{
    public function fromFonnte()
    {
        header('Content-Type: application/json; charset=utf-8');
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $sender = $data['sender'];
        $message = $data['message'];
        if (in_array($sender, ['120363387637009310@g.us', '120363350581821641@g.us', '6289636055420'])) {
            if ($message == "@BOT help" && $sender == '6289636055420') {
                $this->getHelp($sender);
            } else if ($message == "@BOT donasi hari ini") {
                $this->getActiveDonation($sender);
            } else if ($message == "@BOT hero hari ini") {
                $this->getAllActiveHero($sender);
            } elseif ($message == "@BOT hero yang belum") {
                $this->getAllNotYetHero($sender);
            } elseif ($message == "@BOT ingatkan hero hari ini") {
                $this->reminderToday($sender);
            } elseif (str_contains($message, "@BOT ingatkan hero yang belum")) {
                $this->reminderLastCall($message, $sender);
            }
        } else {
            $this->getReplyFromHero($sender, $message);
        }
    }
    public function getReplyFromHero($sender, $text)
    {
        $activeDonation = Donation::where('status', 'aktif')->first();
        $notyetHero = Hero::where('donation_id', $activeDonation->id)->where('status', 'belum')->where('phone', $sender)->get();

        if ($notyetHero->count() == 1) {
            $notyetHero = $notyetHero[0];
            $message = "> Balasan Heroes" . " \n\n" . $notyetHero->name . "\n_Fakultas " . $notyetHero->faculty->name . "_\n\n" . $text;
            $this->kirimWa('120363350581821641@g.us', $message);
        }
    }
    public function kirimWa($target, $message)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $target,
                'message' => $message,
                'schedule' => 0,
                'typing' => false,
                'delay' => '2',
                'countryCode' => '62',
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . env('FONNTE_KEY', null)
            ),
        ));

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);

        if (isset($error_msg)) {
            echo $error_msg;
        }
        echo $response;
    }

    function getAllActiveHero($sender)
    {
        $activeDonation = Donation::where('status', 'aktif')->first();
        $allHero = Hero::where('donation_id', $activeDonation->id)->get(['name', 'phone']);
        $message = "";
        $message = $message . "Daftar heroes hari ini" . " \n ";
        $message = $message . "_Jumlah : " . $allHero->count() . "_" . " \n ";
        foreach ($allHero as $hero) {
            $message = $message . " \n " . $hero->name;
            $message = $message . " \n " . $hero->phone;
        }
        $this->kirimWa($sender, $message);
    }
    function getAllNotYetHero($sender)
    {
        $activeDonation = Donation::where('status', 'aktif')->first();
        $notyetHero = Hero::where('donation_id', $activeDonation->id)->where('status', 'belum')->get(['name', 'phone']);
        $message = "";
        $message = $message . "Daftar yang belum mengambil" . " \n ";
        $message = $message . "_Jumlah : " . $notyetHero->count() . "_" . " \n ";
        foreach ($notyetHero as $hero) {
            $message = $message . " \n " . $hero->name;
            $message = $message . " \n " . $hero->phone;
        }
        $this->kirimWa($sender, $message);
    }

    public function reminderLastCall($jam, $sender)
    {
        $activeDonation = Donation::where('status', 'aktif')->first();
        $notyetHero = Hero::where('donation_id', $activeDonation->id)->where('status', 'belum')->get(['name', 'phone']);
        $jam = str_replace('@BOT ingatkan hero yang belum ', '', $jam);
        foreach ($notyetHero as $hero) {
            $message = "Halo " . $hero->name . " kami dari BBJ mengingatkan untuk bisa mengambil makanan di " . $activeDonation->location . "(" . $activeDonation->maps . "). " . "Kami tunggu hingga pukul " . $jam . " yaaa\nTerimakasih \n\n" . "_pesan ini dikirim dengan bot_";
            $this->kirimWa($hero->phone, $message);
        }
        $message = "Berhasil mengirimkan kepada " . $notyetHero->count() . " hero";
        $this->kirimWa($sender, $message);
    }
    public function reminderToday($sender)
    {
        $activeDonation = Donation::where('status', 'aktif')->first();
        $allActiveHero = Hero::where('donation_id', $activeDonation->id)->get(['name', 'phone']);
        foreach ($allActiveHero as $hero) {
            $message = "Halo " . $hero->name . " kami dari BBJ mengingatkan bahwa pengambilan surplus food dimulai pada pukul " . $activeDonation->hour . "." . $activeDonation->minute . " dan bisa diambil di " . $activeDonation->location . "(" . $activeDonation->maps . ")" . "\n\nTerimakasih \n\n" . "_pesan ini dikirim dengan bot_";
            $this->kirimWa($hero->phone, $message);
        }
        $message = "Berhasil mengirimkan kepada " . $allActiveHero->count() . " hero";
        $this->kirimWa($sender, $message);
    }
    public function getActiveDonation($sender)
    {
        $activeDonation = Donation::where('status', 'aktif')->first();
        $message = "*[AKSI HARI INI]*\n\n" . "Donatur : " . $activeDonation->sponsor->name . "\nKuota : " . $activeDonation->quota . "\nTersisa : " . $activeDonation->remain . "\nHero terdaftar : " . $activeDonation->heroes->count() . " Orang";
        $this->kirimWa($sender, $message);
    }
    public function getHelp($sender)
    {
        $message = "@BOT help\n" . "@BOT donasi hari ini\n" . "@BOT hero hari ini\n" . "@BOT hero yang belum\n" . "@BOT ingatkan hero hari ini\n" . "@BOT ingatkan hero yang belum";
        $this->kirimWa($sender, $message);
    }
}
