<?= is_front_page() ? '<h1>' : '' ?>
	<a href="index.php" class="logo">
		<img src="logo.svg" alt="h1 der Startseite">
	</a>
<?= is_front_page() ? '</h1>' : '' ?>
  
<?= !is_front_page() ? '<h1>Hero-Modul auf Unterseite</h1>' : '' ?>
  
<h2>Beliebiges weiteres Modul</h2>