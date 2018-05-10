FROM mariadb:latest
COPY .profile /root/.profile
COPY .profile /root/.bashrc
RUN apt-get update && apt-get install -y cron
COPY crontab /root/crontab
RUN /usr/bin/crontab /root/crontab
RUN rm /root/crontab
RUN /usr/sbin/cron
