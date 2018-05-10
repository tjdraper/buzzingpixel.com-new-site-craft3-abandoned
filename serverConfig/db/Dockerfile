FROM mariadb:latest
COPY .profile /root/.profile
COPY .profile /root/.bashrc
ADD crontab /etc/cron.d/custom-cron
RUN chmod 0644 /etc/cron.d/custom-cron
