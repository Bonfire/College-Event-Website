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
PICTURE_COUNT = 2000
COMMENT_COUNT = 20000
PUBLICITY_LEVEL_MAX = 3
ENGLISH_FAKER = Faker()
UNIVERSITY_COUNT = 1000
RATINGS_COUNT_MAX = 1000
MEMBERSHIP_COUNT = 50000
ORGANIZATION_COUNT = 4000
UNIX_STOP_TIME = 1543536000
UNIX_START_TIME = 1539736761
LOREM_FAKER = Faker("lt_LT")
OUTPUT_PATH = "add_sample_data.sql"
PICTURE_EXTENSIONS = (".jpg", ".png", ".bmp", ".gif", ".jpeg")
ROAD_TYPES = ("Boulevard", "Lane", "Court", "Road", "Way", "Street")
EMAIL_DOMAINS = (
    "aol.com",
    "gmail.com",
    "yahoo.com",
    "outlook.com",
    "yahoo.co.uk",
    "bellsouth.net",
)
INSTITUTION_FORMATS = (
    "{0} University",
    "University of {0}",
    "{0} State College",
    "{0} State University",
    "{0} Community College",
)
EVENT_FORMATS = (
    "Party for {0}",
    "Wake for {0}",
    "Extravaganza for {0}",
    "Church of {0} Meeting",
    "The Wedding of {0} and {0}",
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


    def __str__(self):
        """Return the SQL insertion command for this university."""
        return self.INSERT.format(
            self.name,
            self.address,
            self.description,
            self.student_count,
        )
    

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


class Organization:
    """Class that holds randomized data for an organization entry in the database."""
    INSERT = (
        "INSERT INTO organizations "
        "(name, description, university_id, owner_id) "
        "VALUES ('{0}', '{1}', {2}, {3});\n"
    )

    def __init__(self, university_id, owner_id):
        """Initialize this organization with a name and owner ID."""
        self.university_id = university_id
        self.name = ENGLISH_FAKER.company()
        self.description = LOREM_FAKER.paragraph()
        self.owner_id = owner_id


    def __str__(self):
        """Return the SQL insertion command for this organization."""
        return self.INSERT.format(
            self.name,
            self.description,
            self.university_id,
            self.owner_id,
        )


class Event:
    """Class that holds randomized data for an event entry in the database."""
    INSERT = (
        "INSERT INTO events "
        "(name, description, category, address, publicity_level, organization_id,"
        " university_id, event_time, contact_number, contact_email,"
        " ratings_count, ratings_average) VALUES "
        "('{0}', '{1}', '{2}', '{3}', {4}, {5}, {6}, {7}, '{8}', '{9}', {10}, {11});\n"
    )

    def __init__(self, university_id, organization_id):
        """Initialize this event with several fields."""
        self.name = random.choice(EVENT_FORMATS).format(ENGLISH_FAKER.first_name())
        self.description = LOREM_FAKER.paragraph()
        self.category = LOREM_FAKER.word()
        self.address = self.__generate_address()
        self.publicity_level = random.randrange(1, PUBLICITY_LEVEL_MAX)
        self.organization_id = organization_id
        self.university_id = university_id
        self.event_time = random.randrange(UNIX_START_TIME, UNIX_STOP_TIME)
        self.contact_number = ENGLISH_FAKER.phone_number()
        self.contact_email = ENGLISH_FAKER.free_email()
        self.ratings_count = random.randrange(1, RATINGS_COUNT_MAX)
        self.ratings_average = random.uniform(1.0, 5.0)


    def __eq__(self, other):
        """Determine if this event is equal to another event."""
        return self.address == other.address and self.event_time == other.event_time


    def __hash__(self):
        """Return a hash code for this object."""
        return hash((self.address, self.event_time))


    def __str__(self):
        """Return the SQL insertion command for this event."""
        return self.INSERT.format(
            self.name,
            self.description,
            self.category,
            self.address,
            self.publicity_level,
            self.organization_id,
            self.university_id,
            self.event_time,
            self.contact_number,
            self.contact_email,
            self.ratings_count,
            self.ratings_average,
        )


    def __generate_address(self):
        """Generate a random address."""
        address = []

        address.append(ENGLISH_FAKER.building_number())
        address.append(ENGLISH_FAKER.last_name())
        address.append(random.choice(ROAD_TYPES) + ",")
        address.append(ENGLISH_FAKER.city() + ",")
        address.append(ENGLISH_FAKER.state_abbr())
        address.append(ENGLISH_FAKER.postcode())

        return " ".join(address)

    
class Picture:
    """Class that holds randomized data for a picture entry in the database."""
    INSERT = "INSERT INTO pictures VALUES ({0}, '{1}');\n"

    def __init__(self, owner_id):
        """Initialize this picture with an owner ID and a random file path."""
        self.owner_id = owner_id
        self.path = self.__generate_path()


    def __str__(self):
        """Return the SQL insertion command for this picture."""
        return self.INSERT.format(self.owner_id, self.path)


    def __generate_path(self):
        """Generate a random file path for this picture."""
        path = []
        for directory_count in range(1, random.randrange(2, 5)):
            path.append(LOREM_FAKER.word())
        path[-1] += random.choice(PICTURE_EXTENSIONS)

        return "/".join(path)


class Comment:
    """Class that holds randomized data for a comment entry in the database."""
    INSERT = "INSERT INTO comments VALUES ({0}, {1}, {2}, '{3}');\n"

    def __init__(self, event_id, user_id):
        """Initialize this comment with some identifiers and other fields."""
        self.event_id = event_id
        self.time = random.randrange(UNIX_START_TIME, UNIX_STOP_TIME)
        self.user_id = user_id
        self.text = LOREM_FAKER.paragraph()


    def __str__(self):
        """Return the SQL insertion command for this comment."""
        return self.INSERT.format(
            self.event_id,
            self.time,
            self.user_id,
            self.text,
        )


class Membership:
    """Class that holds randomized data for a membership entry in the database."""
    INSERT = "INSERT INTO memberships VALUES ({0}, {1});\n"

    def __init__(self, user_id, organization_id):
        """Initialize this membership with some identifiers."""
        self.user_id = user_id
        self.organization_id = organization_id


    def __eq__(self, other):
        """Check if this membership is equal to another membership."""
        return (
            self.user_id == other.user_id and
            self.organization_id == other.organization_id
        )


    def __hash__(self):
        """Produce a hash code for this membership.
        
        The third item in the tuple passed to hash() helps hash() differentiate
        between two memberships where the user_id and organization_id are
        flipped (e.g. (1, 10) and (10, 1)).
        """
        return hash((
            self.user_id,
            self.organization_id,
            self.user_id - self.organization_id,
        ))


    def __str__(self):
        """Return the SQL insertion command for this membership."""
        return self.INSERT.format(self.user_id, self.organization_id)


# Main entry point to script.
# Generate all necessary data.
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
events = set()
for event in range(EVENT_COUNT):
    events.add(
        Event(
            random.randrange(1, len(universities)),
            random.randrange(1, len(organizations)),
        )
    )
pictures = [Picture(random.randrange(1, len(events))) for count in range(PICTURE_COUNT)]
comments = []
for comment in range(COMMENT_COUNT):
    comments.append(Comment(random.randrange(1, len(events)), random.randrange(1, len(users))))
memberships = set()
for membership in range(MEMBERSHIP_COUNT):
    memberships.add(
        Membership(
            random.randrange(1, len(users)),
            random.randrange(1, len(organizations)),
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
    for event in events:
        f.write(str(event))
    for picture in pictures:
        f.write(str(picture))
    for comment in comments:
        f.write(str(comment))
    for membership in memberships:
        f.write(str(membership))
    
    f.write(FOOTER)
