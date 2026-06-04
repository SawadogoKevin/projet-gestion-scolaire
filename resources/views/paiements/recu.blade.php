<h2>Reçu de paiement</h2>

<p><strong>Nom :</strong> {{ $paiement->eleve->nom }} {{ $paiement->eleve->prenom }}</p>

<p><strong>Classe :</strong> {{ $paiement->eleve->classe->nom }}</p>

<p><strong>Montant :</strong> {{ $paiement->montant }} FCFA</p>

<p><strong>Date :</strong> {{ $paiement->date_paiement }}</p>

<p><strong>Reste à payer :</strong> {{ $reste }} FCFA</p>

<hr>

<p>Merci pour votre paiement.</p>