            openlog('NUIG', LOG_CONS | LOG_NDELAY, LOG_USER);
            syslog(LOG_DEBUG, "Activation={$activated}");
            closelog();
