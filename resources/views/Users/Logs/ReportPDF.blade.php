<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Laporan Aktiviti - {{ $periodLabel }}</title>
    <style>
        @page {
            margin: 15mm 20mm;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            font-size: 10pt;
            color: #000000;
            line-height: 1.5;
        }

        /* Official Letterhead Header */
        .letterhead {
            text-align: center;
            border-bottom: 3px double #000000;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .letterhead-logo {
            margin-bottom: 8px;
        }

        .letterhead-title {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 3px;
        }

        .letterhead-dept {
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 2px;
        }

        .letterhead-subtitle {
            font-size: 8pt;
            color: #333;
        }

        /* Document Reference */
        .doc-reference {
            text-align: right;
            font-size: 8pt;
            color: #333;
            margin-bottom: 15px;
        }

        /* Document Title */
        .doc-title-section {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px 0;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
        }

        .doc-title {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .doc-subtitle {
            font-size: 9pt;
            margin-top: 3px;
            font-style: italic;
        }

        /* Official Information Box */
        .info-box {
            border: 2px solid #000000;
            padding: 12px 15px;
            margin-bottom: 20px;
            background-color: #ffffff;
        }

        .info-box-title {
            font-size: 9pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 10px;
            border-bottom: 1px solid #000;
            padding-bottom: 4px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 4px 8px;
            font-size: 9pt;
            vertical-align: top;
        }

        .info-label {
            font-weight: bold;
            width: 40%;
            text-transform: uppercase;
            font-size: 8pt;
        }

        .info-value {
            width: 60%;
        }

        .info-colon {
            width: 10px;
            font-weight: bold;
        }

        /* Summary Statistics Box */
        .summary-box {
            border: 1px solid #000000;
            padding: 10px;
            margin-bottom: 20px;
            background-color: #f5f5f5;
        }

        .summary-title {
            font-size: 9pt;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #000;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary-cell {
            width: 50%;
            text-align: center;
            padding: 12px 10px;
            border: 1px solid #666;
            background-color: #ffffff;
        }

        .summary-label {
            font-size: 8pt;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .summary-value {
            font-size: 22pt;
            font-weight: bold;
            margin: 5px 0;
        }

        .summary-unit {
            font-size: 7pt;
            color: #555;
        }

        /* Section Header */
        .section-header {
            font-size: 10pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 20px 0 10px 0;
            padding: 5px 10px;
            background-color: #000000;
            color: #ffffff;
            text-align: center;
        }

        /* Official Data Table */
        table.official-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 2px solid #000000;
        }

        table.official-table thead {
            background-color: #000000;
            color: #ffffff;
        }

        table.official-table th {
            padding: 6px 5px;
            text-align: center;
            font-size: 8pt;
            font-weight: bold;
            text-transform: uppercase;
            border: 1px solid #000000;
        }

        table.official-table td {
            padding: 6px 5px;
            border: 1px solid #333333;
            font-size: 9pt;
            vertical-align: top;
        }

        table.official-table tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        table.official-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table.official-table tfoot {
            background-color: #e8e8e8;
            font-weight: bold;
            border-top: 2px solid #000000;
        }

        table.official-table tfoot td {
            padding: 8px 5px;
            border: 1px solid #000000;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
        .text-bold { font-weight: bold; }

        /* Activity Content */
        .activity-content {
            line-height: 1.4;
        }

        .activity-type {
            font-weight: bold;
            margin-bottom: 2px;
        }

        .activity-remarks {
            font-size: 8pt;
            color: #333;
            font-style: italic;
            margin-top: 2px;
        }

        /* Location Info */
        .location-info {
            font-size: 8pt;
            color: #555;
            margin-top: 2px;
        }

        /* No Data Message */
        .no-data-box {
            text-align: center;
            padding: 30px;
            border: 2px dashed #666;
            background-color: #f9f9f9;
            color: #666;
            font-style: italic;
        }

        /* Official Notes Section */
        .notes-section {
            margin-top: 20px;
            padding: 10px 12px;
            border: 1px solid #000000;
            background-color: #f9f9f9;
        }

        .notes-header {
            font-weight: bold;
            font-size: 9pt;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .notes-content {
            font-size: 8pt;
            line-height: 1.6;
        }

        .notes-content ul {
            margin-left: 20px;
        }

        .notes-content li {
            margin-bottom: 3px;
        }

        /* Official Signature Section */
        .signature-section {
            margin-top: 35px;
            page-break-inside: avoid;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }

        .signature-cell {
            width: 50%;
            padding: 10px;
            vertical-align: top;
        }

        .signature-box {
            text-align: center;
            padding: 10px;
        }

        .signature-header {
            font-size: 8pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 50px;
        }

        .signature-line-container {
            margin-top: 50px;
        }

        .signature-line {
            border-top: 1px solid #000000;
            display: inline-block;
            width: 200px;
            margin: 0 auto;
        }

        .signature-name {
            font-weight: bold;
            font-size: 9pt;
            margin-top: 5px;
            text-transform: uppercase;
        }

        .signature-title {
            font-size: 8pt;
            margin-top: 2px;
        }

        .signature-date {
            font-size: 7pt;
            margin-top: 3px;
        }

        /* Official Footer */
        .official-footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #000000;
            font-size: 7pt;
            text-align: center;
            color: #333;
        }

        /* Classification Marking */
        .classification {
            text-align: center;
            font-size: 8pt;
            font-weight: bold;
            margin-bottom: 10px;
            padding: 3px;
            border: 1px solid #000000;
            background-color: #f0f0f0;
        }

        /* Page Number */
        .page-number {
            position: fixed;
            bottom: 10mm;
            right: 20mm;
            font-size: 7pt;
        }

        /* Watermark - Subtle for Official Docs */
        .watermark {
            position: fixed;
            top: 350px;
            left: 100px;
            font-size: 70pt;
            color: rgba(0, 0, 0, 0.03);
            font-weight: bold;
            transform: rotate(-45deg);
            z-index: -1;
        }
    </style>
</head>
<body>
    {{-- Watermark --}}
    <div class="watermark">RASMI</div>

    {{-- Classification Marking --}}
    <div class="classification">
        TERHAD / FOR OFFICIAL USE ONLY
    </div>

    {{-- Official Letterhead --}}
    <div class="letterhead">
        <div class="letterhead-title">IBU PEJABAT POLIS DAERAH PEKAN</div>
        <div class="letterhead-dept">SISTEM PELAPORAN ELEKTRONIK EP45</div>
        <div class="letterhead-subtitle">Bahagian Pengurusan Maklumat dan Komunikasi</div>
    </div>

    {{-- Document Reference --}}
    <div class="doc-reference">
        Rujukan: PDRM/EP5/{{ strtoupper(substr(md5($user->id . $periodLabel), 0, 10)) }}<br>
        Tarikh: {{ $generatedDate }}
    </div>

    {{-- Document Title --}}
    <div class="doc-title-section">
        <div class="doc-title">LAPORAN AKTIVITI ANGGOTA</div>
        <div class="doc-subtitle">{{ $periodLabel }}</div>
    </div>

    {{-- Official Information Box --}}
    <div class="info-box">
        <div class="info-box-title">Maklumat Anggota</div>
        <table class="info-table">
            <tr>
                <td class="info-label">Nama Penuh</td>
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
                <td class="info-value">{{ $user->no_badan }}</td>
            </tr>
            @endif
            @if(isset($user->pangkat))
            <tr>
                <td class="info-label">Pangkat</td>
                <td class="info-colon">:</td>
                <td class="info-value">{{ strtoupper($user->pangkat->pangkat_name ?? 'TIADA REKOD') }}</td>
            </tr>
            @endif
            @if(isset($user->no_telefon))
            <tr>
                <td class="info-label">No. Telefon</td>
                <td class="info-colon">:</td>
                <td class="info-value">{{ $user->no_telefon }}</td>
            </tr>
            @endif
            <tr>
                <td class="info-label">Tempoh Laporan</td>
                <td class="info-colon">:</td>
                <td class="info-value">{{ strtoupper($periodLabel) }}</td>
            </tr>
            <tr>
                <td class="info-label">Jenis Laporan</td>
                <td class="info-colon">:</td>
                <td class="info-value">{{ $reportType === 'monthly' ? 'BULANAN' : 'MINGGUAN' }}</td>
            </tr>
        </table>
    </div>

    {{-- Summary Statistics --}}
    <div class="summary-box">
        <div class="summary-title">Ringkasan Prestasi</div>
        <table class="summary-table">
            <tr>
                <td class="summary-cell">
                    <div class="summary-label">Jumlah Aktiviti</div>
                    <div class="summary-value">{{ $totalLogs }}</div>
                    <div class="summary-unit">Tugasan Disahkan</div>
                </td>
                <td class="summary-cell">
                    <div class="summary-label">Jumlah Masa</div>
                    <div class="summary-value">{{ number_format($totalHours, 1) }}</div>
                    <div class="summary-unit">Jam Bertugas</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- Section Header --}}
    <div class="section-header">
        Butiran Terperinci Aktiviti
    </div>

    {{-- Activity Details Table --}}
    @if($logs->count() > 0)
        <table class="official-table">
            <thead>
                <tr>
                    <th style="width: 4%;">BIL</th>
                    <th style="width: 12%;">TARIKH</th>
                    <th style="width: 8%;">MASA<br>MULA</th>
                    <th style="width: 8%;">MASA<br>TAMAT</th>
                    <th style="width: 8%;">TEMPOH<br>(JAM)</th>
                    <th style="width: 20%;">LOKASI</th>
                    <th style="width: 40%;">BUTIRAN AKTIVITI</th>
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
                                <strong>{{ $log->balai ?? '' }}</strong>
                                @if(!empty($log->area))
                                    <div class="location-info">Kawasan: {{ $log->area }}</div>
                                @endif
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <div class="activity-content">
                                <div class="activity-type">{{ strtoupper($log->type ?? 'TIADA MAKLUMAT') }}</div>
                                @if(!empty($log->remarks))
                                    <div class="activity-remarks">Catatan: {{ $log->remarks }}</div>
                                @endif
                                @if($log->is_off_duty)
                                    <div class="activity-remarks" style="color: #d32f2f; font-weight: bold;">⚠ LUAR WAKTU BERTUGAS</div>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right text-bold">JUMLAH KESELURUHAN:</td>
                    <td class="text-center text-bold" style="font-size: 11pt;">{{ number_format($totalHours, 2) }}</td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        </table>
    @else
        <div class="no-data-box">
            TIADA REKOD AKTIVITI YANG DISAHKAN BAGI TEMPOH INI
        </div>
    @endif

    {{-- Official Notes --}}
    <div class="notes-section">
        <div class="notes-header">Nota Penting:</div>
        <div class="notes-content">
            <ul>
                <li>Laporan ini dijana secara automatik daripada Sistem Pelaporan Elektronik PDRM EP5.</li>
                <li>Semua rekod aktiviti telah disemak dan disahkan oleh pegawai penyelia yang bertanggungjawab.</li>
                <li>Dokumen ini adalah salinan digital rasmi dan mempunyai kesahihan yang sama seperti dokumen fizikal.</li>
                <li>Sebarang pertanyaan atau penjelasan lanjut berkenaan laporan ini hendaklah dirujuk kepada Ketua Unit/Bahagian.</li>
                <li>Laporan ini adalah TERHAD dan hanya untuk kegunaan rasmi PDRM sahaja.</li>
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
                            <div class="signature-title">{{ strtoupper($user->pangkat->pangkat_name ?? 'ANGGOTA') }}</div>
                            <div class="signature-date">Tarikh: _______________</div>
                        </div>
                    </div>
                </td>
                <td class="signature-cell">
                    <div class="signature-box">
                        <div class="signature-header">Disahkan Oleh:</div>
                        <div class="signature-line-container">
                            <div class="signature-line"></div>
                            <div class="signature-name">_________________________</div>
                            <div class="signature-title">PEGAWAI PENYELIA / KETUA UNIT</div>
                            <div class="signature-date">Tarikh: _______________</div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- Official Footer --}}
    <div class="official-footer">
        POLIS DIRAJA MALAYSIA | SISTEM PELAPORAN ELEKTRONIK EP5<br>
        Dokumen ini adalah TERHAD dan tertakluk kepada Akta Rahsia Rasmi 1972
    </div>

</body>
</html>