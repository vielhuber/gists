<div class="logo">
  <?= is_front_page() ? '<h1 class="logo__headline">' : '' ?>
      <a class="logo__link" href="index.php">
          <span class="logo__text" style="position:absolute;width:1px;height:1px;overflow:hidden;">h1 der Startseite</span>
          <img class="logo__image" src="logo.svg" alt="h1 der Startseite">
      </a>
  <?= is_front_page() ? '</h1>' : '' ?>
</div>
  
<?= !is_front_page() ? '
<h1>Hero-Modul auf Unterseite</h1>
...
' : '' ?>
  
<h2>Beliebiges weiteres Modul</h2>