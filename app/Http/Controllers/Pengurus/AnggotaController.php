<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\Divisi;
use App\Models\Pendaftaran;
use App\Rules\JabatanRule;
use App\Services\FonnteService; // Import FonnteService
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Import Log
use Illuminate\Support\Facades\Storage;
use PDF;

class AnggotaController extends Controller
{
    public function calonAnggota()
    {
        $candidates = Pendaftaran::with('divisi')->whereNotIn('status', ['diterima', 'ditolak', 'Anggota Aktif', 'Gagal Wawancara', 'Lulus Wawancara'])->get();

        return view('pengurus.calon-anggota.index', compact('candidates'));
    }

    public function exportCsvTahap1()
    {
        $candidates = Pendaftaran::whereIn('status', ['diterima', 'ditolak', 'Gagal Wawancara', 'Lulus Wawancara'])->get();
        $fileName = 'calon-anggota-tahap-1.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Nama Lengkap', 'NIM', 'Nomor HP', 'Divisi Tujuan', 'Status');

        $callback = function() use($candidates, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($candidates as $candidate) {
                $row['Nama Lengkap']  = $candidate->name;
                $row['NIM']    = $candidate->nim;
                $row['Nomor HP']    = $candidate->hp;
                $row['Divisi Tujuan']  = $candidate->divisi->nama_divisi;
                $row['Status']  = $candidate->status;

                fputcsv($file, array($row['Nama Lengkap'], $row['NIM'], $row['Nomor HP'], $row['Divisi Tujuan'], $row['Status']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdfTahap1()
    {
        $candidates = Pendaftaran::whereIn('status', ['diterima', 'ditolak', 'Gagal Wawancara', 'Lulus Wawancara'])->get();
        $pdf = PDF::loadView('pengurus.calon-anggota-tahap-1.pdf', compact('candidates'));
        return $pdf->download('laporan-calon-anggota-tahap-1.pdf');
    }


    public function calonAnggotaTahap1(Request $request)
    {
        $query = Pendaftaran::query()->with('divisi');

        $query->whereIn('status', ['diterima', 'ditolak', 'Gagal Wawancara', 'Lulus Wawancara']);

        // Search by name or NIM
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        // Filter by division
        if ($request->filled('divisi_id')) {
            $query->where('divisi_id', $request->divisi_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $candidates = $query->paginate(10)->withQueryString();

        $divisis = Divisi::all();
        $statuses = [
            'diterima' => 'Lolos ke Tahap 2',
            'ditolak' => 'Ditolak (Administrasi)',
            'Gagal Wawancara' => 'Gagal Wawancara',
            'Lulus Wawancara' => 'Lulus Wawancara (Anggota)',
        ];

        return view('pengurus.calon-anggota-tahap-1.index', compact('candidates', 'divisis', 'statuses'));
    }

    public function calonAnggotaTahap2()
    {
        $candidates = Pendaftaran::where('status', 'diterima')->get();

        return view('pengurus.calon-anggota-tahap-2.index', compact('candidates'));
    }

    public function approveCandidate(Pendaftaran $pendaftaran, FonnteService $fonnte)
    {
        $pendaftaran->status = 'diterima';
        $pendaftaran->save();

        // Kirim notifikasi WhatsApp
        $template = Storage::disk('local')->get('wa_template_diterima.txt');
        $message = str_replace(
            ['{nama}', '{nim}', '{divisi}'],
            [$pendaftaran->nama, $pendaftaran->nim, $pendaftaran->divisi->nama_divisi],
            $template
        );
        $result = $fonnte->send($pendaftaran->hp, $message);

        if ($result['ok']) {
            return redirect()->back()->with('success', 'Calon diterima & notifikasi WhatsApp terkirim.');
        } else {
            Log::error('Fonnte Gagal Terkirim (Approve Pengurus)', ['response' => $result]);

            return redirect()->back()->with('warning', 'Calon diterima, tapi notifikasi WhatsApp gagal dikirim.');
        }
    }

    public function rejectCandidate(Pendaftaran $pendaftaran, FonnteService $fonnte)
    {
        $pendaftaran->status = 'ditolak';
        $pendaftaran->save();

        // Kirim notifikasi WhatsApp
        $template = Storage::disk('local')->get('wa_template_ditolak.txt');
        $message = str_replace(
            ['{nama}', '{nim}', '{divisi}'],
            [$pendaftaran->nama, $pendaftaran->nim, $pendaftaran->divisi->nama_divisi],
            $template
        );
        $result = $fonnte->send($pendaftaran->hp, $message);

        if ($result['ok']) {
            return redirect()->back()->with('success', 'Calon ditolak & notifikasi WhatsApp terkirim.');
        } else {
            Log::error('Fonnte Gagal Terkirim (Reject Pengurus)', ['response' => $result]);

            return redirect()->back()->with('warning', 'Calon ditolak, tapi notifikasi WhatsApp gagal dikirim.');
        }
    }

    public function approveCandidateStage2(Pendaftaran $pendaftaran, FonnteService $fonnte)
    {
        $pendaftaran->status = 'Lulus Wawancara'; // Consistent with admin logic
        $pendaftaran->save();

        // Kirim notifikasi WhatsApp
        $template = Storage::disk('local')->get('wa_template_diterima_tahap2.txt');
        $message = str_replace(
            ['{nama}', '{nim}', '{divisi}'],
            [$pendaftaran->nama, $pendaftaran->nim, $pendaftaran->divisi->nama_divisi],
            $template
        );
        $result = $fonnte->send($pendaftaran->hp, $message);

        if ($result['ok']) {
            return redirect()->route('pengurus.calon-anggota-tahap-2.index')->with('success', 'Calon diterima di tahap 2 & notifikasi WhatsApp terkirim.');
        } else {
            Log::error('Fonnte Gagal Terkirim (Approve Tahap 2 Pengurus)', ['response' => $result]);

            return redirect()->route('pengurus.calon-anggota-tahap-2.index')->with('warning', 'Calon diterima di tahap 2, tapi notifikasi WhatsApp gagal dikirim.');
        }
    }

    public function rejectCandidateStage2(Pendaftaran $pendaftaran, FonnteService $fonnte)
    {
        $pendaftaran->status = 'Gagal Wawancara'; // Consistent with admin logic
        $pendaftaran->save();

        // Kirim notifikasi WhatsApp
        $template = Storage::disk('local')->get('wa_template_ditolak_tahap2.txt');
        $message = str_replace(
            ['{nama}', '{nim}', '{divisi}'],
            [$pendaftaran->nama, $pendaftaran->nim, $pendaftaran->divisi->nama_divisi],
            $template
        );
        $result = $fonnte->send($pendaftaran->hp, $message);

        if ($result['ok']) {
            return redirect()->route('pengurus.calon-anggota-tahap-2.index')->with('success', 'Calon ditolak di tahap 2 & notifikasi WhatsApp terkirim.');
        } else {
            Log::error('Fonnte Gagal Terkirim (Reject Tahap 2 Pengurus)', ['response' => $result]);

            return redirect()->route('pengurus.calon-anggota-tahap-2.index')->with('warning', 'Calon ditolak di tahap 2, tapi notifikasi WhatsApp gagal dikirim.');
        }
    }

    public function passInterview(Pendaftaran $pendaftaran, FonnteService $fonnte)
    {
        $pendaftaran->status = 'Lulus Wawancara'; // Consistent with admin logic
        $pendaftaran->save();

        // Kirim notifikasi WhatsApp
        $template = Storage::disk('local')->get('wa_template_lolos_wawancara.txt');
        $message = str_replace(
            ['{nama}', '{nim}', '{divisi}'],
            [$pendaftaran->nama, $pendaftaran->nim, $pendaftaran->divisi->nama_divisi],
            $template
        );
        $result = $fonnte->send($pendaftaran->hp, $message);

        if ($result['ok']) {
            return redirect()->route('pengurus.calon-anggota-tahap-2.index')->with('success', 'Kandidat lulus wawancara & notifikasi WhatsApp terkirim.');
        } else {
            Log::error('Fonnte Gagal Terkirim (Lulus Wawancara Pengurus)', ['response' => $result]);

            return redirect()->route('pengurus.calon-anggota-tahap-2.index')->with('warning', 'Kandidat lulus wawancara, tapi notifikasi WhatsApp gagal dikirim.');
        }
    }

    public function failInterview(Pendaftaran $pendaftaran, FonnteService $fonnte)
    {
        $pendaftaran->status = 'Gagal Wawancara'; // Consistent with admin logic
        $pendaftaran->save();

        // Kirim notifikasi WhatsApp
        $template = Storage::disk('local')->get('wa_template_gagal_wawancara.txt');
        $message = str_replace(
            ['{nama}', '{nim}', '{divisi}'],
            [$pendaftaran->nama, $pendaftaran->nim, $pendaftaran->divisi->nama_divisi],
            $template
        );
        $result = $fonnte->send($pendaftaran->hp, $message);

        if ($result['ok']) {
            return redirect()->route('pengurus.calon-anggota-tahap-2.index')->with('success', 'Kandidat tidak lulus wawancara & notifikasi WhatsApp terkirim.');
        } else {
            Log::error('Fonnte Gagal Terkirim (Gagal Wawancara Pengurus)', ['response' => $result]);

            return redirect()->route('pengurus.calon-anggota-tahap-2.index')->with('warning', 'Kandidat tidak lulus wawancara, tapi notifikasi WhatsApp gagal dikirim.');
        }
    }

    public function kelolaAnggotaHimati()
    {
        $members = Pendaftaran::where('status', 'Lulus Wawancara')->latest()->paginate(10);
        $semua_divisi = Divisi::all();

        return view('pengurus.kelola-anggota-himati.index', compact('members', 'semua_divisi'));
    }

    public function anggotaPerDivisi(Divisi $divisi)
    {
        $members = Pendaftaran::where('status', 'Lulus Wawancara')
            ->where('divisi_id', $divisi->id)
            ->latest()
            ->paginate(10);
        $semua_divisi = Divisi::all();

        return view('pengurus.kelola-anggota-himati.index', compact('members', 'divisi', 'semua_divisi'));
    }

    public function update(Request $request, Pendaftaran $anggotum)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:255',
            'hp' => 'required|string|max:255',
            'divisi_id' => 'required|exists:divisis,id',
            'jabatan' => ['required', 'string', 'in:Ketua Koordinator,Wakil Koordinator,Anggota Divisi', new JabatanRule($request->divisi_id, $request->jabatan, $anggotum->id)],
        ]);

        $anggotum->update($request->only(['name', 'nim', 'hp', 'divisi_id', 'jabatan']));

        return redirect()->route('pengurus.kelola-anggota-himati.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Pendaftaran $anggotum)
    {
        $anggotum->delete();

        return redirect()->route('pengurus.calon-anggota.index')->with('success', 'Calon anggota berhasil dihapus.');
    }
}