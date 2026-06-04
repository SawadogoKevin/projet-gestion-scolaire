<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>
body {
    font-family: "DejaVu Sans", Arial, sans-serif;
    margin: 25px;
    font-size: 12px;
    color: #333;
}

.page {
    page-break-after: always;
}

/* HEADER */
.header {
    text-align: center;
    border-bottom: 2px solid #000;
    padding-bottom: 10px;
    margin-bottom: 15px;
}

.header h2 {
    margin: 0;
    font-size: 20px;
}

/* INFOS */
.info {
    margin-bottom: 10px;
    padding: 8px;
    background: #f9f9f9;
    border: 1px solid #ddd;
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

th, td {
    border: 1px solid #000;
    padding: 6px;
    text-align: center;
}

th {
    background-color: #eaeaea;
}

td:first-child {
    text-align: left;
}

/* MOYENNE */
.moyenne-row {
    background: #dff0d8;
    font-weight: bold;
}

/* RESULTATS */
.resultats {
    margin-top: 15px;
    padding: 10px;
    border: 1px solid #ccc;
    background: #fafafa;
}

.mention {
    font-weight: bold;
    padding: 3px 8px;
    border-radius: 4px;
}

.excellent { background: #28a745; color: white; }
.tresbien { background: #17a2b8; color: white; }
.bien { background: #007bff; color: white; }
.passable { background: #ffc107; }
.insuffisant { background: #dc3545; color: white; }

/* SIGNATURE */
.signature {
    margin-top: 50px;
    display: flex;
    justify-content: space-between;
}
</style>

</head>

<body>

@foreach($bulletins as $data)

@php
    $total = 0;
    $coefTotal = 0;

    foreach($data['notes'] as $note) {
        $coef = $note->matiere->coefficient ?? 1;

        $total += $note->note * $coef;
        $coefTotal += $coef;
    }

    // ✅ Moyenne sur 10
    $moyenne = $coefTotal > 0 ? $total / $coefTotal : 0;

    // ✅ Mention basée sur /10
    if ($moyenne >= 8) {
        $mention = "Excellent";
        $class = "excellent";
    } elseif ($moyenne >= 7) {
        $mention = "Très bien";
        $class = "tresbien";
    } elseif ($moyenne >= 6) {
        $mention = "Bien";
        $class = "bien";
    } elseif ($moyenne >= 5) {
        $mention = "Passable";
        $class = "passable";
    } else {
        $mention = "Insuffisant";
        $class = "insuffisant";
    }
@endphp

<div class="page">

    <!-- HEADER -->
    <div class="header">
        <h2>BULLETIN SCOLAIRE</h2>
        <p><strong>Année scolaire :</strong> 2025 - 2026</p>
    </div>

    <!-- INFOS -->
    <div class="info">
        <p><strong>Nom :</strong> {{ $data['eleve']->nom }}</p>
        <p><strong>Prénom :</strong> {{ $data['eleve']->prenom }}</p>
        <p><strong>Classe :</strong> {{ $classe->nom }}</p>
        <p><strong>Rang :</strong> {{ $data['rang'] }} / {{ count($bulletins) }}</p>
    </div>

    <!-- TABLE -->
    <table>
        <tr>
            <th>Matière</th>
            <th>Note</th>
            <th>Coef</th>
            <th>Note pondérée</th>
        </tr>

        @foreach($data['notes'] as $note)
        @php
            $coef = $note->matiere->coefficient ?? 1;
            $pondere = $note->note * $coef;
        @endphp

        <tr>
            <td>{{ $note->matiere->nom ?? 'N/A' }}</td>
            <td>{{ $note->note }}</td>
            <td>{{ $coef }}</td>
            <td>{{ $pondere }}</td>
        </tr>
        @endforeach

        <tr class="moyenne-row">
            <td colspan="3">MOYENNE (/10)</td>
            <td>{{ number_format($moyenne/2, 2) }}</td>
        </tr>
    </table>

    <!-- RESULTATS -->
    <div class="resultats">
        <p><strong>Moyenne :</strong> {{ number_format($moyenne/2, 2) }}/10</p>

        <p>
            <strong>Mention :</strong>
            <span class="mention {{ $class }}">
                {{ $mention }}
            </span>
        </p>
    </div>

    <!-- SIGNATURE -->
    <div class="signature">
        <div>
            <p>Le Directeur</p>
            <br><br>
            <p>____________________</p>
        </div>

        <div>
            <p>Le Titulaire</p>
            <br><br>
            <p>____________________</p>
        </div>
    </div>

</div>

@endforeach

</body>
</html>