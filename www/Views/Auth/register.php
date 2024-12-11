<h1>Register</h1>

<form action="/register" method="POST">
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" id="username" name="username" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>
        <label for="passwordConfirm">Confirmer le mot de passe :</label>
        <input type="password" id="passwordConfirm" name="passwordConfirm" required>
        <label for="firstname">Prénom :</label>
        <input type="text" id="firstname" name="firstname" required>
        <label for="lastname">Nom :</label>
        <input type="text" id="lastname" name="lastname" required>
        <label for="country">Pays :</label>
        <input type="text" id="country" name="country" required>
        <button type="submit">S'inscrire</button>

</form>