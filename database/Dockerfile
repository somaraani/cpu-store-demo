FROM mcr.microsoft.com/mssql/server:2019-latest

#Change to root to allow running init scripts
USER root

#Copy init scripts
COPY ./database.sql .
COPY ./createdb.sh .
COPY ./entrypoint.sh .

#Accept EULA 
ENV ACCEPT_EULA Y

#Give scripts execute permissions
RUN chmod +x entrypoint.sh
RUN chmod +x createdb.sh

#Run init script
CMD /bin/bash ./entrypoint.sh