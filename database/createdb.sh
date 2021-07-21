#Waits until SQL server is up, then runs database.sql to init db
for i in {1..50};
do
    /opt/mssql-tools/bin/sqlcmd -S localhost -U sa -P StrongP@ssword! -i database.sql
    if [ $? -eq 0 ]
    then
        echo "Database initialized"
        break
    else
        echo "Waiting on SQL..."
        sleep 1
    fi
done