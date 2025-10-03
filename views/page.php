<!DOCTYPE html>
<html lang="<?= $lang ?? "en" ?>">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?></title>

  <link href="css/global.css" rel="stylesheet">

  <?php if (isset($styles)): ?>
    <?php foreach ($styles as $style): ?>
      <link href="css/<?= $style ?>.css" rel="stylesheet">
    <?php endforeach; ?>
  <?php endif; ?>
</head>

<body>
  <?php $render(); ?>
</body>

</html>
