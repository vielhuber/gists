<?php
echo __('Text without link!', 'custom');
echo sprintf(__('Text with %sspecial%s link!', 'custom'), '<a href="https://test.de" target="_blank">', '</a>');