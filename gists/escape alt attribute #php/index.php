$alt = 'Ich bin ein Alt-Tag "mit" Umlauten!';
echo '<img class="menu-icon" src="#" alt="'.htmlspecialchars($alt, ENT_QUOTES, 'UTF-8').'">';