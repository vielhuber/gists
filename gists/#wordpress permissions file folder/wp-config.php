/* situation: there exists a user for the apache and a user for ssh/git who both are in the same group */
/* the folder wp-content is owned by the ssh/git user but the apache user also can write (because of the same group) */
/* then wordpress does not recognize that and we need to add the following lines to wp-config.php: */

define('FS_METHOD', 'direct');
define('FS_CHMOD_DIR', 0770);
define('FS_CHMOD_FILE', 0660);

/* for more details see wp-admin/includes/file.php: get_filesystem_method */