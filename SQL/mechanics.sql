create table mechanics
(
    id                bigint unsigned auto_increment
        primary key,
    name              varchar(255)    not null,
    user_id           bigint unsigned not null,
    description       text            not null,
    created_at        timestamp       null,
    updated_at        timestamp       null,
    deleted_at        timestamp       null,
    address_latitude  double          null,
    address_longitude double          null,
    address           double          null
)
    collate = utf8mb4_unicode_ci;

INSERT INTO mechanics (id, name, user_id, description, created_at, updated_at, deleted_at, address_latitude, address_longitude, address) VALUES (1, 'test', 1, 0x3C6469763E66686766673C62723E646766683C62723E6667683C62723E6467683C62723E646667683C62723E67643C2F6469763E, '2024-11-04 10:21:26', '2024-11-04 10:43:08', null, null, null, null);
