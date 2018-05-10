FROM nginx:latest
COPY .profile /root/.profile
COPY .profile /root/.bashrc
RUN apt-get update && apt-get install -y cron sudo
RUN apt-get install -y git
