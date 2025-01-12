<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de Paiement</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .content { margin-bottom: 20px; }
        .footer { text-align: center; margin-top: 30px; font-size: 0.9em; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 10px; text-align: left; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reçu de Paiement</h1>
        <h2>{{ strtoupper($agence->nom) }}</h2>
    </div>
    <div class="content">
        <p><strong>ID Paiement :</strong> {{ $paiement->id }}</p>
        <p><strong>Date :</strong> {{ $paiement->date_paiement }}</p>
        <p><strong>Montant :</strong> {{ $paiement->montant }} FCFA</p>
        <p><strong>Status :</strong> {{ $paiement->status }}</p>
        @if($contrat)
            <p><strong>Contrat associé :</strong> {{ $contrat->id }}</p>
        @endif
    </div>
    <div class="footer">
        <p>Merci pour votre paiement.</p>
        <p>Agence : {{ $agence->nom }}</p>
    </div>
</body>
</html>
