<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Customer</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #333; padding: 6px; }
        th { background: #f1f1f1; }
    </style>
</head>
<body>

<h3>Laporan Data Customer</h3>

{{-- @if($start || $end)
    <p>
        Periode:
        {{ $start ?? '-' }} s/d {{ $end ?? '-' }}
    </p>
@endif --}}

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Customer</th>
            <th>No HP</th>
            <th>No KTP</th>
            <th>Kewarganegaraan</th>
            <th>Tgl Dibuat</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($records as $i => $row)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $row->user?->name }}</td>
                <td>{{ $row->no_hp }}</td>
                <td>{{ $row->no_ktp }}</td>
                <td>{{ ucfirst($row->kewarganegaraan) }}</td>
                <td>{{ $row->created_at->format('d-m-Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
