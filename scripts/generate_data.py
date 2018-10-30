"""Generate an SQL script with random data for a mySQL database.

Part of Zajedno.
Written by Tiger Sachse.
"""

import random
import string
from faker import Faker

# Various constants and global objects.
FOOTER = "\nQUIT"
USER_COUNT = 10000
EVENT_COUNT = 1000
PICTURE_COUNT = 200
COMMENT_COUNT = 2000
UNIVERSITY_COUNT = 100
ORGANIZATION_COUNT = 75
ENGLISH_FAKER = Faker()
MEMBERSHIP_COUNT = 20000
LOREM_FAKER = Faker("lt_LT")
OUTPUT_PATH = "add_sample_data.sql"
PICTURE_EXTENSIONS = (".jpg", ".png", ".bmp", ".gif", ".jpeg")
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
        "VALUES ('{0}', '{1}', '{2}', '{3}', {4}, {5});\n"
    )

    def __init__(self, university_id):
        """Generate random data for each field for this user."""
        self.first_name = ENGLISH_FAKER.first_name()
        self.last_name = ENGLISH_FAKER.last_name()
        self.university_id = university_id
        self.email = self.__generate_email()
        self.password = self.__generate_password()
        self.permission_level = random.randrange(0, 3)


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
        "(name, address, description, student_count) "
        "VALUES ('{0}', '{1}', '{2}', {3});\n"
    )

    def __init__(self):
        """Generate random data for this university's fields."""
        self.founder = ENGLISH_FAKER.last_name()
        self.name = self.__generate_name()
        self.address = self.__generate_address()
        self.description = LOREM_FAKER.paragraph()
        self.student_count = 0

    
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
            self.student_count,
        )


class Organization:
    """Class that holds randomized data for an organization entry in the database."""
    INSERT = (
        "INSERT INTO organizations "
        "(name, university_id, owner_id) "
        "VALUES ('{0}', {1}, {2});\n"
    )

    def __init__(self, university_id, owner_id):
        """Initialize this organization with a name and owner ID."""
        self.name = ENGLISH_FAKER.company()
        self.university_id = university_id
        self.owner_id = owner_id


    def __str__(self):
        """Return the SQL insertion command for this organization."""
        return self.INSERT.format(
            self.name,
            self.university_id,
            self.owner_id,
        )


class Event:
    """"""
    INSERT = (
        "INSERT INTO events "
        "(name, description, category, address, publicity_level, organization_id,"
        " university_id, event_time, event_data, contact_number, contact_email,"
        " ratings_count, ratings_average) VALUES "
        "('{0}', '{1}', '{2}', '{3}', {4}, {5}, {6}, {7}, {8}, '{9}', '{10}', {11}, {12});\n"
    )

    def __init__(self, university_id, organization_id):
        """"""
        pass


    def __str__(self):
        """"""
        return ""


class Picture:
    """"""
    INSERT = "INSERT INTO pictures VALUES ({0}, '{1}');\n"

    def __init__(self, owner_id):
        """"""
        self.owner_id = owner_id
        self.path = self.__generate_path()


    def __generate_path(self):
        """"""
        path = []
        for directory_count in range(1, random.randrange(2, 5)):
            path.append(LOREM_FAKER.word())
        path[-1] += random.choice(PICTURE_EXTENSIONS)

        return "/".join(path)


    def __str__(self):
        """"""
        return self.INSERT.format(
            self.owner_id,
            self.path,
        )


class Comment:
    """"""
    INSERT = "INSERT INTO comments VALUES ({0}, {1}, {2}, '{3}');\n"

    def __init__(self, event_id, user_id):
        """"""
        self.event_id = event_id
        self.time = random.randrange(1539736761, 1543536000)
        self.user_id = user_id
        self.text = LOREM_FAKER.paragraph()


    def __str__(self):
        """"""
        return self.INSERT.format(
            self.event_id,
            self.time,
            self.user_id,
            self.text,
        )


class Membership:
    """"""
    INSERT = "INSERT INTO memberships VALUES ({0}, {1});\n"

    def __init__(self, user_id, organization_id):
        """"""
        self.user_id = user_id
        self.organization_id = organization_id


    def __str__(self):
        """"""
        return self.INSERT.format(self.user_id, self.organization_id)


# Main entry point to script.
# Generate random users and universities. ###
universities = [University() for university in range(UNIVERSITY_COUNT)]
users = [User(random.randrange(1, len(universities))) for user in range(USER_COUNT)]

organizations = []
for organization in range(ORGANIZATION_COUNT):
    organizations.append(
        Organization(
            random.randrange(1, len(universities)),
            random.randrange(1, len(users))
        )
    )

events = [Event(1, 1) for event in range(EVENT_COUNT)]
pictures = [Picture(random.randrange(1, len(events))) for count in range(PICTURE_COUNT)]

comments = []
for comment in range(COMMENT_COUNT):
    comments.append(Comment(random.randrange(1, len(events)), random.randrange(1, len(users))))

memberships = []
for membership in range(MEMBERSHIP_COUNT):
    memberships.append(
        Membership(
            random.randrange(1, len(users)),
            random.randrange(1, len(organizations))
        )
    )

# Write all insertion commands, as well as a header and footer, to an SQL script.
with open(OUTPUT_PATH, "w") as f:
    f.write(HEADER)
    for university in universities:
        f.write(str(university))
    for user in users:
        f.write(str(user))
    for organization in organizations:
        f.write(str(organization))
    """
    for event in events:
        f.write(str(event))
    for picture in pictures:
        f.write(str(picture))
    for comment in comments:
        f.write(str(comment))
    for membership in memberships:
        f.write(str(membership))
    """
    f.write(FOOTER)
