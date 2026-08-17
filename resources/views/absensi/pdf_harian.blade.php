<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Presensi Harian Siswa - {{ $formattedDate }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #111;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 6px;
            margin-bottom: 12px;
        }
        .header h2 {
            margin: 0;
            font-size: 15px;
            text-transform: uppercase;
        }
        .header p {
            margin: 2px 0 0 0;
            font-size: 10px;
            color: #444;
        }
        .title {
            text-align: center;
            margin-bottom: 12px;
        }
        .title h3 {
            margin: 0;
            font-size: 13px;
            text-transform: uppercase;
        }
        .title p {
            margin: 2px 0 0 0;
            font-size: 11px;
            font-weight: bold;
            color: #333;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #444;
            padding: 5px 6px;
            text-align: left;
        }
        table.data-table th {
            background-color: #e2e8f0;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            font-size: 9px;
        }
        .text-center { text-align: center !important; }
        .text-bold { font-weight: bold; }
        .badge-hadir { color: #15803d; font-weight: bold; }
        .badge-izin { color: #b45309; font-weight: bold; }
        .badge-sakit { color: #0369a1; font-weight: bold; }
        .badge-alpa { color: #b91c1c; font-weight: bold; }
        .footer-sig {
            margin-top: 25px;
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
        <p>{{ $profilSekolah->alamat ?? 'Jl. Pendidikan No. 1' }} | Telp: {{ $profilSekolah->telepon ?? '-' }} | Email: {{ $profilSekolah->email ?? '-' }}</p>
    </div>

    <!-- Title -->
    <div class="title">
        <h3>LAPORAN PRESENSI HARIAN SISWA SEKOLAH</h3>
        <p>HARI / TANGGAL: {{ strtoupper($formattedDate) }} {{ $selectedKelas ? '| KELAS: '.$selectedKelas : '| SELURUH KELAS' }}</p>
    </div>

    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 25px;">NO</th>
                <th style="width: 60px;">NIS</th>
                <th style="width: 170px;">NAMA SISWA</th>
                <th style="width: 80px;">KELAS</th>
                <th style="width: 80px;">STATUS</th>
                <th>ALASAN / KETERANGAN IZIN / SAKIT / ALPA</th>
                <th style="width: 120px;">PENCATAT ABSEN</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswas as $idx => $s)
                @php
                    $rec = $absensiRecords->get($s->id);
                    $status = $rec ? $rec->status : 'Belum Diabsen';
                    $alasan = $rec ? $rec->alasan : '-';
                    $guruNama = $rec && $rec->guru ? $rec->guru->nama : ($rec ? 'Admin/Guru' : '-');
                @endphp
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td class="text-center">{{ $s->nis }}</td>
                    <td class="text-bold">{{ $s->nama }}</td>
                    <td class="text-center">{{ $s->kelas }}</td>
                    <td class="text-center text-bold 
                        {{ $status === 'Hadir' ? 'badge-hadir' : ($status === 'Izin' ? 'badge-izin' : ($status === 'Sakit' ? 'badge-sakit' : ($status === 'Alpa' ? 'badge-alpa' : ''))) }}">
                        {{ $status }}
                    </td>
                    <td>{{ $alasan }}</td>
                    <td class="text-center">{{ $guruNama }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data presensi tercatat.</td>
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
                    <br><br><br><br>
                    <u>{{ $profilSekolah->nama_kepala_sekolah ?? 'Kepala Sekolah' }}</u><br>
                    NIP. {{ $profilSekolah->nip_kepala_sekolah ?? '-' }}
                </td>
                <td style="width: 50%;">
                    Dicetak Pada: {{ date('d F Y') }}<br>
                    <strong>Petugas Monitoring Absensi</strong>
                    <br><br><br><br>
                    <u>( .................................................. )</u><br>
                    NIP. ...............................................
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
