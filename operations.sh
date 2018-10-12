#

function update_www {
    rm -rf /var/www/html
    mkdir -p /var/www/html
    cp  -r source/web/* /var/www/html
}

function run_sql {
    mysql -u root -p website < $1
}

case "$1" in
    "--update-www")
        update_www
        ;;

    "--run-sql")
        run_sql $2
        ;;
esac
