### notes

- capabilities can be mapped to roles via plugins like User Role Editor [User Role Editor](https://de.wordpress.org/plugins/user-role-editor/)

### register a new capability
```php
// only run this if possible once
add_action('admin_init', function () {
    // register this to the admin role so that it's available for other roles
    get_role('administrator')->add_cap('custom_capability');
});

// remove capability
// only run this if possible once
add_action('admin_init', function () {
    // register this to the admin role so that it's available for other roles
    get_role('administrator')->remove_cap('custom_capability');
});
        
// always make sure, capabilities are available for a certain plugin
add_action('admin_init', function () {
    $roles = get_editable_roles();
    $caps = [];
    $caps[] = 'myplugin__capability_1';
    $caps[] = 'myplugin__capability_2';
    $caps[] = 'myplugin__capability_3';
    foreach ($roles as $roles__key => $roles__value) {
        $roles_value_capabilities = array_filter(array_keys($roles__value['capabilities']), function ($a) {
            return strpos($a, 'myplugin__') === 0;
        });
        // remove caps, that are not existing anymore
        foreach ($roles_value_capabilities as $roles_value_capabilities__value) {
            if (!in_array($roles_value_capabilities__value, $caps)) {
                get_role($roles__key)->remove_cap($roles_value_capabilities__value);
            }
        }
        // add all caps to admin role (so they are visible in plugins like User Role Editor)
        if ($roles__key === 'administrator') {
            foreach (array_diff($caps, array_keys($roles__value['capabilities'])) as $caps__value) {
                get_role($roles__key)->add_cap($caps__value);
            }
        }
    }
});
```
        
### check capability
```php
if( current_user_can('custom_capability') ) { }
$user->has_cap('custom_capability') { }
```

