CREATE TABLE users (
    username VARCHAR(16) NOT NULL COLLATE utf8mb4_0900_as_cs,
    userPassword VARCHAR(16) NOT NULL,
    PRIMARY KEY (username)
);


checklistID should also be collated if using a case sensitive os such as linux.
CREATE TABLE checklist (
   checklistID CHAR(4) NOT NULL,
   username VARCHAR(16) COLLATE utf8mb4_0900_as_cs,
   checklistTitle VARCHAR(16),
   checklistPassword VARCHAR(16),
   PRIMARY KEY (checklistID),
   FOREIGN KEY (username) REFERENCES users(username)
);

CREATE TABLE task (
   taskID CHAR(4) NOT NULL COLLATE utf8mb4_0900_as_cs,
   checklistID CHAR(4) NOT NULL,
   taskTitle VARCHAR(16),
   description VARCHAR(256),
   priority ENUM("None", "Low", "Medium", "High") NOT NULL,
   status ENUM("Not started", "In progress", "Finished") NOT NULL,
   checkbox BOOLEAN NOT NULL,
   PRIMARY KEY (taskID),
   FOREIGN KEY (checklistID) REFERENCES checklist(checklistID)
);


utf8mb4_0900_as_cs for mysql on wamp

utf8mb4_nopad_bin for on hostinger

ALTER TABLE task ADD checkbox BOOLEAN NOT NULL;

ALTER TABLE checklist ADD access ENUM("Public editable", "Public not editable", "Private") NOT NULL;