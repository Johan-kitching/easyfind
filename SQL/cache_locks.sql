create table cache_locks
(
    `key`      varchar(255) not null
        primary key,
    owner      varchar(255) not null,
    expiration int          not null
)
    collate = utf8mb4_unicode_ci;

INSERT INTO cache_locks (`key`, owner, expiration) VALUES ('laravel:pulse:check', 'kBHUPSGBt7qBc848', 1730791980);
