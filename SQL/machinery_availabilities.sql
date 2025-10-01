create table machinery_availabilities
(
    id           bigint unsigned auto_increment
        primary key,
    machinery_id bigint unsigned not null,
    start_date   varchar(255)    not null,
    end_date     varchar(255)    not null,
    created_at   timestamp       null,
    updated_at   timestamp       null,
    deleted_at   timestamp       null,
    constraint machinery_availabilities_machinery_id_foreign
        foreign key (machinery_id) references machineries (id)
)
    collate = utf8mb4_unicode_ci;

INSERT INTO machinery_availabilities (id, machinery_id, start_date, end_date, created_at, updated_at, deleted_at) VALUES (1, 1, '2024-09-17', '2024-09-30', '2024-09-16 10:22:27', '2024-09-16 11:08:05', '2024-09-16 11:08:05');
INSERT INTO machinery_availabilities (id, machinery_id, start_date, end_date, created_at, updated_at, deleted_at) VALUES (2, 1, '2024-09-16', '2024-09-30', '2024-09-16 11:08:15', '2024-09-16 11:08:15', null);
INSERT INTO machinery_availabilities (id, machinery_id, start_date, end_date, created_at, updated_at, deleted_at) VALUES (3, 2, '2024-09-16', '2024-10-12', '2024-09-16 11:08:30', '2024-09-16 11:08:30', null);
