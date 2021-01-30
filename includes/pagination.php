<?php $base = strtok($_SERVER["REQUEST_URI"], '?'); ?>
<nav>
	<ul>
		<li>
			<?php if ($paginator->previous): ?>
				<a href="<?= $base ?>?page=<?= $paginator->previous; ?>">Previous</a> <!--- volgens mij is ?page... ook goed? -->
			<?php else: ?>
				Previous
			<?php endif; ?>
		</li>
		<li>
			<?php if ($paginator->next): ?>
				<a href="<?= $base ?>?page=<?= $paginator->next; ?>">Next</a>  <!--- volgens mij is ?page... ook goed? -->
			<?php else: ?>
				Next
			<?php endif; ?>
		</li>
	</ul>
</nav>
