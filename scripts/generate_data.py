"""Generate an SQL script with random data for a mySQL database.

Part of Zajedno.
Written by Tiger Sachse.
"""

import random
import string
from faker import Faker

# Constants.
HEADER = (
    "/*\n"
    "Part of Zajedno.\n"
    "Written by Tiger Sachse.\n"
    "*/\n\n"
    "USE main_database;\n"
    "CONNECT main_database;\n\n"
)
FAKER = Faker()
FOOTER = "\nQUIT"
USER_COUNT = 1000
UNIVERSITY_COUNT = 100
OUTPUT_PATH = "add_sample_data.sql"

class User:
    """Class that holds randomized data for a user entry in a database."""
    INSERT = (
        "INSERT INTO users "
        "(username, password, email, university_id, permission_level) "
        "VALUES ('{0}', '{1}', '{2}', {3}, '{4}');\n"
    )

    def __init__(self, university_id):
        """Generate random data for each field for this user."""
        profile = FAKER.simple_profile()

        self.email = profile["mail"]
        self.university_id = university_id
        self.username = profile["username"]
        self.password = self.__generate_password()
        self.permission_level = random.choice(("normal", "admin", "superadmin"))


    def __generate_password(self):
        """Generate a randomized password with special characters and digits."""
        password = []

        # Include a capital letter, a special character, two digits,
        # and several lowercase letters in the password.
        password.append(random.choice(string.ascii_uppercase))
        password.extend(
            random.choices(
                string.ascii_lowercase,
                k=random.randrange(7, 16)
            )
        )
        password.extend(random.choices(string.digits, k=2))
        password.append(random.choice(("!", "?", ".")))

        random.shuffle(password)

        return "".join(password)


    def __str__(self):
        """Return the SQL insertion command for this user."""
        return self.INSERT.format(
            self.username,
            self.password,
            self.email,
            self.university_id,
            self.permission_level
        )

        
class University:
    """Class that holds randomized data for a university entry in a database."""
    INSERT = (
        "INSERT INTO universities "
        "(name, address, description) "
        "VALUES ('{0}', '{1}', '{2}');\n"
    )

    def __init__(self):
        """Generate random data for this university's fields."""
        self.name = self.__generate_name()
        self.address = FAKER.address()
        self.description = FAKER.sentence()

    
    def __generate_name(self):
        """Generate a random name with a special institutional format."""
        INSTITUTION_FORMATS = (
            "{0} University",
            "University of {0}",
            "{0} State University",
            "{0} State College",
            "{0} Community College",
        )

        return random.choice(INSTITUTION_FORMATS).format(FAKER.last_name())


    def __str__(self):
        """Return the SQL insertion command for this university."""
        return self.INSERT.format(
            self.name,
            self.address,
            self.description,
        )


# Main entry point to script.
# Generate random users and universities.
universities = [University() for count in range(UNIVERSITY_COUNT)]
users = [User(random.randrange(1, len(universities))) for count in range(USER_COUNT)]

# Write all insertion commands, as well as a header and footer, to an SQL script.
with open(OUTPUT_PATH, "w") as f:
    f.write(HEADER)
    for university in universities:
        f.write(str(university))
    for user in users:
        f.write(str(user))
    f.write(FOOTER)
