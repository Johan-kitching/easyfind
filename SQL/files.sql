create table files
(
    id            bigint unsigned auto_increment
        primary key,
    path          varchar(255)    not null,
    filename      varchar(255)    not null,
    file_type     varchar(255)    not null,
    parental_type varchar(255)    not null,
    parental_id   bigint unsigned not null,
    created_at    timestamp       null,
    updated_at    timestamp       null
)
    collate = utf8mb4_unicode_ci;

create index files_parental_type_parental_id_index
    on files (parental_type, parental_id);

INSERT INTO files (id, path, filename, file_type, parental_type, parental_id, created_at, updated_at) VALUES (3, '599a6322375929242535ca2c5c4c3f5b.jpg', '21537562.jpg', 'machinery', 'App\\Models\\Machinery', 1, '2024-09-13 13:08:44', '2024-09-13 13:08:44');
INSERT INTO files (id, path, filename, file_type, parental_type, parental_id, created_at, updated_at) VALUES (4, '9f99e57c29e6f379a5705d13ebcd8f82.jpg', '21537565.jpg', 'machinery', 'App\\Models\\Machinery', 1, '2024-09-13 13:08:44', '2024-09-13 13:08:44');
INSERT INTO files (id, path, filename, file_type, parental_type, parental_id, created_at, updated_at) VALUES (5, 'd9c7e96fdb50a889ea324ffb9aa66907.jpg', 'scania3.jpg', 'machinery', 'App\\Models\\Machinery', 2, '2024-09-13 13:11:43', '2024-09-13 13:11:43');
INSERT INTO files (id, path, filename, file_type, parental_type, parental_id, created_at, updated_at) VALUES (6, '71d9b5e71fcec824178a54765b6698e7.jpg', 'scania2.jpg', 'machinery', 'App\\Models\\Machinery', 2, '2024-09-13 13:11:43', '2024-09-13 13:11:43');
INSERT INTO files (id, path, filename, file_type, parental_type, parental_id, created_at, updated_at) VALUES (7, '05b9d8dcea40996b8438b0ed4900d086.jpg', 'scania1.jpg', 'machinery', 'App\\Models\\Machinery', 2, '2024-09-13 13:11:43', '2024-09-13 13:11:43');
INSERT INTO files (id, path, filename, file_type, parental_type, parental_id, created_at, updated_at) VALUES (8, 'e22f51eaa6f0e6be7fa938dbe1063490.jpg', 'WhatsApp Image 2024-08-13 at 07.18.44_538c0b94.jpg', 'machinery', 'App\\Models\\Machinery', 3, '2024-09-16 12:45:21', '2024-09-16 12:45:21');
INSERT INTO files (id, path, filename, file_type, parental_type, parental_id, created_at, updated_at) VALUES (9, '09f4ca2fc126320c43a98c4e94e1ec1a.jpg', 'WhatsApp Image 2024-08-13 at 07.18.44_b303c10a.jpg', 'machinery', 'App\\Models\\Machinery', 4, '2024-10-04 07:50:26', '2024-10-04 07:50:26');
INSERT INTO files (id, path, filename, file_type, parental_type, parental_id, created_at, updated_at) VALUES (10, '2ff303bcd0e18752e73d36432ca10c4b.jpg', '21537562.jpg', 'machinery', 'App\\Models\\Machinery', 5, '2024-10-08 07:07:13', '2024-10-08 07:07:13');
INSERT INTO files (id, path, filename, file_type, parental_type, parental_id, created_at, updated_at) VALUES (11, 'e2747bd11aacd20b7fa471e4d6382f00.jpg', '21537565.jpg', 'machinery', 'App\\Models\\Machinery', 5, '2024-10-08 07:07:13', '2024-10-08 07:07:13');
INSERT INTO files (id, path, filename, file_type, parental_type, parental_id, created_at, updated_at) VALUES (12, 'beb4c2cd46e7e1817304dd98109056d2.jpg', '1000080394.jpg', 'machinery', 'App\\Models\\Machinery', 6, '2024-10-17 12:40:41', '2024-10-17 12:40:41');
INSERT INTO files (id, path, filename, file_type, parental_type, parental_id, created_at, updated_at) VALUES (13, '11c1bedf2699fec4f16266fc3fb0c5eb.jpg', '20241017_140830.jpg', 'machinery', 'App\\Models\\Machinery', 7, '2024-10-17 12:40:48', '2024-10-17 12:40:48');
