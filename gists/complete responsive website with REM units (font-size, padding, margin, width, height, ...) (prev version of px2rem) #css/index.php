<?php
for($i = 150; $i > 0; $i--) { echo '@media screen and (max-width: '.(1920+($i*10)).'px) { html { font-size: '.(16+($i*0.05)).'px; } } '; }
for($i = 0; $i < 150; $i++) { echo '@media screen and (max-width: '.(1920-($i*10)).'px) { html { font-size: '.(16-($i*0.05)).'px; } } '; }
?>