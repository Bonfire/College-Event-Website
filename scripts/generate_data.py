""""""

import random
import string

class User:
    """"""
    INSERT = "INSERT INTO users VALUES ('{0}', '{1}', '{2}', '{3}', '{4}');\n"

    def __init__(self, universities):
        """"""
        self.username = self.__generate_username()
        self.password = self.__generate_password()
        self.email = self.__generate_email()
        self.university = None#random.choice(universities).name
        self.permission_level = self.__generate_permission_level()


    def __generate_username(self):
        """"""
        username = []

        username.append(random.choice(string.ascii_uppercase))
        for char in range(random.randrange(7, 20)):
            username.append(random.choice(string.ascii_lowercase))

        return "".join(username)


    def __generate_password(self):
        """"""
        password = []

        password.append(random.choice(string.ascii_uppercase))
        for char in range(random.randrange(7, 20)):
            password.append(random.choice(string.ascii_lowercase))
        password.extend(random.choices(string.digits, k=2))
        password.append(random.choice(("!", "?", ".")))

        return "".join(password)


    def __generate_email(self):
        """"""
        DOMAINS = ("gmail", "yahoo", "aol", "hotmail", "outlook")
        
        email = []

        email.append(self.username)
        email.extend(random.choices(string.digits, k=2))
        email.append("@")
        email.append(random.choice(DOMAINS))
        email.append(".com")

        return "".join(email)


    def __generate_permission_level(self):
        """"""
        PERMISSION_TYPES = ("normal", "admin", "superadmin")
        
        return random.choice(PERMISSION_TYPES)


    def __str__(self):
        """"""
        return "{0}\n{1}\n{2}\n{3}\n{4}\n".format(
            self.username,
            self.password,
            self.email,
            self.university,
            self.permission_level
        )


    def get_formatted_statement(self):
        """"""
        return self.INSERT.format(
            self.username,
            self.password,
            self.email,
            self.university,
            self.permission_level
        )


class University:
    """"""
    def __init__(self):
        self.name = self.__generate_name()
        self.address = self.__generate_address()
        self.description = self.__generate_description()
        self.student_count = 0
