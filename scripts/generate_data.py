""""""

import random
import string
from faker import Faker

HEADER = (
    "/*\n"
    "Part of Zajedno.\n"
    "Written by Tiger Sachse.\n"
    "*/\n\n"
    "USE main_database;\n"
    "CONNECT main_database;\n\n"
)
FOOTER = "\nQUIT"
FAKER = Faker()

class User:
    """"""
    INSERT = (
        "INSERT INTO users "
        "(username, password, email, university_id, permission_level) "
        "VALUES ('{0}', '{1}', '{2}', {3}, '{4}');\n"
    )

    def __init__(self, university_id):
        """"""
        profile = FAKER.simple_profile()

        self.email = profile["mail"]
        self.university_id = university_id
        self.username = profile["username"]
        self.password = self.__generate_password()
        self.permission_level = random.choice(("normal", "admin", "superadmin"))
        

    def __generate_password(self):
        """"""
        password = []

        password.append(random.choice(string.ascii_uppercase))
        password.extend(
            random.choices(
                string.ascii_lowercase,
                k=random.randrange(7, 20)
            )
        )
        password.extend(random.choices(string.digits, k=2))
        password.append(random.choice(("!", "?", ".")))

        random.shuffle(password)

        return "".join(password)


    def __str__(self):
        """"""
        return self.INSERT.format(
            self.username,
            self.password,
            self.email,
            self.university_id,
            self.permission_level
        )

        
class University:
    """"""
    INSERT = (
        "INSERT INTO universities "
        "(name, address, description) "
        "VALUES ('{0}', '{1}', '{2}');\n"
    )

    def __init__(self):
        """"""
        self.name = self.__generate_name()
        self.address = FAKER.address()
        self.description = FAKER.sentence()#FAKER.text(max_nb_chars=1000)
        self.student_count = 0

    
    def __generate_name(self):
        """"""
        INSTITUTION_FORMATS = (
            "{0} University",
            "University of {0}",
            "{0} State University",
            "{0} State College",
            "{0} Community College",
        )

        return random.choice(INSTITUTION_FORMATS).format(FAKER.last_name())


    def __str__(self):
        """"""
        return self.INSERT.format(
            self.name,
            self.address,
            self.description,
        )


# Main entry point to script.
universities = [University() for count in range(100)]
users = [User(random.randrange(len(universities))) for count in range(100)]

with open("test.sql", "w") as f:
    f.write(HEADER)
    for university in universities:
        f.write(str(university))

    for user in users:
        f.write(str(user))
    
    f.write(FOOTER)
