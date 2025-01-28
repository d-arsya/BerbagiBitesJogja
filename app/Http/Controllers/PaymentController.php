<?php

namespace App\Http\Controllers;

use App\Models\Donation\Donation;
use App\Models\Donation\Food;
use App\Models\Donation\Payment;
use App\Models\Heroes\Hero;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'phone' => 'regex:/^8/',
            'name' => 'required',
            'variant' => 'required',
        ]);
        $data = $request->all();
        $data["status"] = "waiting";
        $data["phone"] = "62" . $request->phone;
        $data["order_id"] = uuid_create();
        $payment = Payment::create($data);
        return redirect()->route('payment.waiting', $payment->order_id);
    }
    public function waiting(Payment $payment)
    {
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = false;

        $params = array(
            'transaction_details' => array(
                'order_id' => $payment->order_id,
                'gross_amount' => $payment->amount,
            ),
            'customer_details' => array(
                'first_name' => $payment->name,
                'last_name' => $payment->name,
                'email' => $payment->email,
                'phone' => $payment->phone,
            ),
        );
        // $snapToken = 1;
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        return view('pages.payment.waiting', compact('payment', 'snapToken'));
    }
    public function callback()
    {
        header('Content-Type: application/json; charset=utf-8');
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $hash = hash('sha512', $data["order_id"] . $data["status_code"] . $data["gross_amount"] . env("MIDTRANS_SERVER_KEY"));
        if ($hash == $data["signature_key"]) {
            $payment = Payment::where('order_id', $data["order_id"])->where('status', 'waiting')->first();
            if ($payment) {
                if ($data["transaction_status"] == "settlement") {
                    $payment->status = "done";
                    BotController::sendForPublic($payment->phone, "*[PENYALURAN KONTRIBUSI]*\n\nTerimakasih atas kontribusi anda kepada Berbagi Bites Jogja" . "\n\n🌱 Empowering sustainability through collective action\n🍽 Partnering with local businesses & communities\n📍 Yogyakarta-based food rescue initiative\n\n📷 Instagram: @berbagibitesjogja\n🌐 Website: https://berbagibitesjogja.site");
                    BotController::sendForPublic("6289523043433", "*[NOTIFIKASI PAYMENT]*\n\nNominal : " . $data["currency"] . " " . number_format($payment->amount, 0, ',', '.') . "\nDari : " . $payment->name);
                } elseif ($data["transaction_status"] == "pending") {
                    $payment->status = "waiting";
                } else {
                    $payment->status = "cancel";
                }
                $payment->save();
            }
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
    public function create(Request $request)
    {
        $ig_media = collect($this->getJsonData('https://graph.instagram.com/me/media?fields=media_url,permalink,media_type,thumbnail_url&access_token=' . env('INSTAGRAM_ACCESS_TOKEN', null))['data'])->take(9);
        $ig_user = collect($this->getJsonData('https://graph.instagram.com/me?fields=biography,followers_count,follows_count,media_count,name,profile_picture_url,username,website&access_token=' . env('INSTAGRAM_ACCESS_TOKEN', null)));

        $donations_sum = Donation::all()->count();
        $foods = round(Food::all()->sum('weight') / 1000);
        $heroes = Hero::all()->sum('quantity');

        $currentDate = Carbon::now();
        $fourMonthsAgo = Carbon::now()->subMonths(7);

        $donationsStat = Donation::whereBetween('take', [$fourMonthsAgo, $currentDate])->with(['foods', 'heroes'])->get();
        $groupedData = $donationsStat->groupBy(function ($donation) {
            return Carbon::parse($donation->take)->format('Y-m'); // Format tahun-bulan (YYYY-MM)
        });
        $lastData = [];
        foreach ($groupedData as $key => $item) {
            $hero_count = 0;
            $food_count = 0;

            foreach ($item as $data) {
                $hero_count += $data->heroes->sum('quantity');
                $food_count += $data->foods->sum('weight') / 1000;
            }
            $lastData[] = [
                'bulan' => Carbon::parse($key)->format('F'),
                'heroes' => $hero_count,
                'foods' => $food_count,
            ];
        }

        return view('pages.payment.create', compact('donations_sum', 'foods', 'heroes', 'ig_media', 'ig_user', 'lastData'));
    }
    public function getJsonData($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response, true);

        return $data;
    }
}
