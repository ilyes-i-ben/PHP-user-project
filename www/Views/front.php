<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $title??"Titre de page" ?></title>
    <meta name="description" content="<?= $description??"ceci est la description de ma page" ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
<header>
    <nav>
        <ul>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <li><a href="/login">Login</a></li>
                <li><a href="/register">Register</a></li>
            <?php else: ?>
                <li><a href="/home">Profile</a></li>
                <li><a href="/logout">Logout</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
    <?php include "../Views/".$this->v; ?>
</body>
</html>