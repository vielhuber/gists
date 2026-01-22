// disable all
DELETE FROM wp_options WHERE option_name = 'active_plugins_backup';
INSERT INTO wp_options (option_name,option_value,autoload) VALUES ('active_plugins_backup',(SELECT t2.option_value FROM (SELECT * FROM wp_options) as t2 WHERE option_name = 'active_plugins'),'yes');
UPDATE wp_options SET option_value = 'a:0:{}' WHERE option_name = 'active_plugins';
 
// enable all
UPDATE wp_options SET option_value = (SELECT option_value FROM (SELECT * FROM wp_options) as t2 WHERE option_name = 'active_plugins_backup') WHERE option_name = 'active_plugins';
 
// disable one
UPDATE wp_options SET option_value = replace(option_value, 'wpFastestCache.php', 'wpFastestCache.OFF')
 
// enable one
UPDATE wp_options SET option_value = replace(option_value, 'wpFastestCache.OFF', 'wpFastestCache.php')