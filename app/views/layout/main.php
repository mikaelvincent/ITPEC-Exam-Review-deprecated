<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
		<title>
            <?= htmlspecialchars($title ?? "ITPEC Exam Review") ?>
        </title>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/lumen/bootstrap.min.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,300;0,400;0,700;1,400&amp;display=swap">
        <?= $head ?? "" ?>
	</head>
	<body>
		<main>
			<div class="container py-4 py-xl-5">
                <?php include __DIR__ . "/breadcrumbs.php"; ?>
				<?= $content ?>
			</div>
		</main>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <?= $scripts ?? "" ?>
	</body>
</html>
