create table equipment_types
(
    id         bigint unsigned auto_increment
        primary key,
    category   varchar(255) not null,
    type       varchar(255) not null,
    model      varchar(255) not null,
    deleted_at timestamp    null,
    created_at timestamp    null,
    updated_at timestamp    null
)
    collate = utf8mb4_unicode_ci;

