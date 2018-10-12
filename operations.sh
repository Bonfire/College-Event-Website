# Part of Zajedno.
# Written by Tiger Sachse.

USER="root"
SOURCE_PHP_DIR="source/web"
DEST_PHP_DIR="/var/www/html"
DATABASE_NAME="main_database"

# Update the WWW directory with the latest PHP.
function update_www {
    rm -rf $DEST_PHP_DIR
    mkdir -p $DEST_PHP_DIR
    cp  -r $SOURCE_PHP_DIR/* $DEST_PHP_DIR
}

# Run SQL scripts through the database.
function run_sql {
    for FILE in "$@"
    do
        mysql -u $USER -p < $FILE
    done
}

# Main entry-point to this script.
case "$1" in
    "--update-www")
        update_www
        ;;

    "--sql")
        run_sql "${@:2}"
        ;;
esac
