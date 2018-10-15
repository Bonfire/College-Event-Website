# Part of Zajedno.
# Written by Tiger Sachse.

USER="root"
SCRIPTS="scripts"
SOURCE_PHP_DIR="source/web"
DEST_PHP_DIR="/var/www/html"
DATABASE_NAME="main_database"
MAKE_SCRIPT="make_database.sql"
DROP_SCRIPT="drop_database.sql"
GENERATION_SCRIPT="generate_data.py"
DUMMY_DATA_SCRIPT="add_sample_data.sql"

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

# Generate data and create an SQL script for the database.
function generate_data {
    python3 $SCRIPTS/$GENERATION_SCRIPT
    mv $DUMMY_DATA_SCRIPT $SCRIPTS
}

# Destroy and then rebuild the database, plus add dummy data.
function rebuild_database {
    generate_data
    run_sql $SCRIPTS/$DROP_SCRIPT $SCRIPTS/$MAKE_SCRIPT $SCRIPTS/$DUMMY_DATA_SCRIPT
}

# Main entry-point to this script.
case "$1" in
    "--update-www")
        update_www
        ;;

    "--generate-data")
        generate_data
        ;;

    "--sql")
        run_sql "${@:2}"
        ;;

    "--rebuild-database")
        rebuild_database 
        ;;
esac
