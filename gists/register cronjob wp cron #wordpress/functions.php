add_action('init', function () {
    $task = 'my_cronjob';
    $frequency = 'hourly'; // hourly|twicedaily|daily
    $scheduled = wp_next_scheduled($task);
    // actual function
    add_action($task, function () {
        echo 'FOO';
    });
    // deregister (only if needed)
    /*
    if ($scheduled !== false) {
        wp_unschedule_event($scheduled, $task);
    }
    */
    // register
    if (!wp_next_scheduled($task)) {
        wp_schedule_event(
            strtotime(date('Y-m-d H:00:00', strtotime('now + 1 hour'))),
            $frequency,
            $task
        );
    }
});