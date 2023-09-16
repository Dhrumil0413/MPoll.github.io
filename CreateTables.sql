-- If tables exists from the it would drop them,
DROP TABLE IF EXISTS Users, Polls, Options, Vote;

create table Users (
    UserId int AUTO_INCREMENT,
    EmailAddress varchar(100) not null,
    password varchar(50) not null,
    UserName varchar(50),
    Avatar varchar(255),
    primary key (UserId)
);

create table Polls (
    PollId int AUTO_INCREMENT,
    UserId int,
    StartDateTime timestamp,
    CloseDateTime timestamp,
    Question text not null,
    GenerationTime timestamp,
    LastVoteDate timestamp,
    primary key (PollId),
    foreign key (UserId) references Users (UserId)
);

create table Options (
    OptionId int AUTO_INCREMENT,
    PollId int,
    OptionText text,
    primary key (OptionId),
    foreign key (PollId) references Polls (PollId)
);

create table Vote (
    VoteId int AUTO_INCREMENT,
    OptionId int,   
    VoteDateTime timestamp,
    primary key (VoteId),
    foreign key (OptionId) references Options (OptionId)
);