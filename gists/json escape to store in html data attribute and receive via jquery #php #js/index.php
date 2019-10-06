<?php
echo '<div class="elem" data-json="'.htmlspecialchars(json_encode(['that\'s cool']), ENT_QUOTES, 'UTF-8').'"></div>';

$('.elem').data('json');