create table permissions
(
    id         bigint unsigned auto_increment
        primary key,
    name       varchar(255) not null,
    guard_name varchar(255) not null,
    created_at timestamp    null,
    updated_at timestamp    null,
    constraint permissions_name_guard_name_unique
        unique (name, guard_name)
)
    collate = utf8mb4_unicode_ci;

INSERT INTO permissions (id, name, guard_name, created_at, updated_at) VALUES (1, 'Users - Create', 'web', '2024-09-13 08:55:09', '2024-09-13 08:55:09');
INSERT INTO permissions (id, name, guard_name, created_at, updated_at) VALUES (2, 'Admin Users - Edit', 'web', '2024-09-13 08:55:10', '2024-09-13 08:55:10');
INSERT INTO permissions (id, name, guard_name, created_at, updated_at) VALUES (3, 'Admin Users - Remove', 'web', '2024-09-13 08:55:10', '2024-09-13 08:55:10');
INSERT INTO permissions (id, name, guard_name, created_at, updated_at) VALUES (4, 'Admin Users - Activity', 'web', '2024-09-13 08:55:10', '2024-09-13 08:55:10');
INSERT INTO permissions (id, name, guard_name, created_at, updated_at) VALUES (5, 'Admin Users - API', 'web', '2024-09-13 08:55:11', '2024-09-13 08:55:11');
INSERT INTO permissions (id, name, guard_name, created_at, updated_at) VALUES (6, 'My Equipment - Add', 'web', '2024-09-13 08:55:11', '2024-09-13 08:55:11');
INSERT INTO permissions (id, name, guard_name, created_at, updated_at) VALUES (7, 'My Equipment - Edit', 'web', '2024-09-13 08:55:12', '2024-09-13 08:55:12');
INSERT INTO permissions (id, name, guard_name, created_at, updated_at) VALUES (8, 'My Equipment - Remove', 'web', '2024-09-13 08:55:12', '2024-09-13 08:55:12');
INSERT INTO permissions (id, name, guard_name, created_at, updated_at) VALUES (9, 'My Equipment - Rentals', 'web', '2024-09-13 08:55:12', '2024-09-13 08:55:12');
INSERT INTO permissions (id, name, guard_name, created_at, updated_at) VALUES (10, 'My Operators - Add', 'web', '2024-09-13 08:55:13', '2024-09-13 08:55:13');
INSERT INTO permissions (id, name, guard_name, created_at, updated_at) VALUES (11, 'My Machinery - Add', 'web', '2024-09-13 08:55:13', '2024-09-13 08:55:13');
INSERT INTO permissions (id, name, guard_name, created_at, updated_at) VALUES (12, 'Dashboard', 'web', '2024-09-13 08:55:14', '2024-09-13 08:55:14');
INSERT INTO permissions (id, name, guard_name, created_at, updated_at) VALUES (13, 'My Machinery', 'web', '2024-09-13 08:55:14', '2024-09-13 08:55:14');
INSERT INTO permissions (id, name, guard_name, created_at, updated_at) VALUES (14, 'My Equipment', 'web', '2024-09-13 08:55:14', '2024-09-13 08:55:14');
INSERT INTO permissions (id, name, guard_name, created_at, updated_at) VALUES (15, 'My Rentals', 'web', '2024-09-13 08:55:15', '2024-09-13 08:55:15');
INSERT INTO permissions (id, name, guard_name, created_at, updated_at) VALUES (16, 'My Operators', 'web', '2024-09-13 08:55:15', '2024-09-13 08:55:15');
INSERT INTO permissions (id, name, guard_name, created_at, updated_at) VALUES (17, 'Admin', 'web', '2024-09-13 08:55:15', '2024-09-13 08:55:15');
INSERT INTO permissions (id, name, guard_name, created_at, updated_at) VALUES (18, 'Admin Users', 'web', '2024-09-13 08:55:16', '2024-09-13 08:55:16');
INSERT INTO permissions (id, name, guard_name, created_at, updated_at) VALUES (19, 'Admin Permissions', 'web', '2024-09-13 08:55:16', '2024-09-13 08:55:16');
INSERT INTO permissions (id, name, guard_name, created_at, updated_at) VALUES (20, 'Admin Payment', 'web', '2024-09-13 08:55:16', '2024-09-13 08:55:16');
INSERT INTO permissions (id, name, guard_name, created_at, updated_at) VALUES (21, 'Admin Machinery', 'web', '2024-09-13 08:55:17', '2024-09-13 08:55:17');
INSERT INTO permissions (id, name, guard_name, created_at, updated_at) VALUES (22, 'Admin Machinery Type', 'web', '2024-09-13 08:55:17', '2024-09-13 08:55:17');
INSERT INTO permissions (id, name, guard_name, created_at, updated_at) VALUES (23, 'Admin Equipment', 'web', '2024-09-13 08:55:17', '2024-09-13 08:55:17');
INSERT INTO permissions (id, name, guard_name, created_at, updated_at) VALUES (24, 'Admin Equipment Type', 'web', '2024-09-13 08:55:18', '2024-09-13 08:55:18');
INSERT INTO permissions (id, name, guard_name, created_at, updated_at) VALUES (25, 'Admin Rentals', 'web', '2024-09-13 08:55:18', '2024-09-13 08:55:18');
