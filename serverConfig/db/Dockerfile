FROM mariadb:latest
COPY .profile /root/.profile
COPY .profile /root/.bashrc
RUN apt-get update && apt-get install -y cron sudo
COPY crontab /root/crontab
RUN /usr/bin/crontab /root/crontab
RUN rm /root/crontab
RUN echo "mysql2:x:1000:50::/home/mysql:/bin/sh" >> /etc/passwd
RUN echo "mysql2 ALL=(ALL) NOPASSWD: ALL" >> /etc/sudoers
COPY run.sh /usr/local/config/run.sh
RUN chmod +x /usr/local/config/run.sh
RUN apt-get install -y git
RUN chmod 0777 /usr/local/config/run.sh
ENTRYPOINT exec /usr/local/config/run.sh
