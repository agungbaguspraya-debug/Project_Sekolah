<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Absensi Kelas {{ $selectedKelas }} - {{ $namaBulan }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #111;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        .header h2 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }
        .header p {
            margin: 2px 0 0 0;
            font-size: 10px;
            color: #444;
        }
        .title {
            text-align: center;
            margin-bottom: 15px;
        }
        .title h3 {
            margin: 0;
            font-size: 14px;
            text-transform: uppercase;
        }
        .title p {
            margin: 3px 0 0 0;
            font-size: 11px;
            font-weight: bold;
            color: #333;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #444;
            padding: 6px 8px;
            text-align: left;
        }
        table.data-table th {
            background-color: #e2e8f0;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            font-size: 10px;
        }
        .text-center { text-align: center !important; }
        .text-bold { font-weight: bold; }
        .badge-hadir { color: #15803d; font-weight: bold; }
        .badge-izin { color: #b45309; font-weight: bold; }
        .badge-sakit { color: #0369a1; font-weight: bold; }
        .badge-alpa { color: #b91c1c; font-weight: bold; }
        .footer-sig {
            margin-top: 30px;
            width: 100%;
        }
        .footer-sig table {
            width: 100%;
            border: none;
        }
        .footer-sig td {
            border: none;
            text-align: center;
            vertical-align: top;
        }
    </style>
</head>
<body>

    <!-- School Kop Header -->
    <div class="header">
        <h2>{{ $profilSekolah->nama_sekolah ?? 'SEKOLAH MENENGAH KEJURUAN' }}</h2>
        <p>{{ $profilSekolah->alamat ?? 'Jl. Pendidikan No. 1, Kota' }} | Telp: {{ $profilSekolah->telepon ?? '-' }} | Email: {{ $profilSekolah->email ?? '-' }}</p>
    </div>

    <!-- Title -->
    <div class="title">
        <h3>LAPORAN REKAPITULASI PRESENSI & ABSENSI SISWA</h3>
        <p>KELAS: {{ $selectedKelas }} | PERIODE: {{ strtoupper($namaBulan) }}</p>
    </div>

    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 25px;">NO</th>
                <th style="width: 70px;">NIS</th>
                <th style="width: 160px;">NAMA SISWA</th>
                <th style="width: 40px;">HADIR</th>
                <th style="width: 40px;">IZIN</th>
                <th style="width: 40px;">SAKIT</th>
                <th style="width: 40px;">ALPA</th>
                <th style="width: 50px;">% HADIR</th>
                <th>RINCIAN ALASAN IZIN / SAKIT / ALPA</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswas as $idx => $s)
                @php
                    $hadir = $s->absensi->where('status', 'Hadir')->count();
                    $izin = $s->absensi->where('status', 'Izin')->count();
                    $sakit = $s->absensi->where('status', 'Sakit')->count();
                    $alpa = $s->absensi->where('status', 'Alpa')->count();
                    $totalTercatat = $s->absensi->count();
                    $persen = $totalTercatat > 0 ? number_format(($hadir / $totalTercatat) * 100, 0) . '%' : '100%';
                    $nonHadir = $s->absensi->whereIn('status', ['Izin', 'Sakit', 'Alpa']);
                @endphp
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td class="text-center">{{ $s->nis }}</td>
                    <td class="text-bold">{{ $s->nama }}</td>
                    <td class="text-center badge-hadir">{{ $hadir }}</td>
                    <td class="text-center badge-izin">{{ $izin }}</td>
                    <td class="text-center badge-sakit">{{ $sakit }}</td>
                    <td class="text-center badge-alpa">{{ $alpa }}</td>
                    <td class="text-center text-bold">{{ $persen }}</td>
                    <td>
                        @if($nonHadir->count() > 0)
                            @foreach($nonHadir as $ab)
                                [{{ $ab->status }} {{ date('d/m', strtotime($ab->tanggal)) }}: {{ $ab->alasan ?? '-' }}] 
                            @endforeach
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Belum ada data absensi tercatat.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Signature Block -->
    <div class="footer-sig">
        <table>
            <tr>
                <td style="width: 50%;">
                    <br>
                    Mengetahui,<br>
                    <strong>Kepala Sekolah</strong>
                    <br><br><br><br><br>
                    <u>{{ $profilSekolah->nama_kepala_sekolah ?? 'Kepala Sekolah' }}</u><br>
                    NIP. {{ $profilSekolah->nip_kepala_sekolah ?? '-' }}
                </td>
                <td style="width: 50%;">
                    Dicetak Pada: {{ date('d F Y') }}<br>
                    <strong>Guru / Wali Kelas {{ $selectedKelas }}</strong>
                    <br><br><br><br><br>
                    <u>( .................................................. )</u><br>
                    NIP. ...............................................
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
