<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 24px;
            color: #0f172a;
            font-size: 12px;
        }

        .header {
            margin-bottom: 16px;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 12px;
        }

        .title {
            font-size: 20px;
            margin: 0 0 4px 0;
        }

        .subtitle {
            margin: 2px 0;
            color: #334155;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 14px;
        }

        th, td {
            border: 1px solid #cbd5e1;
            padding: 8px;
            vertical-align: top;
            text-align: left;
        }

        th {
            background: #f1f5f9;
            font-weight: 700;
        }

        .empty {
            margin-top: 12px;
            padding: 10px 12px;
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">{{ $title }}</h1>
        <p class="subtitle"><strong>Módulo:</strong> {{ $moduleLabel }}</p>
        <p class="subtitle"><strong>Unidad:</strong> {{ $unitName }}</p>
        <p class="subtitle"><strong>Rango:</strong> {{ $rangeLabel }}</p>
        <p class="subtitle"><strong>Generado:</strong> {{ $generatedAt->format('d/m/Y H:i') }}</p>
    </div>

    @if($rows->isEmpty())
        <div class="empty">
            Sin registros en el rango seleccionado.
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Fecha de entrada</th>
                    <th>Unidad productiva</th>
                    <th>Tipo de residuo</th>
                    <th>Cantidad</th>
                    <th>Observaciones</th>
                    <th>Responsable</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rows as $row)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($row->entry_date)->format('d/m/Y H:i') }}</td>
                        <td>{{ $row->productive_unit_name }}</td>
                        <td>{{ $row->waste_type }}</td>
                        <td>{{ $row->amount }}</td>
                        <td>{{ $row->observations ?? 'Sin observaciones' }}</td>
                        <td>{{ $row->responsible_name ?? 'Sin usuario' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
