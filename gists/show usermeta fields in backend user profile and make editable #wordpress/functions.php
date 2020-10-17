<?php
add_action('show_user_profile', function ($user) {
    renderFields($user);
});
add_action('edit_user_profile', function ($user) {
    renderFields($user);
});
add_action('personal_options_update', function ($user_id) {
    saveFields($user_id);
});
add_action('edit_user_profile_update', function ($user_id) {
    saveFields($user_id);
});

function addFields($user)
{
    echo '<h3>' . __('Meta fields', 'my-domain') . '</h3>';
    echo '<table class="form-table">';
    foreach (getFields() as $fields__key => $fields__value) {
        echo '<tr>';
        echo '<th><label for="usermeta_' . $fields__key . '">' . $fields__value . '</label></th>';
        echo '<td>';
        echo '<input type="text" name="usermeta_' .
            $fields__key .
            '" id="usermeta_' .
            $fields__key .
            '" value="' .
            esc_attr(get_user_meta($user->ID, $fields__key, true)) .
            '" class="regular-text" />';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
}

function saveFields($user_id)
{
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }
    foreach (getFields() as $fields__key => $fields__value) {
        if (isset($_POST['usermeta_' . $fields__key])) {
            update_user_meta($user_id, $fields__key, $_POST['usermeta_' . $fields__key]);
        }
    }
}

function renderFields()
{
    return [
        'foo' => __('Foo', 'my-domain'),
        'bar' => __('Bar', 'my-domain')
    ];
}
