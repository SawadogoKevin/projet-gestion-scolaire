<!DOCTYPE html>
<html>
<head>
    <title>Affectation</title>
</head>
<body>

    <h2>Affecter un utilisateur</h2>

    <form method="POST" action="/affecter/1">
        @csrf

        <label>Nom :</label>
        <input type="text" name="nom">

        <button type="submit">Affecter</button>
    </form>

</body>
</html>