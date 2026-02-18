<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Laporan Aktiviti - {{ $periodLabel }}</title>
    <style>
        @page {
            /* Changed from 20mm to 35mm to add more padding on the left and right */
            margin: 15mm 35mm; 
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10pt;
            color: #111111;
            line-height: 1.5;
        }

        /* Classification Marking */
        .classification {
            text-align: center;
            font-size: 9pt;
            font-weight: bold;
            margin-bottom: 15px;
            letter-spacing: 1px;
            color: #cc0000;
        }

        /* Official Letterhead */
        .letterhead {
            text-align: center;
            border-bottom: 2px solid #111111;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .logo-container {
            margin-bottom: 10px;
        }

        .logo {
            width: 80px;
            height: auto;
        }

        .letterhead-title {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .letterhead-dept {
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .letterhead-subtitle {
            font-size: 9pt;
            color: #444444;
        }

        /* Document Reference */
        .doc-reference {
            text-align: right;
            font-size: 9pt;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        /* Document Title */
        .doc-title-section {
            text-align: center;
            margin-bottom: 25px;
        }

        .doc-title {
            font-size: 12pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .doc-subtitle {
            font-size: 10pt;
            font-weight: bold;
        }

        /* Official Information Box */
        .info-box {
            border: 1px solid #111111;
            padding: 15px;
            margin-bottom: 20px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 4px 8px;
            font-size: 10pt;
            vertical-align: top;
        }

        .info-label {
            font-weight: bold;
            width: 30%;
            text-transform: uppercase;
            font-size: 9pt;
        }

        .info-value {
            width: 68%;
        }

        .info-colon {
            width: 2%;
            font-weight: bold;
        }

        /* Summary Statistics Box */
        .summary-box {
            margin-bottom: 25px;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #111111;
        }

        .summary-cell {
            width: 50%;
            text-align: center;
            padding: 10px;
            border: 1px solid #111111;
        }

        .summary-label {
            font-size: 9pt;
            text-transform: uppercase;
            font-weight: bold;
            background-color: #f4f4f5;
            padding: 4px;
            border-bottom: 1px solid #111111;
        }

        .summary-value {
            font-size: 16pt;
            font-weight: bold;
            margin-top: 8px;
        }

        .summary-unit {
            font-size: 8pt;
            color: #555555;
            margin-top: 2px;
        }

        /* Section Header */
        .section-header {
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 25px 0 10px 0;
            border-bottom: 1px solid #111111;
            padding-bottom: 5px;
        }

        /* Official Data Table */
        table.official-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            border: 1px solid #111111;
        }

        table.official-table thead {
            background-color: #e5e7eb; /* Light Grey Header */
        }

        table.official-table th {
            padding: 8px 5px;
            text-align: center;
            font-size: 9pt;
            font-weight: bold;
            text-transform: uppercase;
            border: 1px solid #111111;
            color: #111111;
        }

        table.official-table td {
            padding: 8px 5px;
            border: 1px solid #111111;
            font-size: 9pt;
            vertical-align: top;
        }

        table.official-table tbody tr:nth-child(even) {
            background-color: #fafafa;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .text-bold { font-weight: bold; }

        /* Activity Content */
        .activity-type {
            font-weight: bold;
            margin-bottom: 3px;
        }

        .activity-remarks {
            font-size: 8pt;
            color: #333333;
            margin-top: 3px;
        }

        .location-info {
            font-size: 8pt;
            color: #444444;
            margin-top: 3px;
        }

        /* No Data Message */
        .no-data-box {
            text-align: center;
            padding: 20px;
            border: 1px solid #111111;
            font-style: italic;
            font-size: 10pt;
        }

        /* Official Notes Section */
        .notes-section {
            margin-top: 30px;
            padding: 15px;
            border: 1px solid #111111;
            background-color: #f9fafb;
        }

        .notes-header {
            font-weight: bold;
            font-size: 10pt;
            text-decoration: underline;
            margin-bottom: 10px;
        }

        .notes-content {
            font-size: 9pt;
            line-height: 1.6;
        }

        .notes-content ul {
            margin-left: 25px;
        }

        .notes-content li {
            margin-bottom: 4px;
        }

        /* Official Signature Section */
        .signature-section {
            margin-top: 40px;
            page-break-inside: avoid;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }

        .signature-cell {
            width: 50%;
            vertical-align: top;
        }

        .signature-box {
            padding: 10px;
        }

        .signature-header {
            font-size: 10pt;
            font-weight: bold;
            margin-bottom: 60px;
        }

        .signature-line-container {
            margin-top: 60px;
        }

        .signature-line {
            border-top: 1px dashed #111111;
            width: 80%;
            margin-bottom: 5px;
        }

        .signature-name {
            font-weight: bold;
            font-size: 10pt;
            text-transform: uppercase;
        }

        .signature-title {
            font-size: 9pt;
            margin-top: 2px;
        }

        .signature-date {
            font-size: 9pt;
            margin-top: 5px;
        }

        /* Official Footer */
        .official-footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px solid #111111;
            font-size: 8pt;
            text-align: center;
            font-weight: bold;
        }

        /* Watermark */
        .watermark {
            position: fixed;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80pt;
            color: rgba(0, 0, 0, 0.04);
            font-weight: bold;
            z-index: -1;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    {{-- Watermark --}}
    <div class="watermark">SULIT & TERHAD</div>

    {{-- Classification Marking --}}
    <div class="classification">
        SULIT / TERHAD
    </div>

    {{-- Official Letterhead --}}
    <div class="letterhead">
        {{-- PDRM Logo using absolute storage path --}}
        <div class="logo-container">
            <img src="{{ storage_path('app/public/Logo/logo_polis.png') }}" class="logo" alt="PDRM Logo">
        </div>
        <div class="letterhead-title">IBU PEJABAT POLIS DAERAH PEKAN</div>
        <div class="letterhead-dept">SISTEM PELAPORAN ELEKTRONIK EP5</div>
        <div class="letterhead-subtitle">Bahagian Pengurusan Maklumat dan Komunikasi</div>
    </div>

    {{-- Document Reference --}}
    <div class="doc-reference">
        <strong>Rujukan:</strong> PDRM/EP5/{{ strtoupper(substr(md5($user->id . $periodLabel), 0, 10)) }}<br>
        <strong>Tarikh Cetakan:</strong> {{ $generatedDate }}
    </div>

    {{-- Document Title --}}
    <div class="doc-title-section">
        <div class="doc-title">LAPORAN AKTIVITI PENUGASAN</div>
        <div class="doc-subtitle">Bagi Tempoh: {{ $periodLabel }}</div>
    </div>

    {{-- Official Information Box --}}
    <div class="info-box">
        <table class="info-table">
            <tr>
                <td class="info-label">Nama Pegawai / Anggota</td>
                <td class="info-colon">:</td>
                <td class="info-value">{{ strtoupper($user->name) }}</td>
            </tr>
            <tr>
                <td class="info-label">No. Kad Pengenalan</td>
                <td class="info-colon">:</td>
                <td class="info-value">{{ $user->ic_number ?? $user->no_ic ?? 'TIADA REKOD' }}</td>
            </tr>
            @if(isset($user->no_badan))
            <tr>
                <td class="info-label">No. Badan</td>
                <td class="info-colon">:</td>
                <td class="info-value">{{ strtoupper($user->no_badan) }}</td>
            </tr>
            @endif
            @if(isset($user->pangkat))
            <tr>
                <td class="info-label">Pangkat / Gelaran</td>
                <td class="info-colon">:</td>
                <td class="info-value">{{ strtoupper($user->pangkat->pangkat_name ?? 'TIADA REKOD') }}</td>
            </tr>
            @endif
            @if(isset($user->no_telefon))
            <tr>
                <td class="info-label">No. Telefon Laluan</td>
                <td class="info-colon">:</td>
                <td class="info-value">{{ $user->no_telefon }}</td>
            </tr>
            @endif
            <tr>
                <td class="info-label">Kategori Laporan</td>
                <td class="info-colon">:</td>
                <td class="info-value">{{ $reportType === 'monthly' ? 'BULANAN' : 'MINGGUAN' }}</td>
            </tr>
        </table>
    </div>

    {{-- Summary Statistics --}}
    <div class="summary-box">
        <table class="summary-table">
            <tr>
                <td class="summary-cell">
                    <div class="summary-label">Jumlah Penugasan Disahkan</div>
                    <div class="summary-value">{{ $totalLogs }}</div>
                    <div class="summary-unit">Rekod Aktiviti</div>
                </td>
                <td class="summary-cell">
                    <div class="summary-label">Jumlah Tempoh Bertugas</div>
                    <div class="summary-value">{{ number_format($totalHours, 1) }}</div>
                    <div class="summary-unit">Jam Keseluruhan</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- Section Header --}}
    <div class="section-header">
        Lampiran A: Perincian Aktiviti Penugasan
    </div>

    {{-- Activity Details Table --}}
    @if($logs->count() > 0)
        <table class="official-table">
            <thead>
                <tr>
                    <th style="width: 5%;">BIL.</th>
                    <th style="width: 12%;">TARIKH</th>
                    <th style="width: 10%;">MASA MULA</th>
                    <th style="width: 10%;">MASA TAMAT</th>
                    <th style="width: 8%;">JAM</th>
                    <th style="width: 20%;">LOKASI / KAWASAN</th>
                    <th style="width: 35%;">BUTIRAN PENUGASAN</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $index => $log)
                    <tr>
                        <td class="text-center text-bold">{{ $index + 1 }}.</td>
                        <td class="text-center">
                            @if(!empty($log->date) || !empty($log->created_at))
                                {{ \Carbon\Carbon::parse($log->date ?? $log->created_at)->translatedFormat('d/m/Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-center">
                            @if(!empty($log->time))
                                {{ \Carbon\Carbon::parse($log->time)->format('H:i') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-center">
                            @if(!empty($log->end_time))
                                {{ \Carbon\Carbon::parse($log->end_time)->format('H:i') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-center text-bold">{{ number_format($log->calculated_hours ?? 0, 2) }}</td>
                        <td>
                            @if(!empty($log->balai) || !empty($log->area))
                                <strong>{{ strtoupper($log->balai ?? '') }}</strong>
                                @if(!empty($log->area))
                                    <div class="location-info">KAWASAN: {{ strtoupper($log->area) }}</div>
                                @endif
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <div class="activity-type">{{ strtoupper($log->type ?? 'TIADA MAKLUMAT') }}</div>
                            @if(!empty($log->remarks))
                                <div class="activity-remarks">CATATAN: {{ $log->remarks }}</div>
                            @endif
                            @if($log->is_off_duty)
                                <div class="activity-remarks" style="color: #cc0000; font-weight: bold; margin-top: 5px;">
                                    [ PERHATIAN: LUAR WAKTU BERTUGAS ]
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right text-bold">JUMLAH KESELURUHAN:</td>
                    <td class="text-center text-bold" style="font-size: 10pt;">{{ number_format($totalHours, 2) }}</td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>
    @else
        <div class="no-data-box">
            TIADA REKOD PENUGASAN YANG DISAHKAN BAGI TEMPOH INI.
        </div>
    @endif

    {{-- Official Notes --}}
    <div class="notes-section">
        <div class="notes-header">PERHATIAN:</div>
        <div class="notes-content">
            <ul>
                <li>Laporan ini dijana secara automatik daripada Sistem Pelaporan Elektronik PDRM EP5.</li>
                <li>Semua rekod penugasan telah disemak dan disahkan sah oleh Pegawai Penyelia yang bertanggungjawab.</li>
                <li>Dokumen ini adalah cetakan komputer berpusat dan mematuhi piawaian pengesahan digital. Tandatangan fizikal tidak diwajibkan melainkan diarahkan oleh Ketua Jabatan.</li>
                <li>Sebarang pemalsuan maklumat di dalam lampiran ini boleh dikenakan tindakan tatatertib di bawah Peraturan-Peraturan Pegawai Awam (Kelakuan dan Tatatertib) 1993.</li>
            </ul>
        </div>
    </div>

    {{-- Official Signature Section --}}
    <div class="signature-section">
        <table class="signature-table">
            <tr>
                <td class="signature-cell">
                    <div class="signature-box">
                        <div class="signature-header">Disediakan Oleh:</div>
                        <div class="signature-line-container">
                            <div class="signature-line"></div>
                            <div class="signature-name">{{ strtoupper($user->name) }}</div>
                            <div class="signature-title">{{ strtoupper($user->pangkat->pangkat_name ?? 'ANGGOTA PDRM') }}</div>
                            <div class="signature-title">No. Badan: {{ strtoupper($user->no_badan ?? '-') }}</div>
                            <div class="signature-date">Tarikh: ____________________</div>
                        </div>
                    </div>
                </td>
                <td class="signature-cell">
                    <div class="signature-box" style="margin-left: 20px;">
                        <div class="signature-header">Disemak & Disahkan Oleh:</div>
                        <div class="signature-line-container">
                            <div class="signature-line"></div>
                            <div class="signature-name">&nbsp;</div>
                            <div class="signature-title">PEGAWAI PENYELIA / KETUA BAHAGIAN</div>
                            <div class="signature-title">Cop Rasmi:</div>
                            <div class="signature-date">Tarikh: ____________________</div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- Official Footer --}}
    <div class="official-footer">
        POLIS DIRAJA MALAYSIA | SISTEM PELAPORAN ELEKTRONIK EP5<br>
        DOKUMEN INI ADALAH HAK MILIK KERAJAAN MALAYSIA
    </div>

</body>
</html>