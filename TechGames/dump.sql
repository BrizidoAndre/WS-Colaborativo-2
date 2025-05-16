create table Admins
(
    id          int auto_increment
        primary key,
    email       varchar(255)         not null,
    phone       varchar(522)         null,
    password    varchar(255)         null,
    firstAccess tinyint(1) default 0 not null,
    name        varchar(255)         null
);

create table Players
(
    id         int auto_increment
        primary key,
    email      varchar(255)         not null,
    password   varchar(522)         not null,
    phone      varchar(255)         not null,
    isRemoved  tinyint(1) default 0 not null,
    name       varchar(255)         null,
    token      varchar(522)         null,
    token_time int                  null
);

create table Puzzles
(
    id           int auto_increment
        primary key,
    image        varchar(522) not null,
    piecesAmount int          not null,
    date         date         not null
);

create table Points
(
    id        int auto_increment
        primary key,
    time      time not null,
    date      date not null,
    puzzle_id int  not null,
    player_id int  not null,
    constraint Points_Players_id_fk
        foreign key (player_id) references Players (id),
    constraint Points_Puzzles_id_fk
        foreign key (puzzle_id) references Puzzles (id)
);

create table PuzzlePieces
(
    id         int auto_increment
        primary key,
    image_path varchar(255) not null,
    position   int          not null,
    puzzle_id  int          not null,
    constraint PuzzlePieces_Puzzles_id_fk
        foreign key (puzzle_id) references Puzzles (id)
);

create table PiecesPlayers
(
    id              int auto_increment
        primary key,
    puzzle_piece_id int not null,
    currentPosition int not null,
    player_id       int not null,
    constraint PiecesPlayers_Players_id_fk
        foreign key (player_id) references Players (id),
    constraint PiecesPlayers_PuzzlePieces_id_fk
        foreign key (puzzle_piece_id) references PuzzlePieces (id)
);

