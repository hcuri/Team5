###Creating database and tables


CREATE DATABASE upresent;
USE upresent;

/*
Table: Users
Info:
	userId - auto incremented 
	fName - First name of user
	lName - Last name of user
	username - Username of user
	email - Email address of user
	password - User's hashed password
	NotesURL - Drive URL to this user's notes doc
*/
CREATE TABLE Users  
(
	userId 			INT UNSIGNED			NOT NULL AUTO_INCREMENT,
	fName			VARCHAR(256)			NOT NULL,
	lName			VARCHAR(256)			NOT NULL,
	username		VARCHAR(256)			NOT NULL,
	email 			VARCHAR(255)			NOT NULL,
	password 		VARCHAR(256) 			NOT NULL,
	organization	VARCHAR(256)			NOT NULL,
	schoolID		VARCHAR(256)			NOT NULL,
	NotesURL		VARCHAR(255)			NOT NULL,			
	PRIMARY KEY 		(userId)
);

/*
Table: Groups
Info:
	groupId - Auto incremented
	groupName - Name of group the owner chose when making it
	ownerId - userId of owner of group
	Code - 4-digit alphanumeric code to join the group when searching for it
*/
CREATE TABLE Groups
(
        groupId                 INT UNSIGNED                    NOT NULL AUTO_INCREMENT,
        groupName               VARCHAR(256)                    NOT NULL,
        ownerId                 INT UNSIGNED                    NOT NULL,
        PRIMARY KEY             (groupId),
		FOREIGN KEY				(ownerId)						REFERENCES Users(userId)
);

/*
Table: Group_Users
Info:
	groupId - ID of group
	userId - ID of user
*/
CREATE TABLE Group_Users
(
        groupId					INT UNSIGNED                    NOT NULL,
        userId                  INT UNSIGNED                    NOT NULL,
		FOREIGN KEY				(groupId)						REFERENCES Groups(groupId),
		FOREIGN KEY				(userId)						REFERENCES Users(userId)
);

/*
Table: Presentations
Info:
        presId - auto incremented
        presName - Title of the presentation
        rootURL - Root URL where the presentation is stored on the server
        sessionId - ID of session this presentation belongs to
        ownerId - userId of presentation owner
        currSlide - Slide number the presenter is on in their presentation
        alreadyPresented - Has the presentation already been presented
*/
CREATE TABLE Presentations
(
        presId                  INT UNSIGNED                    NOT NULL AUTO_INCREMENT,
		presName				VARCHAR(256)					NOT NULL,
        rootURL                 VARCHAR(256)                    NOT NULL,
        ownerId					INT UNSIGNED                    NOT NULL,
        groupId					INT UNSIGNED					NOT NULL,
        presDate 				VARCHAR(256) 					NOT NULL,
        PresTime				VARCHAR(256) 					NOT NULL,
        currSlide				INT UNSIGNED 					NOT NULL DEFAULT 0,
        alreadyPresented		BOOLEAN							NOT NULL DEFAULT FALSE,
        PRIMARY KEY             (presId),
		FOREIGN KEY				(ownerId)						REFERENCES Users(userId)
);

/*
Table: Poll
Info:
	pollId - Auto incremented
	presId - ID of presentation this poll belongs to
	slideNum - Slide number that this poll pops up on
	question - Question that the poll asks
	numOptions - Number of options for poll
*/
CREATE TABLE Poll
(
        pollId                  INT UNSIGNED                    NOT NULL AUTO_INCREMENT,
        presId                  INT UNSIGNED                    NOT NULL,
        slideNum                INT UNSIGNED                    NOT NULL,
        question                VARCHAR(256)                    NOT NULL,
        numOptions              INT UNSIGNED                    NOT NULL
        PRIMARY KEY             (pollId),
        FOREIGN KEY		(presId)                        REFERENCES Presentations(presId)
);

/*
Table: Poll_Options
Info: 2NF table for poll options
	pollId - ID of poll these options belong to
	option_text - Text for this option
*/
CREATE TABLE Poll_Options
(
        pollId                  INT UNSIGNED                    NOT NULL,
		option_num				VARCHAR(1)			NOT NULL DEFAULT 'Z',
        option_text             VARCHAR(256)                    NOT NULL,
		option_results          INT UNSIGNED    		NOT NULL DEFAULT 0,
        FOREIGN KEY             (pollId)			REFERENCES Poll(pollId)
);

