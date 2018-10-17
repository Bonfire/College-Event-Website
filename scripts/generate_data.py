"""Generate an SQL script with random data for a mySQL database.

Part of Zajedno.
Written by Tiger Sachse.
"""

import random
import string
from faker import Faker

# Various constants and global objects.
ORG_COUNT = 75
FOOTER = "\nQUIT"
USER_COUNT = 1000
UNIVERSITY_COUNT = 50
ENGLISH_FAKER = Faker()
LOREM_FAKER = Faker("lt_LT")
OUTPUT_PATH = "add_sample_data.sql"
PRIVILEGE_LEVELS = ("normal", "admin", "superadmin")
ROAD_TYPES = ("Boulevard", "Lane", "Court", "Road", "Way", "Street")
EMAIL_DOMAINS = (
    "gmail.com",
    "yahoo.com",
    "aol.com",
    "bellsouth.net",
    "outlook.com",
    "yahoo.co.uk",
)
INSTITUTION_FORMATS = (
    "{0} University",
    "University of {0}",
    "{0} State University",
    "{0} State College",
    "{0} Community College",
)
HEADER = (
    "/*\n"
    "Part of Zajedno.\n"
    "Written by Tiger Sachse.\n"
    "*/\n\n"
    "USE main_database;\n"
    "CONNECT main_database;\n\n"
)

class User:
    """Class that holds randomized data for a user entry in a database."""
    INSERT = (
        "INSERT INTO users "
        "(first_name, last_name, password, email, university_id, permission_level) "
        "VALUES ('{0}', '{1}', '{2}', '{3}', {4}, '{5}');\n"
    )

    def __init__(self, university_id):
        """Generate random data for each field for this user."""
        self.first_name = ENGLISH_FAKER.first_name()
        self.last_name = ENGLISH_FAKER.last_name()
        self.university_id = university_id
        self.email = self.__generate_email()
        self.password = self.__generate_password()
        self.permission_level = random.choice(PRIVILEGE_LEVELS)


    def __generate_email(self):
        """Generate a random email using this user's name."""
        email = []

        email.append(self.first_name)
        email.append(".")
        email.append(self.last_name)
        email.extend(random.choices(string.digits, k=2))
        email.append("@")
        email.append(random.choice(EMAIL_DOMAINS))

        return "".join(email)
    

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
            self.first_name,
            self.last_name,
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
        self.founder = ENGLISH_FAKER.last_name()
        self.name = self.__generate_name()
        self.address = self.__generate_address()
        self.description = LOREM_FAKER.paragraph()

    
    def __generate_name(self):
        """Generate a random name with a special institutional format."""
        return random.choice(INSTITUTION_FORMATS).format(self.founder)


    def __generate_address(self):
        """Generate a random address using this university's founder's name."""
        address = []

        address.append(ENGLISH_FAKER.building_number())
        address.append(self.founder)
        address.append(random.choice(ROAD_TYPES) + ",")
        address.append(ENGLISH_FAKER.city() + ",")
        address.append(ENGLISH_FAKER.state_abbr())
        address.append(ENGLISH_FAKER.postcode())

        return " ".join(address)

    def __str__(self):
        """Return the SQL insertion command for this university."""
        return self.INSERT.format(
            self.name,
            self.address,
            self.description,
        )


class Organization:
    """Class that holds randomized data for an organization entry in the database."""
    INSERT = "INSERT INTO organizations (name, owner_id) VALUES ('{0}', {1});\n"

    def __init__(self, owner_id):
        """Initialize this organization with a name and owner ID."""
        self.name = ENGLISH_FAKER.company()
        self.owner_id = owner_id


    def __str__(self):
        """Return the SQL insertion command for this organization."""
        return self.INSERT.format(
            self.name,
            self.owner_id,
        )


# Main entry point to script.
# Generate random users and universities.
universities = [University() for count in range(UNIVERSITY_COUNT)]
users = [User(random.randrange(1, len(universities))) for count in range(USER_COUNT)]
organizations = [Organization(random.randrange(1, len(users))) for count in range(ORG_COUNT)]

# Write all insertion commands, as well as a header and footer, to an SQL script.
with open(OUTPUT_PATH, "w") as f:
    f.write(HEADER)
    for university in universities:
        f.write(str(university))
    for user in users:
        f.write(str(user))
    for organization in organizations:
        f.write(str(organization))
    f.write(FOOTER)
