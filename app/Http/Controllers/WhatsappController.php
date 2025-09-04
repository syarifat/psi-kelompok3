<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\RombelSiswa;
use App\Models\Report;

class WhatsappController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        $siswa = Siswa::all();
        return view('whatsapp.index', compact('kelas', 'siswa'));
    }

    private function sendFonnte($hp, $pesan)
    {
        $token = 'JMyNJwRy999NVUj4eHfS';
        $url = 'https://api.fonnte.com/send';
        $data = [
            'target' => $hp,
            'message' => $pesan,
            'countryCode' => '62'
        ];
        $client = new \GuzzleHttp\Client();
        $response = $client->post($url, [
            'headers' => ['Authorization' => $token],
            'form_params' => $data
        ]);
        $body = $response->getBody()->getContents();
        $res = json_decode($body, true);

        \Log::info('Fonnte send response:', $res);

        if (isset($res["id"])) {
            foreach($res["id"] as $k => $v){
                \App\Models\Report::create([
                    'message_id' => $v,
                    'target' => $res["target"][$k] ?? $hp,
                    'message' => $pesan,
                    'status' => $res["process"] ?? null,
                ]);
            }
            return ['success' => true];
        } else {
            \Log::error('No message id in Fonnte response', $res);
            return ['success' => false, 'reason' => $res['reason'] ?? 'Gagal kirim'];
        }
    }

    public function send(Request $request)
    {
        $request->validate([
            'pesan' => 'required',
            'tipe' => 'required',
        ]);

        $nomor = [];
        if ($request->tipe == 'semua') {
            $nomor = Siswa::pluck('no_hp_ortu')->toArray();
        } elseif ($request->tipe == 'kelas') {
            $siswaIds = RombelSiswa::where('kelas_id', $request->kelas_id)->pluck('siswa_id');
            $nomor = Siswa::whereIn('id', $siswaIds)->pluck('no_hp_ortu')->toArray();
        } elseif ($request->tipe == 'individu') {
            $nomor[] = $request->no_hp_ortu;
        }

        $gagal = 0;
        foreach ($nomor as $hp) {
            $result = $this->sendFonnte($hp, $request->pesan);
            if (!$result['success']) {
                $gagal++;
            }
        }

        if ($gagal > 0) {
            return back()->with('error', "Gagal kirim ke $gagal nomor. Device WhatsApp tidak connect.");
        }
        return back()->with('success', 'Pesan berhasil dikirim!');
    }

    public function qr()
    {
        $token = 'JMyNJwRy999NVUj4eHfS';
        $url = 'https://api.fonnte.com/qr';

        $client = new \GuzzleHttp\Client();
        $response = $client->post($url, [
            'headers' => ['Authorization' => $token],
            'form_params' => [
                'type' => 'qr',
                'whatsapp' => '6287859017087' // ganti dengan nomor device kamu
            ]
        ]);
        $data = json_decode($response->getBody(), true);

        // Jika device sudah connect, tampilkan pesan
        if (isset($data['reason']) && $data['reason'] === 'device already connect') {
            $qr = null;
            $reason = $data['reason'];
        } elseif (isset($data['url'])) {
            $qr = $data['url'];
            $reason = null;
        } else {
            $qr = null;
            $reason = $data['reason'] ?? 'QR tidak tersedia';
        }

        return view('whatsapp.qr', compact('qr', 'reason'));
    }

    public function webhook(Request $request)
    {
        \Log::info('Webhook Fonnte masuk:', $request->all());

        $data = $request->all();
        $id = $data['id'] ?? null;
        $stateid = $data['stateid'] ?? null;
        $status = $data['status'] ?? null;
        $state = $data['state'] ?? null;

        if ($id) {
            $report = Report::where('message_id', $id)->first();
            if ($report) {
                $report->update([
                    'status' => $status,
                    'state' => $state,
                    'stateid' => $stateid,
                ]);
            }
        }
        return response()->json(['success' => true]);
    }

    public function report()
    {
        $reports = \App\Models\Report::orderBy('created_at', 'desc')->get();
        return view('whatsapp.report', compact('reports'));
    }
}