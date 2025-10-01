create table roles
(
    id         bigint unsigned auto_increment
        primary key,
    name       varchar(255) not null,
    guard_name varchar(255) not null,
    created_at timestamp    null,
    updated_at timestamp    null,
    constraint roles_name_guard_name_unique
        unique (name, guard_name)
)
    collate = utf8mb4_unicode_ci;

INSERT INTO roles (id, name, guard_name, created_at, updated_at) VALUES (1, 'Super Admin', 'web', '2024-09-13 08:55:08', '2024-09-13 08:55:08');
INSERT INTO roles (id, name, guard_name, created_at, updated_at) VALUES (2, 'Admin', 'web', '2024-09-13 08:55:08', '2024-09-13 08:55:08');
INSERT INTO roles (id, name, guard_name, created_at, updated_at) VALUES (3, 'Personal', 'web', '2024-09-13 08:55:08', '2024-09-13 08:55:08');
INSERT INTO roles (id, name, guard_name, created_at, updated_at) VALUES (4, 'Operator', 'web', '2024-09-13 08:55:09', '2024-09-13 08:55:09');
INSERT INTO roles (id, name, guard_name, created_at, updated_at) VALUES (5, 'Company', 'web', '2024-09-13 08:55:09', '2024-09-13 08:55:09');
INSERT INTO roles (id, name, guard_name, created_at, updated_at) VALUES (6, 'User', 'web', '2024-09-13 08:55:09', '2024-09-13 08:55:09');
