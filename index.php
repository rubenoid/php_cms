<?php

	require 'includes/init.php';

	$conn = require 'includes/db.php';

	// if no query string, page number is 1. Check 'Null coalescing operator'
	//$paginator = new Paginator(isset($_GET['page']) ? $_GET['page'] : 1, 4);
	$paginator = new Paginator($_GET['page'] ?? 1, 4, Article::getTotal($conn));

	$articles = Article::getPage($conn, $paginator->limit, $paginator->offset);

?>
<?php require 'includes/header.php'; ?>

<?php if (empty($articles)): ?>
	<p>No articles found.</p>
<?php else: ?>

	<ul>
		<?php foreach ($articles as $article): ?>
			<li>
				<article>
					<h2><a href="article.php?id=<?= $article['id']; ?>"><?= htmlspecialchars($article['title']); ?></a></h2>

					<?php if ($article['category_names']) : ?>
						<p>Categories:
							<?php foreach ($article['category_names'] as $name) : ?>
								<?php var_dump($name); ?>
								<?= htmlspecialchars($name); ?>
							<?php endforeach; ?>
						</p>
					<?php endif; ?>
					<p><?= htmlspecialchars($article['content']); ?></p>
				</article>
			</li>
		<?php endforeach; ?>
	</ul>


	<?php require 'includes/pagination.php'; ?>

<?php endif; ?>

<?php require 'includes/footer.php'; ?>
