# Extend from Laravel Sail's official image
FROM laravelsail/php84-composer

RUN apt-get update && apt-get install -y cron

# Add cron job for Laravel Scheduler
RUN echo "* * * * * root php /var/www/html/artisan schedule:run >> /var/log/cron.log 2>&1" > /etc/cron.d/laravel-scheduler
RUN chmod 0644 /etc/cron.d/laravel-scheduler && crontab /etc/cron.d/laravel-scheduler

# Copy cron supervisor config
COPY ./cron.conf /etc/supervisor/conf.d/cron.conf
