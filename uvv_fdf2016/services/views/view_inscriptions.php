<!DOCTYPE html>
<html>
<head>
	<title>FdF 2016 - Inscriptions</title>
	<meta charset="UTF-8">
</head>
<body>

<h1>Inscrits</h1>
<?php if (count($inscrits) > 0): ?>
<table>
  <thead>
    <tr>
      <th><?php echo implode('</th><th>', array_keys($inscrits[0])); ?></th>
    </tr>
  </thead>
  <tbody>
<?php foreach ($inscrits as $row): array_map('htmlentities', $row); ?>
    <tr>
      <td><?php echo implode('</td><td>', $row); ?></td>
    </tr>
<?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>

<h1>Tentatives d'inscriptions (mais pas inscrits)</h1>
<?php if (count($tokens) > 0): ?>
<table>
  <thead>
    <tr>
      <th><?php echo implode('</th><th>', array_keys($tokens[0])); ?></th>
    </tr>
  </thead>
  <tbody>
<?php foreach ($tokens as $row): array_map('htmlentities', $row); ?>
    <tr>
      <td><?php echo implode('</td><td>', $row); ?></td>
    </tr>
<?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>
</body>
</html>