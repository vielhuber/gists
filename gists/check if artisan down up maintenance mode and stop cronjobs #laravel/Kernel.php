/* ... */
	protected function schedule(Schedule $schedule)
    {
        /* stop executing cronjobs when down */
        if(App::isDownForMaintenance())
        {
            return;
        }
        /* ... */
    }
/* ... */
