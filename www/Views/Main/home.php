<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Home</title>
</head>

<body>
    <h1>Bonjour, <?= htmlspecialchars($username) ?>!</h1>
    <p>Ton email: <?= htmlspecialchars($email) ?></p>
</body>

</html>