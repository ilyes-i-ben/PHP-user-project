<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $title??"Titre de page" ?></title>
    <meta name="description" content="<?= $description??"ceci est la description de ma page" ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>
<body>
    <h1>Titre du front</h1>
    <?php include "../Views/".$this->v; ?>
</body>
</html>