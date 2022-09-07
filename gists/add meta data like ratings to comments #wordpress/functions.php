<?php
/* show comment meta fields in backend */
$comment_meta_fields = [
    'comment_field1' => 'foo',
    'comment_field2' => 'bar',
    'comment_field3' => 'baz'
];
add_action('add_meta_boxes_comment', function () use ($comment_meta_fields) {
    add_meta_box(
        'comments-meta-fields',
        __('Weitere Felder'),
        function ($comment) use ($comment_meta_fields) {
            echo '<p>';
            foreach (
                $comment_meta_fields
                as $comment_meta_fields__key => $comment_meta_fields__value
            ) {
                echo '<label for="' .
                    $comment_meta_fields__key .
                    '">' .
                    __($comment_meta_fields__value) .
                    '</label>';
                echo '<input type="text" id="' .
                    $comment_meta_fields__key .
                    '" name="' .
                    $comment_meta_fields__key .
                    '" value="' .
                    esc_attr(
                        get_comment_meta($comment->comment_ID, $comment_meta_fields__key, true)
                    ) .
                    '" class="widefat" />';
            }
            echo '</p>';
        },
        'comment',
        'normal',
        'high'
    );
});
add_action('edit_comment', function ($comment_id) use ($comment_meta_fields) {
    foreach ($comment_meta_fields as $comment_meta_fields__key => $comment_meta_fields__value) {
        if (isset($_POST[$comment_meta_fields__key])) {
            update_comment_meta(
                $comment_id,
                $comment_meta_fields__key,
                esc_attr($_POST[$comment_meta_fields__key])
            );
        }
    }
});